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
 *     @OA\Property(property="phone1", type="string", example="(62) 9 9999-9999"),
 *     @OA\Property(property="phone2", type="string", example="(62) 9 9999-9999"),
 *     @OA\Property(property="status", ref="#/components/schemas/UserStatus"),
 *     @OA\Property(property="type", ref="#/components/schemas/UserType"),
 *     @OA\Property(property="profileId", type="integer", example="2"),
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
            'name' => 'string',
            'email' => 'email|unique:users,email,' . $this->id,
            'type' => 'in:' . User::USER_TYPE_MASTER . ',' . User::USER_TYPE_COMMERCIAL . ',' . User::USER_TYPE_PHARMACY,
            'status' => 'in:' . User::USER_STATUS_ACTIVE . ',' . User::USER_STATUS_INACTIVE,
            'profileId' => 'exists:profiles,id',
            'phone1' => 'string|nullable',
            'phone2' => 'string|nullable',
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
            'username' => 'Login',
            'type' => 'Tipo',
            'profileId' => 'Perfil',
            'phone1' => 'Telefone',
            'phone2' => 'Telefone 2',
        ];
    }
}
