<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class home_hero extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'background_image' => 'array',
        'is_active' => 'boolean',
    ];
  
}
