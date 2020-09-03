<?php

namespace App\Http\Requests;

use App\Request;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="RequestProductRequest",
 *     type="object",
 *     title="Request form request",
 *     required={"status", "returnId"},
 *     @OA\Property(property="status", type="string", example="ATTENDEND"),
 *     @OA\Property(property="returnId", type="integer", example="5"),
 *     @OA\Property(property="qtdReturn", type="string", example="10"),
 * )
 */
class RequestProductRequest extends FormRequest
{
    /**
     * Determine if the Offer is authorized to make this request.
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
            'status' => 'required|in:CREATED,ATTENDED,ATTENDED_PARTIAL,NOT_ATTENDED',
            'returnId' => 'required|numeric|exists:returns,id',
            'qtdReturn' => 'nullable|numeric',
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
            'returnId' => 'Retorno'
        ];
    }
}
