<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SchoolActivityPhoto extends Model
{
    protected $fillable = [
        'school_activity_id',
        'image',
        'sort_order',
    ];

    public function activity(): BelongsTo
    {
        return $this->belongsTo(SchoolActivity::class, 'school_activity_id');
    }
}
