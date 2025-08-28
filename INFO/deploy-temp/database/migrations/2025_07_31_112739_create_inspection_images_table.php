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
        Schema::create('inspection_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inspection_id')->constrained()->onDelete('cascade');
            $table->enum('image_type', ['general', 'specific_area']);
            $table->string('area_name')->nullable();
            $table->string('file_path');
            $table->string('original_name')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->timestamps();
            
            $table->index(['inspection_id', 'image_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspection_images');
    }
};
