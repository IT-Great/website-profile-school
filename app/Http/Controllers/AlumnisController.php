<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Alumni;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;

class AlumnisController extends Controller
{
    public function index(Request $request)
    {
        $query = Alumni::query();

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('position', 'like', '%' . $request->search . '%')
                    ->orWhere('company', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->status === 'active') {
            $query->where('is_active', true);
        }

        if ($request->status === 'inactive') {
            $query->where('is_active', false);
        }

        $alumni = $query
            ->orderBy('sort_order')
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Public/Admin/Alumni/Index', [
            'alumni' => $alumni,
            'filters' => [
                'search' => $request->search,
                'status' => $request->status,
            ],
        ]);
    }

    public function create()
    {
        return Inertia::render('Public/Admin/Alumni/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'alumni' => [
                'required',
                'array',
                'min:1',
            ],

            'alumni.*.name' => [
                'required',
                'string',
                'max:255',
            ],

            'alumni.*.position' => [
                'nullable',
                'string',
                'max:255',
            ],

            'alumni.*.company' => [
                'nullable',
                'string',
                'max:255',
            ],

            'alumni.*.testimonial' => [
                'nullable',
                'string',
            ],

            'alumni.*.photo' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],

            'alumni.*.is_active' => [
                'boolean',
            ],
        ]);

        foreach ($request->input('alumni', []) as $index => $data) {

            $validated = [
                'name' => $data['name'],
                'position' => $data['position'] ?? null,
                'company' => $data['company'] ?? null,
                'testimonial' => $data['testimonial'] ?? null,
                'sort_order' => $index + 1,
                'is_active' => filter_var(
                    $data['is_active'] ?? true,
                    FILTER_VALIDATE_BOOLEAN
                ),
            ];

            /*
            |--------------------------------------------------------------------------
            | Photo
            |--------------------------------------------------------------------------
            */

            if ($request->hasFile("alumni.$index.photo")) {

                $file = $request->file("alumni.$index.photo");

                $extension = strtolower(
                    $file->getClientOriginalExtension()
                );

                $fileName =
                    'alumni-' .
                    Str::slug($data['name']) .
                    '-' .
                    now()->format('YmdHis') .
                    '-' .
                    Str::random(6) .
                    '.' .
                    $extension;

                $validated['photo'] = $file->storeAs(
                    'alumni',
                    $fileName,
                    'public'
                );
            }

            Alumni::create($validated);
        }

        return redirect()
            ->route('admin.alumnis.index')
            ->with(
                'success',
                $request->input('alumni')
                    ? count($request->input('alumni')) . ' alumni added successfully.'
                    : 'Alumni added successfully.'
            );
    }

    public function edit(Alumni $alumni)
    {
        return Inertia::render('Public/Admin/Alumni/Edit', [
            'alumni' => $alumni,
        ]);
    }

    public function update(
        Request $request,
        Alumni $alumni
    ) {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'position' => [
                'nullable',
                'string',
                'max:255',
            ],

            'company' => [
                'nullable',
                'string',
                'max:255',
            ],

            'testimonial' => [
                'nullable',
                'string',
            ],

            'photo' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],

            'sort_order' => [
                'nullable',
                'integer',
                'min:0',
            ],

            'is_active' => [
                'boolean',
            ],
        ]);

        if ($request->hasFile('photo')) {

            if (
                $alumni->photo &&
                Storage::disk('public')->exists(
                    $alumni->photo
                )
            ) {
                Storage::disk('public')->delete(
                    $alumni->photo
                );
            }

            $file = $request->file('photo');

            $extension = strtolower(
                $file->getClientOriginalExtension()
            );

            $fileName =
                'alumni-' .
                Str::slug($request->name) .
                '-' .
                now()->format('YmdHis') .
                '-' .
                Str::random(6) .
                '.' .
                $extension;

            $validated['photo'] = $file->storeAs(
                'alumni',
                $fileName,
                'public'
            );
        }

        $validated['is_active'] =
            $request->boolean('is_active');

        $alumni->update($validated);

        return redirect()
            ->route('admin.alumnis.index')
            ->with(
                'success',
                'Alumni updated successfully.'
            );
    }

    public function destroy(Alumni $alumni)
    {
        if (
            $alumni->photo &&
            Storage::disk('public')->exists(
                $alumni->photo
            )
        ) {
            Storage::disk('public')->delete(
                $alumni->photo
            );
        }

        $alumni->delete();

        return redirect()
            ->route('admin.alumnis.index')
            ->with(
                'success',
                'Alumni deleted successfully.'
            );
    }
}