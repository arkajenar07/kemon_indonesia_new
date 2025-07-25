<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Muhanz\Shoapi\Facades\Shoapi;
use App\Services\ShopeeTokenManager;
class ProductController extends Controller
{
    public function index()
    {
        $shopId = 766550807; // ganti dengan shop_id kamu

        $accessToken = ShopeeTokenManager::getValidAccessToken($shopId);

        if (!$accessToken) {
            return response()->json(['error' => 'Token tidak ditemukan atau belum di-authorize'], 401);
        }

        $params =  [
            'offset'       => 0,
            'page_size'    => 10,
            'item_status' => ['NORMAL']
        ];

        $response = Shoapi::call('product')
    		        ->access('get_item_list', $accessToken)
    		        ->shop($shopId)
                    ->request($params)
    		        ->response();

        $responseArray = json_decode(json_encode($response), true);

        if ($responseArray['total_count'] > 0) {
            $items = $responseArray['item'];

            $allData = [];

            foreach ($items as $item) {
                $item_id  = $item['item_id'];

                $baseInfoParams =  [
                    'item_id_list' => [$item_id]
                ];

                $responseBase = Shoapi::call('product')
                            ->access('get_item_base_info', $accessToken)
                            ->shop($shopId)
                            ->request($baseInfoParams)
                            ->response();

                $responseArrayBase = json_decode(json_encode(value: $responseBase), true);
                $baseInfo = $responseArrayBase['item_list'][0];

                $modelListParams =  [
                    'item_id' => $item_id
                ];

                $responseModel = Shoapi::call('product')
                            ->access('get_model_list', $accessToken)
                            ->shop($shopId)
                            ->request($modelListParams)
                            ->response();

                $responseArrayModel = json_decode(json_encode(value: $responseModel), true);
                $modelList = $responseArrayModel['model'];

                $prices = [];
                $totalStock = 0;

                foreach ($modelList as $model) {
                    $price = $model['price_info'][0]['current_price'] ?? 0;
                    $stock = $model['stock_info_v2']['summary_info']['total_available_stock'] ?? 0;

                    $prices[] = $price;
                    $totalStock += $stock;
                }

                $minPrice = !empty($prices) ? min($prices) : 0;
                $maxPrice = !empty($prices) ? max($prices) : 0;

                $allData[] = [
                    'item_id'    => $baseInfo['item_id'],
                    'name'       => $baseInfo['item_name'] ?? '',
                    'image'      => $baseInfo['image'] ?? '',
                    'min_price'  => $minPrice,
                    'max_price'  => $maxPrice,
                    'total_stock'=> $totalStock,
                ];
            }

            // dd($allData);
            return view('dashboard', compact('allData'));

        }else{
            return view('dashboard');
        }
    }

    public function show($item_id)
    {
        $shopId = 766550807; // ganti dengan shop_id kamu

        $accessToken = ShopeeTokenManager::getValidAccessToken($shopId);

        if (!$accessToken) {
            return response()->json(['error' => 'Token tidak ditemukan atau belum di-authorize'], 401);
        }

        $paramBaseInfo =  [
            'item_id_list' => [$item_id]
        ];

        $responseInfo = Shoapi::call('product')
    		        ->access('get_item_base_info', $accessToken)
    		        ->shop($shopId)
                    ->request($paramBaseInfo)
    		        ->response();

        $responseInfoArray = json_decode(json_encode($responseInfo), true);
        $baseInfo = $responseInfoArray['item_list'][0];

        // dd($responseInfoArray);

        $paramModel =  [
            'item_id' => $item_id
        ];

        $responseModel = Shoapi::call('product')
    		        ->access('get_model_list', $accessToken)
    		        ->shop($shopId)
                    ->request($paramModel)
    		        ->response();

        $responseModelArray = json_decode(json_encode($responseModel), true);
        $modelInfo = $responseModelArray;

        $groupedModels = [];

        foreach ($modelInfo['model'] as $model) {
            $modelNameParts = explode(',', $model['model_name']);
            $warna = $modelNameParts[0] ?? null;
            $ukuran = $modelNameParts[1] ?? null;
            if ($warna && $ukuran) {
                $groupedModels[$warna][] = $ukuran;
            }
        }
        foreach ($groupedModels as $warna => $ukuranList) {
            $groupedModels[$warna] = array_unique($ukuranList);
        }

        $item = [
            'base_info'      => $baseInfo,
            'model_data'     => [
                'tier_variation' => $modelInfo['tier_variation'] ?? [],
                'model'          => $modelInfo['model'] ?? [],
            ],
            'grouped_models' => $groupedModels,
        ];

        // dd($item);

        return view('product.index', compact('item_id', 'item'));

    }
    public function edit_base($item_id)
    {
        $shopId = 766550807; // ganti dengan shop_id kamu

        $accessToken = ShopeeTokenManager::getValidAccessToken($shopId);

        if (!$accessToken) {
            return response()->json(['error' => 'Token tidak ditemukan atau belum di-authorize'], 401);
        }

        $params =  [
            'item_id_list' => [$item_id]
        ];

        $response = Shoapi::call('product')
    		        ->access('get_item_base_info', $accessToken)
    		        ->shop($shopId)
                    ->request($params)
    		        ->response();

        $responseArray = json_decode(json_encode($response), true);
        $item = $responseArray['item_list'][0];
        // dd($item);

        return view('product.edit-base', compact('item'));
    }

    public function update_base(Request $request)
    {
        $shopId = 766550807; // ganti dengan shop_id kamu

        $accessToken = ShopeeTokenManager::getValidAccessToken($shopId);

        if (!$accessToken) {
            return response()->json(['error' => 'Token tidak ditemukan atau belum di-authorize'], 401);
        }

        $validated = $request->validate([
            'item_id' => 'required|numeric',
            'item_name' => 'required|string|max:255',
            'item_sku' => 'required|string|max:255',
            'description_text' => 'required|string',
        ]);

        $params = [
            'item_id' => (int) $validated['item_id'],
            'item_name' => $validated['item_name'],
            'item_sku' => $validated['item_sku'],
            'description_info' => [
                'extended_description' => [
                    'field_list' => [
                        [
                            'field_type' => 'text',
                            'text' => $validated['description_text'],
                        ]
                    ]
                ]
            ],
            'description_type' => 'extended'
        ];

        $response = Shoapi::call('product')
                    ->access('update_item', $accessToken)
                    ->shop($shopId)
                    ->request($params)
                    ->response();

        $responseArray = json_decode(json_encode($response), true);

        if (isset($responseArray['error'])) {
            return redirect()->route('product.editbase', parameters: $params['item_id'])->with('error', 'Update gagal: ' . $responseArray['message']);
        }

        return redirect()->route('product.editbase', parameters: $params['item_id'])->with('success', 'Item berhasil diupdate!');
    }

    public function edit_tier($item_id)
    {
        $shopId = 766550807; // ganti dengan shop_id kamu

        $accessToken = ShopeeTokenManager::getValidAccessToken($shopId);

        if (!$accessToken) {
            return response()->json(['error' => 'Token tidak ditemukan atau belum di-authorize'], 401);
        }

        $params =  [
            'item_id' => $item_id
        ];

        $response = Shoapi::call('product')
    		        ->access('get_model_list', $accessToken)
    		        ->shop($shopId)
                    ->request($params)
    		        ->response();

        $responseArray = json_decode(json_encode($response), true);
        $variations = $responseArray;

        // dd($variations);

        // return view('product.edit-tier', compact('item_id', 'variations'));
    }

    public function update_tier(Request $request)
    {
        $shopId = 766550807; // ganti dengan shop_id kamu

        $accessToken = ShopeeTokenManager::getValidAccessToken($shopId);

        if (!$accessToken) {
            return response()->json(['error' => 'Token tidak ditemukan atau belum di-authorize'], 401);
        }

        $validated = $request->validate([
            'item_id' => 'required|numeric',
            'tier_variation' => 'required|array',
            'tier_variation.*.name' => 'required|string',
            'tier_variation.*.option_list' => 'required|array',
            'tier_variation.*.option_list.*.option' => 'required|string',
            'tier_variation.*.option_list.*.image_url' => 'nullable|url',
            'tier_variation.*.option_list.*.image_id' => 'nullable|string',
            'combinations' => 'nullable|array',
            'combinations.*.model_id' => 'nullable|string',
            'combinations.*.warna' => 'nullable|string',  // nullable, karena bisa model baru
            'combinations.*.ukuran' => 'nullable|string',  // nullable, karena bisa model baru
            'combinations.*.price' => 'required|numeric',
            'combinations.*.stock' => 'required|numeric',
            'combinations.*.tier_index' => 'nullable|array', // untuk model baru
        ]);

        // dd($validated['combinations']);

        // Siapkan parameter untuk update tier_variation
        $params = [
            'item_id' => (int) $validated['item_id'],
            'tier_variation' => [],
        ];

        foreach ($validated['tier_variation'] as $tier) {
            $option_list = [];
            foreach ($tier['option_list'] as $opt) {
                $entry = ['option' => $opt['option']];
                if (!empty($opt['image_url']) && !empty($opt['image_id'])) {
                    $entry['image'] = [
                        'image_id' => $opt['image_id'],
                        'image_url' => $opt['image_url'],
                    ];
                }
                $option_list[] = $entry;
            }

            $params['tier_variation'][] = [
                'name' => $tier['name'],
                'option_list' => $option_list,
            ];
        }

        // 1. Update Tier Variation
        $updateTierResponse = Shoapi::call('product')
            ->access('update_tier_variation', $accessToken)
            ->shop($shopId)
            ->request($params)
            ->response();

        // dd('update tier', $updateTierResponse);

        $priceList = [];
        $stockList = [];
        $newModels = [];

        if (!empty($validated['combinations'])) {
            foreach ($validated['combinations'] as $combo) {
                if (!empty($combo['model_id'])) {
                    // 2. Model sudah ada -> Update Harga dan Stok
                    $priceList[] = [
                        'model_id' => (int) $combo['model_id'],
                        'original_price' => (float) $combo['price'],
                    ];

                    $stockList[] = [
                        'model_id' => (int) $combo['model_id'],
                        'seller_stock' => [
                           [
                            // 'location_id' => 'IDZ', // ✅ Tambahkan ini
                            'stock' => (int) $combo['stock'],
                           ]
                        ],
                    ];
                } else {
                    // 3. Model belum ada -> Tambah Model Baru
                    if (!isset($combo['tier_index']) || count($combo['tier_index']) !== 2) {
                        continue; // skip jika tier_index tidak lengkap
                    }

                    $newModels[] = [
                        "tier_index" => array_map('intval', $combo['tier_index']),
                        "original_price" => (float) $combo['price'],
                        "seller_stock" => [
                            [
                                "location_id" => "IDZ",
                                "stock" => (int) $combo['stock'],
                            ]
                        ],
                        "model_sku" => $combo['warna']."-".$combo['ukuran'],
                    ];
                }
            }

            // dd($stockList);
            // 4. Update Harga
            if (!empty($priceList)) {
                $updatePriceResponse = Shoapi::call('product')
                ->access('update_price', $accessToken)
                ->shop($shopId)
                ->request([
                    'item_id' => (int) $validated['item_id'],
                    'price_list' => $priceList,
                    ])
                    ->response();
                }


                // 5. Update Stok
            if (!empty($stockList)) {
                $updateStockResponse = Shoapi::call('product')
                ->access('update_stock', $accessToken)
                ->shop($shopId)
                ->request([
                    'item_id' => (int) $validated['item_id'],
                    'stock_list' => $stockList,
                    ])
                    ->response();
                }

            // dd($updatePriceResponse);

            // 6. Tambahkan Model Baru (Jika Ada)
            if (!empty($newModels)) {
                $addModelResponse = Shoapi::call('product')
                    ->access('add_model', $accessToken)
                    ->shop($shopId)
                    ->request([
                        'item_id' => (int) $validated['item_id'],
                        'model_list' => $newModels,
                    ])
                    ->response();

                $addModelResponse = json_decode(json_encode($addModelResponse), true);

                if ($addModelResponse['api_status'] != "error") {
                    dd($addModelResponse);
                    return back()->with('error', 'Gagal menambahkan model baru: ' . ($addModelResponse['message'] ?? 'Unknown error'));
                }
            }
        }

        return redirect()->route('product.info', parameters: $validated['item_id']);
    }

    public function delete($item_id)
    {
        $shopId = 766550807; // ganti dengan shop_id kamu

        $accessToken = ShopeeTokenManager::getValidAccessToken($shopId);

        if (!$accessToken) {
            return response()->json(['error' => 'Token tidak ditemukan atau belum di-authorize'], 401);
        }
        $deleteItem = Shoapi::call('product')
            ->access('delete_item', $accessToken)
            ->shop($shopId)
            ->request([
                'item_id' => (int) $item_id
            ])
            ->response();

        // dd($deleteItem);

        return redirect()->route('dashboard');
    }

    public function add()
    {
        $shopId = 766550807; // ganti dengan shop_id kamu

        $accessToken = ShopeeTokenManager::getValidAccessToken($shopId);

        if (!$accessToken) {
            return response()->json(['error' => 'Token tidak ditemukan atau belum di-authorize'], 401);
        }

        $responseCategory = Shoapi::call('product')
                    ->access('get_category', $accessToken)
                    ->shop($shopId)
                    ->request([
                        'language' => 'id',
                    ])
                    ->response();

        $responseCategory = json_decode(json_encode($responseCategory), true);

        $categories = $responseCategory['category_list'] ?? [];

        $categories = $responseCategory['category_list'] ?? [];

        $categories = array_filter($categories, function ($category) {
            $name = strtolower($category['display_category_name']);
            $firstWord = explode(' ', $name)[0];
            return in_array($firstWord, ['sepatu', 'sandal']);
        });

        return view('product.add', compact('categories'));
    }

    public function store_item(Request $request){
        $shopId = 766550807; // ganti dengan shop_id kamu

        $accessToken = ShopeeTokenManager::getValidAccessToken($shopId);

        if (!$accessToken) {
            return response()->json(['error' => 'Token tidak ditemukan atau belum di-authorize'], 401);
        }

        $validated = $request->validate([
            'item_name' => 'required|string',
            'description' => 'required|string',
            'item_sku' => 'required|string',
            'category_id' => 'required|numeric',
            'weight' => 'required|numeric',
            'package_length' => 'required|numeric',
            'package_width' => 'required|numeric',
            'package_height' => 'required|numeric',
            'logistic_id' => 'required|numeric',
            'condition' => 'required|string',
            'item_status' => 'required|string',
            'image' => 'nullable|array',
            'image.image_id_list' => 'nullable|array',
            'image.image_url_list' => 'nullable|array',
        ]);

        // Simulasi input
        $data = [
            "category_id" => $validated['category_id'],
            "item_name" => $validated['item_name'],
            "description" => $validated['description'],
            "item_sku" => $validated['item_sku'],
            "image" => [
                $validated['image'][0],
                "image_ratio" => "1:1",
            ],
            "original_price" => 7000,
            "weight" => $validated['weight'],
            "dimension" => [
                "package_length" => $validated['package_length'],
                "package_width" => $validated['package_length'],
                "package_height" => $validated['package_length'],
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

        dd($data);

        $addResponse = Shoapi::call('product')
                    ->access('add_item', $accessToken)
                    ->shop($shopId)
                    ->request(
                        $data
                    )
                    ->response();

        $addResponseArray = json_decode(json_encode($addResponse), true);


        $tier = [
            "item_id" => $addResponseArray['item_id'],
            "tier_variation" => [
                [
                    "name" => "Warna",
                    "option_list" => [
                        [
                            "option" => "Default",
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
                            "option" => "32",
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

        dd($validated);
    }


    // public function get_model_list()
    // {
    //     $params =  [
    //         'item_id' => 1910008
    //     ];

    //     $response = Shoapi::call('product')
    // 		        ->access('get_model_list', $accessToken)
    // 		        ->shop($shopId)
    //                 ->request($params)
    // 		        ->response();

    //     dd($response);
    // }

    // public function get_base_info()
    // {
    //     $params =  [
    //         'item_id_list' => [1910008]
    //     ];

    //     $response = Shoapi::call('product')
    // 		        ->access('get_item_base_info', $accessToken)
    // 		        ->shop($shopId)
    //                 ->request($params)
    // 		        ->response();

    //     dd($response);
    // }
}
