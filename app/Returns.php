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
 */
class Returns extends Model
{
    protected $fillable = [
        'code',
        'desc',
        'status'
    ];
}
