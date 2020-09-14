<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="PriorityResource",
 *     type="object",
 *     title="Priority Response",
 *     @OA\Property(property="id", type="integer", example="1"),
 *     @OA\Property(property="description", type="string", example="Teste"),
 *     @OA\Property(property="status", ref="#/components/schemas/UserStatus"),
 *     @OA\Property(
 *         property="nationalPartners",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/DistributorListResource")
 *     ),
 *     @OA\Property(
 *         property="regionalPartners",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/DistributorListResource")
 *     ),
 * )
 */
class PriorityResource extends JsonResource
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
            'description' => $this->description,
            'status' => $this->status,
            'nationalPartners' => DistributorListResource::collection(
                $this->partners()->where('category', \App\Distributor::CATEGORY_NATIONAL)->get()
            ),
            'regionalPartners' => DistributorListResource::collection(
                $this->partners()->where('category', \App\Distributor::CATEGORY_REGIONAL)->get()
            )
        ];
    }
}
