<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'customer_id',
        'order_id',
        'payment_method',
        'transaction_id',
        'status',
        'amount',
        'currency',
        'payment_status',
        'payment_response',
        'payment_date',
        'payment_expiry',
        'payment_type',
        'payment_mode',
        'bank',
        'card_no',
        'card_type',
        'card_expiry_month',
        'card_expiry_year',
        'card_holder_name',
        'cf_order_id',      // Cashfree Fields
        'cf_payment_id',
        'payment_group',
        'error_message',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'payment_response' => 'array',
        'payment_date' => 'datetime',
        'payment_expiry' => 'datetime',
        'amount' => 'decimal:2',
    ];

    /**
     * Get the customer that owns the payment.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the order associated with the payment.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
