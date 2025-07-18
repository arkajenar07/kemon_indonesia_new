<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopeeToken extends Model
{
    protected $fillable = [
        'shop_id',
        'access_token',
        'refresh_token',
        'expires_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];
}
