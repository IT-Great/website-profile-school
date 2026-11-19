<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SecondaryProgramItem extends Model
{
    protected $fillable = [
        'secondary_program_section_id',
        'name',
        'description',
        'icon',
        'color',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(SecondaryProgramSection::class, 'secondary_program_section_id');
    }

    public function photos(): HasMany
    {
        return $this->hasMany(SecondaryProgramPhoto::class)
            ->orderBy('sort_order');
    }
}
