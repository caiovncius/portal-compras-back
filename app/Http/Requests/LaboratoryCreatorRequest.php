<?php

namespace App\Http\Requests;

use App\Laboratory;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="LaboratoryCreatorRequest",
 *     type="object",
 *     title="Laboratory form request",
 *     required={"code", "status", "name"},
 *     @OA\Property(property="code", type="integer", example="01"),
 *     @OA\Property(property="status", type="string", example="ACTIVE"),
 *     @OA\Property(property="name", type="string", example="Teste"),
 * )
 */
class LaboratoryCreatorRequest extends FormRequest
{
    /**
     * Determine if the laboratory is authorized to make this request.
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
            'code' => 'required|string|unique:laboratories',
            'name' => 'required|string',
            'status' => 'required|in:ACTIVE,INACTIVE'
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
