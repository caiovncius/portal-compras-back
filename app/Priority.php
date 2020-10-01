<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Priority
 * @package App
 *
 * @property integer $id
 * @property string $description
 * @property string $status
 */
class Priority extends Model
{

    const PRIORITY_STATUS_ACTIVE = 'ACTIVE';
    const PRIORITY_STATUS_INACTIVE = 'INACTIVE';

    /**
     * @var array
     */
    protected $fillable = [
        'description',
        'status'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function partners()
    {
        return $this->belongsToMany(Distributor::class, 'priority_partners', 'priority_id', 'distributor_id');
    }
}
