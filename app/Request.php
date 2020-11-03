<?php

namespace App;

use App\Distributor;
use App\Program;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Request
 * @package App
 *
 * @property int $pharmacy_id
 * @property string $status
 * @property int $updated_at
 * @property int $partner_id
 * @property int $priority
 * @property decimal $value
 * @property string $send_date
 */
class Request extends Model
{
    /**
     * @var array
     */
    public $fillable = [
        'pharmacy_id',
        'requestable_type',
        'requestable_id',
        'priority',
        'status',
        'payment_method',
        'subtotal',
        'total_discount',
        'total',
        'send_date',
        'updated_id',
    ];

    protected $casts = [
        'total' => 'float',
        'subtotal' => 'float',
        'total_discount' => 'float',
        'send_date' => 'date'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'updated_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pharmacy()
    {
        return $this->belongsTo('App\Pharmacy', 'pharmacy_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function historics()
    {
        return $this->hasMany(\App\RequestHistoric::class, 'request_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function requestable()
    {
        return $this->morphTo();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products()
    {
        return $this->belongsToMany(
            \App\Product::class,
            'request_products',
            'request_id',
            'product_id'
        )->withPivot([
            'return_id',
            'partner_id',
            'requested_quantity',
            'quantity_served',
            'subtotal',
            'total_discount',
            'total'
        ]);
    }

    /**
     * @return mixed
     */
    public function getMonthAttribute()
    {
        return date('m', strtotime($this->created_at));
    }

    /**
     * @param $value
     * @param $quantity
     * @param $paymentMethod
     * @param $offerDetail
     * @return float|int
     */
    public static function calculateDiscount($value, $quantity, $paymentMethod, $offerDetail)
    {
        $subtotal = $value * $quantity;
        $discount = $paymentMethod === 'CASH' ? $offerDetail->discount_on_cash : $offerDetail->discount_deferred;
        $discountValue = ($subtotal / 100) * $discount;
        return $subtotal - $discountValue;
    }

    /**
     * @param $value
     * @return string
     */
    public static function getProductStatusText($value)
    {
        switch ($value) {

            case 'CREATED':
                return 'Adicionado';
                break;

            case 'ATTENDED':
                return 'Atendido';
                break;

            case 'ATTENDED_PARTIAL':
                return 'Atendido Parcialmente';
                break;

            case 'NOT_ATTENDED':
                return 'Não Atendido';
                break;

            default:
                return '';
                break;
        }
    }

    /**
     * @param ProductDetail $productDetail
     * @param int $quantity
     * @param string $paymentMethod
     * @return float|int
     */
    public static function getProductSubTotal(ProductDetail $productDetail, int $quantity, string $paymentMethod)
    {
        if ($quantity < 1 || is_null($productDetail->factory_price) || $productDetail->factory_price <= 0) return 0;
        return $productDetail->factory_price * $quantity;
    }

    /**
     * @param ProductDetail $productDetail
     * @param string $paymentMethod
     * @param $subtotal
     * @return float|int
     */
    public static function getProductTotalDiscount(ProductDetail $productDetail, string $paymentMethod, $subtotal, int $quantity)
    {
        if ($subtotal <= 0) return 0;

        $discount = $paymentMethod === 'CASH' ? $productDetail->discount_on_cash : $productDetail->discount_deferred;

        if ($productDetail->variable) {
            $offerClass = $productDetail->productable;
            $productRange = $productDetail->productable->products()
                ->where('quantity_minimum', '<=', $quantity)
                ->where('quantity_maximum', '>=', $quantity)
                ->first();

            if (is_null($productRange)) {
                $productRange = $productDetail->productable->products()
                    ->where('quantity_minimum', '<=', $quantity)
                    ->orderBy('quantity_minimum', 'desc')
                    ->first();
            }

            $discount = (is_null($productRange) ? 0 : $paymentMethod === 'CASH')
                ? $productRange->discount_on_cash
                : $productRange->discount_deferred;

        }

        return ($subtotal / 100) * $discount;
    }

    /**
     * @param $subtotal
     * @param $discountValue
     * @return int
     */
    public static function getProductTotal($subtotal, $discountValue)
    {
        $sum = $subtotal - $discountValue;
        if ($sum <= 0) return 0;
        return $sum;
    }
}
