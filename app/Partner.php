<?php

namespace App;

use App\Distributor;
use App\Program;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Partner
 * @package App
 *
 * @property int $id
 * @property string $partner_id
 * @property string $partner_type
 */
class Partner extends Model
{
    protected $fillable = [
        'partner_id',
        'partner_type',
        'ol',
        'priority'
    ];

    const PARTNER_TYPE_DISTRIBUTOR = 'DISTRIBUTOR';
    const PARTNER_TYPE_PROGRAM = 'PROGRAM';

    public function typable()
    {
        return $this->morphTo();
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
