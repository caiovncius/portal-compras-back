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

    public function requestable()
    {
        return $this->morphTo();
    }

    public function products()
    {
        return $this->belongsToMany('App\Product')
                    ->withPivot(['qtd', 'value', 'total']);
    }
}
