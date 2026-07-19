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
        Schema::create('user_details_logs', function (Blueprint $table) {    
            
            $table->id();
            $table->foreignId('user_detail_id')
                    ->constrained('user_details')
                    ->cascadeOnDelete();
                    
            $table->string('mobile_no')->nullable();
            $table->text('address')->nullable();
            $table->date('dob')->nullable();
            $table->enum('gender', ['male','female', 'other'])->nullable();
            $table->string('country')->nullable();
            $table->string('profile_image')->nullable();
            $table->timestamp('last_login_at')->nullable();
            $table->string('ip_address', 45)->nullable();  
            $table->string('device_type')->nullable();     // web, mobile 
            $table->string('timezone')->nullable();  
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
        Schema::dropIfExists('user_details_logs');
    }
};
