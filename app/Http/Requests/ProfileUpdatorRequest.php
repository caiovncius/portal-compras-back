<?php

namespace App\Http\Requests;

use App\Profile;
use App\User;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="ProfileUpdatorRequest",
 *     type="object",
 *     title="Profile form request",
 *     required={"name", "type", "status"},
 *     @OA\Property(property="name", type="string", example="Manager"),
 *     @OA\Property(property="type", ref="#/components/schemas/UserType"),
 *     @OA\Property(property="status", ref="#/components/schemas/UserStatus"),
 *     @OA\Property(
 *         property="functions",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/ProfileFunctions")
 *     ),
 * )
 */
class ProfileUpdatorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'string|required',
            'type' => 'required|in:' . User::USER_TYPE_MASTER . ',' . User::USER_TYPE_COMMERCIAL . ',' . User::USER_TYPE_PHARMACY,
            'status' => 'required|in:' . User::USER_STATUS_ACTIVE . ',' . User::USER_STATUS_INACTIVE,
            'permissions' => 'array|min:1',
            'permissions.*.functionality' => 'required',
            'permissions.*.permission' => 'in:' . Profile::PERMISSION_TYPE_NO_ACCESS . ','
                . Profile::PERMISSION_TYPE_READ_ACCESS . ','
                . Profile::PERMISSION_TYPE_FREE_ACCESS
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'name' => 'Nome',
            'type' => 'Tipo',
            'permissions.*.functionality' => 'Funcionalidade',
            'permissions.*.permission' => 'Permissão'
        ];
    }
}
