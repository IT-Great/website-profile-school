<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Home_hero;
use App\Models\Home_about;
use App\Models\Home_about_point;
use App\Models\Home_program;
use App\Models\Why_choose_us_settings;
use App\Models\Why_choose_settings;
use App\Models\Home_admissions;
use App\Models\Home_admission_stats;
use App\Models\Get_in_touch;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class HomepageController extends Controller
{
    // Halaman edit hero section
    public function edit()
    {
        $hero = Home_hero::first();

        return inertia('Public/Admin/Home/Home-hero', [
            'hero' => $hero,
        ]);
    }
    // Update hero section
    
        public function update(Request $request)
        {
            $request->validate([
                'badge' => 'nullable|string|max:255',
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',

                'background_image' => 'nullable|array',
                'background_image.*' => 'image|mimes:jpg,jpeg,png,webp|max:5120',

                'primary_button_text' => 'nullable|string|max:255',
                'primary_button_url' => 'nullable|string|max:255',

                'secondary_button_text' => 'nullable|string|max:255',
                'secondary_button_url' => 'nullable|string|max:255',

                'is_active' => 'nullable|boolean',
            ]);

            $hero = Home_hero::firstOrNew();

            $hero->badge = $request->badge;
            $hero->title = $request->title;
            $hero->description = $request->description;

            $hero->primary_button_text = $request->primary_button_text;
            $hero->primary_button_url = $request->primary_button_url;

            $hero->secondary_button_text = $request->secondary_button_text;
            $hero->secondary_button_url = $request->secondary_button_url;

            // Pertahankan gambar yang sudah tersimpan
            $images = $hero->background_image ?? [];

            // Upload gambar baru jika ada
            foreach ($request->file('background_image', []) as $image) {
                $images[] = $image->store('images', 'public');
            }

            $hero->background_image = $images;
            $hero->is_active = $request->boolean('is_active');

            $hero->save();

            return back()->with(
                'success',
                'Hero section berhasil diperbarui.'
            );
        }


    // Halaman edit about section
    public function editAbout(){

        $about = Home_about::with([
            'points' => function ($query) {
                $query->orderBy('sort_order');
            }
        ])->first();

        return inertia('Public/Admin/Home/Home-about', [
            'about' => $about,
        ]);
    }

    // Update about section
    public function updateAbout(Request $request)
    {
        $request->validate([
            'badge' => 'nullable|string|max:255',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',

            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',

            'button_text' => 'nullable|string|max:255',
            'button_url' => 'nullable|string|max:255',

            'is_active' => 'nullable|boolean',

            'points' => 'nullable|array',
            'points.*.text' => 'required|string|max:255',
        ]);

        DB::transaction(function () use ($request) {

            $about = Home_about::firstOrNew();

            $about->badge = $request->badge;
            $about->title = $request->title;
            $about->description = $request->description;

            $about->button_text = $request->button_text;
            $about->button_url = $request->button_url;

            $about->is_active = $request->boolean('is_active');


            /*
            |--------------------------------------------------------------------------
            | IMAGE
            |--------------------------------------------------------------------------
            */

            if ($request->hasFile('image')) {

                $file = $request->file('image');

                /*
                | Delete old image
                */
                if (
                    $about->image &&
                    Storage::disk('public')->exists($about->image)
                ) {
                    Storage::disk('public')->delete($about->image);
                }

                /*
                | Generate new filename
                */
                $extension = $file->getClientOriginalExtension();

                $fileName =
                    Str::slug($request->title)
                    . '-'
                    . date('Y-m-d_H-i-s')
                    . '.'
                    . $extension;

                /*
                | Save image
                */
                $about->image = $file->storeAs(
                    'home/about',
                    $fileName,
                    'public'
                );
            }


            $about->save();


            /*
            |--------------------------------------------------------------------------
            | ABOUT POINTS
            |--------------------------------------------------------------------------
            */

            $ids = [];

            foreach (
                $request->input('points', [])
                as $index => $point
            ) {

                $aboutPoint = Home_about_point::updateOrCreate(
                    [
                        'id' => $point['id'] ?? null,
                    ],
                    [
                        'home_about_id' => $about->id,
                        'text' => $point['text'],
                        'sort_order' => $index,
                    ]
                );

                $ids[] = $aboutPoint->id;
            }


            if (count($ids) > 0) {

                Home_about_point::where(
                    'home_about_id',
                    $about->id
                )
                    ->whereNotIn('id', $ids)
                    ->delete();

            } else {

                Home_about_point::where(
                    'home_about_id',
                    $about->id
                )->delete();

            }

        });


        return back()->with(
            'success',
            'Homepage About berhasil diperbarui.'
        );
    }

    // Halaman edit program section
    public function editPrograms()
    {
        $programs = Home_program::orderBy('sort_order')
            ->orderBy('id')
            ->get();

        return inertia('Public/Admin/Home/Home-program', [
            'programs' => $programs,
        ]);
    }

    public function updatePrograms(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'programs' => 'required|array',

            'programs.*.id' => 'nullable|integer',

            'programs.*.icon' => 'nullable|string|max:255',

            'programs.*.title' => 'required|string|max:255',

            'programs.*.age_range' => 'nullable|string|max:255',

            'programs.*.description' => 'nullable|string',

            'programs.*.button_text' => 'nullable|string|max:255',

            'programs.*.button_url' => 'nullable|string|max:255',

            'programs.*.is_active' => 'nullable|boolean',
        ]);


        DB::transaction(function () use ($request) {

            $ids = [];

            foreach ($request->programs as $index => $program) {

                /*
                |--------------------------------------------------------------------------
                | Existing Program
                |--------------------------------------------------------------------------
                */

                if (!empty($program['id'])) {

                    $homeProgram = Home_program::findOrFail(
                        $program['id']
                    );

                }

                /*
                |--------------------------------------------------------------------------
                | New Program
                |--------------------------------------------------------------------------
                */

                else {

                    $homeProgram = new Home_program();

                }


                $homeProgram->icon =
                    $program['icon'] ?? null;

                $homeProgram->title =
                    $program['title'];

                $homeProgram->age_range =
                    $program['age_range'] ?? null;

                $homeProgram->description =
                    $program['description'] ?? null;

                $homeProgram->button_text =
                    $program['button_text'] ?? null;

                $homeProgram->button_url =
                    $program['button_url'] ?? null;

                /*
                * Posisi mengikuti urutan array dari Vue.
                */
                $homeProgram->sort_order = $index;

                $homeProgram->is_active =
                    filter_var(
                        $program['is_active'] ?? true,
                        FILTER_VALIDATE_BOOLEAN
                    );

                $homeProgram->save();

                $ids[] = $homeProgram->id;
            }


            /*
            |--------------------------------------------------------------------------
            | Delete Program yang dihapus dari form
            |--------------------------------------------------------------------------
            */

            Home_program::whereNotIn('id', $ids)->delete();

        });


        return back()->with(
            'success',
            'Homepage Programs berhasil diperbarui.'
        );
    }

    public function editWhyChoose()
    {
        $setting = Why_choose_settings::first();

        $items = Why_choose_settings::orderBy('id')
            ->get();

        return inertia('Public/Admin/Home/Home-whychooseus', [
            'setting' => $setting,
            'items' => $items,
        ]);
    }

    public function updateWhyChoose(Request $request)
    {
        $request->validate([
            'badge' => 'nullable|string|max:255',
            'title' => 'required|string|max:255',
            'is_active' => 'nullable|boolean',
            'items' => 'nullable|array',
            'items.*.id' => 'nullable|integer',
            'items.*.icon' => 'nullable|string|max:255',
            'items.*.title' => 'required|string|max:255',
            'items.*.description' => 'nullable|string',
            'items.*.is_active' => 'nullable|boolean',
        ]);

        DB::transaction(function () use ($request) {
            $ids = [];
            foreach (
                $request->input('items', [])
                as $index => $item
            ) {
                if (!empty($item['id'])) {
                    $whyChoose = Why_choose_settings::findOrFail(
                        $item['id']
                    );
                } else {
                    $whyChoose = new Why_choose_settings();
                }

                $whyChoose->icon = $item['icon'] ?? null;
                $whyChoose->title = $item['title'];
                $whyChoose->description = $item['description'] ?? null;
                $whyChoose->sort_order = $index;
                $whyChoose->is_active =
                    filter_var(
                        $item['is_active'] ?? true,
                        FILTER_VALIDATE_BOOLEAN
                    );
                $whyChoose->save();
                $ids[] = $whyChoose->id;
            }


            if (count($ids) > 0) {
                Why_choose_settings::whereNotIn('id',$ids)->delete();
            } else {
                Why_choose_settings::query()->delete();
            }
        });


        return back()->with(
            'success',
            'Why Choose Us berhasil diperbarui.'
        );
    }

    public function editAdmission()
    {
        $admission = Home_admissions::with([
            'stats' => function ($query) {
                $query->orderBy('sort_order');
            }
        ])->first();

        return inertia(
            'Public/Admin/Home/Home-admission',
            [
                'admission' => $admission,
            ]
        );
    }

    public function updateAdmission(Request $request)
    {
        $request->validate([
            'badge' => 'nullable|string|max:255',

            'title' => 'required|string|max:255',

            'description' => 'nullable|string',

            'background_image' =>
                'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',

            'primary_button_text' =>
                'nullable|string|max:255',

            'primary_button_url' =>
                'nullable|string|max:255',

            'secondary_button_text' =>
                'nullable|string|max:255',

            'secondary_button_url' =>
                'nullable|string|max:255',

            'is_active' =>
                'nullable|boolean',


            'stats' =>
                'nullable|array',

            'stats.*.id' =>
                'nullable|integer',

            'stats.*.icon' =>
                'nullable|string|max:255',

            'stats.*.value' =>
                'required|string|max:100',

            'stats.*.label' =>
                'required|string|max:255',

            'stats.*.is_active' =>
                'nullable|boolean',
        ]);


        DB::transaction(function () use ($request) {

            /*
            |--------------------------------------------------------------------------
            | ADMISSION
            |--------------------------------------------------------------------------
            */

            $admission =
                Home_admissions::firstOrNew();


            $admission->badge =
                $request->badge;

            $admission->title =
                $request->title;

            $admission->description =
                $request->description;


            $admission->primary_button_text =
                $request->primary_button_text;

            $admission->primary_button_url =
                $request->primary_button_url;


            $admission->secondary_button_text =
                $request->secondary_button_text;

            $admission->secondary_button_url =
                $request->secondary_button_url;


            $admission->is_active =
                $request->boolean('is_active');


            /*
            |--------------------------------------------------------------------------
            | BACKGROUND IMAGE
            |--------------------------------------------------------------------------
            */

            if (
                $request->hasFile(
                    'background_image'
                )
            ) {

                $file =
                    $request->file(
                        'background_image'
                    );


                /*
                * Delete old image
                */
                if (
                    $admission->background_image &&
                    Storage::disk('public')
                        ->exists(
                            $admission->background_image
                        )
                ) {

                    Storage::disk('public')
                        ->delete(
                            $admission->background_image
                        );

                }


                /*
                * New filename
                */
                $extension =
                    $file->getClientOriginalExtension();


                $fileName =
                    'homepage-admission-'
                    . time()
                    . '.'
                    . $extension;


                /*
                * Save
                */
                $admission->background_image =
                    $file->storeAs(
                        'home/admission',
                        $fileName,
                        'public'
                    );

            }


            $admission->save();


            /*
            |--------------------------------------------------------------------------
            | STATISTICS
            |--------------------------------------------------------------------------
            */

            $ids = [];


            foreach (
                $request->input(
                    'stats',
                    []
                )
                as $index => $stat
            ) {

                if (!empty($stat['id'])) {

                    $admissionStat =
                        Home_admission_stats::where(
                            'home_admission_id',
                            $admission->id
                        )
                        ->findOrFail(
                            $stat['id']
                        );

                } else {

                    $admissionStat =
                        new Home_admission_stats();

                    $admissionStat
                        ->home_admission_id =
                        $admission->id;

                }


                $admissionStat->icon =
                    $stat['icon'] ?? null;

                $admissionStat->value =
                    $stat['value'];

                $admissionStat->label =
                    $stat['label'];

                $admissionStat->sort_order =
                    $index;

                $admissionStat->is_active =
                    filter_var(
                        $stat['is_active'] ?? true,
                        FILTER_VALIDATE_BOOLEAN
                    );


                $admissionStat->save();


                $ids[] =
                    $admissionStat->id;

            }


            /*
            |--------------------------------------------------------------------------
            | DELETE REMOVED STAT
            |--------------------------------------------------------------------------
            */

            if (count($ids) > 0) {

                Home_admission_stats::where(
                    'home_admission_id',
                    $admission->id
                )
                ->whereNotIn(
                    'id',
                    $ids
                )
                ->delete();

            } else {

                Home_admission_stats::where(
                    'home_admission_id',
                    $admission->id
                )
                ->delete();

            }

        });


        return back()->with(
            'success',
            'Admission section berhasil diperbarui.'
        );
    }

    public function editGetInTouch()
    {
        $getInTouch = Get_in_touch::first();

        return inertia(
            'Public/Admin/Home/Home-getintouch',
            [
                'getInTouch' => $getInTouch,
            ]
        );
    }

    public function updateGetInTouch(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',

            'email' => 'nullable|email|max:255',

            'phone' => 'nullable|string|max:100',

            'whatsapp' => 'nullable|string|max:100',

            'office_hours' => 'nullable|string|max:255',

            'map_embed_url' => 'nullable|string',

            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',

            'is_active' => 'nullable|boolean',
        ]);


        $getInTouch = Get_in_touch::firstOrNew();


        $getInTouch->title =
            $request->title;

        $getInTouch->email =
            $request->email;

        $getInTouch->phone =
            $request->phone;

        $getInTouch->whatsapp =
            $request->whatsapp;

        $getInTouch->office_hours =
            $request->office_hours;

        $getInTouch->map_embed_url =
            $request->map_embed_url;

        $getInTouch->is_active =
            $request->boolean('is_active');


        /*
        |--------------------------------------------------------------------------
        | IMAGE
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('image')) {

            $file = $request->file('image');


            /*
            * Delete old image
            */

            if (
                $getInTouch->image &&
                Storage::disk('public')
                    ->exists($getInTouch->image)
            ) {

                Storage::disk('public')
                    ->delete($getInTouch->image);

            }


            /*
            * Rename
            */

            $extension =
                $file->getClientOriginalExtension();


            $fileName =
                'homepage-get-in-touch-'
                . time()
                . '.'
                . $extension;


            /*
            * Save
            */

            $getInTouch->image =
                $file->storeAs(
                    'home/get-in-touch',
                    $fileName,
                    'public'
                );
        }


        $getInTouch->save();


        return back()->with(
            'success',
            'Get in Touch berhasil diperbarui.'
        );
    }

}
