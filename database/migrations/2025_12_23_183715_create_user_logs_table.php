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
        Schema::create('user_logs', function (Blueprint $table) { 
            $table->id();
        
            $table->foreignId('user_id')
                    ->constrained('users')
                    ->cascadeOnDelete();
        
           
            // Old values
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->enum('role', ['superAdmin','admin','user','member'])->nullable();
            $table->boolean('is_email_verify')->nullable();
            $table->unsignedTinyInteger('is_active')->nullable();
            $table->string('remember_token')->nullable();
            $table->enum('action', ['created','updated','deleted'])->nullable();
            $table->unsignedTinyInteger('deleted_at')->default(0);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        });
             
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_logs');
    }
};
