<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="ProfilePermissionsResource",
 *     type="object",
 *     title="Porfile Permissions Response",
 *     @OA\Property(
 *         property="permissions",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/ProfilePermission")
 *     ),
 * )
 */

class ProfilePermissionsResource extends JsonResource
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
            'permissions' => ProfileFunctionsResource::collection($this->functionalities)
        ];
    }
}
