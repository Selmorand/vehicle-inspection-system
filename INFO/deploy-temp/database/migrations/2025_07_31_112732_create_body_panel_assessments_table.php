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
        Schema::create('body_panel_assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inspection_id')->constrained()->onDelete('cascade');
            $table->string('panel_name');
            $table->enum('condition', ['good', 'average', 'bad'])->nullable();
            $table->string('comment_type')->nullable();
            $table->text('additional_comment')->nullable();
            $table->text('other_notes')->nullable();
            $table->timestamps();
            
            $table->index(['inspection_id', 'panel_name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('body_panel_assessments');
    }
};
