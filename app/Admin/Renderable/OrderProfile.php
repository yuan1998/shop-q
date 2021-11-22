<?php

namespace App\Admin\Renderable;

use App\Models\Order;
use App\Models\OrderReturn;
use Carbon\Carbon;
use Dcat\Admin\Admin;
use Dcat\Admin\Contracts\LazyRenderable;
use Dcat\Admin\Traits\LazyWidget;
use Dcat\Admin\Widgets\Form;

class OrderProfile extends Form implements LazyRenderable
{
    use LazyWidget;

    public function handle(array $input): \Dcat\Admin\Http\JsonResponse
    {
        $action  = data_get($input, 'action');
        $comment = data_get($input, 'comment');
        $id      = $this->payload['id'] ?? null;
        $msg     = '保存成功';
        $data    = collect();

        if ($comment) {
            $data->put('comment', $comment);
        }

        switch ($action) {
            case "PASS_ORDER":
                $data->put('price', data_get($input, 'price'));
                $data->put('status', Order::UN_PAY);
                break;
            case "PAYED":
                $data->put('pay_date', Carbon::now()->toDateTimeString());
                $data->put('status', Order::PAY_SUCCESS);
                break;
            case "SEND":
                $data->put('logistic_number', $input['logistic_number']);
                $data->put('status', Order::SHIP);
                $data->put('send_at', Carbon::now()->toDateTimeString());
                break;
            case "PASS_RETURN_PRODUCT":
                $data->put('return_location', $input['return_location']);
                $data->put('return_status', 2);
                $data->put('status', 4);
                break;
            case "SEND_RETURN_PRODUCT":
                $data->put('return_status', 3);
                $data->put('status', 4);
                $data->put('return_logistics_number', $input['return_logistics_number']);

                break;
            case "WAIT_RETURN_PRODUCT":
                $data->put('return_status', 5);
                $data->put('status', 4);
                break;
            case "PASS_RETURN_PRICE":
                $data->put('return_status', 5);
                $data->put('status', 4);
                break;
        }

        if (!$data->isEmpty()) {
            Order::query()
                ->where('id', $id)
                ->update($data->toArray());
        }
        return $this->response()->success($msg)->refresh();
    }

    public function form()
    {
        // 接收外部传递参数
        $id           = $this->payload['id'] ?? null;
        $model        = Order::query()
            ->where('id', $id)
            ->first();
        $status       = $model->status;
        $returnStatus = $model->return_status;

        if (!Admin::user()->can('order.actions')) {
            $this->submitButton(false);
            $this->resetButton(false);
        }

        $this->textarea('comment', '备注')
            ->value($model->comment);

        if ($returnStatus) {
            $this->display('return_status', '退货/退款类型')
                ->value(data_get(OrderReturn::$outStatus, $returnStatus));
            $this->display('return_reason', '退货/退款理由')
                ->value($model->return_reason);

            if ($returnStatus == 1) {
                $this->submitButton(false);
                $this->resetButton(false);
                $this->hidden('action')->value('PASS_RETURN_PRODUCT');
                $this->textarea('return_location', '退货地址');
                if (Admin::user()->can('order.actions')) {
                    $this->button("同意退货退款")->class('submit');
                }
            }

            if ($returnStatus == 2) {
                $this->display('return_location', '退货地址')
                    ->value($model->return_location);
                $this->text('return_logistics_number', '快递单号')
                    ->required();
                $this->hidden('action')->value('SEND_RETURN_PRODUCT');
            }

            if ($returnStatus == 3) {
                $this->display('return_location', '退货地址')
                    ->value($model->return_location);
                $this->display('return_logistics_number', '快递单号')
                    ->value($model->return_logistics_number);
                $this->hidden('action')->value('WAIT_RETURN_PRODUCT');
                $this->submitButton(false);
                $this->resetButton(false);
                if (Admin::user()->can('order.actions')) {
                    $this->button("已经收到货了,同意退款")->class('submit');
                }
            }

            if ($returnStatus == 4) {
                $this->submitButton(false);
                $this->resetButton(false);
                $this->hidden('action')->value('PASS_RETURN_PRICE');
                if (Admin::user()->can('order.actions')) {
                    $this->button("同意退款")->class('submit');
                }
            }

            if ($returnStatus == 5) {
                $this->submitButton(false);
                $this->resetButton(false);
            }

        } else {
            $this->mapOfStatus($status, $model);
        }
    }


    public function mapOfStatus($status, $model)
    {
//        $typeTitle = $model->logisticsType->title;

//        $this->display('logistics_type_id', '快递类型')
//            ->value($typeTitle);
        $customInfo = json_decode($model->custom_info, true);

        $this->display('recipient_name', '收件人姓名')
            ->value($customInfo['收货人']);
        $this->display('recipient_phone', '收件人电话')
            ->value($customInfo['收货人电话']);
        $this->display('recipient_location', '收件人地址')
            ->value($customInfo['收货人地址']);


//        dd($status);
        if ($status == 0) {
            $this->submitButton(false);
            $this->resetButton(false);
            $this->hidden('action')->value('PASS_ORDER');
            $this->text('price', '价格')->required();
            if (Admin::user()->can('order.actions')) {
                $this->button("审核通过")->class('submit');
            }
        }
        if ($status == 1) {
            $this->submitButton(false);
            $this->resetButton(false);
            $this->hidden('action')->value('PAYED');
            if (Admin::user()->can('order.actions')) {
                $this->button("顾客已付款")->class('submit');
            }
        }
        if ($status == 2) {
            $this->hidden('action')->value('SEND');
            $this->text('logistic_number', '快递单号')
                ->required();
        }
        if ($status == 5) {
            $this->submitButton(false);
            $this->resetButton(false);
            $this->display('logistic_number', '快递单号')
                ->value($model->logistic_number);
        }
    }
}
