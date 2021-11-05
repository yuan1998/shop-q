<?php

namespace App\Admin\Repositories;

use App\Models\Attribute as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class Attribute extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
