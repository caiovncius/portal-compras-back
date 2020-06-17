<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="ProfileFunctionsResource",
 *     type="object",
 *     title="PorfileFunctions Response",
 *     @OA\Property(property="id", type="integer", example="1"),
 *     @OA\Property(property="functionality", type="string", example="Teste"),
 *     @OA\Property(property="permission", type="string", example="test_function"),
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
            'functionality' => $this->name,
            'permission' => $this->key
        ];
    }
}
