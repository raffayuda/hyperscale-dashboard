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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('url')->unique();
            $table->string('github_repo')->nullable();
            $table->string('git_url')->nullable();
            $table->string('branch')->default('main');
            $table->string('framework')->default('Other');
            $table->string('root_directory')->default('./');
            $table->string('build_command')->nullable();
            $table->string('output_directory')->nullable();
            $table->json('environment_variables')->nullable();
            $table->string('last_commit')->nullable();
            $table->enum('status', ['Building', 'Ready', 'Error', 'Deploying'])->default('Building');
            $table->timestamp('deployed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
