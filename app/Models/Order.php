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
        'status',
        'total',
    ];
}
