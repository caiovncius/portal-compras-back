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
        'desc',
        'status',
        'updated_id'
    ];

    public function returnable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'updated_id');
    }
}
