<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class home_about_point extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function about()
    {
        return $this->belongsTo(
            home_about::class,
            'home_about_id'
        );
    }
}
