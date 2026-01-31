<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MarketingLink extends Model
{
    protected $fillable = [
        'product_id',
        'platform',
        'campaign_name',
        'utm_source',
        'utm_medium',
        'utm_campaign',
        'generated_url',
        'clicks'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
