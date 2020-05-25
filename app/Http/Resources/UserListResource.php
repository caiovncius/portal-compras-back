<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="PaginationLinks",
 *     type="object",
 *     @OA\Property(property="first", type="string", example="http://api.test/api/users?page=1"),
 *     @OA\Property(property="last", type="string", example="http://api.test/api/users?page=10"),
 *     @OA\Property(property="next", type="string", example="http://api.test/api/users?page=3"),
 * )
 *
 * @OA\Schema(
 *     schema="PaginationMeta",
 *     type="object",
 *     @OA\Property(property="current_page", type="integer", example="2"),
 *     @OA\Property(property="from", type="integer", example="1"),
 *     @OA\Property(property="last_page", type="integer", example="10"),
 *     @OA\Property(property="path", type="string", example="http://api.test/api/users"),
 *     @OA\Property(property="per_page", type="integer", example="20"),
 *     @OA\Property(property="to", type="integer", example="3"),
 *     @OA\Property(property="total", type="integer", example="10"),
 * )
 *
 *
 * @OA\Schema(
 *     schema="UserListResource",
 *     type="object",
 *     title="UserList Response",
 *     @OA\Property(property="id", type="integer", example="1"),
 *     @OA\Property(property="username", type="string", example="user01"),
 *     @OA\Property(property="name", type="string", example="Meu Nome"),
 *     @OA\Property(property="email", type="string", example="meu@email.com"),
 *     @OA\Property(property="phone_1", type="string", example="(62) 9 9999-9999"),
 *     @OA\Property(property="phone_2", type="string", example="(62) 9 9999-9999"),
 *     @OA\Property(property="type", ref="#/components/schemas/UserType"),
 *     @OA\Property(property="status", ref="#/components/schemas/UserStatus"),
 *     @OA\Property(property="profile_name",  type="string", example="Gerente"),
 *     @OA\Property(property="created_at",  type="datetime", example="2020-05-25T05:09:15.000000Z"),
 * )
 */
class UserListResource extends JsonResource
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
            'phone_1' => $this->phone_1,
            'phone_2' => $this->phone_2,
            'type' => $this->type,
            'status' => $this->status,
            'profile_name' => $this->profile->name,
            'manager' => 'none',
            'created_at' => $this->created_at
        ];
    }
}
