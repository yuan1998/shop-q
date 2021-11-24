<?php

namespace App\Models;

use Spatie\EloquentSortable\SortableTrait;

class Banner extends Model
{
    use SortableTrait;

    public $sortable = [
        'order_column_name' => 'order',
        'sort_when_creating' => true,
    ];

    protected $fillable = [
        'name',
        'url',
        'image',
        'show',
        'order',
    ];
}
