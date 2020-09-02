<?php

namespace App\Http\Resources;

use App\Http\Resources\RequestHistoricResource;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="RequestResource",
 *     type="object",
 *     title="Request Response",
 *     @OA\Property(property="pharmacy_id", type="integer", example="001"),
 *     @OA\Property(property="offer_id", type="string", example="Teste"),
 *     @OA\Property(property="status", type="string", example="ACTIVE"),
 *     @OA\Property(property="updated_user", type="string", example="Nome usuário"),
 *     @OA\Property(property="updated_date", type="string", example="2020-05-01 10:00:00"),
 *     @OA\Property(
 *         property="products",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/RequestProductResource")
 *     ),
 *     @OA\Property(
 *         property="historic",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/RequestHistoricResource")
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
            'pharmacyId' => $this->pharmacy_id,
            'status' => $this->status,
            'products' => RequestProductResource::collection($this->products),
            'historic' => RequestHistoricResource::collection($this->historics),
            'updated_user' => $this->user ? $this->user->name : '',
            'updated_date' => $this->updated_at
        ];
    }
}
