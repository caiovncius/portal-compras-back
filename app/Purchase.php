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
 * @property string $sendType
 * @property string $status
 * @property date $validityStart
 * @property date $validityEnd
 * @property boolean $untilBilling
 * @property int $setMinimumBillingValue
 * @property int $minimumBillingValue
 * @property int $setMinimumBillingQuantity
 * @property int $minimumBillingQuantity
 * @property int $totalIntentionsValue
 * @property int $totalIntentionsQuantity
 * @property int $relatedQuantity
 * @property string $description
 * @property int $updated_id
 */
class Purchase extends Model
{
    protected $fillable = [
        'offer_id',
        'image',
        'code',
        'name',
        'sendType',
        'status',
        'validityStart',
        'validityEnd',
        'untilBilling',
        'setMinimumBillingValue',
        'minimumBillingValue',
        'setMinimumBillingQuantity',
        'minimumBillingQuantity',
        'totalIntentionsValue',
        'totalIntentionsQuantity',
        'relatedQuantity',
        'description',
        'updated_id'
    ];

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
