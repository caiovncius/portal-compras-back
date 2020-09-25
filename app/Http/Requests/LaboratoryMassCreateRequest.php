<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="LaboratoryMassCreatorRequest",
 *     type="object",
 *     title="Laboratory mass form request",
 *     required={"data"},
 *     @OA\Property(
 *         property="data",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/LaboratoryCreatorRequest")
 *     ),
 * )
 */
class LaboratoryMassCreateRequest extends FormRequest
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
            'data.*.code' => 'required|string|unique:laboratories,code',
            'data.*.name' => 'required|string',
            'data.*.status' => 'nullable|in:ACTIVE,INACTIVE',
            'data.*.contacts' => 'array',
            'data.*.contacts.*.name' => 'string|required',
            'data.*.contacts.*.email' => 'email|required',
            'data.*.contacts.*.function' => 'string|required',
            'data.*.contacts.*.telephone' => 'string|required',
        ];
    }
}
