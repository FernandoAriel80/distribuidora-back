<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActionLog extends Model
{
    public function scopeSearch($query, $search)
    {
        if ($search) {
            return $query->where('name', 'like', "%{$search}%")
            ->orWhere('last_name','like',"%{$search}%")
            ->orWhere('email','like',"%{$search}%")
            ->orWhere('payment_id','like',"%{$search}%");
        }
    }
    protected $table = 'action_logs';
    protected $primarykey = 'id';

    protected $fillable = [
        'user_id',
        'name',
        'last_name',
        'email',
        'action',
        'description',
        'orders_id',
        'payment_id',
        'created_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
