<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PrimaryProgramPhoto extends Model
{
    protected $fillable = [
        'primary_program_page_id',
        'image',
        'caption',
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
}
