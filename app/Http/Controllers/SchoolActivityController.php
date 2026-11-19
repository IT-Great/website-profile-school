<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\SchoolActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class SchoolActivityController extends Controller
{
    private const CLASSES = [
        'preschool',
        'kindergarten-A',
        'kindergarten-B',
        'primary',
        'lower primary',
        'upper primary',
        'secondary',
        'all class',
        'upper class',
    ];

    private const CATEGORIES = [
        'event',
        'fieldtrip',
        'school-activities',
    ];

    public function index()
    {
        return inertia('Public/Admin/SchoolActivities/Index', [
            'activities' => SchoolActivity::with('photos')
                ->latest()
                ->paginate(12),
        ]);
    }

    public function create()
    {
        return Inertia::render('Public/Admin/SchoolActivities/Create', [
            'classes' => self::CLASSES,
            'categories' => self::CATEGORIES,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'class_level' => ['required', Rule::in(self::CLASSES)],
            'location' => ['nullable', 'string', 'max:255'],
            'semester' => ['required', 'integer', Rule::in([1, 2])],
            'academic_year' => [
                'required',
                'regex:/^\d{4}-\d{4}$/',
            ],
            'category' => ['required', Rule::in(self::CATEGORIES)],
            'photos' => ['required', 'array', 'min:3', 'max:10'],
            'photos.*' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
            'is_active' => ['required', 'boolean'],
        ]);

        $activity = null;
        $storedPhotos = [];

        try {
            DB::transaction(function () use (
                $validated,
                $request,
                &$activity,
                &$storedPhotos
            ) {
                $slugBase = Str::slug($validated['name']) ?: 'activity';
                $slug = $slugBase;
                $counter = 1;

                while (SchoolActivity::where('slug', $slug)->exists()) {
                    $slug = $slugBase . '-' . $counter++;
                }

                $activity = SchoolActivity::create([
                    'name' => $validated['name'],
                    'slug' => $slug,
                    'class_level' => $validated['class_level'],
                    'location' => $validated['location'] ?? null,
                    'semester' => $validated['semester'],
                    'academic_year' => $validated['academic_year'],
                    'category' => $validated['category'],
                    'is_active' => $request->boolean('is_active'),
                ]);

                foreach ($request->file('photos') as $index => $photo) {
                    $path = $photo->store('school-activities', 'public');
                    $storedPhotos[] = $path;

                    $activity->photos()->create([
                        'image' => $path,
                        'sort_order' => $index,
                    ]);
                }
            });
        } catch (\Throwable $exception) {
            foreach ($storedPhotos as $path) {
                Storage::disk('public')->delete($path);
            }

            throw $exception;
        }

        return redirect()
            ->route('admin.school-activities.index')
            ->with('success', 'School activity successfully uploaded.');
    }

    public function edit(SchoolActivity $school_activity)
    {
        return Inertia::render('Public/Admin/SchoolActivities/Edit', [
            'activity' => $school_activity->load('photos'),
            'classes' => self::CLASSES,
            'categories' => self::CATEGORIES,
        ]);
    }

    public function update(Request $request, SchoolActivity $school_activity)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'class_level' => ['required', Rule::in(self::CLASSES)],
            'location' => ['nullable', 'string', 'max:255'],
            'semester' => ['required', 'integer', Rule::in([1, 2])],
            'academic_year' => [
                'required',
                'regex:/^\d{4}-\d{4}$/',
            ],
            'category' => ['required', Rule::in(self::CATEGORIES)],
            'photos' => ['nullable', 'array', 'max:10'],
            'photos.*' => [
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
            'remove_photos' => ['nullable', 'array'],
            'remove_photos.*' => [
                'integer',
                Rule::exists('school_activity_photos', 'id')
                    ->where('school_activity_id', $school_activity->id),
            ],
            'is_active' => ['required', 'boolean'],
        ]);

        $removeIds = $validated['remove_photos'] ?? [];
        $remainingCount = $school_activity->photos()
            ->whereNotIn('id', $removeIds ?: [0])
            ->count();

        $newPhotos = $request->file('photos', []);

        if ($remainingCount + count($newPhotos) < 3) {
            throw ValidationException::withMessages([
                'photos' => 'Setiap kegiatan harus memiliki minimal 3 foto.',
            ]);
        }

        if ($remainingCount + count($newPhotos) > 10) {
            throw ValidationException::withMessages([
                'photos' => 'Setiap kegiatan maksimal memiliki 10 foto.',
            ]);
        }

        $storedPhotos = [];

        try {
            DB::transaction(function () use (
                $request,
                $validated,
                $school_activity,
                $removeIds,
                $newPhotos,
                &$storedPhotos
            ) {
                $slugBase = Str::slug($validated['name']) ?: 'activity';
                $slug = $slugBase;
                $counter = 1;

                while (
                    SchoolActivity::where('slug', $slug)
                        ->where('id', '!=', $school_activity->id)
                        ->exists()
                ) {
                    $slug = $slugBase . '-' . $counter++;
                }

                $school_activity->update([
                    'name' => $validated['name'],
                    'slug' => $slug,
                    'class_level' => $validated['class_level'],
                    'location' => $validated['location'] ?? null,
                    'semester' => $validated['semester'],
                    'academic_year' => $validated['academic_year'],
                    'category' => $validated['category'],
                    'is_active' => $request->boolean('is_active'),
                ]);

                $removedPhotos = $school_activity->photos()
                    ->whereIn('id', $removeIds)
                    ->get();

                foreach ($removedPhotos as $photo) {
                    Storage::disk('public')->delete($photo->image);
                    $photo->delete();
                }

                $nextOrder = $school_activity->photos()->count();

                foreach ($newPhotos as $photo) {
                    $path = $photo->store('school-activities', 'public');
                    $storedPhotos[] = $path;

                    $school_activity->photos()->create([
                        'image' => $path,
                        'sort_order' => $nextOrder++,
                    ]);
                }
            });
        } catch (\Throwable $exception) {
            foreach ($storedPhotos as $path) {
                Storage::disk('public')->delete($path);
            }

            throw $exception;
        }

        return redirect()
            ->route('admin.school-activities.index')
            ->with('success', 'School activity successfully updated.');
    }

    public function destroy(SchoolActivity $school_activity)
    {
        foreach ($school_activity->photos as $photo) {
            Storage::disk('public')->delete($photo->image);
        }

        $school_activity->delete();

        return back()->with('success', 'School activity successfully deleted.');
    }

    public function show(SchoolActivity $school_activity)
    {
        $school_activity->load('photos');

        return inertia('Public/Admin/SchoolActivities/Show', [
            'activity' => $school_activity,
        ]);
    }
}
