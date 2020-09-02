<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="PharmacyResource",
 *     type="object",
 *     title="PharmacyList Response",
 *     @OA\Property(property="id", type="int", example="2"),
 *     @OA\Property(property="code", type="string", example="234234"),
 *     @OA\Property(property="socialName", type="string", example="Company ltda"),
 *     @OA\Property(property="name", type="string", example="My Company"),
 *     @OA\Property(property="status", type="string", example="ACTIVE"),
 *     @OA\Property(property="cnpj", type="string", example="99.999.999/0001-91"),
 *     @OA\Property(property="stateRegistration", type="string", example="424343"),
 *     @OA\Property(property="email", type="string", example="email@example.com"),
 *     @OA\Property(property="phone", type="string", example="(11) 9 9999-9999"),
 *     @OA\Property(property="supervisorId", type="string", example="1"),
 *     @OA\Property(property="partnerPriority", type="string", example="12"),
 *     @OA\Property(property="address", type="string", example="Rua 12"),
 *     @OA\Property(property="address2", type="string", example="Complemento"),
 *     @OA\Property(property="addressNumber", type="string", example="12"),
 *     @OA\Property(property="district", type="string", example="Bairro"),
 *     @OA\Property(property="zipCode", type="string", example="74000-00"),
 *     @OA\Property(property="cityId", type="string", example="3"),
 *     @OA\Property(property="stateId", type="string", example="3"),
 *     @OA\Property(
 *         property="contacts",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/ContactListResource")
 *     ),
 *     @OA\Property(property="updated_user", type="string", example="User name"),
 *     @OA\Property(property="updated_date", type="string", example="2020-05-21 12:00:11")
 * )
 */
class PharmacyResource extends JsonResource
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
            'socialName' => $this->company_name,
            'name' => $this->name,
            'status' => $this->status,
            'cnpj' => $this->cnpj,
            'stateRegistration' => $this->state_registration,
            'email' => $this->email,
            'phone' => $this->phone,
            'supervisorId' => $this->supervisor_id,
            'partnerPriority' => PriorityResource::make($this->priority),
            'address' => $this->address,
            'address2' => $this->address_2,
            'addressNumber' => $this->address_number,
            'district' => $this->district,
            'zipCode' => $this->zip_code,
            'cityId' => $this->city->id,
            'stateId' => $this->city->state->id,
            'contacts' => ContactListResource::collection($this->contacts),
            'updated_user' => $this->user ? $this->user->name : '',
            'updated_date' => $this->updated_at,
        ];
    }
}
