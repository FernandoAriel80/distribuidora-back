<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TopCategory extends Model
{
    protected $table = 'top_categories';
    protected $primarykey = 'id';
    protected $fillable = ['name'];

    // Relación con subcategorías
    public function categories()
    {
        return $this->hasMany(Category::class);
    }
}
