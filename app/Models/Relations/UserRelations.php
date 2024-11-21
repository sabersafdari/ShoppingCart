<?php

namespace App\Models\Relations;

use App\Models\Order;

trait UserRelations
{
    public function ordres()
    {
        return $this->hasMany(Order::class);
    }
}
