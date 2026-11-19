<?php

namespace Database\Seeders;

use App\Models\PreschoolPage;
use App\Models\PreschoolFeature;
use App\Models\PreschoolClass;
use App\Models\PreschoolClassPoint;
use App\Models\PreschoolPhoto;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PreschoolSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            // =====================================
            // 1. PRESCHOOL PAGE
            // =====================================

            $page = PreschoolPage::first();

            if (!$page) {
                $page = PreschoolPage::create([
                    'about_badge' => 'ABOUT PRESCHOOL',
                    'about_title' => 'A Joyful Beginning to Learning',
                    'about_description' => "Our Preschool Program provides a safe, nurturing, and engaging environment where children build confidence, develop essential skills, and love learning.",
                    'about_second_description' => "Through play-based and student-centered activities, we nurture each child's curiosity, creativity, and character.",

                    'classes_badge' => 'PRESCHOOL PROGRAM',
                    'classes_title' => 'Our Classes',
                    'classes_description' => 'We offer age-appropriate classes designed to support every stage of early childhood development.',

                    'is_active' => true,
                ]);
            } else {
                $page->update([
                    'about_badge' => 'ABOUT PRESCHOOL',
                    'about_title' => 'A Joyful Beginning to Learning',
                    'about_description' => "Our Preschool Program provides a safe, nurturing, and engaging environment where children build confidence, develop essential skills, and love learning.",
                    'about_second_description' => "Through play-based and student-centered activities, we nurture each child's curiosity, creativity, and character.",
                    'classes_badge' => 'PRESCHOOL PROGRAM',
                    'classes_title' => 'Our Classes',
                    'classes_description' => 'We offer age-appropriate classes designed to support every stage of early childhood development.',
                ]);
            }

            // =====================================
            // 2. ABOUT FEATURES
            // =====================================

            $features = [
                [
                    'icon' => 'Heart',
                    'title' => 'Safe & Caring',
                    'description' => 'A warm, secure environment for every child.',
                ],
                [
                    'icon' => 'BookOpen',
                    'title' => 'Play-Based Learning',
                    'description' => 'Learning through play, exploration, and discovery.',
                ],
                [
                    'icon' => 'Users',
                    'title' => 'Holistic Development',
                    'description' => 'Supporting cognitive, social, emotional, and physical growth.',
                ],
                [
                    'icon' => 'Star',
                    'title' => 'Character Building',
                    'description' => 'Cultivating kindness, respect, and responsibility.',
                ],
            ];

            foreach ($features as $index => $feature) {
                PreschoolFeature::updateOrCreate(
                    [
                        'preschool_page_id' => $page->id,
                        'title' => $feature['title'],
                    ],
                    [
                        'icon' => $feature['icon'],
                        'description' => $feature['description'],
                        'sort_order' => $index + 1,
                        'is_active' => true,
                    ]
                );
            }

            // =====================================
            // 3. ABOUT PHOTOS
            // =====================================

            // Menggunakan foto Preschool yang sudah ada di storage.
            // Pastikan file tersedia di storage/app/public/images/preschool.jpg.

            if (!$page->photos()->exists()) {
                PreschoolPhoto::create([
                    'preschool_page_id' => $page->id,
                    'image' => 'images/preschool.jpg',
                    'caption' => 'Preschool Learning Activities',
                    'sort_order' => 1,
                    'is_active' => true,
                ]);
            }

            // =====================================
            // 4. PRESCHOOL CLASSES
            // =====================================

            $classes = [
                [
                    'name' => 'Nursery',
                    'age_range' => 'Ages 1 – 2 Years',
                    'description' => 'A gentle introduction to learning through sensory play, music, movement, and social interaction.',
                    'image' => 'images/preschool.jpg',
                    'button_text' => 'Learn More',
                    'button_url' => null,
                    'points' => [
                        'Building early language skills',
                        'Developing motor skills',
                        'Encouraging independence',
                        'Social & emotional growth',
                    ],
                ],
                [
                    'name' => 'Kindergarten A-B',
                    'age_range' => 'Ages 3 – 5 Years',
                    'description' => 'Preparing children for primary education with hands-on learning and creative exploration.',
                    'image' => 'images/preschool.jpg',
                    'button_text' => 'Learn More',
                    'button_url' => null,
                    'points' => [
                        'Early literacy & numeracy',
                        'Critical thinking & problem solving',
                        'Creativity & self-expression',
                        'Positive habits & character',
                    ],
                ],
            ];

            foreach ($classes as $index => $classData) {
                $class = PreschoolClass::updateOrCreate(
                    [
                        'preschool_page_id' => $page->id,
                        'name' => $classData['name'],
                    ],
                    [
                        'age_range' => $classData['age_range'],
                        'description' => $classData['description'],
                        'image' => $classData['image'],
                        'button_text' => $classData['button_text'],
                        'button_url' => $classData['button_url'],
                        'sort_order' => $index + 1,
                        'is_active' => true,
                    ]
                );

                foreach ($classData['points'] as $pointIndex => $point) {
                    PreschoolClassPoint::updateOrCreate(
                        [
                            'preschool_class_id' => $class->id,
                            'title' => $point,
                        ],
                        [
                            'sort_order' => $pointIndex + 1,
                            'is_active' => true,
                        ]
                    );
                }
            }
        });
    }
}