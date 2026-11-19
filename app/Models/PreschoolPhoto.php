<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PreschoolPhoto extends Model
{
    protected $fillable = [
        'preschool_page_id',
        'image',
        'caption',
        'sort_order',
        'is_active',
    ];

    public function page()
    {
        return $this->belongsTo(PreschoolPage::class, 'preschool_page_id');
    }
}