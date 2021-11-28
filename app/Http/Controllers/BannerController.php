<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function list(Request $request): \Illuminate\Http\JsonResponse
    {
        $count = $request->get('count', 3);

        $banners = Banner::query()
            ->where('show', 1)
            ->limit($count)
            ->orderBy('order', 'asc')
            ->get();

        return response()
            ->json([
                'status' => 0,
                'data' => $banners,
                'msg' => 'success',
            ]);
    }
}
