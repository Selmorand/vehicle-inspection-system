<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add 'tyres_rims' and 'mechanical_report' to the image_type enum
        DB::statement("ALTER TABLE inspection_images MODIFY COLUMN image_type ENUM('general', 'specific_area', 'diagnostic_pdf', 'service_booklet', 'tyres_rims', 'mechanical_report')");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove 'tyres_rims' and 'mechanical_report' from the image_type enum
        DB::statement("ALTER TABLE inspection_images MODIFY COLUMN image_type ENUM('general', 'specific_area', 'diagnostic_pdf', 'service_booklet')");
    }
};
