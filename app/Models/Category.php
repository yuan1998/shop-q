<?php

namespace App\Models;

use Dcat\Admin\Traits\ModelTree;

class Category extends Model
{
    use ModelTree;

    protected $fillable = [
        'parent_id',
        'order',
        'title'
    ];
    protected $titleColumn = 'title';


    public function products(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_has_categories', 'category_id', 'product_id');
    }
}
