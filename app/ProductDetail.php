<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductDetail
 * @package App
 *
 * @property int product_id
 * @property int discount_deferred
 * @property int discount_on_cash
 * @property int minimum
 * @property int minimum_per_family
 * @property string obrigatory
 * @property string variable
 * @property string family
 * @property string gift
 * @property string factory_price
 * @property string price_deferred
 * @property string price_on_cash
 * @property string quantity_maximum
 * @property string quantity_minimum
 * @property string state_id
 * @property string updated_id
 */
class ProductDetail extends Model
{
    protected $fillable = [
        'product_id',
        'discount_deferred',
        'discount_on_cash',
        'minimum',
        'minimum_per_family',
        'obrigatory',
        'variable',
        'family',
        'gift',
        'factory_price',
        'price_deferred',
        'price_on_cash',
        'quantity_maximum',
        'quantity_minimum',
        'state_id',
        'updated_id',
    ];

    protected $casts = [
        'discount_deferred' => 'integer',
        'discount_on_cash' => 'integer',
        'minimum' => 'integer',
        'minimum_per_family' => 'integer',
        'obrigatory' => 'boolean',
        'variable' => 'boolean',
        'family' => 'boolean',
        'gift' => 'boolean',
        'factory_price' => 'decimal:2',
        'price_deferred' => 'decimal:2',
        'price_on_cash' => 'decimal:2',
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

    /**
     * @param $factoryPrice
     * @param $discount
     * @return float|int
     */
    public static function sumDiscount($factoryPrice, $discount)
    {
        if (is_null($factoryPrice) || empty($factoryPrice) || $factoryPrice == 0) return 0;
        if (is_null($discount) || empty($discount) || $discount == 0) return $factoryPrice;
        return $factoryPrice - ($factoryPrice / 100 * $discount);
    }
}
