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

    /// User status
    const PROFILE_STATUS_ACTIVE = 'ACTIVE';
    const PROFILE_STATUS_INACTIVE = 'INACTIVE';

    /// User types
    const PROFILE_TYPE_COMMERCIAL = 'COMMERCIAL';
    const PROFILE_TYPE_PHARMACY = 'PHARMACY';
    const PROFILE_TYPE_SUPPLIER = 'SUPPLIER';

    protected $fillable = [
        'name',
        'type',
        'status'
    ];
}
