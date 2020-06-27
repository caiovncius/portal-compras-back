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
 */
class Publicity extends Model
{
    protected $fillable = [
        'code',
        'desc',
        'date_create',
        'date_publish',
        'images'
    ];
}
