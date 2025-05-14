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
    		        ->access('add_model', '527a5676497247774b53656f7774594b')
    		        ->shop(140997)
                    ->request($params)
    		        ->response();

        dd($response);
    }
}
