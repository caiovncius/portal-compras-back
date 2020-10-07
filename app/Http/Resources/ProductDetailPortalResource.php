<?php

namespace App\Http\Resources;

use App\ProductDetail;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="PurchcaseProductPricesDetailPortalResource",
 *     type="object",
 *     title="Purchcase Product Prices Details Portal Response",
 *     @OA\Property(property="minimum", type="string", example="01"),
 *     @OA\Property(property="maximum", type="string", example="01"),
 *     @OA\Property(property="percent", type="string", example="01"),
 * )
 */


/**
 * @OA\Schema(
 *     schema="ProductDetailPortalResource",
 *     type="object",
 *     title="Product detail Response",
 *     @OA\Property(property="productId", type="integer", example="2"),
 *     @OA\Property(property="product", type="string", example="4"),
 *     @OA\Property(property="price", type="string", example="10"),
 *     @OA\Property(property="priceWithDiscount", type="integer", example="15"),
 *     @OA\Property(property="obrigatory", type="boolean", example="1"),
 *     @OA\Property(property="laboratory", type="string", example="teste"),
 *     @OA\Property(
 *         property="values",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/PurchcaseProductPricesDetailPortalResource")
 *     ),
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
        $payment = (!$request->payment OR $request->payment == 'CASH') ? '_on_cash' : '_deferred';
        $discount = "discount$payment";
        $price_with_discount = "price$payment";

        return [
            'productId' => $this->product_id,
            'product' => $this->product ? $this->product->description : '',
            'productDescription' => $this->product ? $this->product->description : '',
            'price' => $this->factory_price,
            'discount' => $this->$discount,
            'priceWithDiscount' => $this->$price_with_discount,
            'obrigatory' => $this->obrigatory,
            'laboratory' => $this->product ? $this->product->laboratory->name : '',
            'eanCodes' => $this->product ? ProductSecondaryEanCode::collection($this->product->secondaryEanCodes) : [],
            'values' => ProductDetail::where('product_id', $this->product_id)
                                     ->get()->map(function ($item, $key) use ($discount) {
                                         return [
                                            'minimum' => $item->quantity_minimum,
                                            'maximum' => $item->quantity_maximum,
                                            'percent' => $item->$discount
                                        ];
                                     })
        ];
    }
}
