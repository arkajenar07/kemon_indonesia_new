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
    <main class="px-24 mt-[180px]">
        <section>
            <div class="flex items-start justify-between mt-10">
                <div>
                    <h1 class="text-[40px] font-semibold">Produk</h1>
                    <p>Stok dan Informasi Produk</p>
                </div>
                <div class="flex gap-x-5">
                    <div class="flex items-center bg-[#FFF8F2] border border-[#DCA88F] px-4 py-2 rounded-xl">
                        <button>
                            <img src="{{ asset('/assets/icons/search.svg') }}" alt="">
                        </button>
                        <input type="text" name="" id="" class="bg-transparent border-none outline-none focus:outline-none ring-0 focus:ring-0" placeholder="Cari Produk">
                    </div>
                    <button class="w-[200px] bg-[#DCA88F] justify-center rounded-xl">
                        {{-- <a href="{{ route('product.add') }}" class="flex items-center gap-x-4 justify-center font-semibold">
                            <img src="{{ asset('/assets/icons/add-product.svg') }}" alt="" class="w-8">
                            Add Product
                        </a> --}}
                    </button>
                </div>
            </div>
        </section>
        <section class="mt-10">
            <div>
                {{-- <a href="{{ route('product.show', $item['item_id']) }}">View Details</a> --}}
            </div>
            <div class="card-wrapper grid grid-cols-4 gap-5">
                @foreach($allData as $item)
                    <div class="card max-w-[320px] h-[380px] bg-white rounded-[24px] overflow-hidden shadow-xl">
                        <div class="w-full h-2/5">
                            <img src="{{ $item['image']['image_url_list'][0] }}" alt="{{ $item['name'] }}" class="w-full h-full object-cover">
                        </div>
                        <div class="p-6 flex flex-col justify-between h-3/5">
                            <div class="">
                                <h2 class="text-xl font-semibold truncate">{{ $item['name'] }}</h2>
                                <p class="text-gray-500">Rp. {{ $item['min_price'] }} - Rp. {{ $item['max_price'] }}</p>
                                <h2 class="font-medium text-green-800 text-sm p-2 w-2/5 mt-2 bg-green-100 text-center rounded-md">Stok: {{ $item['total_stock'] }}</h2>
                            </div>
                            <div class="card-button-wrapper flex items-center w-full gap-x-2">
                                <button class="px-4 py-2 bg-slate-200 rounded-md">
                                    <a href="{{ route('product.info', parameters: $item['item_id']) }}">Details</a>
                                </button>
                               <div class="ml-auto">
                                 <a href="">
                                    <div class="p-4 bg-red-200 rounded-full">
                                        <img src="{{ asset('assets/icons/trash.svg') }}" alt="">
                                    </div>
                                 </a>
                               </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
        <a href="{{ route('addmodel')}}">
            Test Add
        </a>
    </main>
</body>
</html>
