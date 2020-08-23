<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="ConditionListResource",
 *     type="object",
 *     title="Condition Response",
 *     @OA\Property(property="id", type="integer", example="1"),
 *     @OA\Property(property="code", type="string", example="01"),
 *     @OA\Property(property="description", type="string", example="Teste"),
 *     @OA\Property(property="status", ref="#/components/schemas/UserStatus"),
 *     @OA\Property(property="updatedUser", type="string", example="Nome usuário"),
 *     @OA\Property(property="updatedDate", type="string", example="2020-05-01 10:00:00"),
 *     @OA\Property(
 *         property="partners",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/DistributorContacts")
 *     ),
 * )
 */

class ConditionListResource extends JsonResource
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
            'description' => $this->description,
            'status' => $this->status,
            'visible' => $this->visible,
            'partners' => DistributorListResource::collection($this->partners),
            'updatedUser' => $this->user ? $this->user->name : '',
            'updatedDate' => $this->updated_at
        ];
    }
}
