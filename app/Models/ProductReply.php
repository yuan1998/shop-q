<?php

namespace App\Models;

class ProductReply extends Model
{
    protected $fillable = [
        'order_id',
        'thumb',
        'username',
        'rating',
        'comment',
        'images',
    ];


    public function product(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Product::class, 'order_id', 'id');
    }
}
