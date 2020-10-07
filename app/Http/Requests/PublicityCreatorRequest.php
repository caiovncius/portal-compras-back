<?php

namespace App\Http\Requests;

use App\Publicity;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="PublicityCreatorRequest",
 *     type="object",
 *     title="Publicity form request",
 *     required={"code", "description", "createDate", "publishDate", "image"},
 *     @OA\Property(property="code", type="string", example="001"),
 *     @OA\Property(property="description", type="integer", example="Teste"),
 *     @OA\Property(property="createDate", type="date", example="1992-01-87"),
 *     @OA\Property(property="publishDate", type="date", example="1992-10-87"),
 *     @OA\Property(property="image", type="string", example="teste"),
 * )
 */
class PublicityCreatorRequest extends FormRequest
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
            'code' => 'required|unique:publicities',
            'description' => 'required|string',
            'createDate' => 'required|string',
            'publishDate' => 'required|string',
            'image' => 'required|string',
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
            'publishDate' => 'Data publicação',
            'image' => 'Imagem',
        ];
    }
}
