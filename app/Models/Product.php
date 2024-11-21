<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $fillable = [
        'title',
        'body',
        'price',
        'image_url',
    ];

    public function getLeadAttribute()
    {
        return Str::limit(strip_tags($this->body), 100, '...');
    }
}
