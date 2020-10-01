<?php

namespace App\Http\Requests;

use App\Distributor;
use Illuminate\Foundation\Http\FormRequest;


/**
 * @OA\Schema(
 *     schema="DistributorMassFormCreatorRequest",
 *     type="object",
 *     title="Distributor Mass Form request",
 *     required={"code", "cnpj", "name", "category", "stateId"},
 *     @OA\Property(property="code", type="integer", example="001"),
 *     @OA\Property(property="cnpj", type="integer", example="00.0001/0004.14"),
 *     @OA\Property(property="name", type="string", example="Teste"),
 *     @OA\Property(property="status", ref="#/components/schemas/UserStatus"),
 *     @OA\Property(property="category", type="string", example="NATIONAL or REGIONAL"),
 *     @OA\Property(property="stateId", type="integer", example="2"),
 * )
 */

/**
 * @OA\Schema(
 *     schema="DistributorMassCreatorRequest",
 *     type="object",
 *     title="Distributor mass form request",
 *     required={"data"},
 *     @OA\Property(
 *         property="data",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/DistributorMassFormCreatorRequest")
 *     ),
 * )
 */
class DistributorMassCreatorRequest extends FormRequest
{
    /**
     * Determine if the Distributor is authorized to make this request.
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
            'data.*.code' => 'required|string|unique:distributors,code',
            'data.*.cnpj' => 'required|cnpj|unique:distributors,cnpj',
            'data.*.name' => 'required|string',
            'data.*.status' => 'required|in:ACTIVE,INACTIVE',
            'data.*.category' => 'required|in:NATIONAL,REGIONAL',
            'data.*.stateId' => 'required',
            'data.*.contacts' => 'nullable|array',
            'data.*.contacts.*.function' => 'required|string',
            'data.*.contacts.*.name' => 'required|string',
            'data.*.contacts.*.email' => 'required|email',
            'data.*.contacts.*.telephone' => 'required|string',
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
