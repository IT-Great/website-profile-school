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
        Schema::create('posts', function (Blueprint $table) {
        $table->id();

        $table->enum('category', [
            'news',
            'event',
            'activity',
            'achievement'
        ]);

        $table->string('title');

        $table->string('slug')->unique();

        $table->text('excerpt')->nullable();

        $table->longText('content')->nullable();

        $table->string('thumbnail')->nullable();

        $table->date('published_at')->nullable();

        $table->boolean('is_featured')->default(false);

        $table->boolean('is_active')->default(true);

        $table->unsignedBigInteger('created_by')->nullable();

        $table->timestamps();

        $table->foreign('created_by')
            ->references('id')
            ->on('users')
            ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
