<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RequestMonitoringResource extends JsonResource
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
            'pharmacyCode' => $this->pharmacy->code,
            'offerName' => $this->requestable->name,
            'sendType' => $this->requestable->send_type,
            'sentDate' => $this->send_date,
            'total' => $this->total,
            'status' => $this->status
        ];
    }
}
