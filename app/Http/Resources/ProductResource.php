<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
/**
 * @OA\Schema(
 *     schema="ProductResource",
 *     type="object",
 *     title="Product Response",
 *     @OA\Property(property="id", type="integer", example="1"),
 *     @OA\Property(property="code", type="integer", example="2"),
 *     @OA\Property(property="codeEan", type="integer", example="3"),
 *     @OA\Property(property="description", type="string", example="Teste"),
 *     @OA\Property(property="status", ref="#/components/schemas/UserStatus"),
 *     @OA\Property(property="laboratoryId",  type="integer", example="4"),
 *     @OA\Property(property="laboratory",  type="string", example="asd"),
 *     @OA\Property(property="createdAt",  type="datetime", example="2020-05-25T05:09:15.000000Z"),
 * )
 */
class ProductResource extends JsonResource
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
            'codeEan' => $this->code_ean,
            'description' => $this->description,
            'laboratoryId' => !is_null($this->laboratory) ? $this->laboratory->id : null,
            'laboratory' => !is_null($this->laboratory) ? LaboratoryListResource::make($this->laboratory) : null,
            'status' => $this->status,
            'secondaryEanCodes' => ProductSecondaryEanCode::collection($this->secondaryEanCodes),
            'createdAt' => $this->created_at,
            'updated_user' => $this->user ? $this->user->name : '',
            'updated_date' => $this->updated_at
        ];
    }
}
