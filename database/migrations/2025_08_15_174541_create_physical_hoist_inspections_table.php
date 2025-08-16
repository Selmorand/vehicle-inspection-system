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
        Schema::create('physical_hoist_inspections', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('inspection_id');
            $table->string('section', 50); // suspension, engine, drivetrain
            $table->string('component_name', 100);
            $table->enum('primary_condition', ['Good', 'Average', 'Bad', 'N/A'])->nullable();
            $table->enum('secondary_condition', ['Good', 'Average', 'Bad', 'N/A'])->nullable();
            $table->text('comments')->nullable();
            $table->timestamps();
            
            $table->foreign('inspection_id')->references('id')->on('inspections')->onDelete('cascade');
            $table->index('inspection_id');
            $table->index('section');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('physical_hoist_inspections');
    }
};
