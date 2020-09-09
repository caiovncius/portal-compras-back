<?php

namespace App\Http\Requests;

use App\Connection;
use Illuminate\Foundation\Http\FormRequest;


/**
 * @OA\Schema(
 *     schema="ConnectionUpdatorRequest",
 *     type="object",
 *     required={"isFtpActive", "transferMode", "host", "sendDirectory", "login", "password", "returnDirectory"},
 *     @OA\Property(property="isFtpActive", type="boolean", example="1"),
 *     @OA\Property(property="transferMode", type="string", example="ASCI"),
 *     @OA\Property(property="host", type="string", example="127.0.0.1"),
 *     @OA\Property(property="sendDirectory", type="string", example="/var/www"),
 *     @OA\Property(property="login", type="string", example="teste"),
 *     @OA\Property(property="password", type="string", example="123456"),
 *     @OA\Property(property="returnDirectory", type="string", example="/var/www"),
 *     @OA\Property(property="port", type="string", example="22"),
 *     @OA\Property(property="remove_file", type="boolean", example="0"),
 *     @OA\Property(property="mask", type="string", example="teste"),
 * )
 */
class ConnectionUpdatorRequest extends FormRequest
{
    /**
     * Determine if the DistributorConnection is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'isFtpActive' => 'required|boolean',
            'transferMode' => 'required|string',
            'host' => 'required|string',
            'sendDirectory' => 'required|string',
            'login' => 'required|string',
            'password' => 'required|string',
            'returnDirectory' => 'required|string',
            'port' => 'numeric',
            'mask' => 'string',
            'remove_file' => 'boolean',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'isFtpActive' => 'Ftp ativo',
            'transferMode' => 'Modo de Transferência',
            'sendDirectory' => 'Diretório de envio',
            'password' => 'Senha',
            'returnDirectory' => 'Diretório de retorno',
        ];
    }
}
