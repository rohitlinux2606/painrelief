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
        Schema::table('products', function (Blueprint $table) {
            $table->string('amazon_product_id')->nullable();
            $table->string('amazon_asin')->nullable();
            $table->string('amazon_sku')->nullable();
            $table->string('amazon_price')->nullable();
            $table->string('amazon_quantity')->nullable();
            $table->string('amazon_image')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('amazon_asin');
            $table->dropColumn('amazon_sku');
            $table->dropColumn('amazon_price');
            $table->dropColumn('amazon_quantity');
            $table->dropColumn('amazon_image');
        });
    }
};
