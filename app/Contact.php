<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Contact
 * @package App
 *
 * @property int $id
 * @property string $function
 * @property string $name
 * @property string $email
 * @property string $telephone
 * @property string $contactable_id
 * @property string $contactable_type
 * @property string $updated_id
 */
class Contact extends Model
{
    protected $fillable = [
        'function',
        'name',
        'email',
        'telephone',
        'contactable_id',
        'contactable_type',
        'updated_id'
    ];

    public function contactable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'updated_id');
    }
}
