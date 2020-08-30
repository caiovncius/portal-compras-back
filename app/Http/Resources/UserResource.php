<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="UserResource",
 *     type="object",
 *     title="User Response",
 *     @OA\Property(property="id", type="integer", example="1"),
 *     @OA\Property(property="username", type="string", example="user01"),
 *     @OA\Property(property="name", type="string", example="Meu Nome"),
 *     @OA\Property(property="email", type="string", example="meu@email.com"),
 *     @OA\Property(property="phone1", type="string", example="(62) 9 9999-9999"),
 *     @OA\Property(property="phone2", type="string", example="(62) 9 9999-9999"),
 *     @OA\Property(property="type", ref="#/components/schemas/UserType"),
 *     @OA\Property(property="status", ref="#/components/schemas/UserStatus"),
 *     @OA\Property(property="profileId",  type="integer", example="14"),
 *     @OA\Property(property="createdAt",  type="datetime", example="2020-05-25T05:09:15.000000Z"),
 *     @OA\Property(property="updated_user", type="string", example="Nome usuário"),
 *     @OA\Property(property="updated_date", type="string", example="2020-05-01 10:00:00"),
 * )
 */
class UserResource extends JsonResource
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
            'username' => $this->username,
            'name' => $this->name,
            'email' => $this->email,
            'phone1' => $this->phone_1,
            'phone2' => $this->phone_2,
            'type' => $this->type,
            'status' => $this->status,
            'profileId' => $this->profile_id,
            'manager' => 'none',
            'pharmacies' => PharmacyResource::collection($this->pharmacies),
            'createdAt' => $this->created_at,
            'updated_user' => $this->user ? $this->user->name : '',
            'updated_date' => $this->updated_at,
            'lastLogin' => $this->last_login,
            'image' => $this->image
        ];
    }
}
