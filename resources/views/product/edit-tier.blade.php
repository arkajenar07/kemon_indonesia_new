<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Prouduct | Edit</title>
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
                {{-- <li class="text-lg" ><a href="{{ route('dashboard.pembelian') }}">Data Pembelian</a></li> --}}
                {{-- <li class="text-lg" ><a href="{{ route('dashboard.penjualan') }}">Data Penjualan</a></li> --}}
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
        <div class="max-w-[50rem] mx-auto">
            <div class="flex bg-[#B17457] p-[18px] rounded-t-[30px] items-center gap-x-[12px]">
                <img src="{{ asset('/assets/icons/user-white.svg') }}" alt="" class="w-[42px] h-[42px]">
                <h1 class="text-[28px] text-[#FFF] font-semibold">Informasi Produk</h1>
            </div>
            <div class="container p-6">
                <form action="{{ route('product.update_tier') }}" method="POST">
                    @csrf
                    <input type="hidden" name="item_id" value="{{ $item_id }}">

                    {{-- === FORM TIER VARIATION === --}}
                    @foreach ($variations['tier_variation'] as $i => $tier)
                        <div class="card mb-4">
                            <input type="hidden" name="tier_variation[{{ $i }}][name]"
                                    value="{{ $tier['name'] }}" required>
                            <h2 class="font-semibold mb-4">Opsi {{ $tier['name'] }}</h2>
                            <div class="flex gap-x-6">
                                @foreach ($tier['option_list'] as $j => $option)
                                <div class="mb-3 w-full">
                                    <input type="text" name="tier_variation[{{ $i }}][option_list][{{ $j }}][option]"
                                            class="w-full rounded-lg" value="{{ $option['option'] }}" required>

                                    @if (isset($option['image']))

                                            <input type="hidden" name="tier_variation[{{ $i }}][option_list][{{ $j }}][image_url]"
                                                class="w-full" value="{{ $option['image']['image_url'] }}">

                                            <input type="hidden" name="tier_variation[{{ $i }}][option_list][{{ $j }}][image_id]"
                                                    class="w-full" value="{{ $option['image']['image_id'] }}">

                                        <img src="{{ $option['image']['image_url'] }}" alt="Option Image" class="w-full border">
                                    @endif
                                </div>
                            @endforeach
                            </div>
                        </div>
                    @endforeach

                    {{-- === INPUT STOCK & PRICE UNTUK KOMBINASI OPTION === --}}
                    <div class="card mb-4">
                        <h4 class="font-semibold mb-4">Stock & Harga</h4>

                        @php
                            $warnaTier = $variations['tier_variation'][0];
                            $ukuranTier = $variations['tier_variation'][1];

                            // Kelompokkan model berdasarkan warnaIndex
                            $groupedByWarna = collect($variations['model'])->groupBy(fn($model) => $model['tier_index'][0]);
                        @endphp

                        @foreach ($groupedByWarna as $warnaIndex => $models)
                            @php
                                $warna = $warnaTier['option_list'][$warnaIndex]['option'] ?? 'N/A';

                                // Urutkan model berdasarkan ukuranIndex (tier_index[1]) dari besar ke kecil
                                $sortedModels = collect($models)->sortBy(fn($m) => $m['tier_index'][1]);
                            @endphp
                            <h4> {{ $warna }}</h4>
                            <table class="w-full border border-separate border-gray-300 mb-4">
                                <thead>
                                    <tr>
                                        <th class="border border-gray-300 px-4 py-2">Ukuran</th>
                                        <th class="border border-gray-300 px-4 py-2">Harga (Rp)</th>
                                        <th class="border border-gray-300 px-4 py-2">Stok</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sortedModels as $index => $model)
                                        @php
                                            $ukuranIndex = $model['tier_index'][1];
                                            $ukuran = $ukuranTier['option_list'][$ukuranIndex]['option'] ?? 'N/A';

                                            $modelId = $model['model_id'] ?? null;
                                            $price = $model['price_info'][0]['current_price'] ?? null;
                                            $stock = $model['stock_info_v2']['seller_stock'][0]['stock'] ?? null;
                                        @endphp
                                        <tr>
                                            <td class="border border-gray-300 text-center">
                                                {{ $ukuran }}
                                                <input type="hidden" name="combinations[{{ $loop->parent->index }}_{{ $index }}][model_id]" value="{{ $modelId }}">
                                                <input type="hidden" name="combinations[{{ $loop->parent->index }}_{{ $index }}][warna]" value="{{ $warna }}">
                                                <input type="hidden" name="combinations[{{ $loop->parent->index }}_{{ $index }}][ukuran]" value="{{ $ukuran }}">
                                            </td>
                                            <td class="border border-gray-300">
                                                <input type="number" step="0.01" class="w-full border-none outline-none focus:outline-none focus:border-none ring-0 focus:ring-0" name="combinations[{{ $loop->parent->index }}_{{ $index }}][price]" value="{{ $price }}">
                                            </td>
                                            <td class="border border-gray-300">
                                                <input type="number" class="w-full border-none outline-none focus:outline-none focus:border-none ring-0 focus:ring-0" name="combinations[{{ $loop->parent->index }}_{{ $index }}][stock]" value="{{ $stock }}">
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endforeach
                    </div>

                    <button type="submit" class="w-full bg-green-50 text-green-600 border border-green-600 rounded-xl font-medium flex item-center justify-center p-4">Update Tier Variations</button>
                </form>
            </div>
        </div>
    </main>
</body>
</html>
