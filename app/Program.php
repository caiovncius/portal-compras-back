<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Program
 * @package App
 *
 * @property int $id
 * @property string $code
 * @property string $name
 * @property string $status
 * @property int $updated_id
 */
class Program extends Model
{
    const PROGRAM_STATUS_ACTIVE = 'ACTIVE';
    const PROGRAM_STATUS_INACTIVE = 'INACTIVE';

    protected $fillable = [
        'code',
        'name',
        'status',
        'updated_id'
    ];

    public function contacts()
    {
        return $this->morphMany('App\Contact', 'contactable');
    }

    public function returns()
    {
        return $this->morphMany('App\Returns', 'returnable');
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
