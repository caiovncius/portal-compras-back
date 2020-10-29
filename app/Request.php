<?php

namespace App;

use App\Distributor;
use App\Program;
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
        'partner_type',
        'partner_id',
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
            'partner_type',
            'partner_id',
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
    public function getPartnerAttribute()
    {
        if (is_null($this->partner_type)) return null;
        return $this->partner_type == 'App\Distributor' ? Distributor::find($this->partner_id) : Program::find($this->partner_id);
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
}
