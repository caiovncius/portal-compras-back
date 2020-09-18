<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Return
 * @package App
 *
 * @property int $id
 * @property string $code
 * @property string $desc
 * @property string $status
 * @property int $updated_id
 */
class Returns extends Model
{
    protected $fillable = [
        'code',
        'description',
        'status',
        'updated_id'
    ];

    const RETURN_STATUS_ACTIVE = 'ACTIVE';
    const RETURN_STATUS_INACTIVE = 'INACTIVE';

    public function returnable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'updated_id');
    }
}
