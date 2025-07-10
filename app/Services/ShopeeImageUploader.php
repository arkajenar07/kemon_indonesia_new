<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Muhanz\Shoapi\Facades\Shoapi;

class ShopeeImageUploader
{
    public function uploadImage(UploadedFile $image): mixed
    {
        $shopId = 766550807; // ganti dengan shop_id kamu

        $accessToken = ShopeeTokenManager::getValidAccessToken($shopId);

        if (!$accessToken) {
            return response()->json(['error' => 'Token tidak ditemukan atau belum di-authorize'], 401);
        }

        // Simpan file ke storage
        $path = $image->store('uploads', 'public');
        $fullPath = storage_path('app/public/' . $path);

        $params = [
            'image' => $fullPath,
        ];

        $response = Shoapi::call('media_space')
            ->access('upload_image', access_token: $accessToken)
            ->shop($shopId)
            ->request($params)
            ->response();

        $response = json_decode(json_encode($response), true);

        // Ambil data dari response
        $imageId = $response['image_info']['image_id'] ?? null;
        $imageUrlList = $response['image_info']['image_url_list'] ?? [];

        // Ambil link image dari region ID (atau region pertama jika tidak ada ID)
        $imageUrl = collect($imageUrlList)
            ->firstWhere('image_url_region', 'ID')['image_url'] ??
            ($imageUrlList[0]['image_url'] ?? null);

        return [
            'image_id' => $imageId,
            'image_url' => $imageUrl,
        ];
    }
}

