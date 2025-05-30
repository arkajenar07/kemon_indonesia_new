<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopeeToken extends Model
{
    use HasFactory;

    protected $fillable = [
        'shop_id',
        'access_token',
        'refresh_token',
    ];
}
