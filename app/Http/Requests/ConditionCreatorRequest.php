<?php

namespace App\Http\Requests;

use App\Condition;
use Illuminate\Foundation\Http\FormRequest;


/**
 * @OA\Schema(
 *     schema="ConditionCreatorRequest",
 *     type="object",
 *     title="Condition form request",
 *     required={"code", "description", "status", "partners"},
 *     @OA\Property(property="code", type="string", example="001"),
 *     @OA\Property(property="description", type="string", example="Test name"),
 *     @OA\Property(property="status", ref="#/components/schemas/UserStatus"),
 *     @OA\Property(
 *         property="partners",
 *         type="array",
 *         @OA\Items(
 *          @OA\Property(property="partnerId", type="integer", example="1"),
 *          @OA\Property(property="type", type="string", example="DISTRIBUTOR or PROGRAM"),
 *         )
 *     ),
 * )
 */
class ConditionCreatorRequest extends FormRequest
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
            'code' => 'required|string|unique:conditions,code',
            'description' => 'required|string',
            'status' => 'required|in:ACTIVE,INACTIVE',
            'partners' => 'array|required|min:1',
            'partners.*.type' => 'required|in:DISTRIBUTOR,PROGRAM',
            'partners.*.id' => 'required|numeric'
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
            'code' => 'Código',
            'description' => 'Descrição',
            'visible' => 'Visível'
        ];
    }
}
