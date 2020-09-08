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
 */
class Purchase extends Model
{
    protected $fillable = [
        'image',
        'code',
        'name',
        'status',
        'send_type',
        'validity_start',
        'validity_end',
        'until_billing',
        'set_minimum_billing_value',
        'minimum_billing_value',
        'set_minimum_billing_quantity',
        'minimum_billing_quantity',
        'total_intentions_value',
        'total_intentions_quantity',
        'related_quantity',
        'description',
        'updated_id',
        'contacts'
    ];

    protected $casts = ['contacts' => 'array'];

    public function partners()
    {
        return $this->morphMany('App\Partner', 'typable');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'updated_id');
    }

    public function offer()
    {
        return $this->belongsTo('App\Offer', 'offer_id');
    }

    public function products()
    {
        return $this->morphMany('App\ProductDetail', 'productable');
    }

    public function requests()
    {
        return $this->morphMany('App\Request', 'requestable');
    }
}
