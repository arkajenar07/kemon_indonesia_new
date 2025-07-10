<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tambah Produk</title>
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
        <div class="max-w-[85%] mx-auto">
            <div class="flex items-center justify-start gap-x-6 mb-4">
                <a href="{{ route('dashboard') }}">
                    <div class="bg-[#3A2D28] text-white px-4 py-2 rounded-md">
                        Back
                    </div>
                </a>
            </div>
            <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="flex flex-col">
              <div class="flex gap-x-4">
                <div class="w-1/4 p-4 bg-white border border-gray-200 rounded-lg">
                    <!-- 5. Gambar Produk -->
                    <h3>Gambar Produk</h3>
                    <div id="multi-image-upload"
                         data-upload-url="{{ route('upload-ajax') }}"
                         data-csrf="{{ csrf_token() }}"
                         class="space-y-2">

                        <!-- Input file utama (triggered oleh tombol) -->
                        <input id="multi-image-input" type="file" accept="image/*" multiple class="hidden" onchange="handleMultipleUpload(this)">

                        <!-- Preview dan hidden inputs akan muncul di sini -->
                        <div id="multi-image-preview" class="grid grid-cols-2"></div>

                        <!-- Tombol trigger upload -->
                        <button type="button" onclick="document.getElementById('multi-image-input').click()"
                                class="w-full border-2 border-[#3A2D28] rounded-lg flex items-center justify-center py-2 gap-x-2">
                            <img src="{{ asset('assets/icons/add-product-main.svg') }}" class="w-8 h-8" alt="">
                            Add Image
                        </button>
                    </div>
                </div>
                <div class="w-3/4 bg-white border border-gray-200 rounded-lg p-4 flex flex-col gap-y-2">
                    <div class="flex flex-col gap-y-1">
                        <h3 class="font-semibold">Kategori Produk</h3>
                        <select id="category-select" name="category_id" required class="w-full rounded-md border border-gray-300 p-2">
                          @foreach ($categories as $category)
                            <option value="{{ $category['category_id'] }}">{{ $category['display_category_name'] }}</option>
                          @endforeach
                        </select>
                    </div>
                    <div class="flex flex-col gap-y-1">
                        <h3 class="font-semibold">Nama Produk</h3>
                        <input class="w-full rounded-md border border-gray-300 p-2" type="text" name="item_name" required placeholder="Contoh: Gantungan Kunci Unik">
                    </div>
                    <div class="flex flex-col gap-y-1">
                        <h3 class="font-semibold">Deskripsi</h3>
                        <textarea class="w-full rounded-md border border-gray-300 p-2" name="description" required placeholder="Deskripsi lengkap produk..."></textarea>
                    </div>
                    <div class="flex flex-col gap-y-1">
                        <h3 class="font-semibold">SKU (Opsional)</h3>
                        <input class="w-full rounded-md border border-gray-300 p-2" type="text" name="item_sku" placeholder="SKU jika ada">
                    </div>
                </div>
              </div>

              <div class="flex w-full mt-4 gap-x-4">
                <div class="flex flex-col gap-y-2 bg-white border border-gray-200 p-4 rounded-lg">
                  <div class="flex flex-col gap-y-1">
                    <!-- 7. Berat Produk (Kg) -->
                    <h3 class="font-semibold">Berat Produk (Kg)</h3>
                    <input class="w-full rounded-md border border-gray-300 p-2" type="number" name="weight" step="0.01" required placeholder="Contoh: 0.2">
                  </div>

                  <div class="flex flex-col gap-y-1">
                    <!-- 8. Dimensi Produk -->
                    <h3 class="font-semibold">Dimensi (cm)</h3>
                    <div class="flex gap-x-2">
                      <input class="w-full rounded-md border border-gray-300 p-2" type="number" name="package_length" placeholder="Panjang" required>
                      <input class="w-full rounded-md border border-gray-300 p-2" type="number" name="package_width" placeholder="Lebar" required>
                      <input class="w-full rounded-md border border-gray-300 p-2" type="number" name="package_height" placeholder="Tinggi" required>
                    </div>
                  </div>
                  <div class="flex flex-col gap-y-1">
                    <h3 class="font-semibold">Jasa Kurir</h3>
                    <select class="w-full rounded-md border border-gray-300 p-2" name="logistic_id" required>
                      <option value="8003">Pengiriman Reguler</option>
                      <option value="8002">Hemat Kargo</option>
                      <option value="8003">Same Day</option>
                      <!-- Tambah kurir lain -->
                    </select>
                  </div>
                </div>

                <div class="flex flex-col flex-grow bg-white border border-gray-200 p-4 rounded-lg">
                  <div>
                    <!-- 10. Pre-Order -->
                    <h3 class="font-semibold">
                      <input type="checkbox" name="is_pre_order">
                      Pre-Order?
                    </h3>
                    <input type="number" name="days_to_ship" value="2" placeholder="Hari Kirim">
                  </div>

                  <div>
                    <!-- 11. Kondisi -->
                    <h3 class="font-semibold">Kondisi Barang</h3>
                    <select name="condition">
                      <option value="NEW" selected>Baru</option>
                      <option value="USED">Bekas</option>
                    </select>
                  </div>

                  <div>
                    <!-- 13. Status Barang -->
                    <h3 class="font-semibold">Status Produk</h3>
                    <select name="item_status">
                      <option value="NORMAL">Aktif</option>
                      <option value="UNLIST">Tidak Tampil</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>

            <!-- Submit -->
            <br>
            <button class="w-full bg-green-50 text-green-600 border border-green-600 rounded-xl font-medium flex item-center justify-center p-4" type="submit">Simpan Produk</button>
        </form>
        </div>
    </main>
    <script>
        function handleMultipleUpload(input) {
            const files = input.files;
            if (!files.length) return;

            const container = document.getElementById('multi-image-upload');
            const previewArea = document.getElementById('multi-image-preview');
            const uploadUrl = container.dataset.uploadUrl;
            const csrfToken = container.dataset.csrf;

            Array.from(files).forEach(file => {
                const formData = new FormData();
                formData.append('image', file);

                fetch(uploadUrl, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    // Buat preview + hidden input wrapper
                    const wrapper = document.createElement('div');
                    wrapper.classList.add('relative', 'w-32');

                    // Preview
                    const img = document.createElement('img');
                    img.src = data.image_url;
                    img.className = 'w-full rounded border border-gray-200';

                    // Hidden Inputs
                    const inputId = document.createElement('input');
                    inputId.type = 'hidden';
                    inputId.name = 'image[image_id_list][]';
                    inputId.value = data.image_id;

                    const inputUrl = document.createElement('input');
                    inputUrl.type = 'hidden';
                    inputUrl.name = 'image[image_url_list][]';
                    inputUrl.value = data.image_url;

                    // Optional tombol hapus (jika mau)
                    const removeBtn = document.createElement('button');
                    removeBtn.type = 'button';
                    removeBtn.innerText = '×';
                    removeBtn.className = 'absolute top-0 right-0 bg-red-500 text-white w-6 h-6 flex items-center justify-center rounded-full';
                    removeBtn.onclick = () => wrapper.remove();

                    // Gabungkan semuanya
                    wrapper.appendChild(img);
                    wrapper.appendChild(inputId);
                    wrapper.appendChild(inputUrl);
                    wrapper.appendChild(removeBtn);

                    previewArea.appendChild(wrapper);
                })
                .catch(err => {
                    console.error('Upload error:', err);
                    alert('Gagal upload gambar.');
                });
            });
        }

    </script>
</body>
</html>
