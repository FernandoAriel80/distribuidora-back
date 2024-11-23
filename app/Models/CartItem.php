<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = ['cart_id', 'product_id', 'quantity', 'total'];

    // Relación con Carrito (cada CartItem pertenece a un Carrito)
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    // Relación con Producto (cada CartItem tiene un Producto)
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
