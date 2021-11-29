<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductReply;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function list(Request $request)
    {
        $product = Product::query()
            ->where('show', 1)
            ->paginate(15);

        return response()
            ->json([
                'status' => 0,
                'data' => $product
            ]);
    }

    public function detail(Request $request): \Illuminate\Http\JsonResponse
    {
        $id = $request->get('id');
        if (!$id || !($product = Product::query()
                ->with([
                    'attribute',
                    'replies' => function ($query) {
                        $query->limit(3)
                            ->orderBy('created_at', 'desc');
                    }
                ])
                ->withCount(['replies'])
                ->where('id', $id)
                ->where('show', 1)
                ->first()))
            return response()
                ->json([
                    'status' => 1,
                    'errMsg' => '错误的Id,请刷新页面'
                ]);

        return response()
            ->json([
                'status' => 0,
                'data' => $product
            ]);

    }

    public function productReplies(Request $request): \Illuminate\Http\JsonResponse
    {
        $id = $request->get('id');

        $list = ProductReply::query()
            ->where('order_id', $id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return response()
            ->json([
                'status' => 0,
                'data' => $list,
                'msg' => '操作成功'
            ]);
    }
}
