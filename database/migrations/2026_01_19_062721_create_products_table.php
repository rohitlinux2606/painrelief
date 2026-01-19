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
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            // बेसिक जानकारी
            $table->string('title'); // प्रोडक्ट का नाम
            $table->string('slug')->unique(); // URL के लिए (e.g. iphone-15-pro)
            $table->longText('description')->nullable(); // प्रोडक्ट का विवरण
            $table->string('short_description')->nullable(); // छोटा विवरण
            $table->longText('external_link')->nullable();

            // कीमत (Price)
            $table->decimal('price', 10, 2); // असली कीमत
            $table->decimal('compare_at_price', 10, 2)->nullable(); // कटी हुई कीमत (Discount दिखाने के लिए)
            $table->decimal('cost_per_item', 10, 2)->nullable(); // आपकी खरीद लागत (प्रॉफिट चेक करने के लिए)

            // इन्वेंटरी (Inventory)
            $table->string('sku')->unique()->nullable(); // Stock Keeping Unit
            $table->string('barcode')->nullable(); // Barcode (ISBN, UPC, etc.)
            $table->integer('stock_quantity')->default(0); // कितना स्टॉक है
            $table->boolean('track_quantity')->default(true); // स्टॉक ट्रैक करना है या नहीं
            $table->boolean('continue_selling_out_of_stock')->default(false); // स्टॉक खत्म होने पर भी बेचना है?

            // शिपिंग और फिजिकल डिटेल्स
            $table->boolean('is_physical')->default(true); // क्या यह फिजिकल प्रोडक्ट है?
            $table->decimal('weight', 8, 2)->nullable(); // वजन (शिपिंग के लिए)
            $table->string('weight_unit')->default('kg'); // kg, g, lb, oz

            // स्टेटस और ऑर्गनाइजेशन
            $table->enum('status', ['active', 'draft', 'archived'])->default('draft'); // प्रोडक्ट स्टेटस
            $table->string('brand')->nullable(); // ब्रांड का नाम

            // मीडिया (Images)
            $table->string('thumbnail')->nullable(); // मुख्य फोटो का पाथ

            // SEO (Search Engine Optimization)
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();

            $table->timestamps(); // created_at और updated_at
            $table->softDeletes(); // डिलीट करने पर डेटा पूरी तरह गायब नहीं होगा (Recycle bin की तरह)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
