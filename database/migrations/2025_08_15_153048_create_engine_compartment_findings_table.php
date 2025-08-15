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
        Schema::create('engine_compartment_findings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inspection_id')->constrained()->onDelete('cascade');
            $table->string('finding_type', 50); // e.g., 'engine_number_not_visible', 'no_deficiencies', etc.
            $table->boolean('is_checked')->default(false);
            $table->text('notes')->nullable(); // Additional notes for the finding
            $table->timestamps();
            
            // Index for better performance
            $table->index(['inspection_id', 'finding_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('engine_compartment_findings');
    }
};
