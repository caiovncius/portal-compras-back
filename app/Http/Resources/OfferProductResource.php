<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="OfferProductResource",
 *     type="object",
 *     title="Offer Product Response",
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
 *     @OA\Property(property="state_id", type="string", example="5"),
 *     @OA\Property(property="product_id", type="string", example="5"),
 * )
 */
class OfferProductResource extends JsonResource
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
            'discountDeferred' => $this->discountDeferred,
            'discountOnCash' => $this->discountOnCash,
            'minimum' => $this->minimum,
            'minimumPerFamily' => $this->minimumPerFamily,
            'obrigatory' => $this->obrigatory,
            'variable' => $this->variable,
            'family' => $this->family,
            'gift' => $this->gift,
            'factoryPrice' => $this->factoryPrice,
            'priceDeferred' => $this->priceDeferred,
            'priceOnCash' => $this->priceOnCash,
            'quantityMaximum' => $this->quantityMaximum,
            'quantityMinimum' => $this->quantityMinimum,
            'state_id' => $this->state_id,
            'product_id' => $this->product_id,
            'productName' => $this->product ? $this->product->name : '',
            'updated_user' => $this->user ? $this->user->name : '',
            'updated_date' => $this->updated_at
        ];
    }
}
