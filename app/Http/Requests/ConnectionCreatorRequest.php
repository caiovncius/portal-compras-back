<?php

namespace App\Http\Requests;

use App\Connection;
use Illuminate\Foundation\Http\FormRequest;


/**
 * @OA\Schema(
 *     schema="ConnectionCreatorRequest",
 *     type="object",
 *     title="DistributorConnection form request",
 *     required={"isFtpActive", "transferMode", "host", "sendDirectory", "login", "password", "returnDirectory"},
 *     @OA\Property(property="distributorId", type="boolean", example="1"),
 *     @OA\Property(property="isFtpActive", type="boolean", example="true"),
 *     @OA\Property(property="transferMode", type="string", example="ASCI"),
 *     @OA\Property(property="host", type="string", example="127.0.0.1"),
 *     @OA\Property(property="sendDirectory", type="string", example="/var/www"),
 *     @OA\Property(property="login", type="string", example="teste"),
 *     @OA\Property(property="password", type="string", example="123456"),
 *     @OA\Property(property="returnDirectory", type="string", example="/var/www"),
 * )
 */
class ConnectionCreatorRequest extends FormRequest
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
        ];
    }
}
