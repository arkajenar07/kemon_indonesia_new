<?php

namespace App\Http\Controllers;
use App\Services\ShopeeImageUploader;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function uploadAjax(Request $request, ShopeeImageUploader $uploader)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $result = $uploader->uploadImage($request->file('image'));

        return response()->json($result);
    }

}
