<?php

namespace App;

use App\Traits\Models\FunctionalityRelations;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Functionality
 * @package App
 *
 * @property int $id
 * @property string $key
 * @property string $name
 */
class Functionality extends Model
{
    use FunctionalityRelations;
    /**
     * @var bool
     */
    public $timestamps = false;

    protected $fillable = [
        'name',
        'key'
    ];
}
