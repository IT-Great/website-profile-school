<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

public function up(): void
{
    Schema::create('preschool_pages', function (Blueprint $table) {
        $table->id();

        // About Preschool
        $table->string('about_badge')->nullable();
        $table->string('about_title')->nullable();
        $table->text('about_description')->nullable();
        $table->text('about_second_description')->nullable();

        // Our Classes Section
        $table->string('classes_badge')->nullable();
        $table->string('classes_title')->nullable();
        $table->text('classes_description')->nullable();

        $table->boolean('is_active')->default(true);

        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('preschool_pages');
}

};
