<?php

namespace App\Http\Requests;

use App\User;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="UserMassFormCreatorRequest",
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
 *     @OA\Property(property="password", type="string", example="2e59789787n8n7878787e8m7d8ew7be8xb7"),
 * )
 */

/**
 * @OA\Schema(
 *     schema="UserMassCreatorRequest",
 *     type="object",
 *     title="User mass form request",
 *     required={"data"},
 *     @OA\Property(
 *         property="data",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/UserMassFormCreatorRequest")
 *     ),
 * )
 */
class UserMassCreateRequest extends FormRequest
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
            'data' => 'array|required',
        ];
    }
}
