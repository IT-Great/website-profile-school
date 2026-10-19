<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class home_about extends Model
{
    use HasFactory;

    protected $guarded = ['id'];


    public function points()
    {
        return $this->hasMany(home_about_point::class, 'home_about_id');
    }
}
