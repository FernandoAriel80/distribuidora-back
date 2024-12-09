<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 'addresses';
    protected $primarykey = 'id';

    protected $fillable = [
        'user_id',
        'dni',
        'phone_number',
        'gender',
        'address',
        'department',
        'city',
        'postal_code',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
