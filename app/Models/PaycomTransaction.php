<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaycomTransaction extends Model
{
    public function order()
    {
        $this->belongsTo(Order::class, 'order_id');
    }
}
