<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Header_page_settings;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class HeaderPageSettingController extends Controller
{
     public function index()
    {
        return Inertia::render('Public/Admin/Header/Index', [
            'pages' => Header_page_settings::orderBy('id')->get(),
        ]);
    }

    public function edit(Header_page_settings $headerPage)
    {
        return Inertia::render('Public/Admin/Header/Edit', [
            'page' => $headerPage,
        ]);
    }

    public function update(Request $request, Header_page_settings $headerPage)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'background_image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
            'primary_button_text' => ['nullable', 'string', 'max:255'],
            'primary_button_url' => ['nullable', 'string', 'max:2048'],
            'secondary_button_text' => ['nullable', 'string', 'max:255'],
            'secondary_button_url' => ['nullable', 'string', 'max:2048'],
            'is_active' => ['required', 'boolean'],
        ]);

        if ($request->hasFile('background_image')) {
            $newImage = $request->file('background_image')
                ->store('header-pages', 'public');

            if ($headerPage->background_image) {
                Storage::disk('public')->delete(
                    $headerPage->background_image
                );
            }

            $validated['background_image'] = $newImage;
        } else {
            unset($validated['background_image']);
        }

        $headerPage->update($validated);

        return redirect()
            ->route('admin.header-pages.index')
            ->with('success', 'Header halaman berhasil diperbarui.');
    }

    public function toggleStatus(Header_page_settings $headerPage)
    {
        $headerPage->update([
            'is_active' => ! $headerPage->is_active,
        ]);

        return back()->with('success', 'Status header berhasil diperbarui.');
    }
}
