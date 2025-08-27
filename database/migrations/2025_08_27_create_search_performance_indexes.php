<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration to add database indexes for improved search performance
 * 
 * These indexes are specifically designed for partial search functionality:
 * - Status filtering (completed reports only)
 * - Partial VIN searching
 * - Partial registration number searching  
 * - Partial engine number searching
 * - Report ID searching
 * - Date range filtering
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('inspections', function (Blueprint $table) {
            // Status index - for filtering completed reports
            $table->index('status', 'idx_inspections_status');
            
            // Date index - for date range filtering
            $table->index('inspection_date', 'idx_inspections_date');
            
            // Composite index for status + date (most common query combination)
            $table->index(['status', 'inspection_date'], 'idx_inspections_status_date');
            
            // ID index for report number searching (usually auto-created, but explicitly defined)
            $table->index('id', 'idx_inspections_id');
        });

        Schema::table('vehicles', function (Blueprint $table) {
            // VIN index - for partial VIN searching
            $table->index('vin', 'idx_vehicles_vin');
            
            // Registration number index - for partial registration searching
            $table->index('registration_number', 'idx_vehicles_registration');
            
            // Engine number index - for partial engine number searching  
            $table->index('engine_number', 'idx_vehicles_engine');
            
            // Composite index for all searchable vehicle fields (for OR queries)
            $table->index(['vin', 'registration_number', 'engine_number'], 'idx_vehicles_search_fields');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inspections', function (Blueprint $table) {
            $table->dropIndex('idx_inspections_status');
            $table->dropIndex('idx_inspections_date');
            $table->dropIndex('idx_inspections_status_date');
            $table->dropIndex('idx_inspections_id');
        });

        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropIndex('idx_vehicles_vin');
            $table->dropIndex('idx_vehicles_registration');
            $table->dropIndex('idx_vehicles_engine');
            $table->dropIndex('idx_vehicles_search_fields');
        });
    }
};