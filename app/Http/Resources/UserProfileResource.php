<?php

namespace App\Http\Resources;

use App\Http\Resources\ProfileResource;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="UserProfileResource",
 *     type="object",
 *     title="User Response",
 *     @OA\Property(property="id", type="integer", example="1"),
 *     @OA\Property(property="name", type="string", example="Meu Nome"),
 *     @OA\Property(property="email", type="string", example="meu@email.com"),
 *     @OA\Property(property="profile", ref="#/components/schemas/ProfileResource"),
 * )
 */
class UserProfileResource extends JsonResource
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
            'profile' => ProfileResource::make($this->profile),
            'updated_user' => $this->user ? $this->user->name : '',
            'updated_date' => $this->updated_at,
            'lastLogin' => $this->last_login,
            'image' => $this->image
        ];
    }
}
