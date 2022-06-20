<?php

namespace App\Admin\Controllers;

use App\Admin\Exporters\OrderExporter;
use App\Admin\Forms\OrderLogisticNumber;
use App\Admin\Renderable\OrderProductTable;
use App\Admin\Repositories\Order;
use App\Admin\RowActions\BlockPhoneAndIp;
use App\MobileDetect;
use App\Models\OrderReturn;
use Carbon\Carbon;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Widgets\Card;

class OrderController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {

        return Grid::make(Order::indexQuery(), function (Grid $grid) {
            $grid->scrollbarX();

            $grid->export(new OrderExporter());

            $grid->disableCreateButton();
            $grid->disableDeleteButton();

            $grid->header(function ($collection) use ($grid) {
                $query = \App\Models\Order::query();

                // 拿到表格筛选 where 条件数组进行遍历
                $grid->model()->getQueries()->unique()->each(function ($value) use (&$query) {
                    if (in_array($value['method'], ['paginate', 'get', 'orderBy', 'orderByDesc'], true)) {
                        return;
                    }

                    $query = call_user_func_array([$query, $value['method']], $value['arguments'] ?? []);
                });

                // 查出统计数据
                $count = $query->count();
                $sum = $query->sum('price');
                $value = "总订单数:{$count}";
//                dd($count,$sum);

                // 自定义组件
                return new Card($value, " 金额: {$sum} ");
            });


            $grid->column('id')->display(function () {
                return $this->_index + 1;
            });
            $grid->column('order_id')->help('请输入5-20个字符');
            $grid->column('snapshot', '订单商品')
                ->expand(function (Grid\Displayers\Expand $expand) {
                    $expand->button('详情');
                    return OrderProductTable::make()->payload([
                        'id' => $this->id,
                    ]);
                });

            $grid->column('price')
                ->display(function ($value) {
                    return "{$value}元";
                })
                ->style("color:red;");

            $grid->column('status')
                ->display(function ($val) {
                    $status = $this->return_status ? data_get(\App\Models\OrderReturn::$outStatus, $this->return_status)
                        : data_get(\App\Models\Order::$payStatus, $val);
                    return "<a href='orders/{$this->id}/edit'>$status</a>";
                });


            $grid->column('pay_method')
                ->using(\App\Models\Order::$paymentName);
            $grid->column('pay_date');
            $grid->column('logistic_number', '快递单号')
                ->display(function ($val) {
                    return $val ?? '未发货';
                })
                ->if(function () {
                    return $this->status !== \App\Models\Order::UN_PAY;
                })
                ->modal(function (Grid\Displayers\Modal $modal) {
                    $modal->title('快递单号');
                    $modal->icon('feather icon-edit');

                    return OrderLogisticNumber::make()->payload([
                        'id' => $this->id,
                    ]);
                });
            $grid->column('comment')
                ->style('max-width:200px')
                ->editable();


            $grid->column('custom_info')
                ->display(function ($value) {
                    return collect(json_decode($value, true))
                        ->map(function ($val, $key) {
                            return "$key : $val";
                        })->join('<br/>');
                });

            $grid->column('created_at');
            $grid->column('return_at');

            $grid->actions(new BlockPhoneAndIp());

            $grid->filter(function (Grid\Filter $filter) {
                $detect = new MobileDetect;
                if ($detect->isMobile()) {
                    $filter->panel();
                }

                $filter->like('order_id');

                $filter->where('status', function ($query) {
                    if (is_numeric($this->input)) {
                        if ($this->input == 4) {
                            $query->where('return_status', '<>', 0);
                        } else {
                            $query->where('status', $this->input);
                        }
                    }
                })->select(\App\Models\Order::$payStatus)->config([
                    'placeholder' => ['id' => '', 'text' => '全部数据',],
                ]);
                $filter->equal('return_status')
                    ->select(OrderReturn::$outStatus)->config([
                        'placeholder' => ['id' => '', 'text' => '全部数据',],
                    ]);

                $filter->group('custom_info', function ($group) {
                    $group->like('模糊');
                    $group->equal('精准');
                }, '收货人/收货人电话');

                $filter->equal('logistic_number');
                $filter->between('created_at', '创建时间')->datetime([
                    'startOptions' => [
                        'defaultCurrent' => Carbon::today()->toDateString() . ' 00:00:00',
                    ],
                    'endOptions' => [
                        'defaultCurrent' => Carbon::today()->toDateString() . ' 23:59:59',
                    ],
                ]);
                $filter->between('pay_date', '支付时间')->datetime([
                    'startOptions' => [
                        'defaultCurrent' => Carbon::today()->toDateString() . ' 00:00:00',
                    ],
                    'endOptions' => [
                        'defaultCurrent' => Carbon::today()->toDateString() . ' 23:59:59',
                    ],
                ]);

                $filter->between('return_at', '退货/款时间')->datetime([
                    'startOptions' => [
                        'defaultCurrent' => Carbon::today()->toDateString() . ' 00:00:00',
                    ],
                    'endOptions' => [
                        'defaultCurrent' => Carbon::today()->toDateString() . ' 23:59:59',
                    ],
                ]);
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
        return Show::make($id, new Order(), function (Show $show) {
            $show->field('id');
            $show->field('pay_date');
            $show->field('product_id');
            $show->field('snapshot');
            $show->field('product_sku');
            $show->field('custom_info');
            $show->field('status');
            $show->field('pay_method');
            $show->field('pay_info');
            $show->field('price');
            $show->field('order_id');
            $show->field('created_at');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new Order(), function (Form $form) {
            $form->display('id');
            $form->hidden('pay_date');
            $form->hidden('product_id');
            $form->hidden('snapshot');
            $form->hidden('product_sku');
            $form->display('pay_method');
            $form->display('pay_info');
            $form->display('price');
            $form->hidden('order_id');
            $form->textarea('comment');

            $form->radio('status')
                ->options(\App\Models\Order::$payStatus)
                ->when([\App\Models\Order::SHIP], function (Form $form) {
                    $form->text('logistic_number')
                        ->rules("required_if:status," . \App\Models\Order::SHIP, [
                            'required_if' => ':attribute 不能为空'
                        ]);
                })
                ->when([0, 1, 2, 3, 5], function (Form $form) {

                    $form->embeds('custom_info', function ($form) {

                        $form->text('收货人')->required();
                        $form->text('收货人电话')->required();
                        $form->text('收货人地址')->required();
                    })
                        ->saving(function ($v) {
                            return json_encode($v);
                        })
                        ->rules('required_if:status,0,1,2,3,5', [
                            'required_if' => ':attribute 不能为空'
                        ]);

                })
                ->when([4], function (Form $form) {
                    $form->textarea('return_reason')
                        ->rules('required_if:status,4', [
                            'required_if' => ':attribute 不能为空'
                        ]);

                    $form->radio('return_status')
                        ->options(OrderReturn::$outStatus)
                        ->when([
                            OrderReturn::RETURN_AGREE_WAIT_SHIP,
                            OrderReturn::RETURN_AGREE_SHIP,
                            OrderReturn::EXCHANGE_REQUEST,
                            OrderReturn::EXCHANGE_REQUEST_WAIT_SHIP,
                            OrderReturn::EXCHANGE_REQUEST_SHIP,
                        ], function (Form $form) {
                            $statusId = implode(',', [
                                OrderReturn::RETURN_AGREE_WAIT_SHIP,
                                OrderReturn::RETURN_AGREE_SHIP,
                                OrderReturn::EXCHANGE_REQUEST,
                                OrderReturn::EXCHANGE_REQUEST_WAIT_SHIP,
                                OrderReturn::EXCHANGE_REQUEST_SHIP,
                            ]);
                            $form->textarea('return_location')
                                ->rules(
                                    'required_if:return_status,' . $statusId,
                                    [
                                        'required_if' => ':attribute 不能为空'
                                    ]
                                );
                        })
                        ->when([
                            OrderReturn::RETURN_AGREE_SHIP,
                            OrderReturn::EXCHANGE_REQUEST_SHIP,
                        ], function (Form $form) {

                            $statusId = implode(',', [
                                OrderReturn::RETURN_AGREE_SHIP,
                                OrderReturn::EXCHANGE_REQUEST_SHIP,
                            ]);
                            $form->text('return_logistics_number')
                                ->rules(
                                    'required_if:return_status,' . $statusId,
                                    [
                                        'required_if' => ':attribute 不能为空'
                                    ]
                                );
                        })
                        ->rules('required_if:status,4', [
                            'required_if' => ':attribute 不能为空'
                        ]);
                })
                ->rules('required', [
                    'required' => ':attribute 不能为空'
                ]);

            $form->saving(function (Form $form) {
                if (!$form->return_status) {
                    $form->return_status = 0;
                } else {
                    if ($form->status != \App\Models\Order::PAY_OUTING) {
                        $form->return_status = 0;
                    }
                }

            });
        });
    }
}
