<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="ContactListResource",
 *     type="Contact",
 *     title="Contact Response",
 *     @OA\Property(property="id", type="integer", example="1"),
 *     @OA\Property(property="function", type="string", example="Teste"),
 *     @OA\Property(property="name", type="string", example="Teste"),
 *     @OA\Property(property="email", type="string", example="teste@domain.com"),
 *     @OA\Property(property="telephone", type="string", example="123"),
 * )
 */

class ContactListResource extends JsonResource
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
            'function' => $this->function,
            'name' => $this->name,
            'email' => $this->email,
            'telephone' => $this->telephone,
            'updated_user' => $this->user ? $this->user->name : '',
            'updated_date' => $this->updated_at
        ];
    }
}
