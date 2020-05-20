<?php

namespace App;

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
    /**
     * @var bool
     */
    public $timestamps = false;

    protected $fillable = [
        'name',
        'key'
    ];
}
