<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PrimaryProgramLevel extends Model
{
    protected $fillable = [
        'primary_program_page_id',
        'name',
        'grade_label',
        'image',
        'description',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function page(): BelongsTo
    {
        return $this->belongsTo(PrimaryProgramPage::class, 'primary_program_page_id');
    }

    public function points(): HasMany
    {
        return $this->hasMany(PrimaryProgramLevelPoint::class)
            ->orderBy('sort_order');
    }
}
