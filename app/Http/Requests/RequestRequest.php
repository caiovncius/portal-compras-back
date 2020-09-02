<?php

namespace App\Http\Requests;

use App\Request;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="RequestRequest",
 *     type="object",
 *     title="Request form request",
 *     required={"pharmacyId", "status", "modelId", "modelType"},
 *     @OA\Property(property="pharmacyId", type="integer", example="001"),
 *     @OA\Property(property="status", type="string", example="ACTIVE"),
 *     @OA\Property(property="modelId", type="string", example="1"),
 *     @OA\Property(property="modelType", type="string", example="OFFER"),
 *     @OA\Property(
 *         property="products",
 *         type="array",
 *         @OA\Items(
 *     @OA\Property(property="productId", type="integer", example="1"),
 *     @OA\Property(property="quantity", type="integer", example="1"),
 *         )
 *     ),
 * )
 */
class RequestRequest extends FormRequest
{
    /**
     * Determine if the Offer is authorized to make this request.
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
            'modelId' => 'required',
            'modelType' => 'required',
            'pharmacyId' => 'required|exists:pharmacies,id',
            'status' => 'required|in:ACTIVE,INACTIVE',
            'products' => 'array|required',
            'products.*.productId' => 'required|exists:products,id',
            'products.*.quantity' => 'required|numeric',
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
            'offerId' => 'Oferta',
            'modelId' => 'modelId',
            'modelType' => 'ModelType',
            'pharmacyId' => 'Farmácia',
            'status' => 'Status',
        ];
    }
}
