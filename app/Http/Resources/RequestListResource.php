<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="RequestListResource",
 *     type="object",
 *     title="Request List Response",
 *     @OA\Property(property="pharmacyId", type="integer", example="001"),
 *     @OA\Property(property="status", type="string", example="ACTIVE"),
 *     @OA\Property(property="updated_user", type="string", example="Nome usuário"),
 *     @OA\Property(property="updated_date", type="string", example="2020-05-01 10:00:00"),
 * )
 */

class RequestListResource extends JsonResource
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
            'pharmacyCode' => $this->pharmacy->code,
            'offerName' => $this->requestable->name,
            'sendType' => $this->requestable->send_type,
            'status' => $this->status,
            'total' => 0,
        ];
    }
}
