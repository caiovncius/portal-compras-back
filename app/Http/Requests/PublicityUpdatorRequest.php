<?php

namespace App\Http\Requests;

use App\Publicity;
use Illuminate\Foundation\Http\FormRequest;


/**
 * @OA\Schema(
 *     schema="PublicityUpdatorRequest",
 *     type="object",
 *     title="Publicity form request",
 *     @OA\Property(property="code", type="integer", example="001"),
 *     @OA\Property(property="desc", type="integer", example="Teste"),
 *     @OA\Property(property="date_create", type="date", example="1992-01-87"),
 *     @OA\Property(property="date_publish", type="date", example="1992-10-87"),
 *     @OA\Property(property="image", type="boolean", example="1"),
 * )
 */
class PublicityUpdatorRequest extends FormRequest
{
    /**
     * Determine if the Publicity is authorized to make this request.
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
            'code' => 'required|string',
            'desc' => 'required|string',
            'createDate' => 'required|string',
            'publishDate' => 'required|string'
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
            'desc' => 'Descrição',
            'createDate' => 'Data criação',
            'publishDate' => 'Data publicação'
        ];
    }
}
