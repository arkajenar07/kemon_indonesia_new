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
    		        ->access('add_model', '58597441507872566d4e516453664850')
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
                    ->access('upload_image', access_token: '58597441507872566d4e516453664850')
                    ->shop(140997)
                    ->request($params)
                    ->response();

        return dd($response);
    }

    public function testUpdateStockDummy(Request $request)
{
    // Simulasi input
    $dummyInput = [
        'item_id' => 1910008,
        'stock_list' => [
            [
                'model_id' => 10009629510,
                'seller_stock' => [
                    [
                        // 'location_id' => 'IDZ',
                        'stock' => 45,
                    ]
                ]
            ],
        ]
    ];

    $dummyResponse = Shoapi::call('product')
                ->access('update_stock', '58597441507872566d4e516453664850')
                ->shop(140997)
                ->request(
                    $dummyInput
                )
                ->response();

    return response()->json($dummyResponse);
}

}
