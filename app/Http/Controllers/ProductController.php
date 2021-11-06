<?php

namespace App\Http\Controllers;

use App\Models\Product;
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

    public function detail(Request $request)
    {
        $id = $request->get('id');
        if (!$id || !($product = Product::find($id)))
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
}
