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
                'order_id',
                'price',
                'status',
                'snapshot',
                'pay_method',
                'pay_date',
                'custom_info',
                'created_at',
                'logistic_number',
            ])
            ->orderBy('id', 'desc');
    }
}
