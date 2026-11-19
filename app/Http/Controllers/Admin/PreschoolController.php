<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PreschoolPage;
use App\Models\PreschoolClass;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PreschoolController extends Controller
{
    /**
     * Dashboard Preschool
     */
    public function index()
    {
        $page = PreschoolPage::with([
            'photos',
            'features',
            'classes.points',
        ])->firstOrFail();

        return Inertia::render('Public/Admin/Preschool/Index', [
            'page' => $page,
        ]);
    }

    /**
     * Manage About Preschool
     */
    public function editAbout()
    {
        $page = PreschoolPage::with([
            'photos',
            'features',
        ])->firstOrFail();

        return Inertia::render('Public/Admin/Preschool/About', [
            'page' => $page,
        ]);
    }

    /**
     * Manage Our Classes
     */
    public function editClasses()
    {
        $page = PreschoolPage::with([
            'classes.points',
        ])->firstOrFail();

        return Inertia::render('Public/Admin/Preschool/Classes', [
            'page' => $page,
        ]);
    }


    public function updateAbout(Request $request)
    {
        $validated = $request->validate([
            'about_badge' => ['nullable', 'string', 'max:100'],
            'about_title' => ['required', 'string', 'max:255'],
            'about_description' => ['nullable', 'string'],
            'about_second_description' => ['nullable', 'string'],

            'features' => ['present', 'array'],
            'features.*.id' => ['nullable', 'integer'],
            'features.*.icon' => ['nullable', 'string', 'max:100'],
            'features.*.title' => ['required', 'string', 'max:255'],
            'features.*.description' => ['nullable', 'string'],
            'features.*.is_active' => ['required', 'boolean'],

            'remove_photos' => ['nullable', 'array'],
            'remove_photos.*' => ['integer'],

            'new_photos' => ['nullable', 'array'],
            'new_photos.*' => [
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
        ]);

        $page = PreschoolPage::firstOrFail();

        DB::transaction(function () use ($validated, $request, $page) {

            // Update About Information
            $page->update([
                'about_badge' => $validated['about_badge'] ?? null,
                'about_title' => $validated['about_title'],
                'about_description' => $validated['about_description'] ?? null,
                'about_second_description' => $validated['about_second_description'] ?? null,
            ]);

            // Update Features
            $submittedFeatureIds = [];

            foreach ($validated['features'] as $index => $item) {

                if (!empty($item['id'])) {
                    $feature = $page->features()
                        ->whereKey($item['id'])
                        ->firstOrFail();
                } else {
                    $feature = $page->features()->make();
                }

                $feature->fill([
                    'icon' => $item['icon'] ?? null,
                    'title' => $item['title'],
                    'description' => $item['description'] ?? null,
                    'sort_order' => $index + 1,
                    'is_active' => $item['is_active'],
                ]);

                $feature->save();

                $submittedFeatureIds[] = $feature->id;
            }

            $page->features()
                ->whereNotIn('id', $submittedFeatureIds)
                ->delete();

            // Remove Selected Photos
            if (!empty($validated['remove_photos'])) {
                $photos = $page->photos()
                    ->whereIn('id', $validated['remove_photos'])
                    ->get();

                foreach ($photos as $photo) {
                    Storage::disk('public')->delete($photo->image);
                    $photo->delete();
                }
            }

            // Upload New Photos
            if ($request->hasFile('new_photos')) {
                foreach ($request->file('new_photos') as $file) {
                    $path = $file->store('preschool/about', 'public');

                    $page->photos()->create([
                        'image' => $path,
                        'sort_order' => ($page->photos()->max('sort_order') ?? 0) + 1,
                        'is_active' => true,
                    ]);
                }
            }
        });

        return redirect()
            ->route('admin.preschool.about.edit')
            ->with('success', 'About Preschool updated successfully.');
    }


    public function updateClasses(Request $request)
    {
        $validated = $request->validate([
            'classes' => ['present', 'array'],

            'classes.*.id' => ['nullable', 'integer'],
            'classes.*.name' => ['required', 'string', 'max:255'],
            'classes.*.age_range' => ['nullable', 'string', 'max:100'],
            'classes.*.description' => ['nullable', 'string'],
            'classes.*.button_text' => ['nullable', 'string', 'max:100'],
            'classes.*.button_url' => ['nullable', 'string', 'max:255'],
            'classes.*.is_active' => ['required', 'boolean'],

            'classes.*.new_image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
            'classes.*.remove_image' => ['nullable', 'boolean'],

            'classes.*.points' => ['present', 'array'],
            'classes.*.points.*.id' => ['nullable', 'integer'],
            'classes.*.points.*.title' => ['required', 'string', 'max:255'],
            'classes.*.points.*.is_active' => ['required', 'boolean'],
        ]);

        $page = PreschoolPage::firstOrFail();

        DB::transaction(function () use ($validated, $request, $page) {
            $submittedClassIds = [];

            foreach ($validated['classes'] as $index => $item) {
                // Find existing class or create a new one
                if (!empty($item['id'])) {
                    $class = $page->classes()
                        ->whereKey($item['id'])
                        ->firstOrFail();
                } else {
                    $class = $page->classes()->make();
                }

                $class->fill([
                    'name' => $item['name'],
                    'age_range' => $item['age_range'] ?? null,
                    'description' => $item['description'] ?? null,
                    'button_text' => $item['button_text'] ?? 'Learn More',
                    'button_url' => $item['button_url'] ?? null,
                    'sort_order' => $index + 1,
                    'is_active' => $item['is_active'],
                ]);

                // Upload replacement image
                $newImage = $request->file("classes.$index.new_image");

                if ($newImage) {
                    if ($class->image) {
                        Storage::disk('public')->delete($class->image);
                    }

                    $class->image = $newImage->store(
                        'preschool/classes',
                        'public'
                    );
                } elseif (!empty($item['remove_image']) && $class->image) {
                    Storage::disk('public')->delete($class->image);
                    $class->image = null;
                }

                $class->save();

                $submittedClassIds[] = $class->id;

                // Save learning points
                $submittedPointIds = [];

                foreach ($item['points'] as $pointIndex => $pointItem) {
                    if (!empty($pointItem['id'])) {
                        $point = $class->points()
                            ->whereKey($pointItem['id'])
                            ->firstOrFail();
                    } else {
                        $point = $class->points()->make();
                    }

                    $point->fill([
                        'title' => $pointItem['title'],
                        'sort_order' => $pointIndex + 1,
                        'is_active' => $pointItem['is_active'],
                    ]);

                    $point->save();

                    $submittedPointIds[] = $point->id;
                }

                $class->points()
                    ->whereNotIn('id', $submittedPointIds)
                    ->delete();
            }

            // Remove classes omitted from the form
            $removedClasses = $page->classes()
                ->whereNotIn('id', $submittedClassIds)
                ->get();

            foreach ($removedClasses as $removedClass) {
                if ($removedClass->image) {
                    Storage::disk('public')->delete($removedClass->image);
                }

                $removedClass->delete();
            }
        });

        return redirect()
            ->route('admin.preschool.classes.edit')
            ->with('success', 'Preschool classes updated successfully.');
    }


}
