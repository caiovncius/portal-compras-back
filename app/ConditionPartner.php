<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ConditionPartner
 * @package App
 *
 * @property int $id
 * @property string $condition_id
 * @property string $partnerId
 * @property string $partnerType
 */
class ConditionPartner extends Model
{
    protected $fillable = [
        'condition_id',
        'partnerId',
        'partnerType',
    ];

    public function condition()
    {
        return $this->belongsTo('App\Condition', 'condition_id');
    }
}
