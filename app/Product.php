<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Product
 * @package App
 *
 * @property int $id
 * @property string $code
 * @property string $code_ean
 * @property string $description
 * @property string $status
 * @property int $laboratory_id
 * @property int $updated_id
 */
class Product extends Model
{
    protected $fillable = [
        'code',
        'code_ean',
        'description',
        'status',
        'laboratory_id',
        'updated_id'
    ];

    public function laboratory()
    {
        return $this->belongsTo(Laboratory::class, 'laboratory_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'updated_id');
    }

    public function requests()
    {
        return $this->belongsToMany('App\Request')
                    ->withPivot(['qtd', 'value', 'total']);
    }
}
