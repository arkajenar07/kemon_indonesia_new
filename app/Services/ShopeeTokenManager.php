<?php

namespace App\Services;

use App\Models\ShopeeToken;
use Carbon\Carbon;
use Muhanz\Shoapi\Facades\Shoapi;

class ShopeeTokenManager
{
    public static function getValidAccessToken(int $shopId): ?string
    {
        $token = ShopeeToken::where('shop_id', $shopId)->first();

        if (!$token) {
            return null;
        }

        // Jika token belum expired, langsung pakai
        if ($token->expires_at->isFuture()) {
            return $token->access_token;
        }

        // Token expired, refresh!
        $response = Shoapi::call('auth')
            ->access('refresh_access_token')
            ->shop($shopId)
            ->request([
                'refresh_token' => $token->refresh_token
            ])
            ->response();

        $responseToken = json_decode(json_encode($response), true);

        // Update database dengan token baru
        $token->update([
            'access_token' => $responseToken['access_token'],
            'refresh_token' => $responseToken['refresh_token'],
            'expires_at' => now()->addSeconds($responseToken['expire_in']),
        ]);

        return $response['access_token'];
    }
}
