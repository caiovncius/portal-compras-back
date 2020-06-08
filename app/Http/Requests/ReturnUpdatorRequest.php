<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="ReturnUpdatorRequest",
 *     type="object",
 *     title="Return form request",
 *     @OA\Property(property="code", type="integer", example="001"),
 *     @OA\Property(property="desc", type="integer", example="TESTE"),
 *     @OA\Property(property="status", ref="#/components/schemas/UserStatus"),
 * )
 */
class ReturnUpdatorRequest extends FormRequest
{
    /**
     * Determine if the Return is authorized to make this request.
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
            'code' => 'required|integer',
            'desc' => 'required|string',
            'status' => 'required|in:ACTIVE,INACTIVE'
        ];
    }
}
