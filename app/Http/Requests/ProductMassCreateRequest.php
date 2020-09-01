<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="ProductMassCreatorRequest",
 *     type="object",
 *     title="Product mass form request",
 *     required={"data"},
 *     @OA\Property(
 *         property="data",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/ProductCreatorRequest")
 *     ),
 * )
 */
class ProductMassCreateRequest extends FormRequest
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
            'data.*.code' => 'required|integer|unique:products',
            'data.*.codeEan' => 'required|integer',
            'data.*.description' => 'required|string',
            'data.*.status' => 'nullable|in:ACTIVE,INACTIVE',
            'data.*.laboratoryId' => 'nullable|exists:laboratories,id',
            'data.*.secondaryEanCodes' => 'array',
            'data.*.secondaryEanCodes.*.name' => 'string|required',
        ];
    }
}
