<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="DistributorConnectionListResource",
 *     type="DistributorConnection",
 *     title="Profile Response",
 *     @OA\Property(property="id", type="integer", example="1"),
 *     @OA\Property(property="distributorId", type="integer", example="1"),
 *     @OA\Property(property="ftpActive", type="string", example="Teste"),
 *     @OA\Property(property="transferency", type="string", example="teste"),
 *     @OA\Property(property="host", type="string", example="localhost"),
 *     @OA\Property(property="pathSend", type="string", example="123"),
 *     @OA\Property(property="login", type="string", example="123"),
 *     @OA\Property(property="password", type="string", example="123"),
 *     @OA\Property(property="pathReturn", type="string", example="123"),
 * )
 */

class DistributorConnectionListResource extends JsonResource
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
            'distributorId' => $this->distributor_id,
            'ftpActive' => $this->ftp_active,
            'transferency' => $this->transferency,
            'host' => $this->host,
            'pathSend' => $this->path_send,
            'login' => $this->login,
            'password' => $this->password,
            'pathReturn' => $this->path_return,
        ];
    }
}
