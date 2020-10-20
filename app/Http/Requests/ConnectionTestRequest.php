<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
/**
 * @OA\Schema(
 *     schema="ConnectionTestRequest",
 *     type="object",
 *     title="ConnectionTestRequest form request",
 *     required={"host", "username", "password"},
 *     @OA\Property(property="host", type="strong", example="127.0.0.1"),
 *     @OA\Property(property="username", type="string", example="name"),
 *     @OA\Property(property="password", type="string", example="123446"),
 * )
 */
class ConnectionTestRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
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
            'connection.host' => 'required',
            'connection.login' => 'required',
            'connection.password' => 'required'
        ];
    }
}
