<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Main page
        Schema::create('secondary_program_pages', function (Blueprint $table) {
            $table->id();
            $table->string('badge')->default('ABOUT SECONDARY');
            $table->string('title')->default('About Secondary Program');
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Program features
        Schema::create('secondary_program_features', function (Blueprint $table) {
            $table->id();
            $table->foreignId('secondary_program_page_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->string('icon')->nullable();
            $table->string('title');
            $table->text('description')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Curriculum
        Schema::create('secondary_program_curriculums', function (Blueprint $table) {
            $table->id();
            $table->foreignId('secondary_program_page_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->string('name');
            $table->string('short_name')->nullable();
            $table->string('icon')->nullable();
            $table->text('description')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Learning outcomes
        Schema::create('secondary_program_outcomes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('secondary_program_page_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->string('icon')->nullable();
            $table->string('title');
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Sections: Field Trips, School Activities, Extracurriculars
        Schema::create('secondary_program_sections', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('button_text')->nullable();
            $table->string('button_url')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Items inside each section
        Schema::create('secondary_program_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('secondary_program_section_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('icon')->nullable();
            $table->string('color')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Photos for Field Trips and School Activities
        Schema::create('secondary_program_photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('secondary_program_item_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->string('image');
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('secondary_program_photos');
        Schema::dropIfExists('secondary_program_items');
        Schema::dropIfExists('secondary_program_sections');
        Schema::dropIfExists('secondary_program_outcomes');
        Schema::dropIfExists('secondary_program_curriculums');
        Schema::dropIfExists('secondary_program_features');
        Schema::dropIfExists('secondary_program_pages');
    }
};
