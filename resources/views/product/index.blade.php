<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Product | Info</title>
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
                {{-- <li class="text-lg" ><a href="{{ route('dashboard.pembelian') }}">Data Pembelian</a></li>
                <li class="text-lg" ><a href="{{ route('dashboard.penjualan') }}">Data Penjualan</a></li> --}}
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
            <div>
                <div class="flex bg-[#B17457] p-[18px] rounded-t-[30px] items-center gap-x-[12px]">
                    <img src="{{ asset('/assets/icons/user-white.svg') }}" alt="" class="w-[42px] h-[42px]">
                    <h1 class="text-[28px] text-[#FFF] font-semibold">Informasi Produk</h1>
                </div>
                <div class="px-6 pb-6">
                    <div class="flex py-6 gap-x-6">
                        <div class="flex gap-4 items-start w-[35%] h-auto rounded-lg overflow-hidden border border-[#B17457]">
                            <img src="{{ $item['base_info']['image']['image_url_list'][0] }}" alt="" class="w-full h-full object-cover">
                        </div>
                        <div class="flex flex-col gap-y-2 w-[65%] pt-4 items-start">
                            <p class="text-sm border border-black px-3 py-1 rounded-full">SKU: {{ $item['base_info']['item_sku'] }}</p>
                            <h2 class="text-[30px] font-semibold">{{ $item['base_info']['item_name'] ?? '-' }}</h2>
                            <p><strong>Kondisi:</strong> {{ $item['base_info']['condition'] ?? '-' }}</p>
                            @if (!empty($item['base_info']['description_info']['extended_description']['field_list']))
                                <p><strong>Deskripsi:</strong>
                                    {{ $item['base_info']['description_info']['extended_description']['field_list'][0]['text'] ?? '-' }}
                                </p>
                            @endif
                            <a href="{{ route('product.editbase', parameters: $item['base_info']['item_id']) }}">
                                <div class="bg-yellow-50 text-yellow-600 px-4 py-2 mt-4">
                                    Edit Base Info
                                </div>
                            </a>
                        </div>
                    </div>
                    <h3 class="font-semibold">Variasi:</h3>
                    <div class="grid md:grid-cols-2 gap-4 my-4">
                        @foreach ($item['grouped_models'] as $warna => $ukuranList)
                            <div class="border rounded-lg shadow p-2">
                                <div class="w-full border p-2 flex gap-x-5">
                                    <div class="flex-grow">
                                        <h2 class="text-sm mb-2 border p-2 rounded-full text-center">Info</h2>
                                        <p class="text-base mb-2"> <strong> Warna: </strong>  {{ $warna }}</p>
                                    </div>
                                {{-- Gambar Warna --}}
                                @php
                                    $warnaImage = collect($item['model_data']['tier_variation'][0]['option_list'])
                                        ->firstWhere('option', $warna)['image']['image_url'] ?? null;
                                @endphp

                                @if ($warnaImage)
                                    <img src="{{ $warnaImage }}" alt="{{ $warna }}" class="w-32 h-32 object-cover border">
                                @endif
                                </div>

                                <table class="w-full text-sm mt-4">
                                    <thead>
                                        <tr class="bg-gray-200">
                                            <th class="text-left py-1 px-2">Ukuran</th>
                                            <th class="text-left py-1 px-2">Stok</th>
                                            <th class="text-left py-1 px-2">Harga</th>
                                            <th class="text-left py-1 px-2">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
    @foreach (collect($ukuranList)->sortBy(function ($val) {
        return preg_replace('/\D/', '', $val) ?: $val;
    }) as $ukuran)
        @php
            $model = collect($item['model_data']['model'])->first(function ($m) use ($warna, $ukuran) {
                return trim($m['model_name']) === "$warna,$ukuran";
            });
        @endphp
        <tr>
            <td class="py-1 px-2">{{ $ukuran }}</td>
            <td class="py-1 px-2">{{ $model['stock_info_v2']['summary_info']['total_available_stock'] ?? 'N/A' }}</td>
            <td class="py-1 px-2">
                Rp. {{ number_format($model['price_info'][0]['current_price'], 0, ',', '.') }}
            </td>
            <td class="py-3 px-2 flex justify-center">
                <div class="w-1/2">
                    <a href="">
                        <img src="{{ asset('assets/icons/trash.svg') }}" alt="">
                    </a>
                </div>
            </td>
        </tr>
    @endforeach
</tbody>

                                </table>
                            </div>
                        @endforeach
                    </div>
                    <hr>
                    <div class="w-full mt-4 flex gap-x-4">
                        <div class="w-1/2">
                            <a href="">
                                <div class="bg-green-50 text-green-600 border border-green-600 rounded-xl font-medium flex item-center justify-center p-4">
                                    Tambah Variasi
                                </div>
                            </a>
                        </div>
                        <div class="w-1/2">
                            <a href="{{ route('product.edit_tier', $item['base_info']['item_id'])}}">
                                <div class="bg-yellow-50 text-yellow-600 border border-yellow-600 rounded-xl font-medium flex item-center justify-center p-4">
                                    Edit Variasi
                                </div>
                            </a>
                        </div>
                    </div>
                    <button type="submit" class="mt-8 w-full bg-gray-800 text-white p-[18px] text-[21px] font-semibold rounded-bl-[24px] rounded-tr-[24px]">
                        <a href="{{ route('dashboard') }}">Kembali</a>
                    </button>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
