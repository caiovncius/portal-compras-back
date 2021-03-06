<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="DistributorListResource",
 *     type="object",
 *     title="Distributor Response",
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

class DistributorListResource extends JsonResource
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
            'code' => $this->code,
            'cnpj' => $this->cnpj,
            'name' => $this->name,
            'status' => $this->status,
            'category' => $this->category,
            'state' => ($this->state) ? $this->state->name : null
        ];
    }
}
