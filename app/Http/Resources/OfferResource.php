<?php

namespace App\Http\Resources;

use App\Http\Resources\ProductDetailResource;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="OfferResource",
 *     type="object",
 *     title="Offer Response",
 *     @OA\Property(property="id", type="integer", example="1"),
 *     @OA\Property(property="image", type="integer", example="teste.png"),
 *     @OA\Property(property="code", type="integer", example="2"),
 *     @OA\Property(property="name", type="integer", example="teste"),
 *     @OA\Property(property="status", ref="#/components/schemas/UserStatus"),
 *     @OA\Property(property="startDate",  type="datetime", example="2020-05-25T05:09:15.000000Z"),
 *     @OA\Property(property="endDate",  type="datetime", example="2020-05-25T05:09:15.000000Z"),
 *     @OA\Property(property="condition",  type="string", example="name"),
 *     @OA\Property(property="minimumPrice",  type="string", example="500"),
 *     @OA\Property(property="offerType",  type="string", example="null"),
 *     @OA\Property(property="sendType",  type="string", example="null"),
 *     @OA\Property(property="noAutomaticSending",  type="boolean", example="true"),
 *     @OA\Property(property="impound",  type="boolean", example="false"),
 *     @OA\Property(property="description",  type="string", example="asdasd"),
 *     @OA\Property(property="updated_user", type="string", example="Nome usuário"),
 *     @OA\Property(property="updated_date", type="string", example="2020-05-01 10:00:00"),
 * )
 */
class OfferResource extends JsonResource
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
            'image' =>  is_null($this->image) ? null : env('APP_URL') . $this->image,
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
            'minimumPerFamily' => $this->minimum_family,
            'products' => ProductDetailResource::collection($this->products),
            'updated_user' => $this->user ? $this->user->name : '',
            'updated_date' => $this->updated_at
        ];
    }
}
