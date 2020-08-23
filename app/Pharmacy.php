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
        'company_name',
        'name',
        'status',
        'cnpj',
        'state_registration',
        'email',
        'phone',
        'supervisor_id',
        'partner_priority',
        'address',
        'address_2',
        'address_number',
        'district',
        'zip_code',
        'city_id',
        'updated_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
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

    /**
     * @param $query
     * @return mixed
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'ACTIVE');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'updated_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function contacts()
    {
        return $this->morphMany(Contact::class, 'contactable');
    }
}
