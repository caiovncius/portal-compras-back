<?php

namespace App\Http\Requests;

use App\Distributor;
use Illuminate\Foundation\Http\FormRequest;


/**
 * @OA\Schema(
 *     schema="DistributorCreatorRequest",
 *     type="object",
 *     title="Distributor form request",
 *     required={"code", "cnpj", "name", "status"},
 *     @OA\Property(property="code", type="integer", example="001"),
 *     @OA\Property(property="cnpj", type="integer", example="00.0001/0004.14"),
 *     @OA\Property(property="name", type="string", example="Teste"),
 *     @OA\Property(property="status", ref="#/components/schemas/UserStatus"),
 * )
 */
class DistributorCreatorRequest extends FormRequest
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
            'code' => 'required|string|numeric|unique:distributors',
            'cnpj' => 'required|cnpj',
            'name' => 'required|string',
            'status' => 'required|in:ACTIVE,INACTIVE',
            'contacts' => 'nullable|array',
            'contacts.*.function' => 'required|string',
            'contacts.*.name' => 'required|string',
            'contacts.*.email' => 'required|email',
            'contacts.*.telephone' => 'required|string',
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
            'code' => 'Código',
            'name' => 'Nome',
            'contacts.*.function' => 'Função',
            'contacts.*.name' => 'Nome',
            'contacts.*.email' => 'Email',
            'contacts.*.telephone' => 'Telefone',
        ];
    }
}
