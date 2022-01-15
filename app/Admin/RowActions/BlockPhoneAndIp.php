<?php

namespace App\Admin\RowActions;

use App\Models\BlackList;
use Dcat\Admin\Grid\RowAction;
use Illuminate\Http\Request;

class BlockPhoneAndIp extends RowAction
{

    /**
     * 标题
     *
     * @return string
     */
    public function title()
    {
        return '拉黑该订单的用户和IP';
    }

    /**
     * 设置确认弹窗信息，如果返回空值，则不会弹出弹窗
     *
     * 允许返回字符串或数组类型
     *
     * @return array|string|void
     */
    public function confirm()
    {
        return [
            // 确认弹窗 title
            "您确定要拉黑该订单的用户吗？",
            // 确认弹窗 content
            $this->row->order_id,
        ];
    }

    /**
     * 处理请求
     *
     * @param Request $request
     *
     * @return \Dcat\Admin\Actions\Response
     */
    public function handle(Request $request)
    {

        // 获取 parameters 方法传递的参数
        $orderId = $request->get('order_id');
        $ip = $request->get('ip');
        $phone = $request->get('phone');

        $ip && BlackList::blockIp($ip, "通过订单{$orderId}添加", BlackList::ADD_TYPE_AUTO, BlackList::TYPE_IP);
        $phone && BlackList::blockIp($phone, "通过订单{$orderId}添加", BlackList::ADD_TYPE_AUTO, BlackList::TYPE_PHONE);


        // 返回响应结果并刷新页面
        return $this->response()->success("拉黑成功: [{$ip} ${phone}]")->refresh();
    }

    /**
     * 设置要POST到接口的数据
     *
     * @return array
     */
    public function parameters()
    {
        $info = is_array($this->row->custom_info) ? $this->row->custom_info : json_decode($this->row->custom_info, true);
        $phone = data_get($info, '收货人电话');

        return [
            // 发送当前行 username 字段数据到接口
            'ip' => $this->row->ip,
            'order_id' => $this->row->order_id,
            'phone' => $phone,
        ];
    }

}
