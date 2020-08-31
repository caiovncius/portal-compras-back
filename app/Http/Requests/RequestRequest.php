<?php

namespace App\Http\Requests;

use App\Request;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="RequestRequest",
 *     type="object",
 *     title="Request form request",
 *     required={"pharmacy_id", "offer_id", "status"},
 *     @OA\Property(property="pharmacy_id", type="integer", example="001"),
 *     @OA\Property(property="offer_id", type="string", example="Teste"),
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
            'offerId' => 'required|exists:offers,id',
            'modelId' => 'required',
            'modelType' => 'required',
            'pharmacyId' => 'required|exists:pharmacies,id',
            'status' => 'required|in:ACTIVE,INACTIVE',
            'products' => 'array|nullable',
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
            'modelId' => 'Model(enviar via formhidden)',
            'modelType' => 'Model(enviar via formhidden(OFFER ou PURCHASE))',
            'pharmacyId' => 'Farmácia',
            'status' => 'Status',
        ];
    }
}
