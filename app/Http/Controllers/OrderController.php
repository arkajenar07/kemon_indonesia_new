<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Muhanz\Shoapi\Facades\Shoapi;

class OrderController extends Controller
{
    public function index()
    {
        $timeTo = time(); // sekarang
        $timeFrom = $timeTo - (14 * 24 * 60 * 60); // 14 hari sebelumnya

        $params = [
            'time_range_field'            => 'create_time',
            'time_from'                   => $timeFrom,
            'time_to'                     => $timeTo,
            'page_size'                   => 20,
        ];

        $response = Shoapi::call('order')
            ->access('get_order_list', '4f64656f4459676f4e4a7a6e70484e66')
            ->shop(140997)
            ->request($params)
            ->response();

        dd($response);

        // return view('dashboard.index', compact('items'));

    }
}
