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
                            {{-- <p><strong>Kondisi:</strong> {{ $item['base_info']['condition'] ?? '-' }}</p> --}}
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
                    <div>
                        <form action="{{ route('product.update_tier') }}" method="POST">
                            @csrf
                            <input type="hidden" name="item_id" value="{{ $item_id }}">
                            {{-- === FORM TIER VARIATION === --}}
                            <div>
                                @foreach ($item['model_data']['tier_variation'] as $i => $tier)
                                <div id="tier-{{ $i }}-options" class="" data-initial-count="{{ count($tier['option_list']) }}">
                                <div class="card my-6">
                                    <input type="hidden" name="tier_variation[{{ $i }}][name]" class="form-control"
                                        value="{{ $tier['name'] }}" required>
                                    <h5>{{ $tier['name'] }}:</h5>
                                    <div id="tier-{{ $i }}-options" class="w-full grid grid-cols-3 gap-4 mt-4">
                                        @foreach ($tier['option_list'] as $j => $option)
                                            <div class="mb-3 option-item">
                                                <div class="d-flex gap-2 align-items-start">
                                                    <div class="flex-fill">
                                                        <input type="text" name="tier_variation[{{ $i }}][option_list][{{ $j }}][option]"
                                                            class="form-control" value="{{ $option['option'] }}" required>
                                                        @if (isset($option['image']))
                                                            <input type="url" name="tier_variation[{{ $i }}][option_list][{{ $j }}][image_url]"
                                                                class="form-control mt-1" value="{{ $option['image']['image_url'] }}">
                                                            <input type="text" name="tier_variation[{{ $i }}][option_list][{{ $j }}][image_id]"
                                                                class="form-control mt-1" value="{{ $option['image']['image_id'] }}">
                                                            <img src="{{ $option['image']['image_url'] }}" alt="Option Image" class="w-[300px] mt-2">
                                                        @endif
                                                    </div>
                                                    <button type="button" class="btn btn-danger btn-sm mt-1" onclick="removeOption(this)">Hapus</button>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    {{-- Tambahkan tombol hanya untuk tier Warna --}}
                                    @if ($tier['name'] === 'Warna' || $i === 0)
                                        <button type="button" class="px-4 py-2 bg-slate-200 border border-gray-800 mt-3 font-semibold rounded-lg" onclick="addWarna({{ $i }})">
                                            + Tambah Warna
                                        </button>
                                    @endif

                                    {{-- Tambahkan tombol hanya untuk tier Ukuran --}}
                                    @if ($tier['name'] === 'Ukuran' || $i === 1)
                                        <button type="button" class="px-4 py-2 bg-slate-200 border border-gray-800 mt-3 font-semibold rounded-lg" onclick="addUkuran({{ $i }})">
                                            + Tambah Ukuran
                                        </button>
                                    @endif

                                </div>
                                </div>
                            @endforeach
                            <button id="update-options-button" type="submit"
                                class="hidden px-4 py-2 bg-blue-600 text-white rounded-lg mt-4">
                                Update Opsi
                            </button>
                            </div>

                            {{-- === INPUT STOCK & PRICE UNTUK KOMBINASI OPTION === --}}
                            <div class="card mb-4">
                                <h4 class="font-semibold mb-4">Stock & Harga</h4>
                                <div id="model-combinations"></div>
                            </div>
                            <button type="submit" class="w-full bg-green-50 text-green-600 border border-green-600 rounded-xl font-medium flex item-center justify-center p-4">Update Variasi</button>
                        </form>
                    </div>
                    <hr>
                    <button class="w-full mt-4 bg-gray-800 text-white p-[18px] text-[21px] font-semibold rounded-bl-[24px] rounded-tr-[24px]">
                        <a href="{{ route('dashboard') }}">Kembali</a>
                    </button>
                </div>
            </div>
        </div>
    </main>
{{-- <script>
    function showUpdateButtonIfNeeded(container) {
        const initialCount = parseInt(container.getAttribute('data-initial-count'));
        const currentCount = container.querySelectorAll('input[name$="[option]"]').length;
        const updateButton = document.getElementById('update-options-button');

        if (currentCount > initialCount) {
            updateButton.classList.remove('hidden');
        }
    }

    function addWarna(index) {
        const container = document.getElementById(`tier-${index}-options`);
        const count = container.querySelectorAll('.option-item').length;

        const html = `
            <div class="mb-3 option-item">
                <div class="d-flex gap-2 align-items-start">
                    <div class="flex-fill">
                        <input type="text" name="tier_variation[${index}][option_list][${count}][option]"
                            class="form-control" placeholder="Warna baru..." required>
                        <input type="url" name="tier_variation[${index}][option_list][${count}][image_url]"
                            class="form-control mt-1" placeholder="Image URL (opsional)">
                        <input type="text" name="tier_variation[${index}][option_list][${count}][image_id]"
                            class="form-control mt-1" placeholder="Image ID (opsional)">
                    </div>
                    <button type="button" class="btn btn-danger btn-sm mt-1" onclick="removeOption(this)">Hapus</button>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', html);
    }

    function addUkuran(index) {
        const container = document.getElementById(`tier-${index}-options`);
        const count = container.querySelectorAll('.option-item').length;

        const html = `
            <div class="mb-3 option-item">
                <div class="d-flex gap-2 align-items-start">
                    <div class="flex-fill">
                        <input type="text" name="tier_variation[${index}][option_list][${count}][option]"
                            class="form-control" placeholder="Ukuran baru..." required>
                    </div>
                    <button type="button" class="btn btn-danger btn-sm mt-1" onclick="removeOption(this)">Hapus</button>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', html);
    }

    function removeOption(button) {
        const item = button.closest('.option-item');
        if (item) item.remove();
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

    function generateCombinations() {
        const warnaList = getOptions(0);
        const ukuranList = getOptions(1);
        const container = document.getElementById('model-combinations');
        container.innerHTML = '';

        warnaList.forEach((warna, warnaIndex) => {
            const warnaTable = document.createElement('div');
            warnaTable.innerHTML = `
                <h4>${warna}</h4>
                <table class="w-full border border-separate border-gray-300 mb-4">
                    <thead>
                        <tr>
                            <th class="border border-gray-300 px-4 py-2">Ukuran</th>
                            <th class="border border-gray-300 px-4 py-2">Harga (Rp)</th>
                            <th class="border border-gray-300 px-4 py-2">Stok</th>
                        </tr>
                    </thead>
                    <tbody id="tbody-${warnaIndex}"></tbody>
                </table>
            `;

            const tbody = warnaTable.querySelector(`#tbody-${warnaIndex}`);

            ukuranList.forEach((ukuran, ukuranIndex) => {
                const key = `${warnaIndex}_${ukuranIndex}`;
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td class="border border-gray-300 text-center">
                        ${ukuran}
                        <input type="hidden" name="combinations[${key}][warna]" value="${warna}">
                        <input type="hidden" name="combinations[${key}][ukuran]" value="${ukuran}">
                        <input type="hidden" name="combinations[${key}][tier_index][]" value="${warnaIndex}">
                        <input type="hidden" name="combinations[${key}][tier_index][]" value="${ukuranIndex}">
                    </td>
                    <td class="border border-gray-300">
                        <input type="number" step="0.01" class="w-full border-none outline-none focus:outline-none focus:border-none ring-0 focus:ring-0"
                            name="combinations[${key}][price]" required>
                    </td>
                    <td class="border border-gray-300">
                        <input type="number" class="w-full border-none outline-none focus:outline-none focus:border-none ring-0 focus:ring-0"
                            name="combinations[${key}][stock]" required>
                    </td>
                `;
                tbody.appendChild(row);
            });

            container.appendChild(warnaTable);
        });
    }

    generateCombinations();

    window.addEventListener('DOMContentLoaded', () => {
        generateCombinations(); // Untuk inisialisasi awal
    });
</script> --}}
<script>
    const existingModels = @json($item['model_data']['model'] ?? []);

    function showUpdateButtonIfNeeded(container) {
        const initialCount = parseInt(container.getAttribute('data-initial-count'));
        const currentCount = container.querySelectorAll('input[name$="[option]"]').length;
        const updateButton = document.getElementById('update-options-button');

        if (currentCount > initialCount) {
            updateButton.classList.remove('hidden');
        }
    }

    function addWarna(index) {
        const container = document.getElementById(`tier-${index}-options`);
        const count = container.querySelectorAll('.option-item').length;

        const html = `
            <div class="mb-3 option-item">
                <div class="d-flex gap-2 align-items-start">
                    <div class="flex-fill">
                        <input type="text" name="tier_variation[${index}][option_list][${count}][option]"
                            class="form-control" placeholder="Warna baru..." required>
                        <input type="url" name="tier_variation[${index}][option_list][${count}][image_url]"
                            class="form-control mt-1" placeholder="Image URL (opsional)">
                        <input type="text" name="tier_variation[${index}][option_list][${count}][image_id]"
                            class="form-control mt-1" placeholder="Image ID (opsional)">
                    </div>
                    <button type="button" class="btn btn-danger btn-sm mt-1" onclick="removeOption(this)">Hapus</button>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', html);
    }

    function addUkuran(index) {
        const container = document.getElementById(`tier-${index}-options`);
        const count = container.querySelectorAll('.option-item').length;

        const html = `
            <div class="mb-3 option-item">
                <div class="d-flex gap-2 align-items-start">
                    <div class="flex-fill">
                        <input type="text" name="tier_variation[${index}][option_list][${count}][option]"
                            class="form-control" placeholder="Ukuran baru..." required>
                    </div>
                    <button type="button" class="btn btn-danger btn-sm mt-1" onclick="removeOption(this)">Hapus</button>
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
                <h4>${warna}</h4>
                <table class="w-full border border-separate border-gray-300 mb-4">
                    <thead>
                        <tr>
                            <th class="border border-gray-300 px-4 py-2">Ukuran</th>
                            <th class="border border-gray-300 px-4 py-2">Harga (Rp)</th>
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
                        <input type="text" name="combinations[${key}][model_id]" value="${modelId}">
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

    window.addEventListener('DOMContentLoaded', () => {
        generateCombinations();
    });
</script>



</body>
</html>
