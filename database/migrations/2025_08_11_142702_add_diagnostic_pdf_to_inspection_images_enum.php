<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add 'diagnostic_pdf' to the image_type enum
        DB::statement("ALTER TABLE inspection_images MODIFY COLUMN image_type ENUM('general', 'specific_area', 'diagnostic_pdf') NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove 'diagnostic_pdf' from the image_type enum
        DB::statement("ALTER TABLE inspection_images MODIFY COLUMN image_type ENUM('general', 'specific_area') NOT NULL");
    }
};
