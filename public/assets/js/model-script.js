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

    // function generateCombinations() {
    //     const warnaList = getOptions(0);
    //     const ukuranList = getOptions(1);
    //     const container = document.getElementById('model-combinations');
    //     container.innerHTML = '';

    //     warnaList.forEach((warna, warnaIndex) => {
    //         const warnaWrapper = document.createElement('div');
    //         warnaWrapper.className = 'mb-4';

    //         const heading = document.createElement('div');
    //         heading.className = 'font-medium mb-3 px-4 py-2 border-2 border-gray-300 rounded-full';
    //         heading.textContent = `Warna: ${warna}`;
    //         warnaWrapper.appendChild(heading);

    //         const grid = document.createElement('div');
    //         grid.className = 'grid grid-cols-8 gap-2';

    //         ukuranList.forEach((ukuran, ukuranIndex) => {
    //             const key = `${warnaIndex}_${ukuranIndex}`;
    //             const model = findModel(warnaIndex, ukuranIndex);
    //             const price = model?.price_info?.[0]?.current_price ?? '';
    //             const stock = model?.stock_info_v2?.seller_stock?.[0]?.stock ?? '';
    //             const modelId = model?.model_id ?? '';
    //             const isNew = !model;

    //             const card = document.createElement('div');
    //             card.className = 'border border-gray-200 rounded-lg p-2';

    //             card.innerHTML = `
    //                 <div class="mb-2 text-sm font-medium">Ukuran: ${ukuran}</div>

    //                 <input type="hidden" name="combinations[${key}][model_id]" value="${modelId}">
    //                 <input type="hidden" name="combinations[${key}][warna]" value="${warna}">
    //                 <input type="hidden" name="combinations[${key}][ukuran]" value="${ukuran}">
    //                 <input type="hidden" name="combinations[${key}][tier_index][]" value="${warnaIndex}">
    //                 <input type="hidden" name="combinations[${key}][tier_index][]" value="${ukuranIndex}">

    //                 ${isNew ? `
    //                 <label class="block text-sm mb-1">Harga:
    //                     <input type="number" step="0.01" class="w-full border px-2 py-1 rounded"
    //                         name="combinations[${key}][price]" required>
    //                 </label>` : `
    //                 <!-- Harga disimpan jika model lama, tapi tidak ditampilkan -->
    //                 <input type="hidden" name="combinations[${key}][price]" value="${price}">
    //                 `}

    //                 <label class="block text-sm mt-2">Stok:
    //                     <input type="number" class="w-full border px-2 py-1 rounded"
    //                         name="combinations[${key}][stock]" value="${stock}" required>
    //                 </label>
    //             `;

    //             grid.appendChild(card);
    //         });

    //         warnaWrapper.appendChild(grid);
    //         container.appendChild(warnaWrapper);
    //     });
    // }


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
    container.innerHTML = ''; // kosongkan container

    warnaList.forEach((warna, warnaIndex) => {
        const warnaSection = document.createElement('div');
        warnaSection.className = 'my-4';
        warnaSection.innerHTML = `<h2 class="font-medium mb-2">Warna ${warna}</h2>`;

        const combinationGrid = document.createElement('div');
        combinationGrid.className = 'grid grid-cols-8 gap-4';

        ukuranList.forEach((ukuran, ukuranIndex) => {
            const key = `${warnaIndex}_${ukuranIndex}`;
            const model = findModel(warnaIndex, ukuranIndex);
            const price = model?.price_info?.[0]?.current_price ?? '';
            const stock = model?.stock_info_v2?.seller_stock?.[0]?.stock ?? '';
            const modelId = model?.model_id ?? '';

            const item = document.createElement('div');
            item.className = 'p-4 border border-gray-300 rounded shadow-sm bg-white';

            item.innerHTML = `
                <!-- Hidden Inputs -->
                <input type="hidden" name="combinations[${key}][model_id]" value="${modelId}">
                <input type="hidden" name="combinations[${key}][warna]" value="${warna}">
                <input type="hidden" name="combinations[${key}][ukuran]" value="${ukuran}">
                <input type="hidden" name="combinations[${key}][tier_index][]" value="${warnaIndex}">
                <input type="hidden" name="combinations[${key}][tier_index][]" value="${ukuranIndex}">

                <!-- Display -->
                <div class="font-semibold text-lg mb-2">Ukuran: ${ukuran}</div>

                <div class="mb-3">
                    <label class="block text-sm font-medium mb-1">Harga</label>
                    <input type="number" step="0.01" name="combinations[${key}][price]" value="${price}" required
                        class="w-full border-gray-300 rounded p-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Stok</label>
                    <input type="number" name="combinations[${key}][stock]" value="${stock}" required
                        class="w-full border-gray-300 rounded p-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>
            `;

            combinationGrid.appendChild(item);
        });

        warnaSection.appendChild(combinationGrid);
        container.appendChild(warnaSection);
    });
}


    generateCombinations();

    function handleInputChange() {
        generateCombinations();
    }

    window.addEventListener('DOMContentLoaded', () => {
        generateCombinations();
    });

