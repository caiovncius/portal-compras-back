<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="OfferProductRequest",
 *     type="object",
 *     title="Offer update form request",
 @OA\Property(
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
 *     @OA\Property(property="productOnName", type="string", example="Teste"),
 *     @OA\Property(property="quantityMaximum", type="integer", example="6"),
 *     @OA\Property(property="quantityMinimum", type="integer", example="10"),
 *     @OA\Property(property="state_id", type="string", example="5"),
           )
 *     ),

 * )
 */
class OfferProductRequest extends FormRequest
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
            'products' => 'array',
            'products.*.discountDeferred' => 'required',
            'products.*.discountOnCash' => 'required',
            'products.*.minimum' => 'required',
            'products.*.minimumPerFamily' => 'required',
            'products.*.obrigatory' => 'required',
            'products.*.variable' => 'required',
            'products.*.family' => 'required',
            'products.*.gift' => 'required',
            'products.*.factoryPrice' => 'required',
            'products.*.priceDeferred' => 'required',
            'products.*.priceOnCash' => 'required',
            'products.*.productOnName' => 'required',
            'products.*.quantityMaximum' => 'required',
            'products.*.quantityMinimum' => 'required',
            'products.*.state_id' => 'required',
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
            'products.*.discountDeferred' => 'Desconto à prazo',
            'products.*.discountOnCash' => 'Desconto à vista',
            'products.*.minimum' => 'Qtd mínima de compra',
            'products.*.minimumPerFamily' => 'QTD mínima por família',
            'products.*.obrigatory' => 'Obrigatório',
            'products.*.variable' => 'Variável',
            'products.*.family' => 'Família',
            'products.*.gift' => 'Presente',
            'products.*.factoryPrice' => 'Preço de fábrica',
            'products.*.priceDeferred' => 'Preço à prazo',
            'products.*.priceOnCash' => 'Preço à vista',
            'products.*.productOnName' => 'Nome do produto',
            'products.*.quantityMaximum' => 'QTD máxima',
            'products.*.quantityMinimum' => 'QTD mínima',
            'products.*.state_id' => 'Estado'
        ];
    }
}
