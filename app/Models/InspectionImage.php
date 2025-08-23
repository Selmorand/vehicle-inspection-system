<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InspectionImage extends Model
{
    protected $fillable = [
        'inspection_id',
        'image_type',
        'area_name',
        'caption',
        'file_path',
        'original_name',
        'latitude',
        'longitude'
    ];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8'
    ];

    public function inspection(): BelongsTo
    {
        return $this->belongsTo(Inspection::class);
    }
}
