<?php

namespace App\Http\Resources;

use App\ProductDetail;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="ProductDetailPortalResource",
 *     type="object",
 *     title="Product detail Response",
 *     @OA\Property(property="discountDeferred", type="string", example="2"),
 *     @OA\Property(property="discountOnCash", type="string", example="4"),
 *     @OA\Property(property="minimum", type="integer", example="10"),
 *     @OA\Property(property="minimumPerFamily", type="integer", example="15"),
 *     @OA\Property(property="obrigatory", type="boolean", example="1"),
 *     @OA\Property(property="variable", type="boolean", example="1"),
 *     @OA\Property(property="family", type="boolean", example="0"),
 *     @OA\Property(property="gift", type="boolean", example="0"),
 *     @OA\Property(property="factoryPrice", type="string", example="10.00"),
 *     @OA\Property(property="priceDeferred", type="string", example="11.00"),
 *     @OA\Property(property="priceOnCash", type="string", example="10.51"),
 *     @OA\Property(property="productName", type="string", example="Teste"),
 *     @OA\Property(property="quantityMaximum", type="integer", example="6"),
 *     @OA\Property(property="quantityMinimum", type="integer", example="10"),
 *     @OA\Property(property="state_id", type="string", example="5"),
 *     @OA\Property(property="product_id", type="string", example="5"),
 *     @OA\Property(property="updatedUser", type="string", example="Nome usuário"),
 *     @OA\Property(property="updatedDate", type="string", example="2020-05-01 10:00:00"),
 * )
 */
class ProductDetailPortalResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $payment = (!$request->payment OR $request->payment == 'CASH') ? 'OnCash' : 'Deferred';
        $discount = "discount$payment";
        $priceWithDiscount = "price$payment";

        return [
            'product_id' => $this->product_id,
            'product' => $this->product ? $this->product->description : '',
            'price' => $this->factoryPrice,
            'discount' => $this->$discount,
            'priceWithDiscount' => $this->$priceWithDiscount,
            'obrigatory' => $this->obrigatory,
            'values' => ProductDetail::where('product_id', $this->product_id)
                                     ->get()->map(function ($item, $key) use ($discount) {                                        return [
                                            'minimum' => $item->quantityMinimum,
                                            'maximum' => $item->quantityMaximum,
                                            'percent' => $item->$discount
                                        ];
                                     })
        ];
    }
}
