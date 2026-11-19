<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SecondaryProgramSection extends Model
{
    protected $fillable = [
        'slug',
        'title',
        'description',
        'button_text',
        'button_url',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function items(): HasMany
    {
        return $this->hasMany(SecondaryProgramItem::class)
            ->orderBy('sort_order');
    }
}
