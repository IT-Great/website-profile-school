<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\SecondaryProgramPage;

class SecondaryProgramCurriculum extends Model
{
    protected $table = 'secondary_program_curriculums';

    protected $fillable = [
        'secondary_program_page_id',
        'name',
        'short_name',
        'icon',
        'description',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function page(): BelongsTo
    {
        return $this->belongsTo(SecondaryProgramPage::class, 'secondary_program_page_id');
    }
}
