
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('student_achievements', function (Blueprint $table) {
            $table->id();

            // Informasi prestasi
            $table->string('title');
            $table->string('slug')->unique();

            // Informasi siswa
            $table->string('student_name');
            $table->string('student_class')->nullable();

            // Informasi kompetisi dan penghargaan
            $table->string('competition_name');
            $table->string('category', 50);
            $table->string('award');
            $table->string('achievement_level', 50);

            // Detail prestasi
            $table->date('achievement_date');
            $table->longText('description')->nullable();
            $table->string('image')->nullable();

            // Status publikasi
            $table->boolean('is_active')->default(false);

            $table->timestamps();

            // Index untuk pencarian dan filter
            $table->index('category');
            $table->index('achievement_date');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_achievements');
    }
};
