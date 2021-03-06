<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="OfferPortalResource",
 *     type="object",
 *     title="Offer Portal Response",
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
 * )
 */

class OfferPortalResource extends JsonResource
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
            'image' => is_null($this->image) ? null : env('APP_URL') . $this->image,
            'code' => $this->code,
            'name' => $this->name,
            'startDate' => $this->start_date,
            'endDate' => $this->end_date,
            'condition' => $this->condition ? $this->condition->description : '',
            'minimumPrice' => $this->minimum_price,
            'offerType' => $this->offer_type,
            'sendType' => $this->send_type,
            'noAutomaticSending' => $this->no_automatic_sending,
            'impound' => $this->impound,
            'description' => $this->description,
            'hasRequest' => $this->hasRequest,
            'requestId' => $this->requestId,
        ];
    }
}
