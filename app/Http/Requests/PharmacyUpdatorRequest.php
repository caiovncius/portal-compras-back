<?php

namespace App\Http\Requests;

use App\Pharmacy;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="PharmacyUpdaterRequest",
 *     type="object",
 *     title="Pharmacy update form request",
 *     @OA\Property(property="code", type="string", example="234234"),
 *     @OA\Property(property="socialName", type="string", example="Company ltda"),
 *     @OA\Property(property="name", type="string", example="My Company"),
 *     @OA\Property(property="status", type="string", example="ACTIVE"),
 *     @OA\Property(property="cnpj", type="string", example="99.999.999/0001-91"),
 *     @OA\Property(property="stateRegistration", type="string", example="424343"),
 *     @OA\Property(property="email", type="string", example="email@example.com"),
 *     @OA\Property(property="phone", type="string", example="(11) 9 9999-9999"),
 *     @OA\Property(property="supervisorId", type="string", example="1"),
 *     @OA\Property(property="partnerPriority", type="string", example="12"),
 *     @OA\Property(property="address", type="string", example="Rua 12"),
 *     @OA\Property(property="address2", type="string", example="Complemento"),
 *     @OA\Property(property="addressNumber", type="string", example="12"),
 *     @OA\Property(property="district", type="string", example="Bairro"),
 *     @OA\Property(property="zipCode", type="string", example="74000-00"),
 *     @OA\Property(property="cityId", type="int", example="3"),
 * )
 */
class PharmacyUpdatorRequest extends FormRequest
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
            'code' => 'required|string',
            'cnpj' => 'required|cnpj',
            'socialName' => 'required|string',
            'status' => 'required|in:ACTIVE,INACTIVE',
            'cityId' => 'required|integer|exists:cities,id',
            'commercial' => 'required|string',
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
            'socialName' => 'Razão social',
            'cityId' => 'Cidade',
            'commercial' => 'Comercial',
        ];
    }
}
