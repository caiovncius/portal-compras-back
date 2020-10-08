<?php

namespace App\Http\Requests;

use App\Program;
use Illuminate\Foundation\Http\FormRequest;


/**
 * @OA\Schema(
 *     schema="ProgramMassFormCreatorRequest",
 *     type="object",
 *     title="Program form request",
 *     required={"code", "name", "status"},
 *     @OA\Property(property="code", type="integer", example="001"),
 *     @OA\Property(property="name", type="string", example="Teste"),
 *     @OA\Property(property="status", ref="#/components/schemas/UserStatus"),
 * )
 */

/**
 * @OA\Schema(
 *     schema="ProgramMassCreatorRequest",
 *     type="object",
 *     title="Program mass form request",
 *     required={"data"},
 *     @OA\Property(
 *         property="data",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/ProgramMassFormCreatorRequest")
 *     ),
 * )
 */
class ProgramMassCreatorRequest extends FormRequest
{
    /**
     * Determine if the Program is authorized to make this request.
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

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'data.*.code' => 'Código',
            'data.*.name' => 'Nome',
            'data.*.contacts.*.function' => 'Função',
            'data.*.contacts.*.name' => 'Nome',
            'data.*.contacts.*.email' => 'Email',
            'data.*.contacts.*.telephone' => 'Telefone',
        ];
    }
}
