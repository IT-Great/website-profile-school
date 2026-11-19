<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PreschoolClassPoint extends Model
{
    protected $fillable = [
        'preschool_class_id',
        'title',
        'sort_order',
        'is_active',
    ];

    public function preschoolClass()
    {
        return $this->belongsTo(PreschoolClass::class);
    }
}
