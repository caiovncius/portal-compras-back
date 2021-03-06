<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Product
 * @package App
 *
 * @property int $id
 * @property string $code
 * @property string $code_ean
 * @property string $description
 * @property string $status
 * @property int $laboratory_id
 * @property int $updated_id
 */
class Product extends Model
{

    const PRODUCT_STATUS_ACTIVE = 'ACTIVE';
    const PRODUCT_STATUS_INACTIVE = 'INACTIVE';
    /**
     * @var array
     */
    protected $fillable = [
        'code',
        'code_ean',
        'description',
        'status',
        'laboratory_id',
        'updated_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function laboratory()
    {
        return $this->belongsTo(Laboratory::class, 'laboratory_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'updated_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function secondaryEanCodes()
    {
        return $this->hasMany(SecondaryEanCode::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function details()
    {
        return $this->hasMany('App\ProductDetail', 'product_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function requests()
    {
        return $this->belongsToMany(
            'App\Request',
            'request_products',
            'product_id',
            'request_id',
        )->withPivot(['qtd', 'qtd_return', 'status', 'partner_id', 'partner_type', 'return_id', 'value']);
    }
}
