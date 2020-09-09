<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'codeEan' => $this->code_ean,
            'description' => $this->description,
            'laboratoryId' => !is_null($this->laboratory) ? $this->laboratory->id : null,
            'status' => $this->status,
            'scondaryEanCodes' => ProductSecondaryEanCode::collection($this->secondaryEanCodes),
            'createdAt' => $this->created_at,
            'updated_user' => $this->user ? $this->user->name : '',
            'updated_date' => $this->updated_at
        ];
    }
}
