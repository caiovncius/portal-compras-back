<?php

namespace App\Http\Requests;

use App\Product;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="ProductUpdaterRequest",
 *     type="object",
 *     title="Product update form request",
 *     @OA\Property(property="code", type="integer", example="001"),
 *     @OA\Property(property="codeEan", type="integer", example="002"),
 *     @OA\Property(property="description", type="string", example="Teste"),
 *     @OA\Property(property="status", ref="#/components/schemas/UserStatus"),
 *     @OA\Property(property="laboratoryId", type="integer", example="2"),
 * )
 */
class ProductUpdatorRequest extends FormRequest
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
            'code' => 'required|string|unique:products',
            'codeEan' => 'required|integer',
            'description' => 'required|string',
            'status' => 'required|in:ACTIVE,INACTIVE',
            'laboratoryId' => 'required|exists:laboratories,id',
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
            'codeEan' => 'Código EAN',
            'description' => 'Descrição',
            'laboratoryId' => 'Laboratório',
        ];
    }
}
