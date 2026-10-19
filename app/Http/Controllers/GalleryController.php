<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\Gallery_page_setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        $galleries = Gallery::query()
            ->when($request->search, function ($query, $search) {
                $query->where('title', 'like', "%{$search}%");
            })
            ->when(
                $request->category !== null && $request->category !== '' && $request->category !== 'all',
                function ($query) use ($request) {
                    $query->where('category', $request->category);
                }
            )
            ->when(
                $request->status !== null && $request->status !== '',
                function ($query) use ($request) {
                    $query->where('status', $request->status);
                }
            )
            ->orderBy('id', 'desc')
            ->paginate(12)
            ->withQueryString();

        return inertia('Public/Admin/Gallery/Index', [
            'galleries' => $galleries,
            'filters' => [
                'search' => $request->search,
                'category' => $request->category,
                'status' => $request->status,
            ],
        ]);
    }

    public function create()
    {
        return Inertia::render('Public/Admin/Gallery/Create');
    }

    public function store(Request $request)
    {
        // Validasi array data
        $request->validate([
            'items' => ['required', 'array', 'min:1'],
            'items.*.title' => ['required', 'string', 'max:255'],
            'items.*.description' => ['nullable', 'string'],
            'items.*.is_published' => ['boolean'],
            'items.*.show_on_home' => ['boolean'],
            'items.*.image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);

        DB::transaction(function () use ($request) {
            foreach ($request->file('items', []) as $index => $fileData) {
                // Tangkap data teks dari request
                $itemData = $request->input("items.{$index}");

                // Generate Unique Slug
                $slug = Str::slug($itemData['title']);
                $originalSlug = $slug;
                $count = 1;
                while (Gallery::where('slug', $slug)->exists()) {
                    $slug = "{$originalSlug}-" . $count++;
                }

                $imagePath = null;
                if (isset($fileData['image'])) {
                    $file = $fileData['image'];
                    $extension = strtolower($file->getClientOriginalExtension());
                    $fileName = 'gallery-' . $slug . '-' . time() . '-' . Str::random(4) . '.' . $extension;
                    $imagePath = $file->storeAs('galleries', $fileName, 'public');
                }

                Gallery::create([
                    'title' => $itemData['title'],
                    'slug' => $slug,
                    'category' => $itemData['category'],
                    'image_path' => $imagePath,
                    'description' => $itemData['description'] ?? null,
                    'is_published' => filter_var($itemData['is_published'] ?? true, FILTER_VALIDATE_BOOLEAN),
                    'show_on_home' => filter_var($itemData['show_on_home'] ?? true, FILTER_VALIDATE_BOOLEAN),
                ]);
            }
        });

        return redirect()
            ->route('admin.galleries.index')
            ->with('success', 'Galleries created successfully.');
    }

    public function edit(Gallery $gallery)
    {
        return Inertia::render('Public/Admin/Gallery/Edit', [
            'gallery' => [
                'id' => $gallery->id,
                'title' => $gallery->title,
                'description' => $gallery->description,
                'category' => $gallery->category,
                'is_published' => (bool) $gallery->is_published,
                'show_on_home' => (bool) $gallery->show_on_home,
                'image_path' => $gallery->image_path,
            ],
        ]);
    }

    public function update(Request $request, Gallery $gallery)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'category' => ['required', 'in:academic,events,sports,arts,field_trips'],
            'is_published' => ['boolean'],
            'show_on_home' => ['boolean'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);

        if ($gallery->title !== $request->title) {
            $slug = Str::slug($request->title);
            $originalSlug = $slug;
            $count = 1;
            while (Gallery::where('slug', $slug)->where('id', '!=', $gallery->id)->exists()) {
                $slug = "{$originalSlug}-" . $count++;
            }
            $gallery->slug = $slug;
        }

        if ($request->hasFile('image')) {
            if ($gallery->image_path && Storage::disk('public')->exists($gallery->image_path)) {
                Storage::disk('public')->delete($gallery->image_path);
            }

            $file = $request->file('image');
            $extension = strtolower($file->getClientOriginalExtension());
            $fileName = 'gallery-' . $gallery->slug . '-' . time() . '.' . $extension;
            $gallery->image_path = $file->storeAs('galleries', $fileName, 'public');
        }

        $gallery->title = $request->title;
        $gallery->description = $request->description;
        $gallery->category = $request->category;
        $gallery->is_published = filter_var($request->is_published, FILTER_VALIDATE_BOOLEAN);
        $gallery->show_on_home = filter_var($request->show_on_home, FILTER_VALIDATE_BOOLEAN);
        $gallery->save();

        return redirect()->route('admin.galleries.index')->with('success', 'Gallery updated successfully.');
    }

    public function destroy(Gallery $Gallery)
    {
        if (
            $Gallery->image &&
            Storage::disk('public')->exists($Gallery->image)
        ) {
            Storage::disk('public')->delete($Gallery->image);
        }

        $Gallery->delete();

        return redirect()
            ->route('admin.student-galleries.index')
            ->with('success', 'Student gallery deleted successfully.');
    }

    public function editHero()
    {
        $setting = Gallery_page_setting::first();

        if (!$setting) {
            $setting = Gallery_page_setting::create([
                'title' => 'Student Activities Gallery',
                'description' => 'Explore various student activities across academic, sports, arts, and field trips.',
                'primary_button_text' => 'Learn More',
                'primary_button_url' => '/about',
                'secondary_button_text' => 'Contact Us',
                'secondary_button_url' => '/contact',
                'is_active' => true,
            ]);
        }

        return Inertia::render('Public/Admin/Gallery/Header', [
            'setting' => $setting,
        ]);
    }

    public function updateHero(Request $request)
    {
        $setting = Gallery_page_setting::first();

        if (!$setting) {
            $setting = new Gallery_page_setting();
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

        if ($request->hasFile('background_image')) {
            if (
                $setting->background_image &&
                Storage::disk('public')->exists($setting->background_image)
            ) {
                Storage::disk('public')->delete($setting->background_image);
            }

            $file = $request->file('background_image');
            $extension = strtolower($file->getClientOriginalExtension());

            $fileName =
                'gallery-header-' .
                now()->format('YmdHis') .
                '-' .
                Str::random(8) .
                '.' .
                $extension;

            $validated['background_image'] = $file->storeAs(
                'student-galleries',
                $fileName,
                'public'
            );
        }

        $setting->fill($validated);
        $setting->is_active = $request->boolean('is_active');
        $setting->save();

        return redirect()
            ->route('admin.edit.galleries.header')
            ->with('success', 'Student gallery page header updated successfully.');
    }
}