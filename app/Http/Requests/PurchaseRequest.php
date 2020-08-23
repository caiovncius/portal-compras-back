<?php

namespace App\Http\Requests;

use App\Purchase;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="PurchaseRequest",
 *     type="object",
 *     title="Purchase form request",
 *     required={"code", "name", "status", "description", "offer_id"},
 *     @OA\Property(property="code", type="integer", example="001"),
 *     @OA\Property(property="image", type="integer", example="001"),
 *     @OA\Property(property="name", type="string", example="Teste"),
 *     @OA\Property(property="description", type="string", example="Teste"),
*     @OA\Property(property="validityStart",  type="date", example="2020-05-25"),
 *     @OA\Property(property="validityEnd",  type="date", example="2020-05-25"),
 *     @OA\Property(property="status",  type="string", example="ACTIVE"),
 *     @OA\Property(property="sendType",  type="string", example="Teste"),
 *     @OA\Property(property="untilBilling", type="boolean", example="1"),
 *     @OA\Property(property="setMinimumBillingValue", type="integer", example="1"),
 *     @OA\Property(property="minimumBillingValue", type="integer", example="1"),
 *     @OA\Property(property="setMinimumBillingQuantity", type="integer", example="1"),
 *     @OA\Property(property="minimumBillingQuantity", type="integer", example="1"),
 *     @OA\Property(property="totalIntentionsValue", type="integer", example="1"),
 *     @OA\Property(property="totalIntentionsQuantity", type="integer", example="1"),
 *     @OA\Property(property="relatedQuantity", type="integer", example="1"),
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
 *     @OA\Property(property="productOnName", type="string", example="Teste"),
 *     @OA\Property(property="quantityMaximum", type="integer", example="6"),
 *     @OA\Property(property="quantityMinimum", type="integer", example="10"),
 *     @OA\Property(property="state_id", type="string", example="5"),
 *     @OA\Property(property="product_id", type="string", example="5"),
           )
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
            'offerId' => 'required|exists:offers,id',
            'code' => 'required|string|numeric|unique:offers',
            'name' => 'required|string',
            'description' => 'required|string',
            'status' => 'required|in:ACTIVE,INACTIVE',
            'validityStart' => 'date',
            'validityEnd' => 'date|after_or_equal:validityStart',
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
        ];
    }
}
