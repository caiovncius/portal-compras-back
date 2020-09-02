<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="PharmacyMassCreatorRequest",
 *     type="object",
 *     title="Pharmacy mass form request",
 *     required={"data"},
 *     @OA\Property(
 *         property="data",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/PharmacyCreatorRequest")
 *     ),
 * )
 */

class PharmacyMassCreateRequest extends FormRequest
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
            'data.*.code' => 'required|string|unique:pharmacies',
            'data.*.socialName' => 'required|string',
            'data.*.name' => 'required|string',
            'data.*.cnpj' => 'required|cnpj',
            'data.*.email' => 'email',
            'data.*.status' => 'nullable|in:ACTIVE,INACTIVE',
            'data.*.cityId' => 'nullable|integer|exists:cities,id',
            'data.*.stateRegistration' => 'string',
            'data.*.phone' => 'string',
            'data.*.supervisorId' => 'exists:users,id',
            'data.*.partnerPriority' => 'numeric|exists:priorities,id',
            'data.*.address' => 'string|nullable',
            'data.*.address2' => 'string|nullable',
            'data.*.addressNumber' => 'string|nullable',
            'data.*.district' => 'string|nullable',
            'data.*.zipCode' => 'string|nullable',
            'data.*.contacts' => 'array',
            'data.*.contacts.*.name' => 'string|required',
            'data.*.contacts.*.email' => 'email|required',
            'data.*.contacts.*.function' => 'string|required',
            'data.*.contacts.*.telephone' => 'string|required'
        ];
    }
}
