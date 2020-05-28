<?php

namespace App;

use App\Traits\Models\ProfileRelations;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Profile
 * @package App
 *
 * @property int $id
 * @property string $name
 * @property string $type
 * @property string $status
 */
class Profile extends Model
{
    use ProfileRelations;

    const PERMISSION_TYPE_FREE_ACCESS = 'FREE_ACCESS';
    const PERMISSION_TYPE_READ_ACCESS = 'READ_ACCESS';
    const PERMISSION_TYPE_NO_ACCESS = 'NO_ACCESS';

    protected $fillable = [
        'name',
        'type',
        'status'
    ];
}
