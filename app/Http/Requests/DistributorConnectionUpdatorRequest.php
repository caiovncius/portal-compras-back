<?php

namespace App\Http\Requests;

use App\DistributorConnection;
use Illuminate\Foundation\Http\FormRequest;


/**
 * @OA\Schema(
 *     schema="DistributorConnectionUpdatorRequest",
 *     type="object",
 *     title="DistributorConnection form request",
 *     @OA\Property(property="ftp_active", type="boolean", example="1"),
 *     @OA\Property(property="transferency", type="string", example="Teste"),
 *     @OA\Property(property="host", type="string", example="teste"),
 *     @OA\Property(property="path_send", type="string", example="teste"),
 *     @OA\Property(property="login", type="string", example="teste"),
 *     @OA\Property(property="password", type="string", example="teste"),
 *     @OA\Property(property="path_return", type="string", example="teste"),
 * )
 */
class DistributorConnectionUpdatorRequest extends FormRequest
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
            'distributor_id' => 'required|integer|exists:distributors,id',
            'ftp_active' => 'required|boolean',
            'transferency' => 'required|string',
            'host' => 'required|string',
            'path_send' => 'required|string',
            'login' => 'required|string',
            'password' => 'required|string',
            'path_return' => 'required|string',
        ];
    }
}
