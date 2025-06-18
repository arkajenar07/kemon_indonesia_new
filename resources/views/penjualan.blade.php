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
                <li class="text-lg px-4 py-2 bg-slate-500 font-semibold text-white rounded-xl" ><a href="{{ route('dashboard') }}">Produk</a></li>
                <li class="text-lg" ><a href="{{ route('dashboard.pembelian') }}">Data Pembelian</a></li>
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
    <main class="px-24 mt-[180px]">
        <section>
            <div class="flex items-start justify-between mt-10">
                <div>
                    <h1 class="text-[40px] font-semibold">Riwayat Pembelian</h1>
                    <p>Lorem ipsum  dolor sit amet </p>
                </div>
                <div class="flex gap-x-5">
                    <div class="flex items-center bg-[#FFF8F2] border border-[#DCA88F] px-4 py-2 rounded-xl">
                        <button>
                            <img src="{{ asset('/assets/icons/search.svg') }}" alt="">
                        </button>
                        <input type="text" name="" id="" class="bg-transparent border-none outline-none focus:outline-none ring-0 focus:ring-0" placeholder="Cari Produk">
                    </div>
                    <button class="w-[200px] bg-[#DCA88F] justify-center rounded-xl">
                        <a href="{{ route('product.add') }}" class="flex items-center gap-x-4 justify-center font-semibold">
                            <img src="{{ asset('/assets/icons/add-product.svg') }}" alt="" class="w-8">
                            Add Product
                        </a>
                    </button>
                </div>
            </div>
        </section>
        <section class="mt-10">
            <div class="list-wrapper flex flex-col gap-y-10">
                <div class="w-full bg-white border rounded-[24px] border-gray-800 flex justify-between p-8 gap-x-6">
                    <div class="text-wrapper">
                        <div class="flex items-start gap-x-4">
                            <div class="w-20 p-5 border rounded-full border-gray-600" >
                                <img src="{{ asset('assets/icons/buying.svg') }}" alt="">
                            </div>
                            <div>
                                <h1 class="font-semibold text-xl">Nama Barang</h1>
                                <div class="mt-2">
                                    <p class="text-sm">Nama Pemasok : ANDO</p>
                                    <p class="text-sm">Jumlah Bayar : Rp. 25.000.000,00</p>
                                    <p class="text-sm">Jumlah : 1000,00</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-x-3">
                        <a href="#">
                            <div class="bg-green-100 text-lg text-green-800 font-semibold px-6 py-3 rounded-lg">
                                Lunas
                            </div>
                        </a>
                        <a href="">
                            <div class="bg-green-100 text-lg text-green-800 font-semibold px-6 py-3 rounded-lg">
                                Pembelian Selesai
                            </div>
                        </a>
                        <a href="">
                            <div class="bg-gray-100 text-lg text-gray-800 font-semibold px-6 py-3 rounded-lg">
                                Detail
                            </div>
                        </a>
                    </div>
                </div>
                <div class="w-full bg-white border rounded-[24px] border-gray-800 flex justify-between p-8 gap-x-6">
                    <div class="text-wrapper">
                        <div class="flex items-start gap-x-4">
                            <div class="w-20 p-5 border rounded-full border-gray-600" >
                                <img src="{{ asset('assets/icons/buying.svg') }}" alt="">
                            </div>
                            <div>
                                <h1 class="font-semibold text-xl">Nama Barang</h1>
                                <div class="mt-2">
                                    <p class="text-sm">Nama Pemasok : ANDO</p>
                                    <p class="text-sm">Jumlah Bayar : Rp. 25.000.000,00</p>
                                    <p class="text-sm">Jumlah : 1000,00</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-x-3">
                        <a href="#">
                            <div class="bg-yellow-100 text-lg text-yellow-800 font-semibold px-6 py-3 rounded-lg">
                                Belum Lunas
                            </div>
                        </a>
                        <a href="">
                            <div class="bg-green-100 text-lg text-green-800 font-semibold px-6 py-3 rounded-lg">
                                Pembelian Selesai
                            </div>
                        </a>
                        <a href="">
                            <div class="bg-gray-100 text-lg text-gray-800 font-semibold px-6 py-3 rounded-lg">
                                Detail
                            </div>
                        </a>
                    </div>
                </div>
                <div class="w-full bg-white border rounded-[24px] border-gray-800 flex justify-between p-8 gap-x-6">
                    <div class="text-wrapper">
                        <div class="flex items-start gap-x-4">
                            <div class="w-20 p-5 border rounded-full border-gray-600" >
                                <img src="{{ asset('assets/icons/buying.svg') }}" alt="">
                            </div>
                            <div>
                                <h1 class="font-semibold text-xl">Nama Barang</h1>
                                <div class="mt-2">
                                    <p class="text-sm">Nama Pemasok : ANDO</p>
                                    <p class="text-sm">Jumlah Bayar : Rp. 25.000.000,00</p>
                                    <p class="text-sm">Jumlah : 1000,00</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-x-3">
                        <div class="bg-green-100 text-lg text-green-800 font-semibold px-6 py-3 rounded-lg hidden">
                            Lunas
                        </div>
                        <div class="bg-yellow-100 text-lg text-yellow-800 font-semibold px-6 py-3 rounded-lg">
                            Pembelian Belum Selesai
                        </div>
                        <div class="bg-gray-100 text-lg text-gray-800 font-semibold px-6 py-3 rounded-lg">
                            Detail
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
</body>
</html>
