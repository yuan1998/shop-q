<?php

namespace App\Admin\Repositories;

use App\Models\PayChannel as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class PayChannel extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
