<?php

namespace App\Models;

class Attribute extends Model
{
    protected $fillable = [
        'name',
        'attributes',
        'skus',
    ];

    protected $casts = [
        'attributes',
        'skus',
    ];
}
