<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="ConnectionListResource",
 *     type="Connection",
 *     title="Profile Response",
 *     @OA\Property(property="id", type="integer", example="1"),
 *     @OA\Property(property="isFtpActive", type="boolean", example="1"),
 *     @OA\Property(property="transferMode", type="string", example="teste"),
 *     @OA\Property(property="host", type="string", example="localhost"),
 *     @OA\Property(property="sendDirectory", type="string", example="123"),
 *     @OA\Property(property="login", type="string", example="123"),
 *     @OA\Property(property="password", type="string", example="123"),
 *     @OA\Property(property="returnDirectory", type="string", example="123"),
 *     @OA\Property(property="updated_user", type="string", example="Nome usuário"),
 *     @OA\Property(property="updated_date", type="string", example="2020-05-01 10:00:00"),
 *     @OA\Property(property="port", type="string", example="22"),
 *     @OA\Property(property="removeFile", type="boolean", example="0"),
 *     @OA\Property(property="mask", type="string", example="teste"),
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
            'updated_user' => $this->user ? $this->user->name : '',
            'updated_date' => $this->updated_at,
            'removeFile' => $this->remove_file,
            'mask' => $this->mask,
            'port' => $this->port,
        ];
    }
}
