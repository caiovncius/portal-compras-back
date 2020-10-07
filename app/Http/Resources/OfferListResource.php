<?php

namespace App\Http\Resources;

use App\Http\Resources\PartnerListResource;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="OfferListResource",
 *     type="object",
 *     title="Offer List Response",
 *     @OA\Property(property="id", type="integer", example="1"),
 *     @OA\Property(property="code", type="string", example="01"),
 *     @OA\Property(property="name", type="string", example="Teste"),
 *     @OA\Property(property="startDate", type="datetime", example="2019-05-25 03:00:00"),
 *     @OA\Property(property="endDate", type="datetime", example="2019-07-25 03:00:00"),
 *     @OA\Property(property="condition", type="string", example="teste"),
 *     @OA\Property(property="minimumPrice", type="string", example="500"),
 *     @OA\Property(property="offerType", type="string", example="null"),
 *     @OA\Property(property="sendType", type="string", example="null"),
 *     @OA\Property(property="noAutomaticSending", type="boolean", example="true"),
 *     @OA\Property(property="impound", type="boolean", example="false"),
 *     @OA\Property(property="description", type="string", example="asdqwe"),
 *     @OA\Property(property="updated_user", type="string", example="Nome usuário"),
 *     @OA\Property(property="updated_date", type="string", example="2020-05-01 10:00:00"),
 *     @OA\Property(
 *         property="email",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/Email")
 *     ),
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
 * )
 */

class OfferListResource extends JsonResource
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
            'status' => $this->status,
            'startDate' => $this->start_date,
            'endDate' => $this->end_date,
            'condition' => $this->condition_id,
            'minimumPrice' => $this->minimum_price,
            'offerType' => $this->offer_type,
            'sendType' => $this->send_type,
            'noAutomaticSending' => $this->no_automatic_sending,
            'impound' => $this->impound,
            'description' => $this->description,
            'emails' => $this->emails,
            'partners' => PartnerListResource::collection($this->partners),
            'products' => ProductDetailResource::collection($this->products),
            'updated_user' => $this->user ? $this->user->name : '',
            'updated_date' => $this->updated_at
        ];
    }
}
