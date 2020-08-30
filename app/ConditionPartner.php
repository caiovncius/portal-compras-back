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
 * @property string $partner_id
 * @property string $partner_type
 */
class ConditionPartner extends Model
{
    protected $fillable = [
        'condition_id',
        'partner_id',
        'partner_type',
    ];

    const PARTNER_TYPE_DISTRIBUTOR = 'DISTRIBUTOR';
    const PARTNER_TYPE_PROGRAM = 'PROGRAM';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function condition()
    {
        return $this->belongsTo('App\Condition', 'condition_id');
    }

    /**
     * @return mixed
     */
    public function getPartnerAttribute()
    {
        if (is_null($this->partner_type)) return null;
        return $this->partner_type == self::PARTNER_TYPE_DISTRIBUTOR ? Distributor::find($this->partner_id) : Program::find($this->partner_id);
    }

}
