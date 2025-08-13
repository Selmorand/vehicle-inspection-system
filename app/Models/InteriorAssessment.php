<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InteriorAssessment extends Model
{
    protected $table = 'interior_assessments';
    
    protected $fillable = [
        'inspection_id',
        'component_name',
        'condition',
        'colour',
        'comment'
    ];

    public function inspection(): BelongsTo
    {
        return $this->belongsTo(Inspection::class);
    }
}