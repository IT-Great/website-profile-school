<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Facility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;
use App\Models\Facility_page_setting;

class FacilityController extends Controller
{
    public function index(Request $request)
    {
        $facilities = Facility::query()
            ->when($request->search, function ($query, $search) {
                $query->where('title', 'like', "%{$search}%");
            })
            ->when(
                $request->status !== null &&
                $request->status !== '',
                function ($query) use ($request) {
                    $query->where(
                        'status',
                        $request->status
                    );
                }
            )
            ->orderBy('sort_order')
            ->orderBy('id')
            ->paginate(12)
            ->withQueryString();

        return inertia('Public/Admin/Facilities/index', [
            'facilities' => $facilities,
            'filters' => [
                'search' => $request->search,
                'status' => $request->status,
            ],
        ]);
    }


    public function create()
    {
        return Inertia::render('Public/Admin/Facilities/Create');
    }


    public function store(Request $request)
    {
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

            'icon' => [
                'nullable',
                'string',
                'max:100',
            ],

            'sort_order' => [
                'nullable',
                'integer',
                'min:0',
            ],

            'status' => [
                'boolean',
            ],

            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
        ]);

        $validated['status'] =
            $request->boolean('status');

        $validated['sort_order'] =
            $validated['sort_order'] ?? 0;


        if ($request->hasFile('image')) {

            $file = $request->file('image');

            $extension = strtolower(
                $file->getClientOriginalExtension()
            );

            $fileName =
                'facility-' .
                Str::slug($request->title) .
                '-' .
                now()->format('YmdHis') .
                '-' .
                Str::random(6) .
                '.' .
                $extension;

            $validated['image'] = $file->storeAs(
                'facilities',
                $fileName,
                'public'
            );
        }


        Facility::create($validated);

        return redirect()
            ->route('admin.facilities.index')
            ->with(
                'success',
                'Facility created successfully.'
            );
    }


    public function edit(Facility $facility)
    {
        return inertia('Public/Admin/Facilities/Edit', [
            'facility' => $facility,
        ]);
    }


    public function update(
        Request $request,
        Facility $facility
    ) {
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

            'icon' => [
                'nullable',
                'string',
                'max:100',
            ],

            'sort_order' => [
                'nullable',
                'integer',
                'min:0',
            ],

            'status' => [
                'boolean',
            ],

            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
        ]);

        $validated['status'] =
            $request->boolean('status');

        $validated['sort_order'] =
            $validated['sort_order'] ?? 0;


        if ($request->hasFile('image')) {

            if (
                $facility->image &&
                Storage::disk('public')->exists(
                    $facility->image
                )
            ) {
                Storage::disk('public')->delete(
                    $facility->image
                );
            }


            $file = $request->file('image');

            $extension = strtolower(
                $file->getClientOriginalExtension()
            );

            $fileName =
                'facility-' .
                Str::slug($request->title) .
                '-' .
                now()->format('YmdHis') .
                '-' .
                Str::random(6) .
                '.' .
                $extension;

            $validated['image'] = $file->storeAs(
                'facilities',
                $fileName,
                'public'
            );
        }


        $facility->update($validated);

        return redirect()
            ->route('admin.facilities.index')
            ->with(
                'success',
                'Facility updated successfully.'
            );
    }


    public function destroy(Facility $facility)
    {
        if (
            $facility->image &&
            Storage::disk('public')->exists(
                $facility->image
            )
        ) {
            Storage::disk('public')->delete(
                $facility->image
            );
        }

        $facility->delete();

        return redirect()
            ->route('admin.facilities.index')
            ->with(
                'success',
                'Facility deleted successfully.'
            );
    }

    public function editHero()
    {
        $setting = Facility_page_setting::first();

        if (!$setting) {
            $setting = Facility_page_setting::create([
                'title' => 'News',
                'description' => 'Great Crystal School and Course Center provides a complete academic journey through internationally and nationally recognized programs across Preschool, Primary, and Secondary.',
                'primary_button_text' => 'Get to Know',
                'primary_button_url' => '/about',
                'secondary_button_text' => 'Contact',
                'secondary_button_url' => '/contact',
                'is_active' => true,
            ]);
        }

        return Inertia::render(
            'Public/Admin/Facilities/Header',
            [
                'setting' => $setting,
            ]
        );
    }

    public function updateHero(Request $request)
    {
        $setting = Facility_page_setting::first();

        if (!$setting) {
            $setting = new Facility_page_setting();
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