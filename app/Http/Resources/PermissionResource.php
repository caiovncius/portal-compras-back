<?php

namespace App\Http\Resources;

use App\Functionality;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="PermissionResource",
 *     type="object",
 *     title="Permission Response",
 *     @OA\Property(property="name", type="string", example="Usuário"),
 *     @OA\Property(property="functionality", type="string", example="User"),
 *     @OA\Property(property="permission", type="string", example="NO_ACCESS"),
 * )
 */
class PermissionResource extends JsonResource
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
            'name' => $this->functionality->name,
            'functionality' => $this->functionality->key,
            'permission' =>  $this->pivot->access_type
        ];
    }
}
