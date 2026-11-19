<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PrimaryProgramPage;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PrimaryProgramController extends Controller
{
    /**
     * Dashboard Primary Program
     */
    public function index()
    {
        $page = PrimaryProgramPage::with([
            'photos',
            'features',
            'levels.points',
            'curriculums',
            'extracurriculars',
        ])->first();

        return Inertia::render('Public/Admin/PrimaryProgram/Index', [
            'page' => $page,
        ]);
    }

    /**
     * Edit About Primary Program
     */
    public function editAbout()
    {
        $page = PrimaryProgramPage::with([
            'photos',
            'features',
        ])->firstOrFail();

        return Inertia::render('Public/Admin/PrimaryProgram/About', [
            'page' => $page,
        ]);
    }

    /**
     * Update About Primary Program
     */
    public function updateAbout(Request $request)
    {
        $validated = $request->validate([
            'badge' => 'nullable|string|max:100',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'second_description' => 'nullable|string',
            'is_active' => 'required|boolean',

            'features' => 'required|array|min:1',
            'features.*.id' => 'nullable|integer',
            'features.*.icon' => 'nullable|string|max:100',
            'features.*.title' => 'required|string|max:255',
            'features.*.description' => 'nullable|string',
            'features.*.is_active' => 'required|boolean',

            'remove_photos' => 'nullable|array',
            'remove_photos.*' => 'integer',

            'new_photos' => 'nullable|array',
            'new_photos.*' => 'image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $page = PrimaryProgramPage::firstOrFail();

        DB::transaction(function () use ($request, $validated, $page) {

            // Update main About information
            $page->update([
                'badge' => $validated['badge'] ?? null,
                'title' => $validated['title'],
                'description' => $validated['description'] ?? null,
                'second_description' => $validated['second_description'] ?? null,
                'is_active' => $validated['is_active'],
            ]);

            // Update and create features
            $submittedFeatureIds = [];

            foreach ($validated['features'] as $index => $featureData) {

                if (!empty($featureData['id'])) {
                    $feature = $page->features()
                        ->whereKey($featureData['id'])
                        ->first();

                    if (!$feature) {
                        abort(404, 'Feature tidak ditemukan.');
                    }

                    $feature->update([
                        'icon' => $featureData['icon'] ?? null,
                        'title' => $featureData['title'],
                        'description' => $featureData['description'] ?? null,
                        'sort_order' => $index,
                        'is_active' => $featureData['is_active'],
                    ]);
                } else {
                    $feature = $page->features()->create([
                        'icon' => $featureData['icon'] ?? null,
                        'title' => $featureData['title'],
                        'description' => $featureData['description'] ?? null,
                        'sort_order' => $index,
                        'is_active' => $featureData['is_active'],
                    ]);
                }

                $submittedFeatureIds[] = $feature->id;
            }

            // Delete features removed from the form
            $page->features()
                ->whereNotIn('id', $submittedFeatureIds)
                ->delete();

            // Remove selected existing photos
            $removePhotoIds = $validated['remove_photos'] ?? [];

            if (!empty($removePhotoIds)) {
                $photos = $page->photos()
                    ->whereIn('id', $removePhotoIds)
                    ->get();

                foreach ($photos as $photo) {
                    Storage::disk('public')->delete($photo->image);
                    $photo->delete();
                }
            }

            // Upload new carousel photos
            $newPhotos = $request->file('new_photos', []);

            foreach ($newPhotos as $photoFile) {
                $path = $photoFile->store(
                    'primary-program/about',
                    'public'
                );

                $page->photos()->create([
                    'image' => $path,
                    'sort_order' => $page->photos()->count(),
                    'is_active' => true,
                ]);
            }

            // Re-order remaining photos
            $page->photos()
                ->orderBy('id')
                ->get()
                ->values()
                ->each(function ($photo, $index) {
                    $photo->update([
                        'sort_order' => $index,
                    ]);
                });
        });

        return redirect()
            ->route('admin.primary-program.about.edit')
            ->with('success', 'About Primary Program berhasil diperbarui.');
    }

    /**
    * Edit Primary Levels
    */
    public function editLevels()
    {
        $page = PrimaryProgramPage::with([
            'levels.points',
        ])->firstOrFail();

        return Inertia::render('Public/Admin/PrimaryProgram/Levels', [
            'page' => $page,
        ]);
    }

    /**
     * Update Primary Levels
     */
    public function updateLevels(Request $request)
    {
        $validated = $request->validate([
            'levels' => 'required|array|min:1',

            'levels.*.id' => 'nullable|integer',
            'levels.*.name' => 'required|string|max:255',
            'levels.*.grade_label' => 'nullable|string|max:100',
            'levels.*.description' => 'nullable|string',
            'levels.*.is_active' => 'required|boolean',

            'levels.*.new_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'levels.*.remove_image' => 'nullable|boolean',

            'levels.*.points' => 'required|array|min:1',
            'levels.*.points.*.id' => 'nullable|integer',
            'levels.*.points.*.title' => 'required|string|max:255',
            'levels.*.points.*.is_active' => 'required|boolean',
        ]);

        $page = PrimaryProgramPage::firstOrFail();

        DB::transaction(function () use ($request, $validated, $page) {

            $submittedLevelIds = [];

            foreach ($validated['levels'] as $index => $levelData) {

                // Update existing level or create a new one.
                if (!empty($levelData['id'])) {
                    $level = $page->levels()
                        ->whereKey($levelData['id'])
                        ->firstOrFail();
                } else {
                    $level = $page->levels()->make();
                }

                $level->fill([
                    'name' => $levelData['name'],
                    'grade_label' => $levelData['grade_label'] ?? null,
                    'description' => $levelData['description'] ?? null,
                    'sort_order' => $index,
                    'is_active' => $levelData['is_active'],
                ]);

                // Upload a replacement image.
                $newImage = $request->file("levels.$index.new_image");

                if ($newImage) {
                    if ($level->image) {
                        Storage::disk('public')->delete($level->image);
                    }

                    $level->image = $newImage->store(
                        'primary-program/levels',
                        'public'
                    );
                } elseif (
                    !empty($levelData['remove_image']) &&
                    $level->image
                ) {
                    Storage::disk('public')->delete($level->image);
                    $level->image = null;
                }

                $level->save();

                $submittedLevelIds[] = $level->id;

                // Update or create learning points.
                $submittedPointIds = [];

                foreach ($levelData['points'] as $pointIndex => $pointData) {

                    if (!empty($pointData['id'])) {
                        $point = $level->points()
                            ->whereKey($pointData['id'])
                            ->firstOrFail();
                    } else {
                        $point = $level->points()->make();
                    }

                    $point->fill([
                        'title' => $pointData['title'],
                        'sort_order' => $pointIndex,
                        'is_active' => $pointData['is_active'],
                    ]);

                    $point->save();

                    $submittedPointIds[] = $point->id;
                }

                // Delete points removed from the form.
                $level->points()
                    ->whereNotIn('id', $submittedPointIds)
                    ->delete();
            }

            // Delete levels removed from the form.
            $removedLevels = $page->levels()
                ->whereNotIn('id', $submittedLevelIds)
                ->get();

            foreach ($removedLevels as $removedLevel) {
                if ($removedLevel->image) {
                    Storage::disk('public')->delete($removedLevel->image);
                }

                $removedLevel->delete();
            }
        });

        return redirect()
            ->route('admin.primary-program.levels.edit')
            ->with('success', 'Primary Levels berhasil diperbarui.');
    }

    public function editCurriculum()
    {
        $page = PrimaryProgramPage::with('curriculums')->firstOrFail();

        return Inertia::render('Public/Admin/PrimaryProgram/Curriculum', [
            'page' => $page,
        ]);
    }

    public function updateCurriculum(Request $request)
    {
        $validated = $request->validate([
            'curriculums' => ['present', 'array'],

            'curriculums.*.id' => ['nullable', 'integer'],
            'curriculums.*.name' => ['required', 'string', 'max:255'],
            'curriculums.*.short_name' => ['nullable', 'string', 'max:100'],
            'curriculums.*.icon' => ['nullable', 'string', 'max:100'],
            'curriculums.*.description' => ['nullable', 'string'],
            'curriculums.*.is_active' => ['required', 'boolean'],
        ]);

        $page = PrimaryProgramPage::firstOrFail();

        DB::transaction(function () use ($validated, $page) {
            $submittedIds = [];

            foreach ($validated['curriculums'] as $index => $item) {
                if (!empty($item['id'])) {
                    $curriculum = $page->curriculums()
                        ->whereKey($item['id'])
                        ->firstOrFail();
                } else {
                    $curriculum = $page->curriculums()->make();
                }

                $curriculum->fill([
                    'name' => $item['name'],
                    'short_name' => $item['short_name'] ?? null,
                    'icon' => $item['icon'] ?? null,
                    'description' => $item['description'] ?? null,
                    'sort_order' => $index + 1,
                    'is_active' => $item['is_active'],
                ]);

                $curriculum->save();

                $submittedIds[] = $curriculum->id;
            }

            $page->curriculums()
                ->whereNotIn('id', $submittedIds)
                ->delete();
        });

        return redirect()
            ->route('admin.primary-program.curriculum.edit')
            ->with('success', 'Curriculum updated successfully.');
    }

    public function editExtracurricular()
    {
        $page = PrimaryProgramPage::with('extracurriculars')->firstOrFail();

        return Inertia::render('Public/Admin/PrimaryProgram/Extracurricular', [
            'page' => $page,
        ]);
    }

    public function updateExtracurricular(Request $request)
    {
        $validated = $request->validate([
            'extracurriculars' => ['present', 'array'],

            'extracurriculars.*.id' => ['nullable', 'integer'],
            'extracurriculars.*.name' => ['required', 'string', 'max:255'],
            'extracurriculars.*.description' => ['nullable', 'string'],
            'extracurriculars.*.icon' => ['nullable', 'string', 'max:100'],
            'extracurriculars.*.color' => ['nullable', 'string', 'max:50'],
            'extracurriculars.*.is_active' => ['required', 'boolean'],
        ]);

        $page = PrimaryProgramPage::firstOrFail();

        DB::transaction(function () use ($validated, $page) {
            $submittedIds = [];

            foreach ($validated['extracurriculars'] as $index => $item) {
                if (!empty($item['id'])) {
                    $activity = $page->extracurriculars()
                        ->whereKey($item['id'])
                        ->firstOrFail();
                } else {
                    $activity = $page->extracurriculars()->make();
                }

                $activity->fill([
                    'name' => $item['name'],
                    'description' => $item['description'] ?? null,
                    'icon' => $item['icon'] ?? null,
                    'color' => $item['color'] ?? null,
                    'sort_order' => $index + 1,
                    'is_active' => $item['is_active'],
                ]);

                $activity->save();

                $submittedIds[] = $activity->id;
            }

            $page->extracurriculars()
                ->whereNotIn('id', $submittedIds)
                ->delete();
        });

        return redirect()
            ->route('admin.primary-program.extracurricular.edit')
            ->with('success', 'Extracurricular activities updated successfully.');
    }

}