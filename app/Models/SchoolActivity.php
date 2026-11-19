<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SchoolActivity extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'class_level',
        'location',
        'semester',
        'academic_year',
        'category',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'semester' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function photos(): HasMany
    {
        return $this->hasMany(SchoolActivityPhoto::class)
            ->orderBy('sort_order');
    }
}
