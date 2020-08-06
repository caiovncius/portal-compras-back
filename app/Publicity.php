<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Publicity
 * @package App
 *
 * @property int $id
 * @property string $code
 * @property string $desc
 * @property string $date_create
 * @property string $date_publish
 * @property string $images
 * @property int $updated_id
 */
class Publicity extends Model
{
    protected $fillable = [
        'code',
        'desc',
        'date_create',
        'date_publish',
        'images',
        'updated_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'updated_id');
    }
}
