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
 * @property string $updated_id
 * @property string $mask
 * @property string $remove_file
 * @property string $port
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
        'updated_id',
        'mask',
        'remove_file',
        'port'
    ];

    protected $casts = [
        'ftp_active' => 'boolean',
        'remove_file' => 'boolean'
    ];

    public function connectionable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'updated_id');
    }
}
