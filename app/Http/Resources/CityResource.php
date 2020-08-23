<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="CityResource",
 *     type="object",
 *     title="City Response",
 *     @OA\Property(property="id", type="integer", example="1"),
 *     @OA\Property(property="name", type="string", example="Goiânia"),
 *     @OA\Property(property="ibgeCode", type="integer", example="123213"),
 *     @OA\Property(property="state", ref="#/components/schemas/StateResource"),
 * )
 */

class CityResource extends JsonResource
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
            'name' => $this->name,
            'ibgeCode' => $this->ibge_code,
            'state' => StateResource::make($this->state)
        ];
    }
}
