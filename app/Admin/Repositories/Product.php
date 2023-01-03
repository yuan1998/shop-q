<?php

namespace App\Admin\Repositories;

use App\Models\Product as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class Product extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;

    public static function indexQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return Model::query()
            ->select([
                'id',
                'title',
                'show',
                'price',
                'origin_price',
                'sales',
                'images',
                'attributes',
                'skus',
                'created_at',
                'once_limit',
            ])
            ->with(['categories' => function ($query) {
                $query->select([
                    'categories.id',
                    'categories.title'
                ]);
            }])
            ->orderBy('id', 'desc');
    }
}
