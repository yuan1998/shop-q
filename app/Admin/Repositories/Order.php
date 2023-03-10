<?php

namespace App\Admin\Repositories;

use App\Models\Order as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class Order extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;

    public static function indexQuery()
    {
        return Model::query()
            ->select([
                'id',
                'ip',
                'order_id',
                'price',
                'status',
                'snapshot',
                'pay_method',
                'pay_date',
                'custom_info',
                'pay_channel_id',
                'created_at',
                'logistic_number',
                'comment',
            ])
            ->orderBy('id', 'desc');
    }
}
