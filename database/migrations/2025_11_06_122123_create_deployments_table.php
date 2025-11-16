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
        Schema::create('deployments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->string('deployment_id')->unique();
            $table->enum('status', ['Building', 'Ready', 'Error', 'Canceled'])->default('Building');
            $table->string('environment')->default('Production');
            $table->boolean('is_current')->default(false);
            $table->string('branch')->default('main');
            $table->string('commit_hash')->nullable();
            $table->string('commit_message')->nullable();
            $table->string('author')->nullable();
            $table->integer('build_time')->nullable(); // in seconds
            $table->timestamp('deployed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deployments');
    }
};
