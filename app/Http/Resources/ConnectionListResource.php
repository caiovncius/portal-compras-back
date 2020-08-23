<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="ConnectionListResource",
 *     type="Connection",
 *     title="Profile Response",
 *     @OA\Property(property="id", type="integer", example="1"),
 *     @OA\Property(property="ftpActive", type="string", example="Teste"),
 *     @OA\Property(property="transferency", type="string", example="teste"),
 *     @OA\Property(property="host", type="string", example="localhost"),
 *     @OA\Property(property="pathSend", type="string", example="123"),
 *     @OA\Property(property="login", type="string", example="123"),
 *     @OA\Property(property="password", type="string", example="123"),
 *     @OA\Property(property="pathReturn", type="string", example="123"),
 *     @OA\Property(property="updatedUser", type="string", example="Nome usuário"),
 *     @OA\Property(property="updatedDate", type="string", example="2020-05-01 10:00:00"),
 * )
 */

class ConnectionListResource extends JsonResource
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
            'isFtpActive' => $this->ftp_active,
            'transferMode' => $this->transferency,
            'host' => $this->host,
            'sendDirectory' => $this->path_send,
            'login' => $this->login,
            'password' => $this->password,
            'returnDirectory' => $this->path_return,
            'updatedUser' => $this->user ? $this->user->name : '',
            'updatedDate' => $this->updated_at
        ];
    }
}
