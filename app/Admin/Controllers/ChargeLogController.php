<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\AccountLimit;
use App\Models\ChargeLog;
use App\Models\Order;
use App\Payable\HuPiPay;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class ChargeLogController extends AdminController
{

    public function charge()
    {
        $url = env('CHARGE_URL', 'https://pay.douyinpaypay.top/apy');
//        $url = env('CHARGE_URL', 'http://alipay.app.test/apy');
        $price = request()->get('price');
        $log = ChargeLog::create([
            'uuid' => Order::generateOrderId(),
            'price' => $price
        ]);
        $domain = request()->getSchemeAndHttpHost();
        $notifyUrl = "{$domain}/api/pay/notify/charge";
        $query = http_build_query([
            'notify_url' => $notifyUrl,
            'notify_id' => $log->uuid,
            'price' => $price,
        ]);

        return redirect("{$url}?$query");
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new ChargeLog(), function (Grid $grid) {
            $maxLimit = env('MAX_LIMIT');
            $count = AccountLimit::getAccountLimit();
            $grid->model()
                ->orderBy('id', 'desc');
            $grid->header(admin_view("admin.chargeLogHeader", [
                'maxLimit' => $maxLimit,
                'count' => $count,
            ]));
            $grid->disableViewButton();
            $grid->disableActions();
            $grid->disableBatchActions();
            $grid->disableCreateButton();
            $grid->model()
                ->orderBy('id', 'desc');

            $grid->column('id')->sortable();
            $grid->column('uuid');
            $grid->column('price');
            $grid->column('status','支付状态')->using(ChargeLog::STATUS_LIST);
            $grid->column('created_at');

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');

            });
        });
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     *
     * @return Show
     */
    protected function detail($id)
    {
        return Show::make($id, new ChargeLog(), function (Show $show) {
            $show->field('id');
            $show->field('uuid');
            $show->field('price');
            $show->field('created_at');
            $show->field('updated_at');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new ChargeLog(), function (Form $form) {
            $form->display('id');
            $form->text('uuid');
            $form->text('price');

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
