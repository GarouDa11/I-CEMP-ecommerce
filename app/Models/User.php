<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

  protected $fillable = [
    'matric_id',
    'name',
    'email',
    'password',
    'phone',
    'mahallah',
    'profile_photo', // Add this
];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }
    public function wishlists()
{
    return $this->belongsToMany(Product::class, 'wishlists');
}

public function carts()
{
    return $this->hasMany(Cart::class);
}
}