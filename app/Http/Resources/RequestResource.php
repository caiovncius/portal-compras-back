<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="RequestResource",
 *     type="object",
 *     title="Request Response",
 *     @OA\Property(property="pharmacy_id", type="integer", example="001"),
 *     @OA\Property(property="offer_id", type="string", example="Teste"),
 *     @OA\Property(property="status", type="string", example="ACTIVE"),
 *     @OA\Property(
 *         property="products",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/RequestProductResource")
 *     ),
 * )
 */

class RequestResource extends JsonResource
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
            'offerid' => $this->offer_id,
            'pharmacyId' => $this->pharmacy_id,
            'status' => $this->status,
            'products' => RequestProductResource::collection($this->products),
            'updated_user' => $this->user ? $this->user->name : '',
            'updated_date' => $this->updated_at
        ];
    }
}
