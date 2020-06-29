<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="PharmacyResource",
 *     type="object",
 *     title="PharmacyList Response",
 *     @OA\Property(property="id", type="integer", example="1"),
 *     @OA\Property(property="code", type="integer", example="01"),
 *     @OA\Property(property="cnpj", type="string", example="99.999.999/0001-91"),
 *     @OA\Property(property="socialName", type="string", example="Teste"),
 *     @OA\Property(property="status", type="string", example="ACTIVE"),
 *     @OA\Property(property="cityId", type="integer", example="1"),
 *     @OA\Property(property="stateId", type="integer", example="10"),
 *     @OA\Property(property="commercial", type="string", example="Teste 02"),
 *     @OA\Property(property="createdAt",  type="datetime", example="2020-05-25T05:09:15.000000Z"),
 * )
 */
class PharmacyResource extends JsonResource
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
            'socialName' => $this->company_name,
            'status' => $this->status,
            'cityId' => $this->city->id,
            'stateId' => $this->city->state->id,
            'commercial' => $this->commercial,
            'createdAt' => $this->created_at
        ];
    }
}