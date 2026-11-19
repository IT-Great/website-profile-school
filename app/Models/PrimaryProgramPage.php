<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PrimaryProgramPage extends Model
{
    protected $fillable = [
        'badge',
        'title',
        'description',
        'second_description',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function photos(): HasMany
    {
        return $this->hasMany(PrimaryProgramPhoto::class)
            ->orderBy('sort_order');
    }

    public function features(): HasMany
    {
        return $this->hasMany(PrimaryProgramFeature::class)
            ->orderBy('sort_order');
    }

    public function levels(): HasMany
    {
        return $this->hasMany(PrimaryProgramLevel::class)
            ->orderBy('sort_order');
    }

    public function curriculums()
    {
        return $this->hasMany(PrimaryProgramCurriculum::class)
            ->orderBy('sort_order');
    }

    public function extracurriculars()
    {
        return $this->hasMany(PrimaryProgramExtracurricular::class)
            ->orderBy('sort_order');
    }
}