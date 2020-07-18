<?php

namespace App\Http\Requests;

use App\Condition;
use Illuminate\Foundation\Http\FormRequest;


/**
 * @OA\Schema(
 *     schema="ConditionUpdatorRequest",
 *     type="object",
 *     title="Condition form request",
 *     @OA\Property(property="code", type="integer", example="001"),
 *     @OA\Property(property="desc", type="integer", example="Teste"),
 *     @OA\Property(property="visible", type="boolean", example="1"),
 *     @OA\Property(property="status", ref="#/components/schemas/UserStatus"),
 * )
 */
class ConditionUpdatorRequest extends FormRequest
{
    /**
     * Determine if the Condition is authorized to make this request.
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
            //'pharmacy_id' => 'required|integer|exists:pharmacies,id',
            'code' => 'required|string|unique:conditions',
            'desc' => 'required|string',
            'visible' => 'required|boolean',
            'status' => 'required|in:ACTIVE,INACTIVE'
        ];
    }
}
