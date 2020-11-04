<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestUpdateProductsStatusesRequest extends FormRequest
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
            'items' => 'required|array|min:1',
            'items.*.productId' => 'numeric|required',
            'items.*.status' => 'required|in:ATTENDED,PARTIALLY_ATTENDED,NOT_ATTENDED',
            'items.*.returnId' => 'required|exists:returns,id',
            'items.*.attendedQuantity' => 'required|numeric'
        ];
    }
}
