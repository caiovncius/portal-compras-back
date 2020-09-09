<?php

namespace App\Http\Requests;

use App\Distributor;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="PurchaseIntentionRequest",
 *     type="object",
 *     title="Purchase Intention request",
 *     required={"requests"},
 *     @OA\Property(
 *         property="requests",
 *         type="array",
 *         @OA\Items(
 *              @OA\Property(property="id", type="number", example="1"),
 *         )
 *     ),
 * )
 */
class PurchaseIntentionRequest extends FormRequest
{
    /**
     * Determine if the Distributor is authorized to make this request.
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
            'requests' => 'array|required',
            'data.*.id' => 'required|numeric|exists:requests',
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
        ];
    }
}
