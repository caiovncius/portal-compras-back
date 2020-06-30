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
 */
class Product extends Model
{
    protected $fillable = [
        'code',
        'code_ean',
        'description',
        'status',
        'laboratory_id'
    ];

    public function laboratory()
    {
        return $this->belongsTo(Laboratory::class, 'laboratory_id');
    }
}
