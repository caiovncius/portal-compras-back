<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


/**
 * @OA\Schema(
 *     schema="ReturnMorphRequest",
 *     type="object",
 *     title="Return morph form request",
 *     @OA\Property(
 *         property="returns",
 *         type="array",
 *         @OA\Items(
 *              @OA\Property(property="code", type="integer", example="001"),
 *              @OA\Property(property="desc", type="integer", example="TESTE"),
 *         ),
 *    ),
 * )
 */
class ReturnMorphRequest extends FormRequest
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
            'returns' => 'array|nullable',
            'returns.*.code' => 'required|string|numeric',
            'returns.*.description' => 'required|string',
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
            'returns' => 'Array de retorno',
            'returns.*.code' => 'Código',
            'returns.*.description' => 'Descrição',
        ];
    }
}
