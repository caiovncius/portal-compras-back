<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImportProductsRequest extends FormRequest
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
            'start_line' => 'required|numeric',
            'family_min_qtd' => 'required|string',
            'state_id' => 'required|exists:states,id',
            'ean_code' => 'required|string',
            'min_qtd' => 'required|string',
            'qtd_to' => 'string|nullable',
            'qtd_until' => 'string|nullable',
            'fab_price' => 'string|nullable',
            'discount_av' => 'string|nullable',
            'price_av' => 'string|nullable',
            'discount_ap' => 'string|nullable',
            'price_ap' => 'string|nullable',
            'required' => 'string|nullable',
            'file' => 'required|string'
        ];
    }
}
