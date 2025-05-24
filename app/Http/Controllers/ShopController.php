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
    		    ->access('get_shop_info', '636362424d6d676c6d68474756504676')
    		    ->shop(140997)
    		    ->response();
    }
}
