<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductMassUpdateRequest extends FormRequest
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
            'data' => 'array|required',
            'data.*.code' => 'required|string',
            'data.*.codeEan' => 'required|string',
            'data.*.description' => 'required|string',
            'data.*.status' => 'nullable|in:ACTIVE,INACTIVE',
            'data.*.laboratoryId' => 'nullable|exists:laboratories,id',
            'data.*.secondaryEanCodes' => 'array',
            'data.*.secondaryEanCodes.*.name' => 'string|required',
        ];
    }
}
