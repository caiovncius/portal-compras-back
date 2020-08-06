<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Accompaniment
 * @package App
 *
 * @property int $id
 * @property string $code_order
 * @property string $code_pharmacy
 * @property string $date_create
 * @property string $date_publish
 * @property string $commercial
 * @property string $type_send
 * @property string $status
 * @property string $updated_id
 */
class Accompaniment extends Model
{
    protected $fillable = [
        'code_order',
        'code_pharmacy',
        'date_create',
        'date_publish',
        'commercial',
        'type_send',
        'status',
        'updated_id'
    ];
}

