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
    <main class="px-10 mt-[120px]">
        <div class="w-[85%] mt-16 mx-auto">
            <div class="flex items-center justify-start gap-x-6">
                <a href="{{ route('dashboard') }}">
                    <div class="bg-[#3A2D28] text-white px-4 py-2 rounded-md">
                        Back
                    </div>
                </a>
                <h2 class="text-xl font-semibold">Detail Info {{ $item['base_info']['item_name'] }}</h2>
            </div>
            <div class="w-full mt-6 pb-6 flex flex-col gap-y-4">
                <div class="w-full flex gap-x-4">
                    <div class="w-1/4 bg-[#FFF] border border-gray-200 rounded-lg p-6">
                        <div class="flex gap-4 items-start overflow-hidden border border-slate-300">
                            <img src="{{ $item['base_info']['image']['image_url_list'][0] }}" alt="" class="w-full h-full object-cover">
                        </div>
                    </div>
                    <div class="w-3/4 flex flex-col gap-y-2 pt-4 items-start bg-[#FFF] border border-gray-200 rounded-lg p-6">
                        <h2 class="text-lg font-semibold">Basic Information</h2>
                        <div class="flex flex-col w-full gap-y-2 mt-2">
                            <label class="text-sm font-medium text-gray-600">Nama Produk</label>
                            <input class="border-2 border-gray-200 rounded-lg" type="text" name="" id="" value="{{ $item['base_info']['item_name'] }}">
                        </div>
                        <div class="flex flex-col w-full gap-y-2 mt-2">
                            <label class="text-sm font-medium text-gray-600">SKU Produk</label>
                            <input class="border-2 border-gray-200 rounded-lg" type="text" name="" id="" value="{{ $item['base_info']['item_sku'] }}">
                        </div>
                        @if (!empty($item['base_info']['description']))
                        <div class="flex flex-col w-full gap-y-2 mt-2">
                            <label class="text-sm font-medium text-gray-600">Deskripsi Produk</label>
                            <textarea class="border-2 border-gray-200 rounded-lg h-[180px]" type="text" name="" id="">{{ $item['base_info']['description'] ?? '-' }}</textarea>
                        </div>
                        @endif
                        <a href="{{ route('product.editbase', parameters: $item['base_info']['item_id']) }}">
                            <div class="bg-yellow-50 text-yellow-600 px-4 py-2 mt-4">
                                Edit Base Info
                            </div>
                        </a>
                    </div>
                </div>
                <div class="w-full">
                    <div id="model-data-container" data-models='@json($item['model_data']['model'] ?? [])'></div>
                    <form action="{{ route('product.update_tier') }}" method="POST">
                        @csrf
                        <input type="hidden" name="item_id" value="{{ $item_id }}">
                        <div class="">
                            {{-- === FORM TIER VARIATION === --}}
                            <div class="w-full">
                                @foreach ($item['model_data']['tier_variation'] as $i => $tier)
                                <div class="card mb-4 bg-[#FFFFFF] border border-gray-200 p-6 rounded-lg" data-initial-count="{{ count($tier['option_list']) }}">
                                    <input type="hidden" name="tier_variation[{{ $i }}][name]" class="form-control"
                                        value="{{ $tier['name'] }}" required>
                                    <h2 class="font-semibold text-lg">Opsi {{ $tier['name'] }}</h2>
                                    <div id="tier-{{ $i }}-options" class="w-full grid grid-cols-6 gap-2 mt-4">
                                        @foreach ($tier['option_list'] as $j => $option)
                                            <div class="mb-3 option-item">
                                                <div class="flex flex-col gap-y-2">
                                                    <input type="text" name="tier_variation[{{ $i }}][option_list][{{ $j }}][option]"
                                                        class="w-full border-2 border-gray-200 rounded-lg" value="{{ $option['option'] }}" required oninput="handleInputChange()">
                                                    @if (isset($option['image']))
                                                        {{-- Input Hidden untuk image_url & image_id --}}
                                                        <input type="hidden" name="tier_variation[{{ $i }}][option_list][{{ $j }}][image_url]"
                                                            class="image-url-field"
                                                            value="{{ $option['image']['image_url'] }}">
                                                        <input type="hidden" name="tier_variation[{{ $i }}][option_list][{{ $j }}][image_id]"
                                                            class="image-id-field"
                                                            value="{{ $option['image']['image_id'] }}">
                                                        {{-- Preview Gambar --}}
                                                        <img src="{{ $option['image']['image_url'] }}" alt="Option Image"
                                                            class="w-full mt-2 preview-image rounded-lg border border-gray-300">
                                                        {{-- Tombol Edit Gambar --}}
                                                        <button type="button"
                                                            class="w-fit mt-2 bg-yellow-300 text-sm px-3 py-1 rounded hover:bg-yellow-400"
                                                            onclick="triggerFileInput(this)">
                                                            Edit Gambar
                                                        </button>
                                                        {{-- File input untuk upload gambar baru (disembunyikan) --}}
                                                        <input type="file"
                                                            name="image_upload[{{ $i }}][{{ $j }}]"
                                                            class="image-upload-input hidden"
                                                            onchange="uploadImage(this, {{ $i }}, {{ $j }})">
                                                    @endif
                                                    <button type="button"
                                                        class="w-fit bg-red-200 px-3 py-1 text-sm rounded"
                                                        onclick="removeOption(this)">
                                                        Hapus Opsi
                                                    </button>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    {{-- Tambahkan tombol hanya untuk tier Warna --}}
                                    @if ($tier['name'] === 'Warna' || $i === 0)
                                        <button type="button" class="w-fit px-4 py-2 bg-slate-200 border border-gray-800 mt-3 font-semibold rounded-lg" onclick="addWarna({{ $i }})">
                                            + Tambah Warna
                                        </button>
                                    @endif
                                    {{-- Tambahkan tombol hanya untuk tier Ukuran --}}
                                    @if ($tier['name'] === 'Ukuran' || $i === 1)
                                        <button type="button" class="w-fit px-4 py-2 bg-slate-200 border border-gray-800 mt-3 font-semibold rounded-lg" onclick="addUkuran({{ $i }})">
                                            + Tambah Ukuran
                                        </button>
                                    @endif
                                </div>
                            @endforeach
                            </div>
                            {{-- === INPUT STOCK & PRICE UNTUK KOMBINASI OPTION === --}}
                            <div class="card mb-4 bg-[#FFF] border border-gray-200 p-6 rounded-lg">
                                <h4 class="font-semibold mb-4">Manajemen Stok dan Harga</h4>
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
    <div id="upload-config"
         data-upload-url="{{ route('upload-ajax') }}"
         data-csrf="{{ csrf_token() }}">
    </div>
    <script src="{{ asset('assets/js/model-script.js') }}"></script>
    <script>
        function triggerFileInput(button) {
            const fileInput = button.parentElement.querySelector('.image-upload-input');
            fileInput.click();
        }

        function uploadImage(input, tierIndex, optionIndex) {
            const file = input.files[0];
            if (!file) return;

            const formData = new FormData();
            formData.append('image', file);

            fetch('{{ route("upload-ajax") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: formData,
            })
            .then(res => res.json())
            .then(data => {
                const parent = input.closest('.option-item');
                parent.querySelector('.image-url-field').value = data.image_url;
                parent.querySelector('.image-id-field').value = data.image_id;
                parent.querySelector('.preview-image').src = data.image_url;
            })
            .catch(err => {
                console.error('Upload failed:', err);
                alert('Gagal mengunggah gambar.');
            });
        }
    </script>
    {{-- <script>
            const container = document.getElementById('model-data-container');
    const existingModels = JSON.parse(container.dataset.models || '[]');

    function uploadImageToShopee(input, tierIndex, optionIndex) {
    const file = input.files[0];
    if (!file) return;

    const config = document.getElementById('upload-config');
    const uploadUrl = config.dataset.uploadUrl;
    const csrfToken = config.dataset.csrf;

    const formData = new FormData();
    formData.append('image', file);

    fetch(uploadUrl, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
        },
        body: formData,
    })
    .then(res => res.json())
    .then(data => {
        const parent = input.closest('.option-item');
        parent.querySelector('.image-url-field').value = data.image_url;
        parent.querySelector('.image-id-field').value = data.image_id;
        const preview = parent.querySelector('.preview-image');
        if (preview) {
            preview.src = data.image_url;
            preview.style.display = 'block';
        }
    })
    .catch(err => {
        console.error('Upload gagal:', err);
        alert('Gagal mengunggah gambar.');
    });
}


    function addWarna(index) {
        const container = document.getElementById(`tier-${index}-options`);
        const count = container.querySelectorAll('.option-item').length;

        const html = `
            <div class="mb-3 option-item">
                <div class="flex flex-col gap-y-2">
                    <div class="flex-fill">
                        <input type="text" name="tier_variation[${index}][option_list][${count}][option]"
                            class="w-full border border-gray-200 rounded-lg warna-input" placeholder="Warna baru..." required
                            oninput="handleInputChange()">

                        <!-- Preview image -->
                        <img src="" class="preview-image mt-2 rounded w-full" style="display: none;" alt="Preview"/>

                        <!-- Input file -->
                        <input type="file" accept="image/*"
                            class="form-control w-full mt-1 image-upload-input"
                            onchange="uploadImageToShopee(this, ${index}, ${count})">

                        <!-- Hidden input untuk menyimpan hasil upload -->
                        <input type="hidden" name="tier_variation[${index}][option_list][${count}][image_url]" class="image-url-field">
                        <input type="hidden" name="tier_variation[${index}][option_list][${count}][image_id]" class="image-id-field">
                    </div>

                    <!-- Tombol hapus -->
                    <button type="button" class="bg-red-200 p-1 rounded-lg mt-1" onclick="removeOption(this)">
                        Hapus
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
            <div class="mb-3 w-full option-item">
                <div>
                    <div class="flex flex-col gap-y-2">
                        <input type="text" name="tier_variation[${index}][option_list][${count}][option]"
                            class="ukuran-input w-full border-2 border-gray-200 rounded-lg" placeholder="Ukuran baru..." required
                            oninput="handleInputChange()">
                        <button type="button" class="bg-red-200 p-2 rounded-lg" onclick="removeOption(this)">
                            Hapus
                        </button>
                    </div>
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

    function generateCombinations() {
        const warnaList = getOptions(0);
        const ukuranList = getOptions(1);
        const container = document.getElementById('model-combinations');
        container.innerHTML = '';

        warnaList.forEach((warna, warnaIndex) => {
            const warnaWrapper = document.createElement('div');
            warnaWrapper.className = 'mb-4';

            const heading = document.createElement('div');
            heading.className = 'font-medium mb-3 px-4 py-2 border border-gray-200 rounded-full';
            heading.textContent = `Warna: ${warna}`;
            warnaWrapper.appendChild(heading);

            const grid = document.createElement('div');
            grid.className = 'grid grid-cols-10 gap-2';

            ukuranList.forEach((ukuran, ukuranIndex) => {
                const key = `${warnaIndex}_${ukuranIndex}`;
                const model = findModel(warnaIndex, ukuranIndex);
                const price = model?.price_info?.[0]?.current_price ?? '';
                const stock = model?.stock_info_v2?.seller_stock?.[0]?.stock ?? '';
                const modelId = model?.model_id ?? '';
                const isNew = !model;

                const card = document.createElement('div');
                card.className = 'border border-gray-200 rounded-lg p-2';

                card.innerHTML = `
                    <div class="mb-2 text-sm font-medium">Ukuran: ${ukuran}</div>

                    <input type="hidden" name="combinations[${key}][model_id]" value="${modelId}">
                    <input type="hidden" name="combinations[${key}][warna]" value="${warna}">
                    <input type="hidden" name="combinations[${key}][ukuran]" value="${ukuran}">
                    <input type="hidden" name="combinations[${key}][tier_index][]" value="${warnaIndex}">
                    <input type="hidden" name="combinations[${key}][tier_index][]" value="${ukuranIndex}">

                    ${isNew ? `
                    <label class="block text-sm mb-1">Harga:
                        <input type="number" step="0.01" class="w-full border px-2 py-1 rounded"
                            name="combinations[${key}][price]" required>
                    </label>` : `
                    <!-- Harga disimpan jika model lama, tapi tidak ditampilkan -->
                    <input type="hidden" name="combinations[${key}][price]" value="${price}">
                    `}

                    <label class="block text-sm mt-2">Stok:
                        <input type="number" class="w-full border px-2 py-1 rounded"
                            name="combinations[${key}][stock]" value="${stock}" required>
                    </label>
                `;

                grid.appendChild(card);
            });

            warnaWrapper.appendChild(grid);
            container.appendChild(warnaWrapper);
        });
    }


    function findModel(warnaIndex, ukuranIndex) {
        return existingModels.find(model =>
            model.tier_index[0] === warnaIndex &&
            model.tier_index[1] === ukuranIndex
        );
    }

    // function generateCombinations() {
    //     const warnaList = getOptions(0);
    //     const ukuranList = getOptions(1);
    //     const container = document.getElementById('model-combinations');
    //     container.innerHTML = '';

    //     warnaList.forEach((warna, warnaIndex) => {
    //         const warnaTable = document.createElement('div');
    //         warnaTable.innerHTML = `
    //             <h2 class="font-medium">Warna ${warna}</h2>
    //             <table class="w-full border border-separate border-gray-300 my-4">
    //                 <thead>
    //                     <tr>
    //                         <th class="border border-gray-300 px-4 py-2">Ukuran</th>
    //                         <th class="border border-gray-300 px-4 py-2">Harga</th>
    //                         <th class="border border-gray-300 px-4 py-2">Stok</th>
    //                     </tr>
    //                 </thead>
    //                 <tbody id="tbody-${warnaIndex}"></tbody>
    //             </table>
    //         `;

    //         const tbody = warnaTable.querySelector(`#tbody-${warnaIndex}`);

    //         ukuranList.forEach((ukuran, ukuranIndex) => {
    //             const key = `${warnaIndex}_${ukuranIndex}`;
    //             const model = findModel(warnaIndex, ukuranIndex);
    //             const price = model?.price_info?.[0]?.current_price ?? '';
    //             const stock = model?.stock_info_v2?.seller_stock?.[0]?.stock ?? '';
    //             const modelId = model?.model_id ?? '';

    //             const row = document.createElement('tr');
    //             row.innerHTML = `
    //                 <td class="border border-gray-300 text-center">
    //                     ${ukuran}
    //                     <input type="hidden" name="combinations[${key}][model_id]" value="${modelId}">
    //                     <input type="hidden" name="combinations[${key}][warna]" value="${warna}">
    //                     <input type="hidden" name="combinations[${key}][ukuran]" value="${ukuran}">
    //                     <input type="hidden" name="combinations[${key}][tier_index][]" value="${warnaIndex}">
    //                     <input type="hidden" name="combinations[${key}][tier_index][]" value="${ukuranIndex}">
    //                 </td>
    //                 <td class="border border-gray-300">
    //                     <input type="number" step="0.01" class="w-full border-none outline-none focus:outline-none focus:border-none ring-0 focus:ring-0"
    //                         name="combinations[${key}][price]" value="${price}" required>
    //                 </td>
    //                 <td class="border border-gray-300">
    //                     <input type="number" class="w-full border-none outline-none focus:outline-none focus:border-none ring-0 focus:ring-0"
    //                         name="combinations[${key}][stock]" value="${stock}" required>
    //                 </td>
    //             `;
    //             tbody.appendChild(row);
    //         });

    //         container.appendChild(warnaTable);
    //     });
    // }

    generateCombinations();

    function handleInputChange() {
        generateCombinations();
    }

    window.addEventListener('DOMContentLoaded', () => {
        generateCombinations();
    });


    </script> --}}

</body>
</html>
