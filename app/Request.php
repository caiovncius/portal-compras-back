<?php

namespace App;

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
 */
class Request extends Model
{
    protected $fillable = [
        'pharmacy_id',
        'status',
        'updated_id',
        'partner_id',
        'priority',
        'value'
    ];

    protected $casts = [
        'value' => 'decimal:10,2'
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function partner()
    {
        return $this->belongsTo('App\Distributor', 'partner_id');
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
                        'App\ProductDetail',
                        'request_products',
                        'request_id',
                        'product_detail_id'
                    )->withPivot(['qtd', 'qtd_return', 'status', 'distributor_id', 'return_id', 'value']);
    }
}
