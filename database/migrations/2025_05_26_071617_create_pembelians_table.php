<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pembelians', function (Blueprint $table) {
            $table->id();
            $table->string('nama_barang');
            $table->integer('no_faktur');
            $table->string('nama_pemasok');
            $table->integer('jumlah_barang');
            $table->date('tanggal_beli');
            $table->string('gudang');
            $table->decimal('jumlah_bayar', 20, 2);
            $table->string('kode_pemasok');
            $table->string('cara_bayar');
            $table->date('jatuh_tempo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembelians');
    }
};
