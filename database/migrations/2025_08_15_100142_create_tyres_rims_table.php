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
        Schema::create('tyres_rims', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inspection_id')->constrained()->onDelete('cascade');
            $table->string('component_name', 50); // front_left, front_right, etc.
            $table->string('size', 100)->nullable();
            $table->string('manufacture', 100)->nullable();
            $table->string('model', 100)->nullable();
            $table->string('tread_depth', 50)->nullable();
            $table->string('damages', 100)->nullable();
            $table->timestamps();
            
            $table->index('inspection_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tyres_rims');
    }
};
