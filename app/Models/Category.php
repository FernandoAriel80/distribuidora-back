<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table = 'categories';
    protected $primarykey = 'id';
    protected $fillable = ['top_category_id', 'name'];

    // Relación con subcategorías
    public function topCategories()
    {
        return $this->belongsTo(TopCategory::class);
    }
}
