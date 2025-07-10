<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard | Data Pembelian</title>
    <link rel="icon" href="{{ asset('assets/icons/shoe-head.svg') }}" type="image/x-icon" />
    <link rel="stylesheet" href="/assets/css/style.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <header class="flex justify-between items-center p-6 fixed w-full bg-white top-0 border-b border-gray-200 ">
        <img class="w-[48px]" src="{{ asset('/assets/images/logo-kemon.png') }}" alt="">
        <nav>
            <ul class="flex gap-x-10 items-center">
                <li class="text-lg" ><a href="{{ route('dashboard') }}">Produk</a></li>
                <li class="text-lg px-4 py-2 bg-slate-500 font-semibold text-white rounded-xl" ><a href="{{ route('dashboard.pembelian') }}">Data Pembelian</a></li>
                <li class="text-lg" ><a href="{{ route('dashboard.penjualan') }}">Data Penjualan</a></li>
            </ul>
        </nav>
        <div class="flex items-center gap-x-2">
            <span class="font-medium">@kemon_indonesia</span>
            <div class="w-[32px] h-[32px] overflow-hidden rounded-full">
                <img class="w-full h-full object-cover" src="{{ asset('/assets/images/login-main.png') }}" alt="">
            </div>
        </div>
    </header>
    <main class="px-24 mt-[120px]">
        <section>
            <div class="flex items-start justify-between mt-10">
                <h1 class="text-[40px] font-semibold">Data Pembelian</h1>
                <div class="flex gap-x-5">
                    <div class="flex items-center bg-[#FFFFFF] border border-[#3A2D28] px-4 py-2 rounded-xl">
                        <button>
                            <img src="{{ asset('/assets/icons/search.svg') }}" alt="">
                        </button>
                        <input type="text" name="" id="" class="bg-transparent border-none outline-none focus:outline-none ring-0 focus:ring-0" placeholder="Cari Produk">
                    </div>
                    <div class="w-[200px] bg-[#3A2D28] rounded-xl">
                        <a href="">
                            <div class="text-white w-full h-full flex items-center justify-center gap-x-2">
                                <img src="{{ asset('assets/icons/add-product-white.svg') }}" alt="" class="w-6">
                                <span>Add Product</span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </section>
        <section class="mt-10">
            <div class="list-wrapper grid grid-cols-3 gap-6">
                @foreach ($pembelians as $pembelian)
                <div class="w-full bg-white rounded-[24px] p-8 gap-x-6">
                    <div class="text-wrapper">
                        <div class="">
                            <div class="flex items-center gap-x-2">
                                <div class="w-10 p-3 border rounded-full border-gray-600" >
                                    <img src="{{ asset('assets/icons/buying.svg') }}" alt="">
                                </div>
                                <h1 class="font-semibold text-xl">{{ $pembelian['nama_barang'] }}</h1>
                            </div>
                            <div class="mt-4 flex flex-col gap-y-2">
                                <div class="flex justify-between">
                                    <p class="text-sm font-semibold">Nama Pemasok :</p>
                                    <p class="text-sm">{{ $pembelian['nama_pemasok'] }}</p>
                                </div>
                                <div class="flex justify-between">
                                    <p class="text-sm font-semibold">Jumlah Bayar :</p>
                                    <p class="text-sm">Rp. {{ number_format($pembelian['jumlah_bayar'], 0, ',', '.') }}</p>
                                </div>
                                <div class="flex justify-between">
                                    <p class="text-sm font-semibold">Jumlah Barang :</p>
                                    <p class="text-sm">{{ number_format($pembelian['jumlah_barang'], 0, ',', '.') }}</p>
                                </div>
                                <div class="flex justify-between">
                                    <p class="text-sm font-semibold">Jatuh Tempo :</p>
                                    <p class="text-sm">{{ \Carbon\Carbon::parse($pembelian['jatuh_tempo'])->translatedFormat('d F Y') }}</p>
                                </div>
                            </div>
                            <div class="mt-4">
                                <div class="bg-green-100 text-sm text-green-800 font-semibold px-4 py-2 rounded-full w-fit">
                                    Lunas
                                </div>
                            </div>
                            <div class="mt-4">
                                <a href="">
                                    <div class="bg-slate-200 text-sm text-gray-800 font-semibold px-4 py-2 rounded-lg text-center">
                                        Detail
                                    </div>
                                </a>
                                <a href="{{ route('pembelian.edit', ['pembelian_id' => $pembelian->id]) }}">
                                    <div class="bg-yellow-200 text-sm text-yellow-800 font-semibold px-4 py-2 rounded-lg text-center">
                                        Edit
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </section>
    </main>
</body>
</html>
