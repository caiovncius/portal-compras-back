<?php

namespace App\Http\Resources;

use App\Request;
use App\Returns;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="RequestProductResource",
 *     type="object",
 *     title="RequestProductResource Response",
 *     @OA\Property(property="product", ref="#/components/schemas/ProductListResource"),
 *     @OA\Property(property="qtd", type="string", example="2"),
 *     @OA\Property(property="value", type="string", example="10"),
 *     @OA\Property(property="total", type="string", example="20"),
 * )
 */

class RequestProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $return  = Returns::find($this->pivot->return_id);
        return [
            'product' => ProductResource::make($this->resource),
            'offerDetails' => ProductDetailResource::make($this->offerDetails),
            'value' => $this->pivot->unit_value,
            'qtd' => $this->pivot->requested_quantity,
            'total' => $this->pivot->total,
            'discount' => $this->pivot->discount_percentage,
            'subtotal' => $this->pivot->subtotal,
            'status' => Request::getProductStatusText($this->pivot->status),
            'quantityServed' => $this->pivot->served_quantity,
            'reason' => !is_null($return) ? $return->description : null,
        ];
    }
}
