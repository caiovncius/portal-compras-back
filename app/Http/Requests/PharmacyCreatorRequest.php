<?php

namespace App\Http\Requests;

use App\Pharmacy;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="PharmacyCreatorRequest",
 *     type="object",
 *     title="Pharmacy form request",
 *     required={"code", "cnpj", "name", "socialName"},
 *     @OA\Property(property="code", type="string", example="234234"),
 *     @OA\Property(property="socialName", type="string", example="Company ltda"),
 *     @OA\Property(property="name", type="string", example="My Company"),
 *     @OA\Property(property="status", type="string", example="ACTIVE"),
 *     @OA\Property(property="cnpj", type="string", example="99.999.999/0001-91"),
 *     @OA\Property(property="stateRegistration", type="string", example="424343"),
 *     @OA\Property(property="email", type="string", example="email@example.com"),
 *     @OA\Property(property="phone", type="string", example="(11) 9 9999-9999"),
 *     @OA\Property(property="supervisorId", type="string", example="1"),
 *     @OA\Property(property="partnerPriority", type="integer", example="12"),
 *     @OA\Property(property="address", type="string", example="Rua 12"),
 *     @OA\Property(property="address2", type="string", example="Complemento"),
 *     @OA\Property(property="addressNumber", type="string", example="12"),
 *     @OA\Property(property="district", type="string", example="Bairro"),
 *     @OA\Property(property="zipCode", type="string", example="74000-00"),
 *     @OA\Property(property="cityId", type="int", example="3"),
 *     @OA\Property(
 *         property="contacts",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/ContactCreatorRequest")
 *     ),
 * )
 */
class PharmacyCreatorRequest extends FormRequest
{
    /**
     * Determine if the pharmacy is authorized to make this request.
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
            'code' => 'required|string|unique:pharmacies',
            'socialName' => 'required|string',
            'name' => 'required|string',
            'cnpj' => 'required|cnpj',
            'email' => 'email',
            'status' => 'nullable|in:ACTIVE,INACTIVE',
            'cityId' => 'nullable|integer|exists:cities,id',
            'stateRegistration' => 'string',
            'phone' => 'string',
            'supervisorId' => 'exists:users,id',
            'partnerPriority' => 'numeric|exists:priorities,id',
            'address' => 'string|nullable',
            'address2' => 'string|nullable',
            'addressNumber' => 'string|nullable',
            'district' => 'string|nullable',
            'zipCode' => 'string|nullable',
            'contacts' => 'array',
            'contacts.*.name' => 'string|required',
            'contacts.*.email' => 'email|required',
            'contacts.*.function' => 'string|required',
            'contacts.*.telephone' => 'string|required'
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
