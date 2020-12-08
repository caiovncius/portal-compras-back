<?php

namespace App\Http\Resources;

use App\Http\Resources\RequestHistoricResource;
use App\Offer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="RequestResource",
 *     type="object",
 *     title="Request Response",
 *     @OA\Property(property="pharmacyId", type="integer", example="001"),
 *     @OA\Property(property="pharmacyName", type="string", example="Teste"),
 *     @OA\Property(property="pharmacyRegister", type="string", example="00000000191"),
 *     @OA\Property(property="offerName", type="string", example="MANUAL"),
 *     @OA\Property(property="offerCondition", type="string", example="true"),
 *     @OA\Property(property="qtdItens", type="string", example="2"),
 *     @OA\Property(property="qtdUnities", type="string", example="6"),
 *     @OA\Property(property="status", type="string", example="WAITING_RETURN"),
 *     @OA\Property(property="value", type="string", example="100.30"),
 *     @OA\Property(property="subtotal", type="string", example="95"),
 *     @OA\Property(property="sendDate", type="string", example="2020-09-25"),
 *     @OA\Property(property="sendType", type="string", example="MANUAL"),
 *     @OA\Property(property="partnerName", type="string", example="TESTE"),
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

class RequestResource extends JsonResource
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
            'pharmacyRegister' => $this->pharmacy->cnpj,
            'offerName' => $this->requestable->name,
            'offerCondition' => !is_null($this->requestable->condition) ? true : false,
            'partner' => $this->getPartner(),
            'minimumValue' => $this->requestable->minimum_price,
            'qtdItens' => $this->products()->count(),
            'qtdUnities' => $this->products()->sum('requested_quantity'),
            'paymentMethod' => $this->payment_method === 'CASH' ? 'CASH' : 'DEFERRED',
            'status' => $this->status,
            'total' => $this->total,
            'totalDiscount' => $this->total_discount,
            'subtotal' => $this->subtotal,
            'sendDate' => $this->send_date,
            'sendType' => $this->requestable->send_type,
            'products' => RequestProductResource::collection($this->products),
            'historic' => RequestHistoricResource::collection($this->historics),
            'updated_user' => $this->user ? $this->user->name : '',
            'updated_date' => $this->updated_at
        ];
    }

    public function getPartner()
    {
        return $this->requestable instanceof Offer
            ? Offer::getOfferCurrentPartner($this->requestable, $this->priority)
            : $this->requestable->partner;
    }
}
