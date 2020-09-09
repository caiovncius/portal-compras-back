<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="RequestListResource",
 *     type="object",
 *     title="Request List Response",
 *     @OA\Property(property="pharmacyId", type="integer", example="001"),
 *     @OA\Property(property="pharmacyCode", type="string", example="123"),
 *     @OA\Property(property="offerName", type="string", example="Teste"),
 *     @OA\Property(property="offerCondition", type="string", example="true"),
 *     @OA\Property(property="sendType", type="string", example="MANUAL"),
 *     @OA\Property(property="status", type="string", example="CREATED"),
 *     @OA\Property(property="sendDate", type="string", example="2020-09-25"),
 *     @OA\Property(property="createdAt", type="string", example="2020-09-25"),
 *     @OA\Property(property="subtotal", type="string", example="10"),
 *     @OA\Property(property="value", type="string", example="8"),
 *     @OA\Property(property="qtdItens", type="integer", example="8"),
 *     @OA\Property(property="qtdUnities", type="integer", example="8"),
 *     @OA\Property(property="pharmacy", ref="#/components/schemas/PharmacyResource"),
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
            'pharmacyId' => $this->pharmacy_id,
            'offerName' => $this->requestable->name,
            'offerCondition' => $this->requestable->condition ? true : false,
            'sendType' => $this->requestable->send_type,
            'status' => $this->status,
            'subtotal' => $this->subtotal,
            'value' => $this->value,
            'sendDate' => $this->send_date,
            'qtdItens' => $this->products()->count(),
            'qtdUnities' => $this->products()->sum('qtd'),
            'pharmacy' => $this->pharmacy,
            'createdAt' => $this->created_at,
        ];
    }
}
