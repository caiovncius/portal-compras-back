<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Distributor
 * @package App
 *
 * @property int $id
 * @property string $code
 * @property string $cnpj
 * @property string $name
 * @property string $status
 * @property string $updated_id
 */
class Distributor extends Model
{
    protected $fillable = [
        'code',
        'cnpj',
        'name',
        'category',
        'state_id',
        'status',
        'updated_id'
    ];

    const CATEGORY_NATIONAL = 'NATIONAL';
    const CATEGORY_REGIONAL = 'REGIONAL';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function contacts()
    {
        return $this->morphMany('App\Contact', 'contactable');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function returns()
    {
        return $this->morphMany('App\Returns', 'returnable');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function connection()
    {
        return $this->morphOne('App\Connection', 'connectionable');
    }

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
    public function state()
    {
        return $this->belongsTo(\App\State::class, 'state_id');
    }
}
