<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="RequestProductResource",
 *     type="object",
 *     title="RequestProductResource Response",
 *     @OA\Property(property="offerProduct", ref="#/components/schemas/OfferProductResource"),
 *     @OA\Property(property="qtd", type="string", example="2"),
 *     @OA\Property(property="value", type="string", example="10"),
 *     @OA\Property(property="total", type="string", example="20"),
 * )
 */

class RequestProductResource extends JsonResource
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
            'offerProduct' => OfferProductResource::make($this->offer_product),
            'qtd' => $this->pivot->qtd,
            'value' => $this->offer_product->priceOnCash,
            'total' => $this->offer_product->priceOnCash * $this->pivot->qtd,
        ];
    }
}
