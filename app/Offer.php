<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Offer
 * @package App
 *
 * @property int $id
 * @property string $image
 * @property string $code
 * @property string $name
 * @property string $status
 * @property string $description
 * @property date $startDate
 * @property date $endDate
 * @property string $condition
 * @property string $minimumPrice
 * @property string $offerType
 * @property bool $sendType
 * @property bool $noAutomaticSending
 * @property string $impound
 * @property json $emails
 */
class Offer extends Model
{
    protected $fillable = [
        'image',
        'code',
        'name',
        'status',
        'description',
        'startDate',
        'endDate',
        'condition',
        'minimumPrice',
        'offerType',
        'sendType',
        'noAutomaticSending',
        'impound',
        'emails',
    ];

    protected $casts = [
        'emails' => 'json',
        'startDate' => 'datetime',
        'endDate' => 'datetime',
        'sendType' => 'boolean',
        'noAutomaticSending' => 'boolean',
    ];

    public function partners()
    {
        return $this->belongsToMany('App/Distributor')
                    ->withPivot('type');
    }
}
