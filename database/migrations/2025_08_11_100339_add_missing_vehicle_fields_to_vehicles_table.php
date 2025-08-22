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
        Schema::table('vehicles', function (Blueprint $table) {
            if (!Schema::hasColumn('vehicles', 'colour')) {
                $table->string('colour')->nullable();
            }
            if (!Schema::hasColumn('vehicles', 'doors')) {
                $table->string('doors')->nullable();
            }
            if (!Schema::hasColumn('vehicles', 'fuel_type')) {
                $table->string('fuel_type')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropColumn(['colour', 'doors', 'fuel_type']);
        });
    }
};
