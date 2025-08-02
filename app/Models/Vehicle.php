<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vehicle extends Model
{
    protected $fillable = [
        'vin',
        'manufacturer',
        'model',
        'vehicle_type',
        'transmission',
        'engine_number',
        'registration_number',
        'year',
        'mileage'
    ];

    public function inspections(): HasMany
    {
        return $this->hasMany(Inspection::class);
    }
}
