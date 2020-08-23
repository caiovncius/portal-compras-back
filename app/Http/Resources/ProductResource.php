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
            'laboratoryId' => $this->laboratory->id,
            'status' => $this->status,
            'createdAt' => $this->created_at,
            'updatedUser' => $this->user ? $this->user->name : '',
            'updatedDate' => $this->updated_at
        ];
    }
}
