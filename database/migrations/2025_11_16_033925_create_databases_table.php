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
        Schema::create('databases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('type'); // PostgreSQL, MySQL, MongoDB, Redis
            $table->string('region');
            $table->integer('connection_limit')->default(100);
            $table->integer('storage_size')->default(10); // in GB
            $table->boolean('auto_backup')->default(true);
            $table->string('status')->default('provisioning'); // provisioning, active, error
            $table->json('env_vars')->nullable();
            $table->string('connection_string')->nullable();
            $table->string('host')->nullable();
            $table->integer('port')->nullable();
            $table->string('username')->nullable();
            $table->string('password')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('databases');
    }
};
