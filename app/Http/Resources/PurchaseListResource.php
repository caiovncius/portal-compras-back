<?php

namespace App\Http\Resources;

use App\Http\Resources\PartnerListResource;
use App\Http\Resources\ProductDetailResource;
use App\ProductDetail;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="PurchaseListResource",
 *     type="object",
 *     title="Purchase Response",
 *     @OA\Property(property="code", type="integer", example="001"),
 *     @OA\Property(property="image", type="string", example="001"),
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
 *     @OA\Property(property="updated_user", type="string", example="Nome usuário"),
 *     @OA\Property(property="updated_date", type="string", example="2020-05-01 10:00:00"),
 *     @OA\Property(property="billedDate", type="string", example="2020-05-01 10:00:00"),
 *     @OA\Property(
 *         property="partners",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/PartnerListResource")
 *     ),
 *     @OA\Property(
 *         property="products",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/ProductDetailResource")
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
class PurchaseListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'image' => env('APP_URL') . $this->image,
            'code' => $this->code,
            'name' => $this->name,
            'sendType' => $this->send_type,
            'status' => $this->status,
            'validityStart' => $this->validity_start,
            'validityEnd' => $this->validity_end,
            'untilBilling' => $this->until_billing,
            'setMinimumBillingValue' => $this->set_minimum_billing_value,
            'minimumBillingValue' => $this->minimum_billing_value,
            'setMinimumBillingQuantity' => $this->set_minimum_billing_quantity,
            'minimumBillingQuantity' => $this->minimum_billing_quantity,
            'totalIntentionsValue' => $this->total_intentions_value,
            'totalIntentionsQuantity' => $this->total_intentions_quantity,
            'relatedQuantity' => $this->related_quantity,
            'description' => $this->description,
            'partnerType' => !is_null($this->partner) ? $this->partner->partner_type : null,
            'partner' => !is_null($this->partner) ?  PartnerListResource::make($this->partner) : null,
            'contacts' => $this->contacts,
            'hasRequest' => $this->when($request->get('pharmacyId'), function() use($request) {
                return $this->requests()->where('pharmacy_id', $request->get('pharmacyId'))->count() > 0;
            }),
            'products' => ProductDetailResource::collection($this->products),
            'updated_user' => $this->user ? $this->user->name : '',
            'updated_date' => $this->updated_at,
            'billedDate' => $this->billed_date,
        ];
    }
}
