<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_barang',
        'no_faktur',
        'nama_pemasok',
        'jumlah_barang',
        'tanggal_beli',
        'gudang',
        'jumlah_bayar',
        'kode_pemasok',
        'cara_bayar',
        'jatuh_tempo',
    ];

    protected $casts = [
        'tanggal_beli' => 'date',
        'jatuh_tempo' => 'date',
    ];
}
