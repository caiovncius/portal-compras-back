<?php

namespace App;

use App\Distributor;
use App\Program;
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

    public function getPartnerAttribute()
    {
    	$model = $this->partnerType == 'DISTRIBUTOR' ? Distributor::find($this->partnerId) : Program::find($this->partnerId);

    	return $model;
    }
}
