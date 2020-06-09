<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="ProfileFunctionsResource",
 *     type="object",
 *     title="PorfileFunctions Response",
 *     @OA\Property(property="id", type="integer", example="1"),
 *     @OA\Property(property="key", type="integer", example="2"),
 *     @OA\Property(property="name", type="string", example="TESTE"),
 * )
 */
class ProfileFunctionsResource extends JsonResource
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
            'key' => $this->key
        ];
    }
}
