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
 * @property string $name
 * @property string $status
 * @property string $state_registration
 * @property string $email
 * @property string $phone
 * @property int $supervisor_id
 * @property string $partner_priority
 * @property string $address
 * @property string $address_2
 * @property string $address_number
 * @property string $district
 * @property string $zip_code
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

    const PHARMACY_STATUS_ACTIVE = 'ACTIVE';
    const PHARMACY_STATUS_INACTIVE = 'INACTIVE';

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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function supervisor()
    {
        return $this->belongsTo('App\User', 'supervisor_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function contacts()
    {
        return $this->morphMany(Contact::class, 'contactable');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function priority()
    {
        return $this->belongsTo(Priority::class, 'partner_priority');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function supervior()
    {
        return $this->belongsTo(User::class, 'supervisor_id');
    }
}
