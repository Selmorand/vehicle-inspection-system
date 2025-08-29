<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            
            // User information
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('user_name')->nullable();
            $table->string('user_email')->nullable();
            $table->string('user_role')->nullable();
            
            // Activity details
            $table->string('action'); // view, create, edit, delete, download, print
            $table->string('description');
            $table->string('model_type')->nullable(); // Inspection, Report, User, etc.
            $table->unsignedBigInteger('model_id')->nullable();
            
            // Request information
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent')->nullable();
            $table->string('browser')->nullable();
            $table->string('platform')->nullable();
            $table->string('device')->nullable(); // desktop, tablet, mobile
            
            // Additional context
            $table->json('old_values')->nullable(); // For edit tracking
            $table->json('new_values')->nullable(); // For edit tracking
            $table->json('metadata')->nullable(); // Any additional data
            
            // Location/Page
            $table->string('url')->nullable();
            $table->string('method')->nullable(); // GET, POST, etc.
            $table->string('referer')->nullable();
            
            // Session tracking
            $table->string('session_id')->nullable();
            
            $table->timestamps();
            
            // Indexes for performance
            $table->index('user_id');
            $table->index('action');
            $table->index('model_type');
            $table->index('model_id');
            $table->index('created_at');
            $table->index(['model_type', 'model_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};