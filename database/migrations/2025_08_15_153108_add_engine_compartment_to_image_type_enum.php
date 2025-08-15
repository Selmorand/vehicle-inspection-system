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
        // Add 'engine_compartment' to the image_type enum
        DB::statement("ALTER TABLE inspection_images MODIFY COLUMN image_type ENUM('general', 'specific_area', 'diagnostic_pdf', 'service_booklet', 'tyres_rims', 'mechanical_report', 'engine_compartment')");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove 'engine_compartment' from the image_type enum
        DB::statement("ALTER TABLE inspection_images MODIFY COLUMN image_type ENUM('general', 'specific_area', 'diagnostic_pdf', 'service_booklet', 'tyres_rims', 'mechanical_report')");
    }
};
