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
        Schema::create('inspection_reports', function (Blueprint $table) {
            $table->id();
            
            // Client Information
            $table->string('client_name');
            $table->string('client_email')->nullable();
            $table->string('client_phone')->nullable();
            
            // Vehicle Information
            $table->string('vehicle_make');
            $table->string('vehicle_model');
            $table->string('vehicle_year')->nullable();
            $table->string('vin_number')->nullable();
            $table->string('license_plate')->nullable();
            $table->string('mileage')->nullable();
            
            // Inspection Information
            $table->date('inspection_date');
            $table->string('inspector_name')->nullable();
            $table->string('report_number')->unique(); // AUTO-generated report number
            
            // File Information
            $table->string('pdf_filename');
            $table->string('pdf_path');
            $table->integer('file_size')->nullable();
            
            // Status
            $table->enum('status', ['draft', 'completed', 'sent'])->default('completed');
            
            // Additional Data (JSON)
            $table->json('inspection_data')->nullable(); // Store complete inspection data as JSON
            
            $table->timestamps();
            
            // Indexes for searching
            $table->index('client_name');
            $table->index('vehicle_make');
            $table->index('vin_number');
            $table->index('report_number');
            $table->index('inspection_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspection_reports');
    }
};
