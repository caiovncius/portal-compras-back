<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Connection
 * @package App
 *
 * @property int $id
 * @property string $ftp_active
 * @property string $transferency
 * @property string $host
 * @property string $path_send
 * @property string $login
 * @property string $password
 * @property string $path_return
 */
class Connection extends Model
{
    protected $fillable = [
        'ftp_active',
        'transferency',
        'host',
        'path_send',
        'login',
        'password',
        'path_return',
    ];

    protected $casts = ['ftp_active' => 'boolean'];

    public function connectionable()
    {
        return $this->morphTo();
    }
}
