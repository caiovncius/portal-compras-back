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
 */
class Distributor extends Model
{
    protected $fillable = [
        'code',
        'cnpj',
        'name',
        'status'
    ];

    public function contacts()
    {
        return $this->morphMany('App\Contact', 'contactable');
    }

    public function connection()
    {
        return $this->morphOne('App\Connection', 'connectionable');
    }
}
