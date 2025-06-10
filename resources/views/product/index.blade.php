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
    <header class="flex justify-between items-center p-6 fixed w-full bg-white top-0">
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
    <main class="px-10 mt-[160px]">
        <div class="w-4/5 mt-16 mx-auto">
            <div class="w-full px-6 pb-6 flex gap-x-4">
                <div class="w-1/3 flex flex-col gap-y-4">
                    <div class="bg-[#FFF] rounded-lg w-full p-6">
                        <div class="flex gap-4 items-start overflow-hidden border border-slate-300">
                            <img src="{{ $item['base_info']['image']['image_url_list'][0] }}" alt="" class="w-full h-full object-cover">
                        </div>
                    </div>
                    <div class="flex flex-col gap-y-2 w-full pt-4 items-start bg-[#FFF] rounded-lg p-6">
                        <h2 class="text-lg font-semibold">Basic Information</h2>
                        <div class="flex flex-col w-full gap-y-2 mt-2">
                            <label class="text-sm font-medium text-gray-600">Nama Produk</label>
                            <textarea
                                class="border-2 border-gray-200 rounded-lg text-left p-2 overflow-hidden h-[120px]"
                            >
                                {{ $item['base_info']['item_name'] ?? '-' }}
                            </textarea>
                        </div>
                        <div class="flex flex-col w-full gap-y-2 mt-2">
                            <label class="text-sm font-medium text-gray-600">SKU Produk</label>
                            <input class="border-2 border-gray-200 rounded-lg" type="text" name="" id="" value="{{ $item['base_info']['item_sku'] }}">
                        </div>
                        @if (!empty($item['base_info']['description_info']['extended_description']['field_list']))
                        <div class="flex flex-col w-full gap-y-2 mt-2">
                            <label class="text-sm font-medium text-gray-600">Deskripsi Produk</label>
                            <textarea class="border-2 border-gray-200 rounded-lg h-[250px]" type="text" name="" id="" value="{{ $item['base_info']['item_sku'] }}">
                                {{ $item['base_info']['description_info']['extended_description']['field_list'][0]['text'] ?? '-' }}
                            </textarea>
                        </div>
                        @endif
                        <a href="{{ route('product.editbase', parameters: $item['base_info']['item_id']) }}">
                            <div class="bg-yellow-50 text-yellow-600 px-4 py-2 mt-4">
                                Edit Base Info
                            </div>
                        </a>
                    </div>
                </div>
                <div class="w-2/3">
                    <form action="{{ route('product.update_tier') }}" method="POST">
                        @csrf
                        <input type="hidden" name="item_id" value="{{ $item_id }}">
                        <div class="flex gap-x-4">
                            {{-- === FORM TIER VARIATION === --}}
                            <div class="w-full">
                                @foreach ($item['model_data']['tier_variation'] as $i => $tier)
                                <div id="tier-{{ $i }}-options" class="card mb-4 bg-[#FFFFFF] p-6 rounded-lg" data-initial-count="{{ count($tier['option_list']) }}">
                                    <input type="hidden" name="tier_variation[{{ $i }}][name]" class="form-control"
                                        value="{{ $tier['name'] }}" required>
                                    <h2 class="font-semibold">Opsi {{ $tier['name'] }}</h2>
                                    <div id="tier-{{ $i }}-options" class="w-full grid grid-cols-2 gap-2 mt-4">
                                        @foreach ($tier['option_list'] as $j => $option)
                                            <div class="mb-3 option-item">
                                                <div class="">
                                                    <div class="flex gap-x-2 group relative">
                                                        <input type="text" name="tier_variation[{{ $i }}][option_list][{{ $j }}][option]"
                                                            class="w-full border-2 border-gray-200 rounded-lg" value="{{ $option['option'] }}" required oninput="handleInputChange()">

                                                        <button type="button"
                                                            class="absolute bg-red-200 w-6 h-6 p-1 hidden group-hover:flex items-center justify-center right-0 rounded-sm"
                                                            onclick="removeOption(this)">
                                                            <img src="{{ asset('assets/icons/trash.svg') }}" class="w-full h-full" alt="hapus"/>
                                                        </button>
                                                    </div>
                                                    @if (isset($option['image']))
                                                        <input type="hidden" name="tier_variation[{{ $i }}][option_list][{{ $j }}][image_url]"
                                                            class="form-control w-3/4" value="{{ $option['image']['image_url'] }}">
                                                        <input type="hidden" name="tier_variation[{{ $i }}][option_list][{{ $j }}][image_id]"
                                                            class="form-control w-3/4" value="{{ $option['image']['image_id'] }}">
                                                        <img src="{{ $option['image']['image_url'] }}" alt="Option Image" class="w-full mt-2">
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    {{-- Tambahkan tombol hanya untuk tier Warna --}}
                                    @if ($tier['name'] === 'Warna' || $i === 0)
                                        <button type="button" class="w-full px-4 py-2 bg-slate-200 border border-gray-800 mt-3 font-semibold rounded-lg" onclick="addWarna({{ $i }})">
                                            + Tambah Warna
                                        </button>
                                    @endif
                                    {{-- Tambahkan tombol hanya untuk tier Ukuran --}}
                                    @if ($tier['name'] === 'Ukuran' || $i === 1)
                                        <button type="button" class="w-full px-4 py-2 bg-slate-200 border border-gray-800 mt-3 font-semibold rounded-lg" onclick="addUkuran({{ $i }})">
                                            + Tambah Ukuran
                                        </button>
                                    @endif
                                </div>
                            @endforeach
                            </div>
                            {{-- === INPUT STOCK & PRICE UNTUK KOMBINASI OPTION === --}}
                            <div class="card mb-4 bg-[#FFF] p-6 rounded-lg">
                                <h4 class="font-semibold mb-4">Stock & Harga</h4>
                                <div id="model-combinations"></div>
                            </div>
                        </div>
                        <button type="submit" class="w-full bg-green-50 text-green-600 border border-green-600 rounded-xl font-medium flex item-center justify-center p-4">Update Variasi</button>
                    </form>
                    <button class="w-full mt-4 bg-gray-800 text-white p-[18px] text-[21px] font-semibold rounded-bl-[24px] rounded-tr-[24px]">
                        <a href="{{ route('dashboard') }}">Kembali</a>
                    </button>
                </div>
            </div>
        </div>
    </main>
<script>
    const existingModels = @json($item['model_data']['model'] ?? []);

    // function showUpdateButtonIfNeeded(container) {
    //     const initialCount = parseInt(container.getAttribute('data-initial-count'));
    //     const currentCount = container.querySelectorAll('input[name$="[option]"]').length;
    //     const updateButton = document.getElementById('update-options-button');

    //     if (currentCount > initialCount) {
    //         updateButton.classList.remove('hidden');
    //     }
    // }

    function addWarna(index) {
        const container = document.getElementById(`tier-${index}-options`);
        const count = container.querySelectorAll('.option-item').length;

        const html = `
            <div class="my-3 option-item">
                <div class="d-flex gap-2 align-items-start">
                    <div class="flex-fill">
                        <input type="text" name="tier_variation[${index}][option_list][${count}][option]"
                            class="form-control warna-input" placeholder="Warna baru..." required
                            oninput="handleInputChange()">
                        <input type="url" name="tier_variation[${index}][option_list][${count}][image_url]"
                            class="form-control mt-1" placeholder="Image URL (opsional)"
                            onblur="fetchImageId(this)">
                        <input type="text" name="tier_variation[${index}][option_list][${count}][image_id]"
                            class="form-control mt-1" placeholder="Image ID (opsional)">
                    </div>
                    <button type="button" class="bg-red-200 p-2 mt-1" onclick="removeOption(this)">
                        <img src="{{ asset('assets/icons/trash.svg') }}" class="w-full h-full" alt="hapus"/>
                    </button>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', html);
    }

    function addUkuran(index) {
        const container = document.getElementById(`tier-${index}-options`);
        const count = container.querySelectorAll('.option-item').length;

        const html = `
            <div class="my-3 option-item">
                <div class="flex gap-x-2 items-start">
                    <div class="flex-fill">
                        <input type="text" name="tier_variation[${index}][option_list][${count}][option]"
                            class="form-control ukuran-input" placeholder="Ukuran baru..." required
                            oninput="handleInputChange()">
                    </div>
                    <button type="button" class="bg-red-200 p-2 mt-1" onclick="removeOption(this)">
                        <img src="{{ asset('assets/icons/trash.svg') }}" class="w-full h-full" alt="hapus"/>
                    </button>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', html);
    }

    function removeOption(button) {
        const item = button.closest('.option-item');
        if (item) item.remove();

        generateCombinations();
    }

    function getOptions(tierIndex) {
        const tierDiv = document.getElementById(`tier-${tierIndex}-options`);
        const inputs = tierDiv.querySelectorAll('input[name^="tier_variation"]');
        const options = [];
        for (let input of inputs) {
            if (input.name.includes('[option]')) {
                const val = input.value.trim();
                if (val) options.push(val);
            }
        }
        return options;
    }

    function findModel(warnaIndex, ukuranIndex) {
        return existingModels.find(model =>
            model.tier_index[0] === warnaIndex &&
            model.tier_index[1] === ukuranIndex
        );
    }

    function generateCombinations() {
        const warnaList = getOptions(0);
        const ukuranList = getOptions(1);
        const container = document.getElementById('model-combinations');
        container.innerHTML = '';

        warnaList.forEach((warna, warnaIndex) => {
            const warnaTable = document.createElement('div');
            warnaTable.innerHTML = `
                <h2 class="font-medium">Warna ${warna}</h2>
                <table class="w-full border border-separate border-gray-300 my-4">
                    <thead>
                        <tr>
                            <th class="border border-gray-300 px-4 py-2">Ukuran</th>
                            <th class="border border-gray-300 px-4 py-2">Harga</th>
                            <th class="border border-gray-300 px-4 py-2">Stok</th>
                        </tr>
                    </thead>
                    <tbody id="tbody-${warnaIndex}"></tbody>
                </table>
            `;

            const tbody = warnaTable.querySelector(`#tbody-${warnaIndex}`);

            ukuranList.forEach((ukuran, ukuranIndex) => {
                const key = `${warnaIndex}_${ukuranIndex}`;
                const model = findModel(warnaIndex, ukuranIndex);
                const price = model?.price_info?.[0]?.current_price ?? '';
                const stock = model?.stock_info_v2?.seller_stock?.[0]?.stock ?? '';
                const modelId = model?.model_id ?? '';

                const row = document.createElement('tr');
                row.innerHTML = `
                    <td class="border border-gray-300 text-center">
                        ${ukuran}
                        <input type="hidden" name="combinations[${key}][model_id]" value="${modelId}">
                        <input type="hidden" name="combinations[${key}][warna]" value="${warna}">
                        <input type="hidden" name="combinations[${key}][ukuran]" value="${ukuran}">
                        <input type="hidden" name="combinations[${key}][tier_index][]" value="${warnaIndex}">
                        <input type="hidden" name="combinations[${key}][tier_index][]" value="${ukuranIndex}">
                    </td>
                    <td class="border border-gray-300">
                        <input type="number" step="0.01" class="w-full border-none outline-none focus:outline-none focus:border-none ring-0 focus:ring-0"
                            name="combinations[${key}][price]" value="${price}" required>
                    </td>
                    <td class="border border-gray-300">
                        <input type="number" class="w-full border-none outline-none focus:outline-none focus:border-none ring-0 focus:ring-0"
                            name="combinations[${key}][stock]" value="${stock}" required>
                    </td>
                `;
                tbody.appendChild(row);
            });

            container.appendChild(warnaTable);
        });
    }

    generateCombinations();

    function handleInputChange() {
        generateCombinations();
    }

    window.addEventListener('DOMContentLoaded', () => {
        generateCombinations();
    });
</script>

</body>
</html>
