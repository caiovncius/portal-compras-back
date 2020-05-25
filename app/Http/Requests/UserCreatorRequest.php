<?php

namespace App\Http\Requests;

use App\User;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *   schema="UserStatus",
 *   type="string",
 *   enum={"ACTIVE", "INACTIVE"}
 * )
 *
 * @OA\Schema(
 *   schema="UserType",
 *   type="string",
 *   enum={"COMMERCIAL", "PHARMACY", "SUPPLIER"}
 * )
 *
 * @OA\Parameter(
 *     name="Authorization",
 *     in="header",
 *     required=true
 * )
 *
 * @OA\Schema(
 *   schema="ValidationResponse",
 *   @OA\Property(property="message", type="string", example="The given data was invalid."),
 *   @OA\Property(
 *     property="errors",
 *     type="array",
 *     @OA\Items(
 *         type="array",
 *         @OA\Items(type="string"),
 *         example="Campo teste é obrigatório",
 *     ),
 *   )
 * )
 *
 * @OA\Schema(
 *     schema="UserCreatorRequest",
 *     type="object",
 *     title="User form request",
 *     required={"name", "email", "username", "profile_id", "type", "status"},
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
            'profile_id' => 'required|exists:profiles,id',
            'phone_1' => 'numeric',
            'phone_2' => 'numeric',
        ];
    }
}
