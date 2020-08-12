<?php

namespace App;

use App\Traits\Models\ProfileRelations;
use App\Traits\Models\ProfileScopes;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Profile
 * @package App
 *
 * @property int $id
 * @property string $name
 * @property string $type
 * @property string $status
 * @property int $updated_id
 */
class Profile extends Model
{
    use ProfileRelations, ProfileScopes;

    /// User status
    const PROFILE_STATUS_ACTIVE = 'ACTIVE';
    const PROFILE_STATUS_INACTIVE = 'INACTIVE';

    /// User types
    const PROFILE_TYPE_COMMERCIAL = 'COMMERCIAL';
    const PROFILE_TYPE_PHARMACY = 'PHARMACY';
    const PROFILE_TYPE_SUPPLIER = 'SUPPLIER';
    const PROFILE_TYPE_MASTER = 'MASTER';

    const PERMISSION_TYPE_FREE_ACCESS = 'FREE_ACCESS';
    const PERMISSION_TYPE_READ_ACCESS = 'READ_ACCESS';
    const PERMISSION_TYPE_NO_ACCESS = 'NO_ACCESS';

    protected $fillable = [
        'name',
        'type',
        'status'
    ];
}
