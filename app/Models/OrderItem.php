<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'item_id',
        'name',
        'quantity',
        'unit_price',
        'sub_total',
    ];

    // Relación inversa con Order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
