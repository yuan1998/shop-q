<?php

namespace App\Admin\Repositories;

use App\Models\BlackList as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class BlackList extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
