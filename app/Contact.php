<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Contact
 * @package App
 *
 * @property int $id
 * @property string $distributor_id
 * @property string $name
 * @property string $function
 * @property string $email
 * @property string $telephone
 */
class Contact extends Model
{
    protected $fillable = [
        'distributor_id',
        'function',
        'name',
        'email',
        'telephone'
    ];

    public function distributor()
    {
        return $this->belongsTo(Distributor::class, 'distributor_id');
    }
}
