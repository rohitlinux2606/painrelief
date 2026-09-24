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
        Schema::create('shiprockets', function (Blueprint $table) {
            $table->id();
            $table->string('email')->nullable();
            $table->text('password')->nullable();
            $table->text('token')->nullable();
            $table->timestamp('token_expires_at')->nullable();
            $table->string('channel_id')->nullable();
            $table->string('pickup_location')->nullable();
            $table->string('pincode')->nullable();
            $table->string('company_name')->nullable();
            $table->string('phone')->nullable();
            $table->boolean('status')->default(true);
            $table->boolean('is_sandbox')->default(false);
            $table->string('api_base_url')->default('https://apiv2.shiprocket.in/v1/external');
            $table->timestamp('last_connected_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shiprockets');
    }
};

