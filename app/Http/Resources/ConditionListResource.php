<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="ConditionListResource",
 *     type="object",
 *     title="Condition Response",
 *     @OA\Property(property="id", type="integer", example="1"),
 *     @OA\Property(property="pharmacyId", type="integer", example="1"),
 *     @OA\Property(property="pharmacyName", type="integer", example="Teste"),
 *     @OA\Property(property="code", type="string", example="01"),
 *     @OA\Property(property="desc", type="string", example="Teste"),
 *     @OA\Property(property="visible", type="boolean", example="1"),
 *     @OA\Property(property="status", ref="#/components/schemas/UserStatus"),
 * )
 */

class ConditionListResource extends JsonResource
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
            'pharmacyName' => $this->pharmacy->name,
            'code' => $this->code,
            'desc' => $this->desc,
            'visible' => $this->visible,
            'status' => $this->status
        ];
    }
}
