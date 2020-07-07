<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Condition
 * @package App
 *
 * @property int $id
 * @property string $pharmacy_id
 * @property string $code
 * @property string $desc
 * @property string $status
 * @property string $visible
 */
class Condition extends Model
{
    protected $fillable = [
        'pharmacy_id',
        'desc',
        'code',
        'status',
        'visible'
    ];

    protected $casts = ['visible' => 'boolean'];

    public function pharmacy()
    {
        return $this->belongsTo(Pharmacy::class, 'pharmacy_id');
    }

    public function partners()
    {
        return $this->belongsToMany('App\Distributor');
    }
}
