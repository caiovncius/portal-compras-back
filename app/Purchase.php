<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Purchase
 * @package App
 *
 * @property int $offer_id
 * @property string $image
 * @property string $code
 * @property string $name
 * @property string $send_type
 * @property string $status
 * @property date $validity_start
 * @property date $validity_end
 * @property boolean $until_billing
 * @property int $setMinimum_billing_value
 * @property int $minimum_billing_value
 * @property int $set_minimum_billing_quantity
 * @property int $minimum_billing_quantity
 * @property int $total_intentions_value
 * @property int $total_intentions_quantity
 * @property int $related_quantity
 * @property string $description
 * @property int $updated_id
 * @property int $minimum_family
 */
class Purchase extends Model
{
    const PARTNER_TYPE_DISTRIBUTOR = 'DISTRIBUTOR';
    const PARTNER_TYPE_PROGRAM = 'PROGRAM';

    const BILLING_TYPE_VALUE = 'VALUE';
    const BILLING_TYPE_QUANTITY = 'QUANTITY';

    protected $fillable = [
        'image',
        'code',
        'name',
        'status',
        'send_type',
        'validity_start',
        'validity_end',
        'until_billing',
        'billing_measure',
        'minimum_billing_value',
        'minimum_billing_quantity',
        'total_intentions_value',
        'total_intentions_quantity',
        'related_quantity',
        'description',
        'updated_id',
        'contacts',
        'billed_date',
        'minimum_family'
    ];

    /**
     * @var array
     */
    protected $casts = ['contacts' => 'array', 'billed_date' => 'datetime'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function partner()
    {
        return $this->morphOne(Partner::class, 'typable');
    }

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
    public function offer()
    {
        return $this->belongsTo('App\Offer', 'offer_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function products()
    {
        return $this->morphMany('App\ProductDetail', 'productable');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function requests()
    {
        return $this->morphMany('App\Request', 'requestable');
    }
}
