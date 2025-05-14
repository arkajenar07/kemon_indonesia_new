<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Muhanz\Shoapi\Facades\Shoapi;

class ShopController extends Controller
{
    public function get_shop_info()
    {

    	// path api: /api/v2/shop(use in call)/get_shop_info(use in access)

      $response = Shoapi::call('shop')
    		    ->access('get_shop_info', '58504f6f587577566b62427a7a70624f')
    		    ->shop(140997)
    		    ->response();
    }
}
