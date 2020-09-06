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
 *     @OA\Property(
 *         property="secondaryEanCodes",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/SecondaryEanCodeCreatorRequest")
 *     ),
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
            'code' => 'required',
            'codeEan' => 'required|integer',
            'description' => 'required|string',
            'status' => 'nullable|in:ACTIVE,INACTIVE',
            'laboratoryId' => 'nullable|exists:laboratories,id',
            'secondaryEanCodes' => 'array',
            'secondaryEanCodes.*.name' => 'string|required',
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
