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
 */
class Laboratory extends Model
{
    use LaboratoryScopes;
    
    protected $fillable = [
        'code',
        'name',
        'status',
    ];
}
