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

    public function testAddDummy(Request $request)
    {
        // Simulasi input
        $data = [
            "category_id" => 101396,
            "item_name" => "Keychain Test",
            "description" => "ini adalah gantungan kunci",
            "item_sku" => "",
            "image" => [
                "image_id_list" => [
                    "id-11134207-7rbkb-maph9k5wsdus18",
                ],
                "image_url_list" => [
                    "https://cf.shopee.co.id/file/id-11134207-7rbkb-maph9k5wsdus18",
                ],
                "image_ratio" => "1:1",
            ],
            "original_price" => 7000,
            "weight" => 0.2,
            "dimension" => [
                "package_length" => 20,
                "package_width" => 20,
                "package_height" => 20,
            ],
            "logistic_info" => [
                // Isi sesuai kebutuhan, misalnya:
                [
                    // Contoh struktur:
                    "logistic_id" => 12345,
                    "enabled" => true,
                    "shipping_fee" => 10000,
                    "size_id" => null,
                    "is_free" => false,
                    "estimated_shipping_time" => "2-5",
                ]
            ],
            "pre_order" => [
                "is_pre_order" => false,
                "days_to_ship" => 2,
            ],
            "condition" => "NEW",
            "size_chart" => "",
            "item_status" => "NORMAL",
            "has_model" => true,
            "brand" => [
                "brand_id" => 0,
                "original_brand_name" => "NoBrand",
            ],
            "item_dangerous" => 0,
            "description_type" => "normal",
            "size_chart_id" => 0,
            "promotion_image" => [
                "image_id_list" => [
                    "id-11134207-7rbkb-maph9k5wsdus18",
                ],
                "image_url_list" => [
                    "https://cf.shopee.co.id/file/id-11134207-7rbkb-maph9k5wsdus18",
                ],
            ],
            "seller_stock" => [
                [
                    "location_id" => "IDZ",
                    "stock" => 10
                ]
            ]
        ];

        $dummyResponse = Shoapi::call('product')
                    ->access('add_item', '4f53436c7a5343464e66416277476a73')
                    ->shop(140997)
                    ->request(
                        $data
                    )
                    ->response();

        return response()->json($dummyResponse);
    }

}
