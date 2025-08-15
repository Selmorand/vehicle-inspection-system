<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EngineCompartmentFinding extends Model
{
    protected $table = 'engine_compartment_findings';
    
    protected $fillable = [
        'inspection_id',
        'finding_type',
        'is_checked',
        'notes'
    ];

    protected $casts = [
        'is_checked' => 'boolean'
    ];

    public function inspection()
    {
        return $this->belongsTo(Inspection::class);
    }
}
