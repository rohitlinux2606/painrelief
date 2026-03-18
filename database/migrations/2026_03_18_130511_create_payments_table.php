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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            // User provided fields
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->string('order_id')->nullable()->index();
            $table->string('payment_method')->nullable();
            $table->string('transaction_id')->nullable()->unique();
            $table->string('status')->nullable();
            $table->decimal('amount', 12, 2)->default(0);
            $table->string('currency', 10)->default('INR');
            $table->string('payment_status')->nullable();
            $table->json('payment_response')->nullable();
            $table->timestamp('payment_date')->nullable();
            $table->timestamp('payment_expiry')->nullable();
            $table->string('payment_type')->nullable();
            $table->string('payment_mode')->nullable();
            $table->string('bank')->nullable();
            $table->string('card_no', 100)->nullable();
            $table->string('card_type', 50)->nullable();
            $table->string('card_expiry_month', 2)->nullable();
            $table->string('card_expiry_year', 4)->nullable();
            $table->string('card_holder_name')->nullable();

            // Additional fields useful for Cashfree
            $table->string('cf_order_id')->nullable()->index()->comment('Cashfree order ID');
            $table->string('cf_payment_id')->nullable()->index()->comment('Cashfree payment ID');
            $table->string('payment_group')->nullable()->comment('Cashfree payment group, e.g., credit_card, upi');
            $table->text('error_message')->nullable()->comment('Error message in case of failure');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
