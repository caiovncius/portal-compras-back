<?php

namespace App\Http\Requests;

use App\Pharmacy;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="PharmacyCreatorRequest",
 *     type="object",
 *     title="Pharmacy form request",
 *     required={"code", "cnpj", "company_name", "status", "city_id", "commercial"},
 *     @OA\Property(property="code", type="integer", example="01"),
 *     @OA\Property(property="cnpj", type="string", example="99.999.999/0001-91"),
 *     @OA\Property(property="company_name", type="string", example="Teste"),
 *     @OA\Property(property="status", type="string", example="ACTIVE"),
 *     @OA\Property(property="city_id", type="integer", example="10"),
 *     @OA\Property(property="commercial", type="string", example="Teste 02"),
 * )
 */
class PharmacyCreatorRequest extends FormRequest
{
    /**
     * Determine if the pharmacy is authorized to make this request.
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
            'code' => 'required|integer',
            'cnpj' => 'required|cnpj',
            'company_name' => 'required|string',
            'status' => 'required|in:ACTIVE,INACTIVE',
            'city_id' => 'required|integer|exists:cities,id',
            'commercial' => 'required|string',
        ];
    }
}
