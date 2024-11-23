<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['user_id'];

    // Relación de Carrito con CartItems (un carrito tiene muchos items)
    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    // Relación con el usuario (si estás utilizando autenticación de usuarios)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Método para obtener el total del carrito
    public function getTotalAttribute()
    {
        return $this->cartItems->sum('total');
    }
}
