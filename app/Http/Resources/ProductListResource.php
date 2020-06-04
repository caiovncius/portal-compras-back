<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="ProductListResource",
 *     type="object",
 *     title="ProductList Response",
 *     @OA\Property(property="id", type="integer", example="1"),
 *     @OA\Property(property="code", type="integer", example="2"),
 *     @OA\Property(property="codeEan", type="integer", example="3"),
 *     @OA\Property(property="description", type="string", example="Teste"),
 *     @OA\Property(property="status", ref="#/components/schemas/UserStatus"),
 *     @OA\Property(property="laboratoryId",  type="integer", example="4"),
 *     @OA\Property(property="laboratoryName",  type="string", example="Teste"),
 *     @OA\Property(property="createdAt",  type="datetime", example="2020-05-25T05:09:15.000000Z"),
 * )
 */
class ProductListResource extends JsonResource
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
            'status' => $this->status,
            'laboratoryId' => $this->laboratory_id,
            'laboratoryName' => $this->laboratory->name,
            'createdAt' => $this->created_at
        ];
    }
}
