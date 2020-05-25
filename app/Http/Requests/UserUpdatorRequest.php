<?php

namespace App\Http\Requests;

use App\User;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="UserUpdaterRequest",
 *     type="object",
 *     title="User update form request",
 *     @OA\Property(property="name", type="string", example="Usuário Teste"),
 *     @OA\Property(property="email", type="string", example="user01@test.test"),
 *     @OA\Property(property="username", type="string", example="user01"),
 *     @OA\Property(property="phone_1", type="string", example="(62) 9 9999-9999"),
 *     @OA\Property(property="phone_2", type="string", example="(62) 9 9999-9999"),
 *     @OA\Property(property="status", ref="#/components/schemas/UserStatus"),
 *     @OA\Property(property="type", ref="#/components/schemas/UserType"),
 *     @OA\Property(property="profile_id", type="integer", example="2"),
 * )
 */
class UserUpdatorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'string',
            'email' => 'email|unique:users,email,' . $this->id,
            'type' => 'in:' . User::USER_TYPE_SUPPLIER . ',' . User::USER_TYPE_COMMERCIAL . ',' . User::USER_TYPE_PHARMACY,
            'status' => 'in:' . User::USER_STATUS_ACTIVE . ',' . User::USER_STATUS_INACTIVE,
            'profile_id' => 'exists:profiles,id',
            'phone_1' => 'string',
            'phone_2' => 'string',
        ];
    }
}
