<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhysicalHoistInspection extends Model
{
    use HasFactory;

    protected $table = 'physical_hoist_inspections';

    protected $fillable = [
        'inspection_id',
        'section',
        'component_name',
        'primary_condition',
        'secondary_condition', 
        'comments'
    ];

    public function inspection()
    {
        return $this->belongsTo(Inspection::class);
    }
}