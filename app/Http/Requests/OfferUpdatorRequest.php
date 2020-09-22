<?php

namespace App\Http\Requests;

use App\Offer;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="OfferUpdatorRequest",
 *     type="object",
 *     title="Offer update form request",
 *     @OA\Property(property="code", type="integer", example="001"),
 *     @OA\Property(property="name", type="string", example="Teste"),
*     @OA\Property(property="startDate",  type="datetime", example="2020-05-25T05:09:15.000000Z"),
 *     @OA\Property(property="endDate",  type="datetime", example="2020-05-25T05:09:15.000000Z"),
 *     @OA\Property(property="condition",  type="integer", example="1"),
 *     @OA\Property(property="minimumPrice",  type="string", example="500"),
 *     @OA\Property(property="offerType",  type="string", example="null"),
 *     @OA\Property(property="sendType",  type="string", example="null"),
 *     @OA\Property(property="noAutomaticSending",  type="boolean", example="true"),
 *     @OA\Property(property="impound",  type="boolean", example="false"),
 *     @OA\Property(property="description",  type="string", example="asdasd"),
 *     @OA\Property(property="emails", ref="#/components/schemas/Email"),
 *     @OA\Property(
 *         property="partners",
 *         type="array",
 *         @OA\Items(
 *     @OA\Property(property="id", type="string", example="1"),
 *     @OA\Property(property="type", type="string", example="PROVIDER"),
 *     @OA\Property(property="ol", type="integer", example="1"),
 *     @OA\Property(property="priority", type="integer", example="1"),
 *         )
 *     ),
 *     @OA\Property(
 *         property="products",
 *         type="array",
 *         @OA\Items(
 *     @OA\Property(property="discountDeferred", type="string", example="2"),
 *     @OA\Property(property="discountOnCash", type="string", example="4"),
 *     @OA\Property(property="minimum", type="integer", example="10"),
 *     @OA\Property(property="minimumPerFamily", type="integer", example="15"),
 *     @OA\Property(property="obrigatory", type="boolean", example="1"),
 *     @OA\Property(property="variable", type="boolean", example="1"),
 *     @OA\Property(property="family", type="boolean", example="0"),
 *     @OA\Property(property="gift", type="boolean", example="0"),
 *     @OA\Property(property="factoryPrice", type="string", example="10.00"),
 *     @OA\Property(property="priceDeferred", type="string", example="11.00"),
 *     @OA\Property(property="priceOnCash", type="string", example="10.51"),
 *     @OA\Property(property="productName", type="string", example="Teste"),
 *     @OA\Property(property="quantityMaximum", type="integer", example="6"),
 *     @OA\Property(property="quantityMinimum", type="integer", example="10"),
 *     @OA\Property(property="stateId", type="string", example="5"),
 *     @OA\Property(property="productId", type="string", example="5"),
           )
 *     ),
 * )
 */
class OfferUpdatorRequest extends FormRequest
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
            'code' => 'string',
            'name' => 'required|string',
            'description' => 'nullable|string',
            'status' => 'nullable|in:ACTIVE,INACTIVE',
            'sendType' => 'nullable|in:MANUAL,AUTOMATIC',
            'offerType' => 'nullable|in:NORMAL,COMBO,COLLECTIVE_BUYING',
            'startDate' => 'required|date',
            'endDate' => 'required|date|after_or_equal:startDate',
            'conditionId' => 'exists:conditions,id',
            'partners' => 'array|nullable',
            'partners.*.id' => 'required|numeric',
            'partners.*.type' => 'required|string',
            'partners.*.ol' => 'required|numeric',
            'partners.*.priority' => 'required|numeric',
            'products' => 'array|nullable',
            'products.*.product.id' => 'required',
            'products.*.discountDeferred' => 'required|numeric',
            'products.*.discountOnCash' => 'required|numeric',
            'products.*.minimum' => 'nullable',
            'products.*.minimumPerFamily' => 'required|required',
            'products.*.obrigatory' => 'boolean',
            'products.*.factoryPrice' => 'string|nullable',
            'products.*.priceDeferred' => 'required|numeric',
            'products.*.priceOnCash' => 'required|numeric',
            'products.*.quantityMaximum' => 'numeric|nullable',
            'products.*.quantityMinimum' => 'numeric|nullable',
            'products.*.stateId' => 'required|required',
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
            'sendType' => 'Tipo de envio',
            'offer_type' => 'Tipo de oferta',
            'description' => 'Descrição',
            'sendType' => 'Tipo de Envio',
            'startDate' => 'Data inicial',
            'endDate' => 'Data final',
        ];
    }
}
