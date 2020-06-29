<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

/**
 * @OA\Schema(
 *     schema="PublicityListResource",
 *     type="Publicity",
 *     title="Publicity Response",
 *     @OA\Property(property="id", type="integer", example="1"),
 *     @OA\Property(property="code", type="integer", example="001"),
 *     @OA\Property(property="description", type="string", example="Teste"),
 *     @OA\Property(property="createDate", type="date", example="1992-01-12"),
 *     @OA\Property(property="publishDate", type="date", example="2010-10-11"),
 *     @OA\Property(
 *         property="images",
 *         type="array",
 *         @OA\Items( type="date", example="http://example.com/storage/image.jpg")
 *     ),
 * )
 */

class PublicityListResource extends JsonResource
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
            'code' => $this->code,
            'description' => $this->desc,
            'createDate' => $this->date_create,
            'publishDate' => $this->date_publish,
            'images' => $this->when(true,  function() {
                $images = [];
                $imagesDecoded = json_decode($this->images);

                if (count($imagesDecoded) > 0) {
                    foreach ($imagesDecoded as $image) {
                        $url = env('APP_URL') . $image;
                        array_push($images, $url);
                    }
                }

                return $images;
            })
        ];
    }
}
