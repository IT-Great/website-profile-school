<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PreschoolPage extends Model
{
    protected $fillable = [
        'about_badge',
        'about_title',
        'about_description',
        'about_second_description',
        'classes_badge',
        'classes_title',
        'classes_description',
        'is_active',
    ];

    public function photos(): HasMany
    {
        return $this->hasMany(PreschoolPhoto::class)
            ->orderBy('sort_order');
    }

    public function features(): HasMany
    {
        return $this->hasMany(PreschoolFeature::class)
            ->orderBy('sort_order');
    }

    public function classes(): HasMany
    {
        return $this->hasMany(PreschoolClass::class)
            ->orderBy('sort_order');
    }
}