<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use Illuminate\Http\Request;

class PembelianController extends Controller
{
    // Menampilkan semua data pembelian
    public function index()
    {
        $pembelians = Pembelian::all();
        return view('pembelian.index', compact('pembelians'));
    }

    // Menampilkan form tambah data
    public function create()
    {
        return view('pembelian.add');
    }

    // Menyimpan data pembelian baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|string',
            'no_faktur' => 'required|integer',
            'nama_pemasok' => 'required|string',
            'jumlah_barang' => 'required|integer',
            'tanggal_beli' => 'required|date',
            'gudang' => 'required|string',
            'jumlah_bayar' => 'required|numeric',
            'kode_pemasok' => 'required|string',
            'cara_bayar' => 'required|string',
            'jatuh_tempo' => 'required|date',
        ]);

        Pembelian::create($request->all());

        return redirect()->route('dashboard.pembelian')->with('success', 'Data pembelian berhasil ditambahkan.');
    }

    // Menampilkan detail satu pembelian
    public function show($pembelian_id)
    {
        $pembelian = Pembelian::find($pembelian_id);
        return view('pembelian.show', compact('pembelian'));
    }

    // Menampilkan form edit
    public function edit($pembelian_id)
    {
        $pembelian = Pembelian::find($pembelian_id);
        return view('pembelian.edit', compact('pembelian'));
    }

    // Menyimpan perubahan data
    public function update(Request $request, $pembelian_id)
    {
        $request->validate([
            'nama_barang' => 'required|string',
            'no_faktur' => 'required|integer',
            'nama_pemasok' => 'required|string',
            'jumlah_barang' => 'required|integer',
            'tanggal_beli' => 'required|date',
            'gudang' => 'required|string',
            'jumlah_bayar' => 'required|numeric',
            'kode_pemasok' => 'required|string',
            'cara_bayar' => 'required|string',
            'jatuh_tempo' => 'required|date',
        ]);

        $pembelian = Pembelian::find($pembelian_id);
        $pembelian->update($request->all());

        return redirect()->route('dashboard.pembelian')->with('success', 'Data pembelian berhasil diperbarui.');
    }

    // Menghapus data
    public function destroy(Pembelian $pembelian)
    {
        $pembelian->delete();
        return redirect()->route('dashboard.pembelianw')->with('success', 'Data pembelian berhasil dihapus.');
    }
}
