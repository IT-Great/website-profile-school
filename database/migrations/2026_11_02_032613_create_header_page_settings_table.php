
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('header_page_settings', function (Blueprint $table) {
            $table->id();

            $table->string('page_key')->unique();
            $table->string('title');
            $table->text('description')->nullable();

            $table->string('background_image')->nullable();

            $table->string('primary_button_text')->nullable();
            $table->string('primary_button_url')->nullable();

            $table->string('secondary_button_text')->nullable();
            $table->string('secondary_button_url')->nullable();

            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('header_page_settings');
    }
};
