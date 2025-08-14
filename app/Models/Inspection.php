<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Inspection extends Model
{
    protected $fillable = [
        'client_id',
        'vehicle_id',
        'inspector_name',
        'inspection_date',
        'diagnostic_report',
        'service_comments',
        'service_recommendations',
        'status'
    ];

    protected $casts = [
        'inspection_date' => 'date'
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function bodyPanelAssessments(): HasMany
    {
        return $this->hasMany(BodyPanelAssessment::class);
    }

    public function interiorAssessments(): HasMany
    {
        return $this->hasMany(InteriorAssessment::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(InspectionImage::class);
    }
}
