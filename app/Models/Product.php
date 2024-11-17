<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function scopeSearch($query, $search)
    {
        if ($search) {
            return $query->where('name', 'like', "%{$search}%")->orWhere('catalog_id','like',"%{$search}%");
        }
    }
    public function type(){
        return $this->belongsTo(Type::class);
    }
    public function category(){
        return $this->belongsTo(Category::class);
    }
    protected $table = 'products';
    protected $primarykey = 'id';

    protected $fillable = [
        'catalog_id',
        'barcode',
        'name',
        'description',
        'unit_price',
        'bulk_unit_price',
        'bulk_unit',
        'percent_off',
        'offer',
        'price_offer',
        'old_price',
        'stock',
        'image_url',
        'category_id',
        'type_id',
    ];
}
