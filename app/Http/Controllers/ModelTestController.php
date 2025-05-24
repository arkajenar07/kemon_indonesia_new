<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Muhanz\Shoapi\Facades\Shoapi;

class ModelTestController extends Controller
{
    public function store_model(Request $request){
        $validated = $request->validate([
            'price' => 'required|numeric',
        ]);

        $params =  [
            'item_id' => 1910008,
            'model_list' => [
                [
                "tier_index" => [0,3],
                "original_price" => (float) $validated['price'],
                "seller_stock" => [
                    [
                      "location_id" => "IDZ",
                      "stock" => 10,
                    ]
                ],
                "model_sku" => "",
                ]
            ],
        ];

        $response = Shoapi::call('product')
    		        ->access('add_model', '78686941466a4f567774684b4c6f774c')
    		        ->shop(140997)
                    ->request($params)
    		        ->response();

        dd($response);
    }

    public function upload(Request $request)
    {
        // Validasi file image
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Simpan file ke storage/app/public/uploads
        $path = $request->file('image')->store('uploads', 'public');

        // Ambil path absolut
        $fullPath = storage_path('app/public/' . $path);

        // Kirim ke Shopee API via Shoapi wrapper
        $params = [
            'image' => $fullPath, // <- Path langsung ditaruh di sini
        ];

        $response = Shoapi::call('media_space')
                    ->access('upload_image', '78686941466a4f567774684b4c6f774c')
                    ->shop(140997)
                    ->request($params)
                    ->response();

        return dd($response);
    }
}
