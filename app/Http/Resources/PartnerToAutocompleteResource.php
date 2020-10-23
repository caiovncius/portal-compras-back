<?php

namespace App\Http\Resources;

use App\Program;
use Illuminate\Http\Resources\Json\JsonResource;

class PartnerToAutocompleteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $lo = $this->resource;
        return [
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->type === Program::PROGRAM_STATUS_ACTIVE || $this->type === Program::PROGRAM_STATUS_INACTIVE
                ? 'PROGRAM'
                : 'DISTRIBUTOR'
        ];
    }
}
