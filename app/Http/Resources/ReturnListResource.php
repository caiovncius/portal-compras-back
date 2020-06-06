<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="ReturnListResource",
 *     type="Return",
 *     title="Return Response",
 *     @OA\Property(property="id", type="integer", example="1"),
 *     @OA\Property(property="code", type="integer", example="1"),
 *     @OA\Property(property="desc", type="string", example="Teste"),
 *     @OA\Property(property="status", type="string", example="ATIVO"),
 * )
 */

class ReturnListResource extends JsonResource
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
            'desc' => $this->desc,
            'status' => $this->status
        ];
    }
}
