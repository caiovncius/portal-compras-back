<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="PartnerListResource",
 *     type="object",
 *     title="PartnerList Response",
 *     @OA\Property(property="id", type="integer", example="1"),
 *     @OA\Property(property="code", type="string", example="01"),
 *     @OA\Property(property="cnpj", type="string", example="00.00001"),
 *     @OA\Property(property="name", type="string", example="Teste"),
 *     @OA\Property(property="category", type="string", example="NATIONAL"),
 *     @OA\Property(property="state", type="string", example="Goiás"),
 *     @OA\Property(property="type", type="string", example="DISTRIBUTOR"),
 *     @OA\Property(property="ol", type="integer", example="1"),
 *     @OA\Property(property="priority", type="integer", example="1"),
 *     @OA\Property(property="status", ref="#/components/schemas/UserStatus"),
 * )
 */

class PartnerListResource extends JsonResource
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
            'cnpj' => $this->partner->cnpj,
            'name' => $this->partner->name,
            'status' => $this->partner->status,
            'category' => $this->partner->category,
            'state' => ($this->partner->state) ? $this->partner->state->name : null,
            'ol' => $this->ol,
            'priority' => $this->priority,
            'type' => $this->partner_type,
        ];
    }
}
