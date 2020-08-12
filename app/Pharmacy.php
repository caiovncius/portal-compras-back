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
 * @property int $updated_id
 */
class Pharmacy extends Model
{
    protected $fillable = [
        'code',
        'cnpj',
        'company_name',
        'status',
        'city_id',
        'commercial',
        'updated_id'
    ];

    public function city()
    {
        return $this->belongsTo(City::class);
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'ACTIVE');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'updated_id');
    }
}
