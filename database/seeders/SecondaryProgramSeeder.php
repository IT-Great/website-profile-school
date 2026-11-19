<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SecondaryProgramPage;
use App\Models\SecondaryProgramFeature;
use App\Models\SecondaryProgramCurriculum;
use App\Models\SecondaryProgramOutcome;
use App\Models\SecondaryProgramSection;
use App\Models\SecondaryProgramItem;

class SecondaryProgramSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Main page
        $page = SecondaryProgramPage::firstOrCreate(
            ['id' => 1],
            [
                'badge' => 'ABOUT SECONDARY',
                'title' => 'About Secondary Program',
                'description' => 'Our Secondary Program (Grades 7–9) focuses on academic excellence, character development, and leadership. Students are encouraged to explore their passions, think critically, and develop the skills they need to succeed in a rapidly changing world.',
                'is_active' => true,
            ]
        );

        // 2. Program features
        $features = [
            [
                'icon' => 'graduation-cap',
                'title' => 'Academic Excellence',
                'description' => 'Strong curriculum that builds knowledge and critical thinking.',
            ],
            [
                'icon' => 'user-round',
                'title' => 'Character & Leadership',
                'description' => 'Building integrity, confidence, and responsibility.',
            ],
            [
                'icon' => 'globe',
                'title' => 'Global Perspective',
                'description' => 'Preparing students to be open-minded and globally aware.',
            ],
            [
                'icon' => 'heart',
                'title' => 'Well-rounded Development',
                'description' => 'Supporting physical, emotional, and social growth.',
            ],
        ];

        foreach ($features as $index => $feature) {
            SecondaryProgramFeature::updateOrCreate(
                [
                    'secondary_program_page_id' => $page->id,
                    'title' => $feature['title'],
                ],
                array_merge($feature, [
                    'sort_order' => $index + 1,
                    'is_active' => true,
                ])
            );
        }

        // 3. Curriculum
        $curriculums = [
            [
                'name' => 'Cambridge Curriculum',
                'short_name' => 'CIE',
                'icon' => 'book-open',
                'description' => 'An internationally recognized curriculum that develops confident, independent learners with strong academic foundation and critical thinking skills.',
            ],
            [
                'name' => 'Kurikulum Merdeka (Indonesia)',
                'short_name' => 'KM',
                'icon' => 'graduation-cap',
                'description' => 'Integrated to ensure students meet national standards while fostering creativity, character, and lifelong learning.',
            ],
        ];

        foreach ($curriculums as $index => $curriculum) {
            SecondaryProgramCurriculum::updateOrCreate(
                [
                    'secondary_program_page_id' => $page->id,
                    'name' => $curriculum['name'],
                ],
                array_merge($curriculum, [
                    'sort_order' => $index + 1,
                    'is_active' => true,
                ])
            );
        }

        // 4. Learning outcomes
        $outcomes = [
            ['icon' => 'book-open', 'title' => 'Advanced Academic Skills'],
            ['icon' => 'lightbulb', 'title' => 'Critical Thinking & Problem Solving'],
            ['icon' => 'message-circle', 'title' => 'Effective Communication'],
            ['icon' => 'handshake', 'title' => 'Collaboration & Teamwork'],
            ['icon' => 'palette', 'title' => 'Creativity & Innovation'],
            ['icon' => 'monitor', 'title' => 'Digital & Information Literacy'],
            ['icon' => 'flag', 'title' => 'Leadership & Responsibility'],
        ];

        foreach ($outcomes as $index => $outcome) {
            SecondaryProgramOutcome::updateOrCreate(
                [
                    'secondary_program_page_id' => $page->id,
                    'title' => $outcome['title'],
                ],
                array_merge($outcome, [
                    'sort_order' => $index + 1,
                    'is_active' => true,
                ])
            );
        }

        // 5. Sections and their items
        $sections = [
            [
                'slug' => 'field-trips',
                'title' => 'Field Trips',
                'description' => "Field trips provide real-world experiences that spark curiosity and broaden students' understanding of the world.",
                'button_text' => 'View All Field Trips',
                'items' => [
                    'Museum Visit',
                    'University Tour',
                    'Science Center',
                ],
            ],
            [
                'slug' => 'school-activities',
                'title' => 'Activities at School',
                'description' => 'Engaging activities that help students discover their interests, build skills, and create lasting memories.',
                'button_text' => 'View All Activities',
                'items' => [
                    'Science Experiment',
                    'Debate Club',
                    'Student Project',
                ],
            ],
            [
                'slug' => 'extracurriculars',
                'title' => 'Extracurricular Programs',
                'description' => 'A wide range of extracurricular activities to develop talents, interests, and leadership skills.',
                'button_text' => 'View All Extracurriculars',
                'items' => [
                    ['name' => 'English Club', 'icon' => 'message-circle', 'color' => '#FFEDD5'],
                    ['name' => 'Robotics', 'icon' => 'code', 'color' => '#DBEAFE'],
                    ['name' => 'Basketball', 'icon' => 'trophy', 'color' => '#FFEDD5'],
                    ['name' => 'Badminton', 'icon' => 'target', 'color' => '#DBEAFE'],
                    ['name' => 'Choir', 'icon' => 'music', 'color' => '#F3E8FF'],
                    ['name' => 'Coding Club', 'icon' => 'monitor', 'color' => '#DBEAFE'],
                    ['name' => 'Taekwondo', 'icon' => 'dumbbell', 'color' => '#FFEDD5'],
                    ['name' => 'Art Club', 'icon' => 'palette', 'color' => '#FFE4E6'],
                ],
            ],
        ];

        foreach ($sections as $sectionIndex => $sectionData) {
            $section = SecondaryProgramSection::updateOrCreate(
                ['slug' => $sectionData['slug']],
                [
                    'title' => $sectionData['title'],
                    'description' => $sectionData['description'],
                    'button_text' => $sectionData['button_text'],
                    'button_url' => null,
                    'sort_order' => $sectionIndex + 1,
                    'is_active' => true,
                ]
            );

            foreach ($sectionData['items'] as $itemIndex => $itemData) {
                $item = is_array($itemData)
                    ? $itemData
                    : ['name' => $itemData];

                SecondaryProgramItem::updateOrCreate(
                    [
                        'secondary_program_section_id' => $section->id,
                        'name' => $item['name'],
                    ],
                    [
                        'icon' => $item['icon'] ?? null,
                        'color' => $item['color'] ?? null,
                        'sort_order' => $itemIndex + 1,
                        'is_active' => true,
                    ]
                );
            }
        }
    }
}