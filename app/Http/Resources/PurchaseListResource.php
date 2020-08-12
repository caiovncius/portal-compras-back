<?php

namespace App\Http\Resources;

use App\Http\Resources\OfferProductResource;
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
            'offerId' => $this->offer_id,
            'image' => $this->image,
            'code' => $this->code,
            'name' => $this->name,
            'sendType' => $this->sendType,
            'status' => $this->status,
            'validityStart' => $this->validityStart,
            'validityEnd' => $this->validityEnd,
            'untilBilling' => $this->untilBilling,
            'setMinimumBillingValue' => $this->setMinimumBillingValue,
            'minimumBillingValue' => $this->minimumBillingValue,
            'setMinimumBillingQuantity' => $this->setMinimumBillingQuantity,
            'minimumBillingQuantity' => $this->minimumBillingQuantity,
            'totalIntentionsValue' => $this->totalIntentionsValue,
            'totalIntentionsQuantity' => $this->totalIntentionsQuantity,
            'relatedQuantity' => $this->relatedQuantity,
            'description' => $this->description,
            'updated_user' => $this->user ? $this->user->name : '',
            'updated_date' => $this->updated_at
        ];
    }
}
