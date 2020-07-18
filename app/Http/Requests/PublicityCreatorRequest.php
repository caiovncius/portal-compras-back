<?php

namespace App\Http\Requests;

use App\Publicity;
use Illuminate\Foundation\Http\FormRequest;


/**
 * @OA\Schema(
 *     schema="PublicityCreatorRequest",
 *     type="object",
 *     title="Publicity form request",
 *     required={"code", "desc", "date_create", "date_publish", "image"},
 *     @OA\Property(property="code", type="integer", example="001"),
 *     @OA\Property(property="desc", type="integer", example="Teste"),
 *     @OA\Property(property="createDate", type="date", example="1992-01-87"),
 *     @OA\Property(property="publishDate", type="date", example="1992-10-87"),
 *     @OA\Property(property="image", type="boolean", example="1"),
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
            'code' => 'required|string',
            'desc' => 'required|string',
            'createDate' => 'required|string',
            'publishDate' => 'required|string',
            'image' => 'required|string',
        ];
    }
}
