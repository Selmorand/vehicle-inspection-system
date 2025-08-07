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
        Schema::table('inspection_reports', function (Blueprint $table) {
            // Make PDF fields nullable since we removed PDF functionality
            $table->string('pdf_filename')->nullable()->change();
            $table->string('pdf_path')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inspection_reports', function (Blueprint $table) {
            // Revert PDF fields to non-nullable
            $table->string('pdf_filename')->nullable(false)->change();
            $table->string('pdf_path')->nullable(false)->change();
        });
    }
};
