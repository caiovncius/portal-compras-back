<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="ProfileResource",
 *     type="object",
 *     title="Porfile Response",
 *     @OA\Property(property="id", type="integer", example="1"),
 *     @OA\Property(property="name", type="string", example="Manager"),
 *     @OA\Property(property="status", ref="#/components/schemas/UserStatus"),
 *     @OA\Property(property="type", ref="#/components/schemas/UserType"),
 *     @OA\Property(property="updatedUser", type="string", example="Nome usuário"),
 *     @OA\Property(property="updatedDate", type="string", example="2020-05-01 10:00:00"),
 *     @OA\Property(
 *         property="permissions",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/ProfilePermission")
 *     ),
 * )
 */

class ProfileResource extends JsonResource
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
            'type' => $this->type,
            'status' => $this->status,
            'permissions' => ProfileFunctionsResource::collection($this->functionalities),
            'updatedUser' => $this->user ? $this->user->name : '',
            'updatedDate' => $this->updated_at
        ];
    }
}
