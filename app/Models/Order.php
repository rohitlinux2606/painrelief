<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'customer_id',
        'address_id',
        'order_number',
        'subtotal',
        'tax',
        'shipping',
        'total',
        'status',
        'payment_method',
        'payment_status',
        'shiprocket_order_id',
        'shiprocket_shipment_id',
        'shiprocket_awb_code',
        'shiprocket_courier_name',
        'shiprocket_status',
        'shiprocket_tracking_url',
        'shipped_at',
    ];

    protected $casts = [
        'shipped_at' => 'datetime',
        'subtotal' => 'decimal:2',
        'tax' => 'decimal:2',
        'shipping' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    /**
     * Check if order has been sent to Shiprocket.
     */
    public function hasShiprocketOrder(): bool
    {
        return !empty($this->shiprocket_order_id);
    }

    /**
     * Check if order status is shipped.
     */
    public function isShipped(): bool
    {
        return $this->status === 'shipped';
    }
}
