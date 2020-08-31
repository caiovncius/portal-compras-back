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
}
