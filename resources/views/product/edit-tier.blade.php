<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Tier</title>
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> --}}
    <link rel="icon" href="{{ asset('assets/icons/shoe-head.svg') }}" type="image/x-icon" />
    <link rel="stylesheet" href="/assets/css/style.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="container py-4">
        <form action="{{ route('product.update_tier') }}" method="POST">
            @csrf
            <input type="hidden" name="item_id" value="{{ $item_id }}">

            {{-- === FORM TIER VARIATION === --}}
            @foreach ($variations['tier_variation'] as $i => $tier)
                <div class="card mb-4 p-3">
                    <input type="hidden" name="tier_variation[{{ $i }}][name]" class="form-control"
                            value="{{ $tier['name'] }}" required>
                    <h5>{{ $tier['name'] }}:</h5>
                    @foreach ($tier['option_list'] as $j => $option)
                        <div class="mb-3">
                            <input type="text" name="tier_variation[{{ $i }}][option_list][{{ $j }}][option]"
                                    class="form-control" value="{{ $option['option'] }}" required>

                            @if (isset($option['image']))

                                    <input type="url" name="tier_variation[{{ $i }}][option_list][{{ $j }}][image_url]"
                                        class="form-control" value="{{ $option['image']['image_url'] }}">

                                    <input type="text" name="tier_variation[{{ $i }}][option_list][{{ $j }}][image_id]"
                                            class="form-control" value="{{ $option['image']['image_id'] }}">

                                <img src="{{ $option['image']['image_url'] }}" alt="Option Image" class="w-[300px]">
                            @endif
                        </div>
                    @endforeach
                </div>
            @endforeach

            {{-- === INPUT STOCK & PRICE UNTUK KOMBINASI OPTION === --}}
            {{-- === INPUT STOCK & PRICE UNTUK KOMBINASI OPTION === --}}
<div class="card mb-4 p-3">
    <h4>Stock & Harga per Kombinasi</h4>

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

        <h5 class="mt-4">Warna: {{ $warna }}</h5>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Ukuran</th>
                    <th>Harga (Rp)</th>
                    <th>Stok</th>
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
                        <td>
                            {{ $ukuran }}
                            <input type="hidden" name="combinations[{{ $loop->parent->index }}_{{ $index }}][model_id]" value="{{ $modelId }}">
                            <input type="hidden" name="combinations[{{ $loop->parent->index }}_{{ $index }}][warna]" value="{{ $warna }}">
                            <input type="hidden" name="combinations[{{ $loop->parent->index }}_{{ $index }}][ukuran]" value="{{ $ukuran }}">
                        </td>
                        <td>
                            <input type="number" step="0.01" class="form-control" name="combinations[{{ $loop->parent->index }}_{{ $index }}][price]" value="{{ $price }}">
                        </td>
                        <td>
                            <input type="number" class="form-control" name="combinations[{{ $loop->parent->index }}_{{ $index }}][stock]" value="{{ $stock }}">
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endforeach
</div>



            <button type="submit" class="btn btn-primary">Update Tier Variations</button>
        </form>
    </div>
</body>
</html>
