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
    protected $fillable = [
        'pharmacy_id',
        'status',
        'updated_id',
        'partner_id',
        'partner_type',
        'priority',
        'value',
        'subtotal',
        'send_date',
        'requestable_id',
        'requestable_type',
    ];

    protected $casts = [
        'value' => 'float',
        'subtotal' => 'float',
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
     * @return mixed
     */
    public function getPartnerAttribute()
    {
        if (is_null($this->partner_type)) return null;
        return $this->partner_type == 'App\Distributor' ? Distributor::find($this->partner_id) : Program::find($this->partner_id);
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
        )->withPivot(['qtd', 'qtd_return', 'status', 'partner_id', 'partner_type', 'return_id', 'value']);
    }
}
