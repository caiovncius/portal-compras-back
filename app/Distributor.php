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
        'status',
        'updated_id'
    ];

    public function contacts()
    {
        return $this->morphMany('App\Contact', 'contactable');
    }

    public function connection()
    {
        return $this->morphOne('App\Connection', 'connectionable');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'updated_id');
    }
}
