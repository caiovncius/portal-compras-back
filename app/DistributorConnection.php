<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Contact
 * @package App
 *
 * @property int $id
 * @property string $distributor_id
 * @property string $ftp_active
 * @property string $transferency
 * @property string $host
 * @property string $path_send
 * @property string $login
 * @property string $password
 * @property string $path_return
 */
class DistributorConnection extends Model
{
    protected $fillable = [
        'distributor_id',
        'ftp_active',
        'transferency',
        'host',
        'path_send',
        'login',
        'password',
        'path_return',
    ];

    public function distributor()
    {
        return $this->belongsTo(Distributor::class, 'distributor_id');
    }
}
