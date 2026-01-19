<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        'customer_id',
        'type',
        'name',
        'phone',
        'address_line1',
        'address_line2',
        'city',
        'state',
        'postal_code',
        'country',
    ];

    protected $casts = [
        'customer_id' => 'integer',
    ];

    /* ---------------- RELATIONSHIPS ---------------- */

    // Address belongs to a Customer
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
