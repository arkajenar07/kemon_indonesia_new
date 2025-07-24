<?php

namespace App\Http\Controllers;

use App\Services\ShopeeTokenManager;
use Illuminate\Http\Request;
use Muhanz\Shoapi\Facades\Shoapi;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $shopId = 766550807; // ganti dengan shop_id kamu

        $accessToken = ShopeeTokenManager::getValidAccessToken($shopId);

        if (!$accessToken) {
            return response()->json(['error' => 'Token tidak ditemukan atau belum di-authorize'], 401);
        }

        $timeTo = time(); // sekarang
        $timeFrom = $timeTo - (15 * 24 * 60 * 60); // 14 hari sebelumnya

        $params = [
            'time_range_field'            => 'create_time',
            'time_from'                   => $timeFrom,
            'time_to'                     => $timeTo,
            'page_size'                   => 20,

        ];

        $orderResponse = Shoapi::call('order')
            ->access('get_order_list', $accessToken)
            ->shop($shopId)
            ->request($params)
            ->response();

        $orderResponseArray = json_decode(json_encode($orderResponse), true);
        $orders = $orderResponseArray['order_list'];

        $allOrders = [];

        foreach ($orders as $order) {
            $orderSn = $order['order_sn'];
            $paramsOrderdetail = [
                'order_sn_list' => $orderSn,
            ];

            $orderDetailResponse = Shoapi::call('order')
                ->access('get_order_detail', $accessToken)
                ->shop($shopId)
                ->request($paramsOrderdetail)
                ->response();

            $orderResponseArray = json_decode(json_encode($orderDetailResponse), true);

            $allOrders[] = $orderResponseArray['order_list'][0];

        }

        // dd($allOrders);

        return view('penjualan.index', compact('allOrders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
