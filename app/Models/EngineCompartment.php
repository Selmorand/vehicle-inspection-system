<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EngineCompartment extends Model
{
    protected $table = 'engine_compartment';
    
    protected $fillable = [
        'inspection_id',
        'component_type',
        'condition',
        'comments'
    ];

    public function inspection()
    {
        return $this->belongsTo(Inspection::class);
    }
}
