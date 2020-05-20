<?php

namespace App;

use App\Traits\Models\StateRelations;
use App\Traits\Models\StateScopes;
use Illuminate\Database\Eloquent\Model;

/**
 * Class State
 * @package App
 *
 * @property int $id
 * @property string $name
 * @property string $code
 */
class State extends Model
{
    use StateRelations, StateScopes;

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'code'
    ];
}
