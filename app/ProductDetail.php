<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductDetail
 * @package App
 *
 * @property int product_id
 * @property int discountDeferred
 * @property int discountOnCash
 * @property int minimum
 * @property int minimumPerFamily
 * @property string obrigatory
 * @property string variable
 * @property string family
 * @property string gift
 * @property string factoryPrice
 * @property string priceDeferred
 * @property string priceOnCash
 * @property string productOnName
 * @property string quantityMaximum
 * @property string quantityMinimum
 * @property string state_id
 * @property string updated_id
 */
class ProductDetail extends Model
{
    protected $fillable = [
        'product_id',
        'discountDeferred',
        'discountOnCash',
        'minimum',
        'minimumPerFamily',
        'obrigatory',
        'variable',
        'family',
        'gift',
        'factoryPrice',
        'priceDeferred',
        'priceOnCash',
        'productName',
        'quantityMaximum',
        'quantityMinimum',
        'state_id',
        'updated_id',
    ];

    protected $casts = [
        'discountDeferred' => 'integer',
        'discountOnCash' => 'integer',
        'minimum' => 'integer',
        'minimumPerFamily' => 'integer',
        'obrigatory' => 'boolean',
        'variable' => 'boolean',
        'family' => 'boolean',
        'gift' => 'boolean',
        'factoryPrice' => 'decimal:2',
        'priceDeferred' => 'decimal:2',
        'priceOnCash' => 'decimal:2',
    ];

    public function product()
    {
        return $this->belongsTo('App\Product', 'product_id');
    }

    public function productable()
    {
        return $this->morphTo();
    }

    public function state()
    {
        return $this->belongsTo('App\State', 'state_id');
    }

    public function requests()
    {
        return $this->belongsToMany(
                        'App\Request',
                        'request_products',
                        'product_detail_id',
                        'request_id',
                    )->withPivot(['qtd', 'qtdReturn', 'status', 'distributor_id']);
    }
}
