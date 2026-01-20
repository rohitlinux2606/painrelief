<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVideos extends Model
{
    protected $fillable = ['product_id', 'video_url', 'status'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getYoutubeId()
    {
        $pattern = '/^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|&v=|shorts\/)([^#\&\?]*).*/';
        preg_match($pattern, $this->video_url, $matches);
        return (isset($matches[2]) && strlen($matches[2]) == 11) ? $matches[2] : null;
    }
}
