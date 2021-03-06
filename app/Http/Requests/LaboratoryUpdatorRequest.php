<?php

namespace App\Http\Requests;

use App\Laboratory;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="LaboratoryUpdaterRequest",
 *     type="object",
 *     title="Laboratory update form request",
 *     @OA\Property(property="code", type="integer", example="01"),
 *     @OA\Property(property="status", type="string", example="ACTIVE"),
 *     @OA\Property(property="name", type="string", example="Teste"),
 *     @OA\Property(
 *         property="contacts",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/ContactCreatorRequest")
 *     ),
 * )
 */
class LaboratoryUpdatorRequest extends FormRequest
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
            'code' => 'required|string|unique:laboratories,code,' . $this->id,
            'status' => 'nullable|in:ACTIVE,INACTIVE',
            'name' => 'required|string',
            'contacts' => 'array',
            'contacts.*.name' => 'string|required',
            'contacts.*.email' => 'email|required',
            'contacts.*.function' => 'string|required',
            'contacts.*.telephone' => 'string|required',
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
            'status' => 'Status',
        ];
    }
}
