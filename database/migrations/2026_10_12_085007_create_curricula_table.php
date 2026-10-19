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
        Schema::create('curricula', function (Blueprint $table) {
            $table->id();
            $table->string('badge_title'); // Contoh: PRESCHOOL CURRICULUM, PRIMARY CURRICULUM
            $table->string('title');       // Contoh: Learning Through Play
            $table->text('description');   // Deskripsi paragraf
            $table->json('features')->nullable(); // List poin centang: ["Play-based & inquiry learning", ...]
            $table->string('image_path')->nullable();
            $table->enum('image_position', ['left', 'right'])->default('left'); // Pengaturan zig-zag
            $table->integer('sort_order')->default(0);
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('curricula');
    }
};
