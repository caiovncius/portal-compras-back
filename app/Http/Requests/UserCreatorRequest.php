<?php

namespace App\Http\Requests;

use App\User;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="UserCreatorRequest",
 *     type="object",
 *     title="User form request",
 *     required={"name", "email", "username", "profile_id", "type", "status"},
 *     @OA\Property(property="name", type="string", example="Usuário Teste"),
 *     @OA\Property(property="email", type="string", example="user01@test.test"),
 *     @OA\Property(property="username", type="string", example="user01"),
 *     @OA\Property(property="phone1", type="string", example="(62) 9 9999-9999"),
 *     @OA\Property(property="phone2", type="string", example="(62) 9 9999-9999"),
 *     @OA\Property(property="status", ref="#/components/schemas/UserStatus"),
 *     @OA\Property(property="type", ref="#/components/schemas/UserType"),
 *     @OA\Property(property="profileId", type="integer", example="2"),
 * )
 */
class UserCreatorRequest extends FormRequest
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
            'name' => 'required|string',
            'username' => 'required|string|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'type' => 'required|in:' . User::USER_TYPE_SUPPLIER . ',' . User::USER_TYPE_COMMERCIAL . ',' . User::USER_TYPE_PHARMACY,
            'status' => 'required|in:' . User::USER_STATUS_ACTIVE . ',' . User::USER_STATUS_INACTIVE,
            'profileId' => 'required|exists:profiles,id',
            'phone1' => 'string',
            'phone2' => 'string',
        ];
    }
}
