<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Header_page_settings;
use Illuminate\Database\Seeder;

class HeaderPageSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pages = [
            ['page_key' => 'home', 'title' => 'Home'],
            ['page_key' => 'about', 'title' => 'About'],
            ['page_key' => 'curriculum', 'title' => 'Curriculum'],
            ['page_key' => 'facility', 'title' => 'Facility'],
            ['page_key' => 'student-achievements', 'title' => 'Student Achievements'],
            ['page_key' => 'vision-mission', 'title' => 'Visi & Misi'],
            ['page_key' => 'alumni', 'title' => 'Alumni'],
            ['page_key' => 'programs', 'title' => 'Programs'],
            ['page_key' => 'preschool', 'title' => 'Preschool'],
            ['page_key' => 'primary', 'title' => 'Primary'],
            ['page_key' => 'secondary', 'title' => 'Secondary'],
            ['page_key' => 'news', 'title' => 'News'],
            ['page_key' => 'gallery', 'title' => 'Gallery'],
            ['page_key' => 'contact', 'title' => 'Contact'],
        ];

        foreach ($pages as $page) {
            Header_page_settings::firstOrCreate(
                ['page_key' => $page['page_key']],
                [
                    'title' => $page['title'],
                    'is_active' => true,
                ]
            );
        }
    }
}
