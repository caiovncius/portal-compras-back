<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="AccompanimentListResource",
 *     type="object",
 *     title="Accompaniment Response",
 *     @OA\Property(property="id", type="integer", example="1"),
 *     @OA\Property(property="codeOrder", type="integer", example="001"),
 *     @OA\Property(property="codePharmacy", type="integer", example="002"),
 *     @OA\Property(property="startDate", type="date", example="1992-01-12"),
 *     @OA\Property(property="endDate", type="date", example="2010-10-11"),
 *     @OA\Property(property="commercial", type="string", example="123"),
 *     @OA\Property(property="sendType", type="string", example="123"),
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
            'codeOrder' => $this->code_order,
            'codePharmacy' => $this->code_pharmacy,
            'startDate' => $this->date_create,
            'endDate' => $this->date_publish,
            'commercial' => $this->commercial,
            'sendType' => $this->type_send,
            'status' => $this->status,
            'updated_user' => $this->user ? $this->user->name : '',
            'updated_date' => $this->updated_at
        ];
    }
}
