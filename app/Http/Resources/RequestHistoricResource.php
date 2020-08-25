<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="RequestHistoricResource",
 *     type="object",
 *     title="Request History Response",
 *     @OA\Property(property="id", type="integer", example="1"),
 *     @OA\Property(property="user", type="string", example="teste"),
 *     @OA\Property(property="action", type="string", example="Criado"),
 *     @OA\Property(property="status", type="datetime", example="ENVIADO"),
 *     @OA\Property(property="createAt", type="datetime", example="2019-07-25 03:00:00"),
 * )
 */

class RequestHistoricResource extends JsonResource
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
            'user' => $this->user,
            'action' => $this->action,
            'status' => $this->status,
            'createdAt' => $this->created_at
        ];
    }
}
