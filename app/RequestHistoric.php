<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class RequestHistoric
 * @package App
 *
 * @property int $request_id
 * @property string $user
 * @property string $action
 * @property string $status
 */
class RequestHistoric extends Model
{
    protected $fillable = [
        'request_id',
        'user',
        'action',
        'status',
    ];

    public function request()
    {
        return $this->belongsTo(\App\Request::class, 'request_id');
    }
}
