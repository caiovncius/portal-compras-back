<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
/**
 * @OA\Schema(
 *     schema="SecondaryEanCodeCreatorRequest",
 *     type="object",
 *     title="Secondary Ean Code form request",
 *     required={"name"},
 *     @OA\Property(property="name", type="string", example="980890"),
 * )
 */
class SecondaryEanCodeRequest extends FormRequest
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
            'name' => 'required|string'
        ];
    }
}
