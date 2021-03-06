<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Offer
 * @package App
 *
 * @property int $id
 * @property string $image
 * @property string $code
 * @property string $name
 * @property string $status
 * @property string $description
 * @property date $start_date
 * @property date $end_date
 * @property string $condition_id
 * @property string $minimum_price
 * @property string $offer_type
 * @property bool $send_type
 * @property bool $no_automatic_sending
 * @property string $impound
 * @property json $emails
 * @property integer $updated_id
 * @property integer $minimum_family
 */
class Offer extends Model
{

    const OFFER_STATUS_ACTIVE = 'ACTIVE';
    const OFFER_STATUS_INACTIVE = 'INACTIVE';

    protected $fillable = [
        'image',
        'code',
        'name',
        'status',
        'description',
        'start_date',
        'end_date',
        'condition_id',
        'minimum_price',
        'offer_type',
        'send_type',
        'no_automatic_sending',
        'impound',
        'emails',
        'updated_id',
        'minimum_family'
    ];

    protected $casts = [
        'emails' => 'json',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'no_automatic_sending' => 'boolean',
    ];

    public function partners()
    {
        return $this->morphMany('App\Partner', 'typable');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'updated_id');
    }

    public function condition()
    {
        return $this->belongsTo('App\Condition', 'condition_id');
    }

    public function products()
    {
        return $this->morphMany('App\ProductDetail', 'productable');
    }

    public function requests()
    {
        return $this->morphMany('App\Request', 'requestable');
    }

    public static function getOfferCurrentPartner(Offer $offer, int $priority)
    {
        $partners = $offer->partners()->orderBy('priority', 'asc')
            ->get();

        if ($partners->count() === 0) return null;
        $currentPartner = isset($partners[($priority - 1)]) ? $partners[($priority - 1)] : $partners->last();

        $partner = $currentPartner->partner_type === 'DISTRIBUTOR'
            ? Distributor::find($currentPartner->partner_id)
            : Program::find($currentPartner->partner_id);

        return $partner;
    }
}
