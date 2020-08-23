<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="PartnerResource",
 *     type="object",
 *     title="Partner Response",
 *     @OA\Property(property="partnerId", type="integer", example="1"),
 *     @OA\Property(property="partnerType", type="string", example="DISTRIBUTOR"),
 *     @OA\Property(property="code", type="string", example="01"),
 *     @OA\Property(property="name", type="string", example="Teste"),
 *     @OA\Property(property="cnpj", type="string", example="Teste"),
 * )
 */

class PartnerResource extends JsonResource
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
            'code' => $this->partner->code,
            'name' => $this->partner->name,
            'cnpj' => $this->partner->cnpj,
            'partnerId' => $this->partnerId,
            'partnerType' => $this->partnerType,
        ];
    }
}
