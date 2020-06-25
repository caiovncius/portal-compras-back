<?php

namespace App\Http\Resources;

use App\Functionality;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="ProfileFunctionsResource",
 *     type="object",
 *     title="PorfileFunctions Response",
 *     @OA\Property(property="id", type="integer", example="1"),
 *     @OA\Property(property="name", type="string", example="Teste"),
 *     @OA\Property(property="functionality", type="string", example="test_function"),
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
            'functionality' => $this->key,
            'permission' =>  $this->pivot->access_type
        ];
    }
}
