<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SecondaryProgramPage extends Model
{
    protected $fillable = [
        'badge',
        'title',
        'description',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function features(): HasMany
    {
        return $this->hasMany(SecondaryProgramFeature::class)
            ->orderBy('sort_order');
    }

    public function curriculums(): HasMany
    {
        return $this->hasMany(SecondaryProgramCurriculum::class)
            ->orderBy('sort_order');
    }

    public function outcomes(): HasMany
    {
        return $this->hasMany(SecondaryProgramOutcome::class)
            ->orderBy('sort_order');
    }
}
