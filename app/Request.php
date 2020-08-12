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
        'offer_id',
        'status',
        'updated_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'updated_id');
    }

    public function pharmacy()
    {
        return $this->belongsTo('App\Pharmacy', 'pharmacy_id');
    }

    public function offer()
    {
        return $this->belongsTo('App\Offer', 'offer_id');
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