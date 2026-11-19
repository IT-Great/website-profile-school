<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Our_program;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use App\Models\Program_page_setting;

class OurProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {   
        $ourprograms = Our_program::query()
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

        return inertia('Public/Admin/OurPrograms/Index', [
            'ourprograms' => $ourprograms,
            'filters' => [
                'search' => $request->search,
                'status' => $request->status,
            ],
        ]);
    }

    public function create()
    {
        return Inertia::render('Public/Admin/OurPrograms/Create');
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
            $fileName = 'ourprograms-' . Str::slug($request->title) . '-' . time() . '.' . $extension;
            $validated['image_path'] = $file->storeAs('ourprograms', $fileName, 'public');
        }

        Our_program::create($validated);

        return redirect()
            ->route('admin.ourprograms.index')
            ->with('success', 'Our Program item created successfully.');
    }

    public function edit($id)
    {
        $ourprograms = Our_program::findOrFail($id);
        return Inertia::render('Public/Admin/OurPrograms/Edit', [
            'ourprograms' => [
                'id' => $ourprograms->id,
                'badge_title' => $ourprograms->badge_title,
                'title' => $ourprograms->title,
                'description' => $ourprograms->description,
                'features' => $ourprograms->features ?? [],
                'image_position' => $ourprograms->image_position,
                'sort_order' => $ourprograms->sort_order,
                'status' => (bool) $ourprograms->status,
                'image_path' => $ourprograms->image_path,
                'image_url' => $ourprograms->image_url,
            ],
        ]);
    }

    public function update(Request $request, Our_program $ourprograms)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                'alpha_dash',
                Rule::unique('our_programs', 'slug')->ignore($ourprograms->id),
            ],
            'icon' => ['nullable', 'string', 'max:100'],
            'age_range' => ['nullable', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'features' => ['nullable', 'array'],
            'features.*' => ['nullable', 'string', 'max:255'],
            'button_text' => ['nullable', 'string', 'max:100'],
            'button_url' => ['nullable', 'string', 'max:2048'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        $validated['slug'] = $this->makeSlug(
            $validated['slug'] ?? $validated['title'],
            $ourprograms->id
        );

        $validated['features'] = array_values(array_filter(
            $validated['features'] ?? [],
            fn ($feature) => is_string($feature) && trim($feature) !== ''
        ));

        $validated['button_text'] = $validated['button_text'] ?? 'Learn More';
        $validated['sort_order'] = $validated['sort_order'] ?? 0;
        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            if ($ourprograms->image) {
                Storage::disk('public')->delete($ourprograms->image);
            }

            $validated['image'] = $request->file('image')
                ->store('programs', 'public');
        } else {
            unset($validated['image']);
        }

        $ourprograms->update($validated);

        return redirect()
            ->route('admin.ourprograms.index')
            ->with('success', 'Program berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $ourprograms = Our_program::findOrFail($id);
        if ($ourprograms->image) {
            Storage::disk('public')->delete($ourprograms->image);
        }

        $ourprograms->delete();

        return redirect()
            ->route('admin.ourprograms.index')
            ->with('success', 'Program berhasil dihapus.');
    }

    public function toggleStatus(Our_program $ourprograms)
    {
        $ourprograms->update([
            'is_active' => ! $ourprograms->is_active,
        ]);

        return back()->with('success', 'Status program berhasil diperbarui.');
    }

    private function makeSlug(string $value, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($value) ?: 'program';
        $slug = $baseSlug;
        $counter = 1;

        while (
            Our_program::where('slug', $slug)
                ->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $baseSlug . '-' . $counter++;
        }

        return $slug;
    }

    public function editHero()
    {
        $setting = Program_page_setting::first();

        if (!$setting) {
            $setting = Program_page_setting::create([
                'title' => 'Programs at Great Crystal School',
                'description' => 'Great Crystal School and Course Center provides a complete academic journey through internationally and nationally recognized programs across Preschool, Primary, and Secondary.',
                'primary_button_text' => 'Get to Know',
                'primary_button_url' => '/about',
                'secondary_button_text' => 'Contact',
                'secondary_button_url' => '/contact',
                'is_active' => true,
            ]);
        }

        return Inertia::render(
            'Public/Admin/OurPrograms/Header',
            [
                'setting' => $setting,
            ]
        );
    }

    public function updateHero(Request $request)
    {
        $setting = Program_page_setting::first();

        if (!$setting) {
            $setting = new Program_page_setting();
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
            ->route('admin.edit.facilities.header')
            ->with(
                'success',
                'Facility page header updated successfully.'
            );
    }
}
