<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $params = $request->only([
            'order_id',
            'phone',
            'wechat',
            'comment'
        ]);

        Complaint::create($params);

        return response()
            ->json([
                'status' => 0,
                'msg' => '感谢您的投诉,请等待我们的检查结果'
            ]);
    }
}
