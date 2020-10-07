<?php

namespace App\Http\Requests;

use App\Purchase;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="PurchaseRequest",
 *     type="object",
 *     title="Purchase form request",
 *     required={"code", "name", "billingMeasure", "sendType", "minimumBillingValue", "minimumBillingQuantity"},
 *     @OA\Property(property="code", type="integer", example="001"),
 *     @OA\Property(property="image", type="integer", example="001"),
 *     @OA\Property(property="name", type="string", example="Teste"),
 *     @OA\Property(property="description", type="string", example="Teste"),
 *     @OA\Property(property="billingMeasure", type="string", example="Teste"),
*      @OA\Property(property="validityStart",  type="date", example="2020-05-25"),
 *     @OA\Property(property="validityEnd",  type="date", example="2020-05-25"),
 *     @OA\Property(property="status",  type="string", example="OPEN"),
 *     @OA\Property(property="sendType",  type="string", example="Teste"),
 *     @OA\Property(property="untilBilling", type="boolean", example="1"),
 *     @OA\Property(property="setMinimumBillingValue", type="integer", example="1"),
 *     @OA\Property(property="minimumBillingValue", type="integer", example="1"),
 *     @OA\Property(property="setMinimumBillingQuantity", type="integer", example="1"),
 *     @OA\Property(property="minimumBillingQuantity", type="integer", example="1"),
 *     @OA\Property(property="totalIntentionsValue", type="integer", example="1"),
 *     @OA\Property(property="totalIntentionsQuantity", type="integer", example="1"),
 *     @OA\Property(property="relatedQuantity", type="integer", example="1"),
 *     @OA\Property(property="patnerType", type="string", example="DISTRIBUTOR or PROGRAM"),
 *     @OA\Property(property="partner", type="integer", example="1"),
 *     @OA\Property(
 *         property="products",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/ProductDetailRequest")
 *     ),
 *     @OA\Property(
 *         property="contacts",
 *         type="array",
 *         @OA\Items(
 *             @OA\Property(property="send", type="string", example="TO"),
 *             @OA\Property(property="email", type="string", example="teste@gmail.com"),
 *         )
 *     ),
 * )
 */
class PurchaseRequest extends FormRequest
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
            'code' => 'required|string|unique:purchases,code,' . $this->id,
            'name' => 'required|string',
            'description' => 'nullable|string',
            'status' => 'nullable|in:OPEN,LATE,READY_SEND,BILLED',
            'billingMeasure' => 'required',
            'minimumBillingValue' => 'required_if:billingMeasure,VALUE|nullable',
            'minimumBillingQuantity' => 'required_if:billingMeasure,QUANTITY|nullable',
            'validityStart' => 'date|nullable',
            'validityEnd' => 'date|after_or_equal:validityStart|nullable',
            'partnerType' => 'string|in:DISTRIBUTOR,PROGRAM|nullable',
            'partner' => 'numeric|nullable',
            'products' => 'array|nullable',
            'products.*.productId' => 'required',
            'products.*.discountDeferred' => 'numeric',
            'products.*.discountOnCash' => 'numeric',
            'products.*.minimum' => 'nullable',
            'products.*.minimumPerFamily' => 'required',
            'products.*.obrigatory' => 'boolean',
            'products.*.factoryPrice' => 'string',
            'products.*.priceDeferred' => 'nullable',
            'products.*.priceOnCash' => 'nullable',
            'products.*.quantityMaximum' => 'numeric|nullable',
            'products.*.quantityMinimum' => 'numeric|nullable',
            'products.*.stateId' => 'required',
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
            'description' => 'Descrição',
            'validityStart' => 'Data Vigência inicial',
            'validityEnd' => 'Data Vigência final',
            'minimumBillingValue' => 'Valor mínimo para faturamento',
            'minimumBillingQuantity' => 'Qtd  mínima para faturamento',
        ];
    }
}
