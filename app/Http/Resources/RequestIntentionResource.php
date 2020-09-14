<?php

namespace App\Http\Resources;

use App\Http\Resources\RequestHistoricResource;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="RequestResourceIntention",
 *     type="object",
 *     title="Request Response",
 *     @OA\Property(property="pharmacyId", type="integer", example="001"),
 *     @OA\Property(property="offerName", type="string", example="Teste"),
 *     @OA\Property(property="offerCondition", type="string", example="true"),
 *     @OA\Property(property="sendType", type="string", example="MANUAL"),
 *     @OA\Property(property="status", type="string", example="CREATED"),
 *     @OA\Property(property="sendDate", type="string", example="2020-09-25"),
 *     @OA\Property(
 *         property="products",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/RequestProductResource")
 *     ),
 *     @OA\Property(
 *         property="historic",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/RequestHistoricResource")
 *     ),
 * )
 */

class RequestIntentionResource extends JsonResource
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
            'pharmacyId' => $this->pharmacy_id,
            'pharmacyName' => $this->pharmacy->name,
            'pharmacyRegisterNumber' => $this->pharmacy->cnpj,
            'createdAt' => $this->created_at,
            'totalItems' => $this->products()->count(),
            'totalUnits' => $this->products->sum('pivot.qtd'),
            'subtotal' => $this->value,
            'total' => $this->value,
            'status' => $this->status,
        ];
    }
}
