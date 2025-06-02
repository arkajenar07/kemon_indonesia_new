<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Prouduct | Edit</title>
    <link rel="icon" href="{{ asset('assets/icons/shoe-head.svg') }}" type="image/x-icon" />
    <link rel="stylesheet" href="/assets/css/style.css">
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <header class="flex justify-between items-center p-6 fixed w-full bg-white top-0">
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
        <div class="w-3/5 bg-[#FFF] mt-16 shadow-xl mx-auto rounded-b-[30px]">
            <div>
                <div class="flex bg-[#B17457] p-[18px] rounded-t-[30px] items-center gap-x-[12px]">
                    <img src="{{ asset('/assets/icons/user-white.svg') }}" alt="" class="w-[42px] h-[42px]">
                    <h1 class="text-[28px] text-[#FFF] font-semibold">Informasi Produk</h1>
                </div>
                <div class="px-6 pb-6">
                    {{-- Tampilkan pesan sukses atau error --}}
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @elseif(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    {{-- Form Update --}}
                    <form action="{{ route('product.updatebase') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <input type="hidden" class="form-control @error('item_id') is-invalid @enderror" name="item_id" id="item_id" value="{{ $item['item_id'] }}" required>
                            @error('item_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mt-3 flex flex-col">
                            <label class="text-[18px] font-semibold" for="item_name">Item Name</label>
                            <input type="text" class="form-control @error('item_name') is-invalid @enderror h-[64px] mt-4 rounded-lg border-2" name="item_name" id="item_name" value="{{ $item['item_name'] }}" required>
                            @error('item_name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group mt-3 flex flex-col">
                            <label class="text-[18px] font-semibold" for="item_sku">Item SKU</label>
                            <input type="text" class="form-control @error('item_sku') is-invalid @enderror h-[64px] mt-4 rounded-lg border-2" name="item_sku" id="item_sku" value="{{ $item['item_sku'] }}" required>
                            @error('item_sku')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mt-3 flex flex-col">
                            <label class="text-[18px] font-semibold" for="description_text">Description</label>
                            <!-- Textarea untuk CKEditor -->
                            <textarea class="form-control @error('description_text') is-invalid @enderror mt-4 rounded-lg border-2"
                                      name="description_text"
                                      id="description_text"
                                      required>{{ $item['description_info']['extended_description']['field_list'][0]['text'] }}</textarea>

                            @error('description_text')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="flex gap-x-4">
                            <button type="submit" class="mt-8 w-full bg-gray-800 text-white p-[18px] text-[21px] font-semibold rounded-bl-[24px] rounded-tr-[24px]">
                                <a href="{{ route('product.info', parameters: $item['item_id']) }}">Kembali</a>
                            </button>
                            <button type="submit" class="mt-8 w-full bg-gray-800 text-white p-[18px] text-[21px] font-semibold rounded-bl-[24px] rounded-tr-[24px]">Update Item</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <script>
    ClassicEditor
        .create(document.querySelector('#description_text'))
        .catch(error => {
            console.error(error);
        });
</script>
</body>
</html>

