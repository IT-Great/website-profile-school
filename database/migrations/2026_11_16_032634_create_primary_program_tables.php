
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Main Primary Program page
        Schema::create('primary_program_pages', function (Blueprint $table) {
            $table->id();
            $table->string('badge')->nullable();
            $table->string('title');
            $table->text('description')->nullable();
            $table->text('second_description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 2. About carousel photos
        Schema::create('primary_program_photos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('primary_program_page_id')
                ->constrained('primary_program_pages')
                ->cascadeOnDelete();

            $table->string('image');
            $table->string('caption')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 3. About features
        Schema::create('primary_program_features', function (Blueprint $table) {
            $table->id();

            $table->foreignId('primary_program_page_id')
                ->constrained('primary_program_pages')
                ->cascadeOnDelete();

            $table->string('icon')->nullable();
            $table->string('title');
            $table->text('description')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 4. Primary Levels
        Schema::create('primary_program_levels', function (Blueprint $table) {
            $table->id();

            $table->foreignId('primary_program_page_id')
                ->constrained('primary_program_pages')
                ->cascadeOnDelete();

            $table->string('name');
            $table->string('grade_label')->nullable();
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 5. Points for each Primary Level
        Schema::create('primary_program_level_points', function (Blueprint $table) {
            $table->id();

            $table->foreignId('primary_program_level_id')
                ->constrained('primary_program_levels')
                ->cascadeOnDelete();

            $table->string('title');
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 6. Curriculum
        Schema::create('primary_program_curriculums', function (Blueprint $table) {
            $table->id();

            $table->foreignId('primary_program_page_id')
                ->constrained('primary_program_pages')
                ->cascadeOnDelete();

            $table->string('name');
            $table->string('short_name')->nullable();
            $table->string('icon')->nullable();
            $table->text('description')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 7. Extracurricular Activities
        Schema::create('primary_program_extracurriculars', function (Blueprint $table) {
            $table->id();

            $table->foreignId('primary_program_page_id')
                ->constrained('primary_program_pages')
                ->cascadeOnDelete();

            $table->string('name');
            $table->string('icon')->nullable();
            $table->string('color')->nullable();
            $table->text('description')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('primary_program_extracurriculars');
        Schema::dropIfExists('primary_program_curriculums');
        Schema::dropIfExists('primary_program_level_points');
        Schema::dropIfExists('primary_program_levels');
        Schema::dropIfExists('primary_program_features');
        Schema::dropIfExists('primary_program_photos');
        Schema::dropIfExists('primary_program_pages');
    }
};
