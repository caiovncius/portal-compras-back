<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="AccompanimentListResource",
 *     type="Accompaniment",
 *     title="Accompaniment Response",
 *     @OA\Property(property="id", type="integer", example="1"),
 *     @OA\Property(property="code_order", type="integer", example="001"),
 *     @OA\Property(property="code_pharmacy", type="integer", example="002"),
 *     @OA\Property(property="date_create", type="date", example="1992-01-12"),
 *     @OA\Property(property="date_publish", type="date", example="2010-10-11"),
 *     @OA\Property(property="commercial", type="string", example="123"),
 *     @OA\Property(property="type_send", type="string", example="123"),
 *     @OA\Property(property="status", type="string", example="Ativo"),
 * )
 */

class AccompanimentListResource extends JsonResource
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
            'code_order' => $this->code_order,
            'code_pharmacy' => $this->code_pharmacy,
            'dateCreate' => $this->date_create,
            'datePublish' => $this->date_publish,
            'commercial' => $this->commercial,
            'typeSend' => $this->type_send,
            'status' => $this->status,
        ];
    }
}
