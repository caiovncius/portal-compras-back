<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="PartnerResource",
 *     type="object",
 *     title="Partner Response",
 *     @OA\Property(property="type", type="string", example="DISTRIBUTOR"),
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
            'id' => $this->partner->id,
            'code' => $this->partner->code,
            'name' => $this->partner->name,
            'cnpj' => $this->partner->cnpj,
            'type' => $this->partner_type,
        ];
    }
}
