<?php

namespace App;

use App\Traits\Models\LaboratoryScopes;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Laboratory
 * @package App
 *
 * @property int $id
 * @property string $code
 * @property string $name
 * @property string $status
 * @property string $updated_id
 */
class Laboratory extends Model
{
    use LaboratoryScopes;

    protected $fillable = [
        'code',
        'name',
        'status',
        'updated_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'updated_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function contacts()
    {
        return $this->morphMany('App\Contact', 'contactable');
    }
}
