<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EngineVerification extends Model
{
    protected $table = 'engine_verification';
    
    protected $fillable = [
        'inspection_id',
        'verification_notes'
    ];
    
    public function inspection()
    {
        return $this->belongsTo(Inspection::class);
    }
}
