<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Curriculum;
use App\Models\Curriculum_page_setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;

class CurriculumController extends Controller
{
    public function index(Request $request)
    {
        $curricula = Curriculum::query()
            ->when($request->search, function ($query, $search) {
                $query->where('title', 'like', "%{$search}%")
                      ->orWhere('badge_title', 'like', "%{$search}%");
            })
            ->when($request->status !== null && $request->status !== '', function ($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->orderBy('sort_order')
            ->orderBy('id')
            ->paginate(12)
            ->withQueryString();

        return inertia('Public/Admin/Curriculum/Index', [
            'curricula' => $curricula,
            'filters' => [
                'search' => $request->search,
                'status' => $request->status,
            ],
        ]);
    }

    public function create()
    {
        return Inertia::render('Public/Admin/Curriculum/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'badge_title' => ['required', 'string', 'max:255'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'features' => ['nullable', 'array'],
            'features.*' => ['nullable', 'string', 'max:255'],
            'image_position' => ['required', 'in:left,right'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'status' => ['boolean'],
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);

        $validated['status'] = $request->boolean('status');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        // Clean empty features
        if (isset($validated['features'])) {
            $validated['features'] = array_values(array_filter($validated['features']));
        }

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = strtolower($file->getClientOriginalExtension());
            $fileName = 'curriculum-' . Str::slug($request->title) . '-' . time() . '.' . $extension;
            $validated['image_path'] = $file->storeAs('curriculum', $fileName, 'public');
        }

        Curriculum::create($validated);

        return redirect()
            ->route('admin.curriculum.index')
            ->with('success', 'Curriculum item created successfully.');
    }

    public function edit(Curriculum $curriculum)
    {
        return Inertia::render('Public/Admin/Curriculum/Edit', [
            'curriculum' => [
                'id' => $curriculum->id,
                'badge_title' => $curriculum->badge_title,
                'title' => $curriculum->title,
                'description' => $curriculum->description,
                'features' => $curriculum->features ?? [],
                'image_position' => $curriculum->image_position,
                'sort_order' => $curriculum->sort_order,
                'status' => (bool) $curriculum->status,
                'image_path' => $curriculum->image_path,
                'image_url' => $curriculum->image_url,
            ],
        ]);
    }

    public function update(Request $request, Curriculum $curriculum)
    {
        $validated = $request->validate([
            'badge_title' => ['required', 'string', 'max:255'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'features' => ['nullable', 'array'],
            'features.*' => ['nullable', 'string', 'max:255'],
            'image_position' => ['required', 'in:left,right'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'status' => ['boolean'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);

        $validated['status'] = $request->boolean('status');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        if (isset($validated['features'])) {
            $validated['features'] = array_values(array_filter($validated['features']));
        }

        if ($request->hasFile('image')) {
            if ($curriculum->image_path && Storage::disk('public')->exists($curriculum->image_path)) {
                Storage::disk('public')->delete($curriculum->image_path);
            }

            $file = $request->file('image');
            $extension = strtolower($file->getClientOriginalExtension());
            $fileName = 'curriculum-' . Str::slug($request->title) . '-' . time() . '.' . $extension;
            $validated['image_path'] = $file->storeAs('curriculum', $fileName, 'public');
        }

        $curriculum->update($validated);

        return redirect()
            ->route('admin.curriculum.index')
            ->with('success', 'Curriculum item updated successfully.');
    }

    public function destroy(Curriculum $curriculum)
    {
        if ($curriculum->image_path && Storage::disk('public')->exists($curriculum->image_path)) {
            Storage::disk('public')->delete($curriculum->image_path);
        }

        $curriculum->delete();

        return redirect()
            ->route('admin.curriculum.index')
            ->with('success', 'Curriculum item deleted successfully.');
    }

    public function editHero()
    {
        $setting = Curriculum_page_setting::first();

        if (!$setting) {
            $setting = Curriculum_page_setting::create([
                'title' => 'Curriculum',
                'description' => 'Great Crystal School and Course Center provides a complete academic journey through internationally and nationally recognized programs across Preschool, Primary, and Secondary.',
                'primary_button_text' => 'Get to Know',
                'primary_button_url' => '/about',
                'secondary_button_text' => 'Contact',
                'secondary_button_url' => '/contact',
                'is_active' => true,
            ]);
        }

        return Inertia::render(
            'Public/Admin/Curriculum/Header',
            [
                'setting' => $setting,
            ]
        );
    }

    public function updateHero(Request $request)
    {
        $setting = Curriculum_page_setting::first();

        if (!$setting) {
            $setting = new Curriculum_page_setting();
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
                'facilities-header-' .
                now()->format('YmdHis') .
                '-' .
                Str::random(8) .
                '.' .
                $extension;

            $path = $file->storeAs(
                'facilities',
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
            ->route('admin.edit.curriculum.header')
            ->with(
                'success',
                'Curriculum page header updated successfully.'
            );
    }
}