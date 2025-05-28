<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Muhanz\Shoapi\Facades\Shoapi;
class ProductController extends Controller
{
    public function index()
    {
        $params =  [
            'offset'       => 0,
            'page_size'    => 10,
            'item_status' => ['NORMAL']
        ];

        $response = Shoapi::call('product')
    		        ->access('get_item_list', '58597441507872566d4e516453664850')
    		        ->shop(140997)
                    ->request($params)
    		        ->response();

        $responseArray = json_decode(json_encode($response), true);
        $items = $responseArray['item'];

        $allData = [];

        foreach ($items as $item) {
            $item_id  = $item['item_id'];

            $baseInfoParams =  [
                'item_id_list' => [$item_id]
            ];

            $responseBase = Shoapi::call('product')
                        ->access('get_item_base_info', '58597441507872566d4e516453664850')
                        ->shop(140997)
                        ->request($baseInfoParams)
                        ->response();

            $responseArrayBase = json_decode(json_encode(value: $responseBase), true);
            $baseInfo = $responseArrayBase['item_list'][0];

            $modelListParams =  [
                'item_id' => $item_id
            ];

            $responseModel = Shoapi::call('product')
                        ->access('get_model_list', '58597441507872566d4e516453664850')
                        ->shop(140997)
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
    }

    public function show($item_id)
    {
        $paramBaseInfo =  [
            'item_id_list' => [$item_id]
        ];

        $responseInfo = Shoapi::call('product')
    		        ->access('get_item_base_info', '58597441507872566d4e516453664850')
    		        ->shop(140997)
                    ->request($paramBaseInfo)
    		        ->response();

        $responseInfoArray = json_decode(json_encode($responseInfo), true);
        $baseInfo = $responseInfoArray['item_list'][0];

        // dd($responseInfoArray);

        $paramModel =  [
            'item_id' => $item_id
        ];

        $responseModel = Shoapi::call('product')
    		        ->access('get_model_list', '58597441507872566d4e516453664850')
    		        ->shop(140997)
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
        $params =  [
            'item_id_list' => [$item_id]
        ];

        $response = Shoapi::call('product')
    		        ->access('get_item_base_info', '58597441507872566d4e516453664850')
    		        ->shop(140997)
                    ->request($params)
    		        ->response();

        $responseArray = json_decode(json_encode($response), true);
        $item = $responseArray['item_list'][0];
        // dd($item);

        return view('product.edit-base', compact('item'));
    }

    public function update_base(Request $request)
    {
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
                    ->access('update_item', '58597441507872566d4e516453664850')
                    ->shop(140997)
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
        $params =  [
            'item_id' => $item_id
        ];

        $response = Shoapi::call('product')
    		        ->access('get_model_list', '58597441507872566d4e516453664850')
    		        ->shop(140997)
                    ->request($params)
    		        ->response();

        $responseArray = json_decode(json_encode($response), true);
        $variations = $responseArray;

        // dd($variations);

        // return view('product.edit-tier', compact('item_id', 'variations'));
    }

    public function update_tier(Request $request)
    {
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
            ->access('update_tier_variation', '58597441507872566d4e516453664850')
            ->shop(140997)
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
                ->access('update_price', '58597441507872566d4e516453664850')
                ->shop(140997)
                ->request([
                    'item_id' => (int) $validated['item_id'],
                    'price_list' => $priceList,
                    ])
                    ->response();
                }


                // 5. Update Stok
            if (!empty($stockList)) {
                $updateStockResponse = Shoapi::call('product')
                ->access('update_stock', '58597441507872566d4e516453664850')
                ->shop(140997)
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
                    ->access('add_model', '58597441507872566d4e516453664850')
                    ->shop(140997)
                    ->request([
                        'item_id' => (int) $validated['item_id'],
                        'model_list' => $newModels,
                    ])
                    ->response();

                $addModelResponse = json_decode(json_encode($addModelResponse), true);

                if (($addModelResponse['error'] ?? 1) != 0) {
                    dd($addModelResponse);
                    // return back()->with('error', 'Gagal menambahkan model baru: ' . ($addModelResponse['message'] ?? 'Unknown error'));
                }
            }
        }

        return redirect()->route('product.info', parameters: $validated['item_id']);
    }


    public function add_tier()
    {

    }


    public function get_model_list()
    {
        $params =  [
            'item_id' => 1910008
        ];

        $response = Shoapi::call('product')
    		        ->access('get_model_list', '58597441507872566d4e516453664850')
    		        ->shop(140997)
                    ->request($params)
    		        ->response();

        dd($response);
    }

    public function get_base_info()
    {
        $params =  [
            'item_id_list' => [1910008]
        ];

        $response = Shoapi::call('product')
    		        ->access('get_item_base_info', '58597441507872566d4e516453664850')
    		        ->shop(140997)
                    ->request($params)
    		        ->response();

        dd($response);
    }
}
