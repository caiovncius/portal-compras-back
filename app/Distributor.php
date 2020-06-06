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
        return $this->hasMany(Contact::class, 'distributor_id');
    }

    public function connection()
    {
        return $this->hasOne(DistributorConnection::class, 'distributor_id');
    }
}
