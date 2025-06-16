<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard | Produk</title>
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
        <div class="flex items-center gap-x-5">
            <img src="{{ asset('/assets/icons/notif.svg') }}" alt="" class="w-6">
            <div class="w-[32px] h-[32px] overflow-hidden rounded-full">
                <img class="w-full h-full object-cover" src="{{ asset('/assets/images/login-main.png') }}" alt="">
            </div>
        </div>
    </header>
    <main class="px-24 mt-[120px]">
        <section>
            <div class="flex items-start justify-between mt-10">
                <div>
                    <h1 class="text-[40px] font-semibold">Produk</h1>
                    <p>Stok dan Informasi Produk</p>
                </div>
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
            <div>
                {{-- <a href="{{ route('product.show', $item['item_id']) }}">View Details</a> --}}
            </div>
            @if(isset($allData))
            <div class="card-wrapper grid grid-cols-4 gap-5">
                @foreach($allData as $item)
                    <div class="card h-[400px] bg-white rounded-2xl overflow-hidden relative">
                        <img src="{{ asset('assets/images/arjuna.webp') }}" class="w-full h-full object-cover">
                        <div class="w-full p-2 h-2/5 absolute bottom-0">
                            <div class="bg-white rounded-xl h-full flex flex-col justify-between p-4">
                                <div class="">
                                    <h2 class="text-lg font-semibold truncate">Sandal Kemon Arjuna Size 31-43 Cowok Selop Shoes Pria Sendal</h2>
                                    <div class="flex mt-2">
                                        <p class="text-sm text-gray-500 border-r border-gray-500 pr-2">Rp. 100.000 - Rp. 125.000</p>
                                        <p class="text-sm text-gray-500 border-l border-gray-500 pl-2">Stok: 90000</p>
                                    </div>
                                </div>
                                <div class="card-button-wrapper flex items-center w-full gap-x-2">
                                    <button class="px-4 py-2 bg-slate-200 rounded-md flex-grow">
                                        <a href="#">Details</a>
                                    </button>
                                    <div class="w-10 h-10">
                                        <a href="">
                                            <div class="bg-red-200 ml-auto rounded-md h-full flex items-center justify-center p-2">
                                                <img src="{{ asset('assets/icons/trash.svg') }}" alt="">
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            @else
                <p class="text-gray-500">Tidak ada data produk tersedia.</p>
            @endif
        </section>
        {{-- <a href="{{ route('addmodel')}}">
            Test Add
        </a> --}}
    </main>
</body>
</html>
