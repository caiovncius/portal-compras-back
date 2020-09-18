<?php

namespace App\Http\Requests;

use App\Distributor;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="DistributorUpdatorRequest",
 *     type="object",
 *     title="Distributor update form request",
 *     @OA\Property(property="code", type="integer", example="001"),
 *     @OA\Property(property="cnpj", type="integer", example="00.0001/0004.14"),
 *     @OA\Property(property="name", type="string", example="Teste"),
 *     @OA\Property(property="category", type="string", example="NATIONAL or REGIONAL"),
 *     @OA\Property(property="stateId", type="integer", example="2"),
 *     @OA\Property(property="status", ref="#/components/schemas/UserStatus"),
 * )
 */
class DistributorUpdatorRequest extends FormRequest
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
            'code' => 'required|string',
            'cnpj' => 'required|cnpj',
            'name' => 'required|string',
            'status' => 'in:ACTIVE,INACTIVE',
            'category' => 'required|in:NATIONAL,REGIONAL',
            'stateId' => 'required',
            'contacts' => 'nullable|array',
            'contacts.*.function' => 'required|string',
            'contacts.*.name' => 'required|string',
            'contacts.*.email' => 'required|email',
            'contacts.*.telephone' => 'required|string',
            'returns' => 'array|nullable',
            'returns.*.code' => 'required|string|unique:returns,code,returnable_type,' . $this->id,
            'returns.*.description' => 'required|string',
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
