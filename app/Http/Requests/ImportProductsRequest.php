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
            'startLine' => 'required|numeric',
            'familyMinQtd' => 'string|nullable',
            'stateId' => 'required|exists:states,id',
            'eanCode' => 'required|string',
            'minQtd' => 'string|nullable',
            'qtdTo' => 'string|nullable',
            'qtdFrom' => 'string|nullable',
            'fabPrice' => 'string|nullable',
            'discountAv' => 'string|nullable',
            'priceAv' => 'string|nullable',
            'discountAp' => 'string|nullable',
            'priceAp' => 'string|nullable',
            'required' => 'string|nullable',
            'file' => 'required|string'
        ];
    }
}
