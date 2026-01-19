<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Customer extends Authenticatable
{
    use SoftDeletes;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'password',
        'dob',
        'gender',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean',
        'dob' => 'date',
    ];

    /* ---------------- RELATIONSHIPS ---------------- */

    // Customer के कई orders हो सकते हैं
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // Customer के कई addresses हो सकते हैं
    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    // Customer का एक cart होगा
    public function cart()
    {
        return $this->hasOne(Cart::class);
    }

    /* ---------------- ACCESSORS ---------------- */

    public function getFullNameAttribute()
    {
        return trim($this->first_name . ' ' . $this->last_name);
    }
}
