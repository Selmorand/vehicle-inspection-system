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
        Schema::create('engine_compartment', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inspection_id')->constrained()->onDelete('cascade');
            $table->string('component_type', 50); // e.g., 'brakefluid_cleanliness', 'coolant_level', etc.
            $table->string('condition', 20)->nullable(); // Good, Average, Bad, N/A
            $table->text('comments')->nullable();
            $table->timestamps();
            
            // Index for better performance
            $table->index(['inspection_id', 'component_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('engine_compartment');
    }
};
