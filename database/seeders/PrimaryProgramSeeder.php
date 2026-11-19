<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use App\Models\PrimaryProgramPage;
use App\Models\PrimaryProgramFeature;
use App\Models\PrimaryProgramLevel;
use App\Models\PrimaryProgramLevelPoint;
use App\Models\PrimaryProgramCurriculum;
use App\Models\PrimaryProgramExtracurricular;

class PrimaryProgramSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {

            /*
            |--------------------------------------------------------------------------
            | 1. MAIN PAGE
            |--------------------------------------------------------------------------
            */

            $page = PrimaryProgramPage::first();

            if (!$page) {
                $page = PrimaryProgramPage::create([
                    'badge' => 'ABOUT PRIMARY PROGRAM',
                    'title' => 'Developing Confident Lifelong Learners',
                    'description' => 'Our Primary Program provides a holistic and broad-based education that nurtures academic excellence, character, and life skills.',
                    'second_description' => 'We encourage students to explore, think critically, and work collaboratively in a supportive and joyful environment.',
                    'is_active' => true,
                ]);
            } else {
                $page->update([
                    'badge' => 'ABOUT PRIMARY PROGRAM',
                    'title' => 'Developing Confident Lifelong Learners',
                    'description' => 'Our Primary Program provides a holistic and broad-based education that nurtures academic excellence, character, and life skills.',
                    'second_description' => 'We encourage students to explore, think critically, and work collaboratively in a supportive and joyful environment.',
                    'is_active' => true,
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | 2. ABOUT FEATURES
            |--------------------------------------------------------------------------
            */

            $features = [
                [
                    'icon' => 'Lightbulb',
                    'title' => 'Student-Centered',
                    'description' => 'Encouraging active learning and critical thinking.',
                ],
                [
                    'icon' => 'BookOpen',
                    'title' => 'Strong Foundations',
                    'description' => 'Building solid skills in literacy, numeracy, and communication.',
                ],
                [
                    'icon' => 'Users',
                    'title' => 'Character Growth',
                    'description' => 'Developing integrity, respect, responsibility, and empathy.',
                ],
                [
                    'icon' => 'Globe',
                    'title' => 'Global Perspective',
                    'description' => 'Preparing students to be open-minded and ready for the future.',
                ],
            ];

            foreach ($features as $index => $feature) {
                PrimaryProgramFeature::updateOrCreate(
                    [
                        'primary_program_page_id' => $page->id,
                        'title' => $feature['title'],
                    ],
                    [
                        'icon' => $feature['icon'],
                        'description' => $feature['description'],
                        'sort_order' => $index,
                        'is_active' => true,
                    ]
                );
            }

            /*
            |--------------------------------------------------------------------------
            | 3. PRIMARY LEVELS
            |--------------------------------------------------------------------------
            */

            $levels = [
                [
                    'name' => 'Lower Primary',
                    'grade_label' => 'Grades 1 – 3',
                    'description' => 'Students build essential skills in reading, writing, mathematics, and explore the world around them through hands-on learning.',
                    'points' => [
                        'Building basic academic skills',
                        'Developing curiosity & creativity',
                        'Social & emotional growth',
                    ],
                ],
                [
                    'name' => 'Upper Primary',
                    'grade_label' => 'Grades 4 – 6',
                    'description' => 'Students expand their knowledge, strengthen independent learning, and develop problem-solving and leadership skills.',
                    'points' => [
                        'Advanced academic skills',
                        'Critical thinking & collaboration',
                        'Leadership & global awareness',
                    ],
                ],
            ];

            foreach ($levels as $index => $levelData) {

                $level = PrimaryProgramLevel::updateOrCreate(
                    [
                        'primary_program_page_id' => $page->id,
                        'name' => $levelData['name'],
                    ],
                    [
                        'grade_label' => $levelData['grade_label'],
                        'description' => $levelData['description'],
                        'sort_order' => $index,
                        'is_active' => true,
                    ]
                );

                foreach ($levelData['points'] as $pointIndex => $point) {
                    PrimaryProgramLevelPoint::updateOrCreate(
                        [
                            'primary_program_level_id' => $level->id,
                            'title' => $point,
                        ],
                        [
                            'sort_order' => $pointIndex,
                            'is_active' => true,
                        ]
                    );
                }
            }

            /*
            |--------------------------------------------------------------------------
            | 4. CURRICULUM
            |--------------------------------------------------------------------------
            */

            $curriculums = [
                [
                    'name' => 'Cambridge International Curriculum',
                    'short_name' => 'CIE',
                    'icon' => 'BookOpen',
                    'description' => 'Cambridge International Curriculum',
                ],
                [
                    'name' => 'Merdeka Curriculum',
                    'short_name' => 'M',
                    'icon' => 'GraduationCap',
                    'description' => 'Merdeka Curriculum',
                ],
                [
                    'name' => 'Character & 21st Century Learning',
                    'short_name' => '21st',
                    'icon' => 'Globe',
                    'description' => 'Character & 21st Century Learning',
                ],
            ];

            foreach ($curriculums as $index => $curriculum) {
                PrimaryProgramCurriculum::updateOrCreate(
                    [
                        'primary_program_page_id' => $page->id,
                        'name' => $curriculum['name'],
                    ],
                    [
                        'short_name' => $curriculum['short_name'],
                        'icon' => $curriculum['icon'],
                        'description' => $curriculum['description'],
                        'sort_order' => $index,
                        'is_active' => true,
                    ]
                );
            }

            /*
            |--------------------------------------------------------------------------
            | 5. EXTRACURRICULAR ACTIVITIES
            |--------------------------------------------------------------------------
            */

            $activities = [
                [
                    'name' => 'English Club',
                    'icon' => 'BookOpen',
                    'color' => 'orange',
                    'description' => 'Developing English communication skills.',
                ],
                [
                    'name' => 'Robotics Club',
                    'icon' => 'Code',
                    'color' => 'blue',
                    'description' => 'Exploring robotics, engineering, and creative problem-solving.',
                ],
                [
                    'name' => 'Coding Club',
                    'icon' => 'Code',
                    'color' => 'purple',
                    'description' => 'Learning computational thinking and programming.',
                ],
                [
                    'name' => 'Math Club',
                    'icon' => 'Calculator',
                    'color' => 'green',
                    'description' => 'Developing logical thinking and mathematical skills.',
                ],
                [
                    'name' => 'Science Club',
                    'icon' => 'FlaskConical',
                    'color' => 'blue',
                    'description' => 'Discovering science through experiments and exploration.',
                ],
                [
                    'name' => 'Art Club',
                    'icon' => 'Palette',
                    'color' => 'pink',
                    'description' => 'Expressing creativity through art and crafts.',
                ],
                [
                    'name' => 'Music Club',
                    'icon' => 'Music',
                    'color' => 'yellow',
                    'description' => 'Exploring music, rhythm, and musical expression.',
                ],
                [
                    'name' => 'Student Council',
                    'icon' => 'Users',
                    'color' => 'orange',
                    'description' => 'Building leadership, teamwork, and responsibility.',
                ],
            ];

            foreach ($activities as $index => $activity) {
                PrimaryProgramExtracurricular::updateOrCreate(
                    [
                        'primary_program_page_id' => $page->id,
                        'name' => $activity['name'],
                    ],
                    [
                        'icon' => $activity['icon'],
                        'color' => $activity['color'],
                        'description' => $activity['description'],
                        'sort_order' => $index,
                        'is_active' => true,
                    ]
                );
            }
        });
    }
}
