<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('preschool_classes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('preschool_page_id')
                ->constrained('preschool_pages')
                ->cascadeOnDelete();

            $table->string('name');
            $table->string('age_range')->nullable();
            $table->text('description')->nullable();

            $table->string('image')->nullable();

            $table->string('button_text')->default('Learn More');
            $table->string('button_url')->nullable();

            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('preschool_classes');
    }
};
