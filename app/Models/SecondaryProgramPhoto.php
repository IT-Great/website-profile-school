<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SecondaryProgramPhoto extends Model
{
    protected $fillable = [
        'secondary_program_item_id',
        'image',
        'sort_order',
    ];

    public function item(): BelongsTo
    {
        return $this->belongsTo(SecondaryProgramItem::class, 'secondary_program_item_id');
    }
}