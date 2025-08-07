<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BodyPanelAssessment extends Model
{
    protected $fillable = [
        'inspection_id',
        'panel_name',
        'condition',
        'comment_type',
        'additional_comment',
        'other_notes'
    ];

    public function inspection(): BelongsTo
    {
        return $this->belongsTo(Inspection::class);
    }
}
