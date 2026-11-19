<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PreschoolClass extends Model
{
    protected $fillable = [
        'preschool_page_id',
        'name',
        'age_range',
        'description',
        'image',
        'button_text',
        'button_url',
        'sort_order',
        'is_active',
    ];

    public function page()
    {
        return $this->belongsTo(PreschoolPage::class, 'preschool_page_id');
    }

    public function points()
    {
        return $this->hasMany(PreschoolClassPoint::class)
            ->orderBy('sort_order');
    }
}
