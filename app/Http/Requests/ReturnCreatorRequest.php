<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


/**
 * @OA\Schema(
 *     schema="ReturnCreatorRequest",
 *     type="object",
 *     title="Return form request",
 *     required={"code", "desc", "status"},
 *     @OA\Property(property="code", type="integer", example="001"),
 *     @OA\Property(property="desc", type="integer", example="TESTE"),
 *     @OA\Property(property="status", ref="#/components/schemas/UserStatus"),
 * )
 */
class ReturnCreatorRequest extends FormRequest
{
    /**
     * Determine if the Return is authorized to make this request.
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
            'code' => 'required|string|unique:returns,code,returnable_type',
            'description' => 'required|string',
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
            'desc' => 'Descrição',
        ];
    }
}
