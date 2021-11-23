<?php

namespace App\Models;


class Product extends Model
{

    protected $casts = [
        'images' => 'json',
        'attributes' => 'json',
        'skus' => 'json',
    ];

    protected $fillable = [
        'show',
        'title',
        'price',
        'sales',
        'description',
        'attribute_id',
        'images',
        'attributes',
        'skus',
        
        'origin_price',
    ];

    public function categories(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'product_has_categories', 'product_id', 'category_id');
    }

    public function attribute(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Attribute::class, 'id', 'attribute_id');
    }
}
