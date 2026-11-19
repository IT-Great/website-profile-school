<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\StudentAchievement;
use App\Models\Achievement_page_setting;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class StudentAchievementController extends Controller
{
    /**
     * Display achievements with search, filters, and pagination.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $category = $request->input('category');
        $status = $request->input('status');

        $achievements = StudentAchievement::query()
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                        ->orWhere('student_name', 'like', "%{$search}%")
                        ->orWhere('competition_name', 'like', "%{$search}%")
                        ->orWhere('award', 'like', "%{$search}%");
                });
            })
            ->when($category, function ($query, $category) {
                $query->where('category', $category);
            })
            ->when($status !== null && $status !== '', function ($query) use ($status) {
                $query->where('is_active', $status === 'published');
            })
            ->latest('created_at')
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Public/Admin/StudentAchievements/Index', [
            'achievements' => $achievements,
            'filters' => [
                'search' => $search ?? '',
                'category' => $category ?? '',
                'status' => $status ?? '',
            ],
            'categories' => [
                'Academic',
                'Sports',
                'Arts',
                'Technology',
                'Other',
            ],
            'statistics' => [
                'total' => StudentAchievement::count(),
                'published' => StudentAchievement::where('is_active', true)->count(),
                'draft' => StudentAchievement::where('is_active', false)->count(),
            ],
        ]);
    }

    /**
     * Show the create form.
     */
    public function create()
    {
        return Inertia::render('Public/Admin/StudentAchievements/Create', [
            'categories' => [
                'Academic',
                'Sports',
                'Arts',
                'Technology',
                'Other',
            ],
            'levels' => [
                'School',
                'City',
                'Regional',
                'National',
                'International',
            ],
        ]);
    }

    /**
     * Store a new achievement.
     */
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'students' => ['required', 'array', 'min:1', 'max:50'],

            'students.*.title' => ['required', 'string', 'max:255'],
            'students.*.student_name' => ['required', 'string', 'max:255'],
            'students.*.student_class' => ['nullable', 'string', 'max:100'],
            'students.*.competition_name' => ['required', 'string', 'max:255'],
            'students.*.category' => [
                'required',
                \Illuminate\Validation\Rule::in([
                    'Academic', 'Sports', 'Arts', 'Technology', 'Other',
                ]),
            ],
            'students.*.award' => ['required', 'string', 'max:255'],
            'students.*.achievement_level' => [
                'required',
                \Illuminate\Validation\Rule::in([
                    'School', 'City', 'Regional', 'National', 'International',
                ]),
            ],
            'students.*.achievement_date' => ['required', 'date'],
            'students.*.description' => ['nullable', 'string'],
            'students.*.image' => [
                'nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120',
            ],
            'students.*.is_active' => ['required', 'boolean'],
        ]);

        \Illuminate\Support\Facades\DB::transaction(function () use ($validated, $request) {
            foreach ($validated['students'] as $index => $data) {
                $imagePath = null;

                if ($request->hasFile("students.{$index}.image")) {
                    $imagePath = $request
                        ->file("students.{$index}.image")
                        ->store('achievements', 'public');
                }

                $title = $data['title'];

                StudentAchievement::create([
                    'title' => $title,
                    'slug' => $this->generateUniqueSlug($title),
                    'student_name' => $data['student_name'],
                    'student_class' => $data['student_class'] ?? null,
                    'competition_name' => $data['competition_name'],
                    'category' => $data['category'],
                    'award' => $data['award'],
                    'achievement_level' => $data['achievement_level'],
                    'achievement_date' => $data['achievement_date'],
                    'description' => $data['description'] ?? null,
                    'image' => $imagePath,
                    'is_active' => $data['is_active'],
                ]);
            }
        });

        return redirect()
            ->route('admin.achievements.index')
            ->with('success', count($validated['students']) . ' prestasi berhasil ditambahkan.');
    }


    /**
     * Show the edit form.
     */
    public function edit($id)
    {
        $achievement = StudentAchievement::findOrFail($id);

        return Inertia::render(
            'Public/Admin/StudentAchievements/Edit',
            [
                'achievement' => $achievement,
                'categories' => [
                    'Academic',
                    'Sports',
                    'Arts',
                    'Technology',
                    'Other',
                ],
                'levels' => [
                    'School',
                    'City',
                    'Regional',
                    'National',
                    'International',
                ],
            ]
        );
    }

    /**
     * Update an existing achievement.
     */
    public function update(
        Request $request,
        StudentAchievement $studentAchievement
    ) {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'student_name' => ['required', 'string', 'max:255'],
            'student_class' => ['nullable', 'string', 'max:100'],
            'competition_name' => ['required', 'string', 'max:255'],
            'category' => [
                'required',
                Rule::in(['Academic', 'Sports', 'Arts', 'Technology', 'Other']),
            ],
            'award' => ['required', 'string', 'max:255'],
            'achievement_level' => [
                'required',
                Rule::in([
                    'School',
                    'City',
                    'Regional',
                    'National',
                    'International',
                ]),
            ],
            'achievement_date' => ['required', 'date'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'is_active' => ['required', 'boolean'],
        ]);

        if ($request->hasFile('image')) {
            if ($studentAchievement->image) {
                Storage::disk('public')->delete($studentAchievement->image);
            }

            $validated['image'] = $request->file('image')
                ->store('achievements', 'public');
        }

        if ($studentAchievement->title !== $validated['title']) {
            $validated['slug'] = $this->generateUniqueSlug(
                $validated['title'],
                $studentAchievement->id
            );
        }

        $studentAchievement->update($validated);

        return redirect()
            ->route('admin.achievements.index')
            ->with('success', 'Student achievement updated successfully.');
    }

    /**
     * Delete an achievement and its uploaded image.
     */
    
    public function destroy($id)
    {
        try {
            $achievement = StudentAchievement::findOrFail($id);

            // Hapus gambar dari storage jika ada
            if ($achievement->image) {
                Storage::disk('public')->delete($achievement->image);
            }

            // Hapus data prestasi
            $achievement->delete();

            return redirect()
                ->route('admin.achievements.index')
                ->with('success', 'Prestasi siswa berhasil dihapus.');
        } catch (\Throwable $e) {
            Log::error('Gagal menghapus prestasi siswa', [
                'id' => $id,
                'message' => $e->getMessage(),
            ]);

            return redirect()
                ->back()
                ->with('error', 'Prestasi gagal dihapus. Silakan periksa log Laravel.');
        }
    }

    /**
     * Generate a unique slug.
     */
    private function generateUniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($title);
        $slug = $baseSlug;
        $counter = 1;

        while (
            StudentAchievement::query()
                ->where('slug', $slug)
                ->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    public function editHero()
    {
        $setting = Achievement_page_setting::first();

        if (!$setting) {
            $setting = Achievement_page_setting::create([
                'title' => 'Achievements',
                'description' => 'Great Crystal School and Course Center provides a complete academic journey through internationally and nationally recognized programs across Preschool, Primary, and Secondary.',
                'primary_button_text' => 'Get to Know',
                'primary_button_url' => '/about',
                'secondary_button_text' => 'Contact',
                'secondary_button_url' => '/contact',
                'is_active' => true,
            ]);
        }

        return Inertia::render(
            'Public/Admin/StudentAchievements/Header',
            [
                'setting' => $setting,
            ]
        );
    }

    public function updateHero(Request $request)
    {
        $setting = Achievement_page_setting::first();

        if (!$setting) {
            $setting = new Achievement_page_setting();
        }

        $validated = $request->validate([
            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'background_image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],

            'primary_button_text' => [
                'nullable',
                'string',
                'max:100',
            ],

            'primary_button_url' => [
                'nullable',
                'string',
                'max:500',
            ],

            'secondary_button_text' => [
                'nullable',
                'string',
                'max:100',
            ],

            'secondary_button_url' => [
                'nullable',
                'string',
                'max:500',
            ],

            'is_active' => [
                'boolean',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Background Image
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('background_image')) {

            if (
                $setting->background_image &&
                Storage::disk('public')->exists(
                    $setting->background_image
                )
            ) {
                Storage::disk('public')->delete(
                    $setting->background_image
                );
            }

            $file = $request->file('background_image');

            $extension = strtolower(
                $file->getClientOriginalExtension()
            );

            $fileName =
                'achievements-header-' .
                now()->format('YmdHis') .
                '-' .
                Str::random(8) .
                '.' .
                $extension;

            $path = $file->storeAs(
                'achievements',
                $fileName,
                'public'
            );

            $validated['background_image'] = $path;
        }

        $setting->fill($validated);

        $setting->is_active =
            $request->boolean('is_active');

        $setting->save();

        return redirect()
            ->route('admin.achievements.edit.header')
            ->with(
                'success',
                'Achievements page header updated successfully.'
            );
    }
}
