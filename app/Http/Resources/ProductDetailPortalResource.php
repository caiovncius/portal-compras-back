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
        $payment = (!$request->payment OR $request->payment == 'CASH') ? 'OnCash' : 'Deferred';
        $discount = "discount$payment";
        $priceWithDiscount = "price$payment";

        return [
            'productId' => $this->product_id,
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
