<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
/**
 * @OA\Schema(
 *     schema="PublicityAttachImageRequest",
 *     type="object",
 *     title="Publicity form request",
 *     @OA\Property(property="image", type="string", example="data:image/png;base64,iVBORw0K...."),
 * )
 */
class PublicityImageRequest extends FormRequest
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
            'image' => 'required|string'
        ];
    }
}
