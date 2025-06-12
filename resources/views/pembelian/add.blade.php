<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="icon" href="{{ asset('assets/icons/shoe-head.svg') }}" type="image/x-icon" />
    <link rel="stylesheet" href="/assets/css/style.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <header class="flex justify-between items-center p-6 shadow-xl fixed w-full bg-white top-0">
        <img class="w-[76px]" src="{{ asset('/assets/images/logo-kemon.png') }}" alt="">
        <nav>
            <ul class="flex gap-x-10 items-center">
                <li class="text-lg px-4 py-2 bg-slate-500 font-semibold text-white rounded-xl" ><a href="{{ route('dashboard') }}">Produk</a></li>
                <li class="text-lg" ><a href="{{ route('dashboard.pembelian') }}">Data Pembelian</a></li>
                <li class="text-lg" ><a href="{{ route('dashboard.penjualan') }}">Data Penjualan</a></li>
            </ul>
        </nav>
        <div class="flex items-center gap-x-5">
            <img src="{{ asset('/assets/icons/notif.svg') }}" alt="" class="w-6">
            <div class="w-[48px] h-[48px] overflow-hidden rounded-full">
                <img class="w-full h-full object-cover" src="{{ asset('/assets/images/login-main.png') }}" alt="">
            </div>
        </div>
    </header>
    <main class="px-10 mt-[180px]">
        <div class="w-3/5 bg-[#FFF] mt-16 shadow-xl mx-auto rounded-b-[30px]">
            <form action="{{ route('pembelian.store') }}" method="post">
                @csrf
                <div class="flex bg-[#B17457] p-[18px] rounded-t-[30px] items-center gap-x-[12px]">
                    <img src="{{ asset('/assets/icons/user-white.svg') }}" alt="" class="w-[42px] h-[42px]">
                    <h1 class="text-[28px] text-[#FFF] font-semibold">Informasi Produk</h1>
                </div>
                <div class="p-10">
                    <div class="flex flex-col">
                        <label for="" class="text-[16px] font-semibold">Nama Barang</label>
                        <input class="h-[48px] mt-4 rounded-lg border-2 border-slate-400 pl-4 outline-[#B17457]" type="name" name="nama_barang" required>
                    </div>
                    <div class="grid grid-cols-3 gap-5 flex-grow my-8">
                        <div class="flex flex-col">
                            <label for="" class="text-[16px] font-semibold">No Faktur </label>
                            <input class="h-[48px] mt-4 rounded-lg border-2 border-slate-400 focus:border-[#B17457] focus:ring-0" type="number" name="no_faktur" required>
                        </div>
                        <div class="flex flex-col">
                            <label for="" class="text-[16px] font-semibold">Nama Pemasok</label>
                            <input class="h-[48px] mt-4 rounded-lg border-2 border-slate-400 focus:border-[#B17457] focus:ring-0" type="text" name="nama_pemasok" required>
                        </div>
                        <div class="flex flex-col">
                            <label for="" class="text-[16px] font-semibold">Jumlah Barang</label>
                            <input class="h-[48px] mt-4 rounded-lg border-2 border-slate-400 focus:border-[#B17457] focus:ring-0" type="number" name="jumlah_barang" required>
                        </div>
                        <div class="flex flex-col">
                            <label for="" class="text-[16px] font-semibold">Tanggal Beli</label>
                            <input class="h-[48px] mt-4 rounded-lg border-2 border-slate-400 focus:border-[#B17457] focus:ring-0" type="date" name="tanggal_beli" required>
                        </div>
                        <div class="flex flex-col">
                            <label for="" class="text-[16px] font-semibold">Gudang</label>
                            <input class="h-[48px] mt-4 rounded-lg border-2 border-slate-400 focus:border-[#B17457] focus:ring-0" type="text" name="gudang" required>
                        </div>
                        <div class="flex flex-col">
                            <label for="" class="text-[16px] font-semibold">Jumlah bayar</label>
                            <input class="h-[48px] mt-4 rounded-lg border-2 border-slate-400 focus:border-[#B17457] focus:ring-0" type="number" name="jumlah_bayar" required>
                        </div>
                        <div class="flex flex-col">
                            <label for="" class="text-[16px] font-semibold">Kode Pemasok</label>
                            <input class="h-[48px] mt-4 rounded-lg border-2 border-slate-400 focus:border-[#B17457] focus:ring-0" type="text" name="kode_pemasok" required>
                        </div>
                        <div class="flex flex-col">
                            <label for="" class="text-[16px] font-semibold">Cara Bayar</label>
                            <label for="" class="text-[16px] font-semibold">Cara Bayar</label>
                            <select name="cara_bayar" id="">
                                <option value="transfer">Transfer</option>
                                <option value="tunai">Tunai</option>
                            </select>
                        </div>
                        <div class="flex flex-col">
                            <label for="" class="text-[16px] font-semibold">Jatuh Tempo</label>
                            <input class="h-[48px] mt-4 rounded-lg border-2 border-slate-400 focus:border-[#B17457] focus:ring-0" type="date" name="jatuh_tempo" required>
                        </div>
                    </div>
                    <button type="submit" class="w-full bg-gray-800 text-white p-[18px] text-[21px] font-semibold rounded-bl-[24px] rounded-tr-[24px]">
                        Selesai ✔
                    </button>
                </div>
            </form>
        </div>
    </main>
</body>
</html>
