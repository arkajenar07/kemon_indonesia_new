<?php

namespace App\Http\Controllers;

use App\Services\ShopeeTokenManager;
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
        $shopId = 766550807; // ganti dengan shop_id kamu

        $accessToken = ShopeeTokenManager::getValidAccessToken($shopId);

        if (!$accessToken) {
            return response()->json(['error' => 'Token tidak ditemukan atau belum di-authorize'], 401);
        }

        // Simulasi input
        $data = [
            "category_id" => 101396,
            "item_name" => "Keychain Tested Sembilan",
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
                [
                    "logistic_id" => 8003,
                    "enabled" => true,
                ],
                [
                    "logistic_id" => 8002,
                    "enabled" => true,
                ]
            ],
            "pre_order" => [
                "is_pre_order" => false,
                "days_to_ship" => 2,
            ],
            "condition" => "NEW",
            "size_chart" => "",
            "item_status" => "NORMAL",
            "brand" => [
                "brand_id" => 0,
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
                    ->access('add_item', $accessToken)
                    ->shop($shopId)
                    ->request(
                        $data
                    )
                    ->response();

        $dummyResponseArray = json_decode(json_encode($dummyResponse), true);

        $tier = [
            "item_id" => $dummyResponseArray['item_id'],
            "tier_variation" => [
                [
                    "name" => "Warna",
                    "option_list" => [
                        [
                            "option" => "Main Blue",
                            "image" => [
                                "image_id" => "id-11134207-7rbkb-maph9k5wsdus18"
                            ]
                        ]
                    ]
                ],
                [
                    "name" => "Ukuran",
                    "option_list" => [
                        [
                            "option" => "100",
                        ]
                    ]
                ]
            ],
            "model" => [
                [
                    "tier_index" => [
                        0, 0
                    ],
                    "original_price" => 10000,
                    "model_sku" => "SKU-test",
                    "seller_stock" => [
                        [
                            "location_id" => "IDZ",
                            "stock" => 0
                        ]
                    ],
                ]
            ],
        ];

        $updateTierResponse = Shoapi::call('product')
            ->access('init_tier_variation', $accessToken)
            ->shop($shopId)
            ->request($tier)
            ->response();

        return response()->json($updateTierResponse);
    }

}
