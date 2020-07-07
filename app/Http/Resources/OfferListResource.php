<?php

namespace App\Http\Resources;

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
 *     @OA\Property(
 *         property="email",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/Email")
 *     ), 
 *     @OA\Property(
 *         property="partners",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/DistributorListResource")
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
            'image' => $this->image,
            'code' => $this->code,
            'name' => $this->name,
            'status' => $this->status,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            'condition' => $this->condition,
            'minimumPrice' => $this->minimumPrice,
            'offerType' => $this->offerType,
            'sendType' => $this->sendType,
            'noAutomaticSending' => $this->noAutomaticSending,
            'impound' => $this->impound,
            'description' => $this->description,
            'emails' => $this->emails,
            'partners' => DistributorListResource::collection($this->partners),
        ];
    }
}
