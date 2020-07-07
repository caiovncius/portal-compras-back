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
 */
class Program extends Model
{
    protected $fillable = [
        'code',
        'name',
        'status',
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
