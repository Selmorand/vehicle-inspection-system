<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InspectionReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_name',
        'client_email',
        'client_phone',
        'vehicle_make',
        'vehicle_model',
        'vehicle_year',
        'vin_number',
        'license_plate',
        'mileage',
        'inspection_date',
        'inspector_name',
        'report_number',
        'pdf_filename',
        'pdf_path',
        'file_size',
        'status',
        'inspection_data'
    ];

    protected $casts = [
        'inspection_date' => 'date',
        'inspection_data' => 'array',
    ];

    /**
     * Generate a unique report number
     */
    public static function generateReportNumber()
    {
        $year = date('Y');
        $month = date('m');
        
        // Get the last report number for this month
        $lastReport = static::where('report_number', 'like', "RPT-{$year}{$month}-%")
                            ->orderBy('report_number', 'desc')
                            ->first();
        
        if ($lastReport) {
            // Extract the sequence number and increment
            $lastNumber = intval(substr($lastReport->report_number, -4));
            $newNumber = $lastNumber + 1;
        } else {
            // Start with 1 for the month
            $newNumber = 1;
        }
        
        // Format: RPT-YYYYMM-0001
        return sprintf("RPT-%s%s-%04d", $year, $month, $newNumber);
    }

    /**
     * Get full vehicle description
     */
    public function getVehicleDescriptionAttribute()
    {
        return trim("{$this->vehicle_year} {$this->vehicle_make} {$this->vehicle_model}");
    }

    /**
     * Get formatted file size
     */
    public function getFormattedFileSizeAttribute()
    {
        $bytes = $this->file_size;
        
        if ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } else {
            return $bytes . ' bytes';
        }
    }
}