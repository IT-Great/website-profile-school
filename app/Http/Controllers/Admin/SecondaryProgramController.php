<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SecondaryProgramPage;
use App\Models\SecondaryProgramSection;
// use App\Models\SecondaryProgramItem;
// use App\Models\SecondaryProgramPhoto;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class SecondaryProgramController extends Controller
{
    // Dashboard utama
    public function index()
    {
        $page = SecondaryProgramPage::with([
            'features',
            'curriculums',
            'outcomes',
        ])->first();

        $sections = SecondaryProgramSection::with([
            'items.photos',
        ])->orderBy('sort_order')->get();

        return Inertia::render('Public/Admin/SecondaryProgram/Index', [
            'page' => $page,
            'sections' => $sections,
        ]);
    }

    // Halaman edit About Secondary
    public function editAbout()
    {
        $page = SecondaryProgramPage::with('features')->firstOrFail();

        return Inertia::render('Public/Admin/SecondaryProgram/About', [
            'page' => $page,
        ]);
    }

    // Update About Secondary dan semua features
    public function updateAbout(Request $request)
    {
        $page = SecondaryProgramPage::firstOrFail();

        $validated = $request->validate([
            'badge' => 'required|string|max:100',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',

            'is_active' => 'required|boolean',

            'features' => 'required|array|min:1',
            'features.*.id' => 'nullable|integer',
            'features.*.icon' => 'nullable|string|max:100',
            'features.*.title' => 'required|string|max:255',
            'features.*.description' => 'nullable|string',
            'features.*.is_active' => 'required|boolean',
        ]);

        DB::transaction(function () use ($page, $validated) {
            // Update informasi utama
            $page->update([
                'badge' => $validated['badge'],
                'title' => $validated['title'],
                'description' => $validated['description'] ?? null,
                'is_active' => $validated['is_active'],
            ]);

            $keptIds = [];

            // Update atau tambah features
            foreach ($validated['features'] as $index => $featureData) {
                if (!empty($featureData['id'])) {
                    // Pastikan feature milik halaman ini
                    $feature = $page->features()
                        ->findOrFail($featureData['id']);

                    $feature->update([
                        'icon' => $featureData['icon'] ?? null,
                        'title' => $featureData['title'],
                        'description' => $featureData['description'] ?? null,
                        'sort_order' => $index + 1,
                        'is_active' => $featureData['is_active'],
                    ]);
                } else {
                    // Tambahkan feature baru
                    $feature = $page->features()->create([
                        'icon' => $featureData['icon'] ?? null,
                        'title' => $featureData['title'],
                        'description' => $featureData['description'] ?? null,
                        'sort_order' => $index + 1,
                        'is_active' => $featureData['is_active'],
                    ]);
                }

                $keptIds[] = $feature->id;
            }

            // Hapus feature yang sudah dihapus dari form
            $page->features()
                ->whereNotIn('id', $keptIds)
                ->delete();
        });

        return redirect()
            ->route('admin.secondary-program.about.edit')
            ->with('success', 'About Secondary berhasil diperbarui.');
    }

    // Halaman Manage Curriculum
    public function editCurriculum()
    {
        $page = SecondaryProgramPage::with('curriculums')->firstOrFail();

        return Inertia::render('Public/Admin/SecondaryProgram/Curriculum', [
            'page' => $page,
        ]);
    }

    // Update seluruh data Curriculum
    public function updateCurriculum(Request $request)
    {
        $page = SecondaryProgramPage::firstOrFail();

        $validated = $request->validate([
            'curriculums' => 'required|array|min:1',
            'curriculums.*.id' => 'nullable|integer',
            'curriculums.*.name' => 'required|string|max:255',
            'curriculums.*.short_name' => 'nullable|string|max:100',
            'curriculums.*.icon' => 'nullable|string|max:100',
            'curriculums.*.description' => 'nullable|string',
            'curriculums.*.is_active' => 'required|boolean',
        ]);

        DB::transaction(function () use ($page, $validated) {
            $keptIds = [];

            foreach ($validated['curriculums'] as $index => $data) {
                if (!empty($data['id'])) {
                    // Pastikan data curriculum milik halaman ini
                    $curriculum = $page->curriculums()
                        ->findOrFail($data['id']);

                    $curriculum->update([
                        'name' => $data['name'],
                        'short_name' => $data['short_name'] ?? null,
                        'icon' => $data['icon'] ?? null,
                        'description' => $data['description'] ?? null,
                        'sort_order' => $index + 1,
                        'is_active' => $data['is_active'],
                    ]);
                } else {
                    // Tambahkan curriculum baru
                    $curriculum = $page->curriculums()->create([
                        'name' => $data['name'],
                        'short_name' => $data['short_name'] ?? null,
                        'icon' => $data['icon'] ?? null,
                        'description' => $data['description'] ?? null,
                        'sort_order' => $index + 1,
                        'is_active' => $data['is_active'],
                    ]);
                }

                $keptIds[] = $curriculum->id;
            }

            // Hapus curriculum yang dikeluarkan dari form
            $page->curriculums()
                ->whereNotIn('id', $keptIds)
                ->delete();
        });

        return redirect()
            ->route('admin.secondary-program.curriculum.edit')
            ->with('success', 'Curriculum berhasil diperbarui.');
    }
    // Halaman Manage Learning Outcomes
    public function editOutcomes()
    {
        $page = SecondaryProgramPage::with('outcomes')->firstOrFail();

        return Inertia::render('Public/Admin/SecondaryProgram/LearningOutcomes', [
            'page' => $page,
        ]);
    }

    // Update seluruh Learning Outcomes
    public function updateOutcomes(Request $request)
    {
        $page = SecondaryProgramPage::firstOrFail();

        $validated = $request->validate([
            'outcomes' => 'required|array|min:1',
            'outcomes.*.id' => 'nullable|integer',
            'outcomes.*.icon' => 'nullable|string|max:100',
            'outcomes.*.title' => 'required|string|max:255',
            'outcomes.*.is_active' => 'required|boolean',
        ]);

        DB::transaction(function () use ($page, $validated) {
            $keptIds = [];

            foreach ($validated['outcomes'] as $index => $data) {
                if (!empty($data['id'])) {
                    // Pastikan outcome milik halaman ini
                    $outcome = $page->outcomes()
                        ->findOrFail($data['id']);

                    $outcome->update([
                        'icon' => $data['icon'] ?? null,
                        'title' => $data['title'],
                        'sort_order' => $index + 1,
                        'is_active' => $data['is_active'],
                    ]);
                } else {
                    // Tambahkan outcome baru
                    $outcome = $page->outcomes()->create([
                        'icon' => $data['icon'] ?? null,
                        'title' => $data['title'],
                        'sort_order' => $index + 1,
                        'is_active' => $data['is_active'],
                    ]);
                }

                $keptIds[] = $outcome->id;
            }

            // Hapus outcome yang dihapus dari form
            $page->outcomes()
                ->whereNotIn('id', $keptIds)
                ->delete();
        });

        return redirect()
            ->route('admin.secondary-program.outcomes.edit')
            ->with('success', 'Learning Outcomes berhasil diperbarui.');
    }

    public function editExtracurriculars()
    {
        $section = SecondaryProgramSection::with('items.photos')
            ->where('slug', 'extracurriculars')
            ->firstOrFail();

        return Inertia::render('Public/Admin/SecondaryProgram/Extracurriculars', [
            'section' => $section,
        ]);
    }

    public function updateExtracurriculars(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'button_text' => 'nullable|string|max:100',
            'button_url' => 'nullable|string|max:255',
            'is_active' => 'required|boolean',

            'items' => 'required|array',
            'items.*.id' => 'nullable|integer',
            'items.*.name' => 'required|string|max:255',
            'items.*.description' => 'nullable|string',
            'items.*.icon' => 'nullable|string|max:100',
            'items.*.color' => 'nullable|string|max:50',
            'items.*.is_active' => 'required|boolean',
            'items.*.remove_photos' => 'nullable|array',
            'items.*.remove_photos.*' => 'integer',
            'items.*.new_photos' => 'nullable|array',
            'items.*.new_photos.*' => 'image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $section = SecondaryProgramSection::where('slug', 'extracurriculars')
            ->firstOrFail();

        DB::transaction(function () use ($request, $validated, $section) {

            $section->update([
                'title' => $validated['title'],
                'description' => $validated['description'] ?? null,
                'button_text' => $validated['button_text'] ?? null,
                'button_url' => $validated['button_url'] ?? null,
                'is_active' => $validated['is_active'],
            ]);

            $submittedIds = collect($validated['items'])
                ->pluck('id')
                ->filter()
                ->values()
                ->all();

            // Hapus program yang sudah dihapus dari form.
            $removedItems = $section->items()
                ->when(
                    count($submittedIds) > 0,
                    fn ($query) => $query->whereNotIn('id', $submittedIds),
                    fn ($query) => $query
                )
                ->get();

            foreach ($removedItems as $removedItem) {
                foreach ($removedItem->photos as $photo) {
                    Storage::disk('public')->delete($photo->image);
                }

                $removedItem->delete();
            }

            foreach ($validated['items'] as $index => $itemData) {

                $item = $section->items()->updateOrCreate(
                    ['id' => $itemData['id'] ?? null],
                    [
                        'name' => $itemData['name'],
                        'description' => $itemData['description'] ?? null,
                        'icon' => $itemData['icon'] ?? null,
                        'color' => $itemData['color'] ?? null,
                        'sort_order' => $index,
                        'is_active' => $itemData['is_active'],
                    ]
                );

                // Hapus foto lama yang dipilih.
                $removePhotoIds = $itemData['remove_photos'] ?? [];

                if (!empty($removePhotoIds)) {
                    $photosToRemove = $item->photos()
                        ->whereIn('id', $removePhotoIds)
                        ->get();

                    foreach ($photosToRemove as $photo) {
                        Storage::disk('public')->delete($photo->image);
                        $photo->delete();
                    }
                }

                // Simpan foto baru.
                $newPhotos = $request->file("items.$index.new_photos", []);

                foreach ($newPhotos as $photoFile) {
                    $path = $photoFile->store(
                        'secondary-program/extracurriculars',
                        'public'
                    );

                    $item->photos()->create([
                        'image' => $path,
                        'sort_order' => $item->photos()->count(),
                    ]);
                }
            }
        });

        return redirect()
            ->route('admin.secondary-program.extracurriculars.edit')
            ->with('success', 'Extracurricular Programs berhasil diperbarui.');
    }
}
