<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class home_admission_stats extends Model
{
    protected $guarded = ['id'];

    public function admission()
    {
        return $this->belongsTo(
            home_admissions::class,
            'home_admission_id'
        );
    }
}
