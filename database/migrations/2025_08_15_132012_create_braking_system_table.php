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
        Schema::create('braking_system', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inspection_id')->constrained()->onDelete('cascade');
            $table->string('position', 20); // front_left, front_right, rear_left, rear_right
            $table->string('pad_life', 10)->nullable(); // 1.00, 0.90, etc.
            $table->string('pad_condition', 20)->nullable(); // Good, Average, Bad, N/A
            $table->string('disc_life', 10)->nullable(); // 1.00, 0.90, etc.
            $table->string('disc_condition', 20)->nullable(); // Good, Average, Bad, N/A
            $table->text('comments')->nullable();
            $table->timestamps();

            $table->index('inspection_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('braking_system');
    }
};
