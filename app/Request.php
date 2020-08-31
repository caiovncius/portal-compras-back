<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Request
 * @package App
 *
 * @property int $pharmacy_id
 * @property string $status
 */
class Request extends Model
{
    protected $fillable = [
        'pharmacy_id',
        'status',
        'updated_id',
        'partner_id',
        'priority',
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'updated_id');
    }

    public function pharmacy()
    {
        return $this->belongsTo('App\Pharmacy', 'pharmacy_id');
    }

    public function partner()
    {
        return $this->belongsTo('App\Distributor', 'partner_id');
    }

    public function historics()
    {
        return $this->morphMany(\App\RequestHistoric::class, 'request_id');
    }

    public function requestable()
    {
        return $this->morphTo();
    }

    public function products()
    {
        return $this->belongsToMany(
                        'App\OfferProduct',
                        'offerProduct_request',
                        'request_id',
                        'offer_product_id'
                    )->withPivot('qtd');
    }
}
