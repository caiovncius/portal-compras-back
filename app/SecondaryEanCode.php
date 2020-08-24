<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SecondaryEanCode extends Model
{
    public $fillable = [
        'product_id',
        'name'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
