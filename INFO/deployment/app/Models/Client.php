<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'email',
        'address'
    ];

    public function inspections(): HasMany
    {
        return $this->hasMany(Inspection::class);
    }
}
