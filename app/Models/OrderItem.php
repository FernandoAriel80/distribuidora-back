<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $table = 'order_items';
    protected $primarykey = 'id';
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
