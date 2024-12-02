<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $primarykey = 'id';

    protected $fillable = [
        'user_id',
        'payment_id',
        'total',
        'name',
        'last_name',
        'dni',
        'email',
        'card_last_numb',
        'type_card',
        'card_name_user',
        'hour_and_date',
        'status',
        'delivery_status',
    ];

    // Relación con OrderItems
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
