<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Pharmacy
 * @package App
 *
 * @property int $id
 * @property string $code
 * @property string $cnpj
 * @property string $company_name
 * @property string $status
 * @property int $city_id
 * @property string $commercial
 */
class Pharmacy extends Model
{
    protected $fillable = [
        'code',
        'cnpj',
        'company_name',
        'status',
        'city_id',
        'commercial'
    ];

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
