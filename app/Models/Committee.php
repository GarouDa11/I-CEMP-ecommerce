<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Committee extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'committee_id',
        'club_name',
        'email',
        'password',
        'description',
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
    
    public function products()
    {
        return $this->hasMany(\App\Models\Product::class);
    }
}