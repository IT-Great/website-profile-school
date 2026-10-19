<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class home_admissions extends Model
{
    protected $guarded = ['id'];

    public function stats()
    {
        return $this->hasMany(
            home_admission_stats::class,
            'home_admission_id'
        )->orderBy('sort_order');
    }
}
