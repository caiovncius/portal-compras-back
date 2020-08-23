<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Condition
 * @package App
 *
 * @property int $id
 * @property string $code
 * @property string $description
 * @property string $status
 * @property string $visible
 * @property string $updated_id
 */
class Condition extends Model
{
    protected $fillable = [
        'description',
        'code',
        'status',
        'visible',
        'updated_id'
    ];

    protected $casts = ['visible' => 'boolean'];

    public function user()
    {
        return $this->belongsTo('App\User', 'updated_id');
    }
}
