<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PreschoolFeature extends Model
{
    protected $fillable = [
        'preschool_page_id',
        'icon',
        'title',
        'description',
        'sort_order',
        'is_active',
    ];

    public function page()
    {
        return $this->belongsTo(PreschoolPage::class, 'preschool_page_id');
    }
}
