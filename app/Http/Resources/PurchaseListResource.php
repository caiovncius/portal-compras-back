<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="PurchaseListResource",
 *     type="object",
 *     title="Purchase Response",
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
 *     @OA\Property(property="updated_user", type="string", example="Nome usuário"),
 *     @OA\Property(property="updated_date", type="string", example="2020-05-01 10:00:00"),
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
            'image' => $this->image,
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
            'products' => ProductResource::collection($this->products),
            'updated_user' => $this->user ? $this->user->name : '',
            'updated_date' => $this->updated_at
        ];
    }
}
