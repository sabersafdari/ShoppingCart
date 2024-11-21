<?php

namespace App\Models\Relations;

use App\Models\Product;
use App\Models\User;

trait OrderRelations
{
    public function products()
    {
        return $this->belongsToMany(Product::class)
            ->withPivot('count', 'recorded_price');
    }
}
