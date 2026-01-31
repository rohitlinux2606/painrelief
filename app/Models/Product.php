<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * वे फ़ील्ड्स जिन्हें मास-असाइनमेंट (Mass-assignment) के लिए अनुमति है।
     */
    protected $fillable = [
        'title',
        'slug',
        'description',
        'short_description',
        'price',
        'compare_at_price',
        'cost_per_item',
        'sku',
        'barcode',
        'stock_quantity',
        'track_quantity',
        'continue_selling_out_of_stock',
        'is_physical',
        'weight',
        'weight_unit',
        'status',
        'category_id',
        'brand',
        'thumbnail',
        'meta_title',
        'meta_description',
        'external_link'
    ];

    /**
     * डेटा टाइप कास्टिंग (Casting)
     */
    protected $casts = [
        'price' => 'decimal:2',
        'compare_at_price' => 'decimal:2',
        'track_quantity' => 'boolean',
        'continue_selling_out_of_stock' => 'boolean',
        'is_physical' => 'boolean',
        'stock_quantity' => 'integer',
    ];

    /**
     * ऑटोमैटिक Slug बनाना: जब भी टाइटल सेव होगा, स्लग अपने आप बन जाएगा।
     */
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->title);
            }
        });
    }

    /* -------------------------------------------------------------------------- */
    /* RELATIONSHIPS                               */
    /* -------------------------------------------------------------------------- */

    // /**
    //  * प्रोडक्ट किस कैटेगरी से संबंधित है।
    //  */
    // public function category()
    // {
    //     return $this->belongsTo(Category::class);
    // }

    /**
     * एक प्रोडक्ट की कई गैलरी इमेजेज हो सकती हैं।
     */
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function marketingLinks()
    {
        return $this->hasMany(MarketingLink::class);
    }

    /* -------------------------------------------------------------------------- */
    /* ACCESSORS                                 */
    /* -------------------------------------------------------------------------- */

    /**
     * डिस्काउंट प्रतिशत (Discount Percentage) निकालने के लिए।
     * इसे आप $product->discount_percentage से एक्सेस कर सकते हैं।
     */
    public function getDiscountPercentageAttribute()
    {
        if ($this->compare_at_price > $this->price) {
            $discount = (($this->compare_at_price - $this->price) / $this->compare_at_price) * 100;
            return round($discount);
        }
        return 0;
    }
}
