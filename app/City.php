<?php

namespace App;

use App\Traits\Models\CityRelations;
use Illuminate\Database\Eloquent\Model;

/**
 * Class City
 * @package App
 *
 * @property int $id
 * @property string $name
 * @property int $state_id
 */
class City extends Model
{
    use CityRelations;

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'state_id'
    ];
}
