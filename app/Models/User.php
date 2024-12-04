<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
class User extends Authenticatable
{
    use HasFactory, Notifiable,HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    public function scopeSearch($query, $search)
    {
        if ($search) {
            return $query->where('name', 'like', "%{$search}%")
            ->orWhere('last_name','like',"%{$search}%")
            ->orWhere('email','like',"%{$search}%")
            ->orWhereHas('address', function ($query) use ($search) {
                $query->where('dni', 'like', "%{$search}%");
            });
        }
    }

    
    protected $table = 'users';
    protected $primarykey = 'id';
    protected $fillable = [
        'name',
        'last_name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
     // Relación con la dirección del usuario
    
    public function address()
    {
        return $this->hasOne(Address::class);
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

}
