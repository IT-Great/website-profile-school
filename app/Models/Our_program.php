<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Our_program extends Model
{
   protected $table = 'our_programs';

    protected $fillable = [
        'badge_title',
        'title',
        'description',
        'features',
        'image_path',
        'image_position',
        'sort_order',
        'status',
    ];

    protected $casts = [
        'features' => 'array',
        'status' => 'boolean',
    ];

    protected $appends = ['image_url'];

    public function getImageUrlAttribute()
    {
        return $this->image_path ? asset('storage/' . $this->image_path) : null;
    }
}
