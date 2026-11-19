
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('school_activity_photos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('school_activity_id')
                ->constrained('school_activities')
                ->cascadeOnDelete();

            $table->string('image');
            $table->unsignedInteger('sort_order')->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('school_activity_photos');
    }
};
