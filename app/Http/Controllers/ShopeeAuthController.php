<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Muhanz\Shoapi\Facades\Shoapi;
use App\Models\ShopeeToken;

class ShopeeAuthController extends Controller
{
    // Step 1: Redirect to Shopee
    public function redirectToShopee()
    {
        return Shoapi::call('shop')->access('auth_partner')->redirect();
    }

    // Step 2: Handle Shopee Callback
    public function handleCallback(Request $request)
    {
        $code = $request->get('code');
        $shopId = (int) $request->get('shop_id');

        $params = [
            'code' => $code,
            'shop_id' => $shopId,
        ];

        $response = Shoapi::call('auth')
            ->access('get_access_token')
            ->shop($shopId)
            ->request($params)
            ->response();


        $response = json_decode(json_encode($response), true);

        // dd($response);
        // // Simpan ke database
        // ShopeeToken::updateOrCreate(
        //     ['shop_id' => $shopId],
        //     [
        //         'access_token' => $response['access_token'],
        //         'refresh_token' => $response['refresh_token'],
        //         'expires_at' => now()->addSeconds($response['expire_in']),
        //     ]
        // );

        ShopeeToken::create([
            'shop_id' => $shopId,
            'access_token' =>  $response['access_token'],
            'refresh_token' => $response['refresh_token'],
        ]);

        return response()->json([
            'message' => 'Token berhasil disimpan!',
            'data' => $response,
        ]);
    }

}
