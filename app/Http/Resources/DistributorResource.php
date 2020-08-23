<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="DistributorResource",
 *     type="object",
 *     title="Porfile Response",
 *     @OA\Property(property="id", type="integer", example="1"),
 *     @OA\Property(property="code", type="string", example="01"),
 *     @OA\Property(property="cnpj", type="string", example="00.000.000/0001-91"),
 *     @OA\Property(property="name", type="string", example="Teste"),
 *     @OA\Property(property="status", ref="#/components/schemas/UserStatus"),
 *     @OA\Property(property="updatedUser", type="string", example="Nome usuário"),
 *     @OA\Property(property="updatedDate", type="string", example="2020-05-01 10:00:00"),
 *     @OA\Property(
 *         property="contacts",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/DistributorContacts")
 *     ),
 *     @OA\Property(property="connection", ref="#/components/schemas/ConnectionListResource"),
 * )
 */

class DistributorResource extends JsonResource
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
            'code' => $this->code,
            'cnpj' => $this->cnpj,
            'name' => $this->name,
            'status' => $this->status,
            'contacts' =>ContactListResource::collection($this->contacts),
            'connection' => ConnectionListResource::make($this->connection),
            'updatedUser' => $this->user ? $this->user->name : '',
            'updatedDate' => $this->updated_at
        ];
    }
}
