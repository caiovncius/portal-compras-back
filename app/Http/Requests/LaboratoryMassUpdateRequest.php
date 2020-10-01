<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LaboratoryMassUpdateRequest extends FormRequest
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
            'data.*.name' => 'required|string',
            'data.*.status' => 'nullable|in:ACTIVE,INACTIVE',
            'data.*.contacts' => 'array',
            'data.*.contacts.*.name' => 'string|required',
            'data.*.contacts.*.email' => 'email|required',
            'data.*.contacts.*.function' => 'string|required',
            'data.*.contacts.*.telephone' => 'string|required',
        ];
    }
}
