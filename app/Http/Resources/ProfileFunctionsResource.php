<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="ProfileFunctionsResource",
 *     type="object",
 *     title="PorfileFunctions Response",
 *     @OA\Property(
 *         property="permissions",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/ProfilePermission")
 *     ),
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
            'functionality' => $this->name,
            'permission' => $this->pivot->access_type
        ];
    }
}
