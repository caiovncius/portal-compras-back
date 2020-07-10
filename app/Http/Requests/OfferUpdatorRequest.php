<?php

namespace App\Http\Requests;

use App\Offer;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="OfferUpdatorRequest",
 *     type="object",
 *     title="Offer update form request",
 *     @OA\Property(property="code", type="integer", example="001"),
 *     @OA\Property(property="name", type="string", example="Teste"),
*     @OA\Property(property="startDate",  type="datetime", example="2020-05-25T05:09:15.000000Z"),
 *     @OA\Property(property="endDate",  type="datetime", example="2020-05-25T05:09:15.000000Z"),
 *     @OA\Property(property="condition",  type="string", example="name"),
 *     @OA\Property(property="minimumPrice",  type="string", example="500"),
 *     @OA\Property(property="offerType",  type="string", example="null"),
 *     @OA\Property(property="sendType",  type="string", example="null"),
 *     @OA\Property(property="noAutomaticSending",  type="boolean", example="true"),
 *     @OA\Property(property="impound",  type="boolean", example="false"),
 *     @OA\Property(property="description",  type="string", example="asdasd"),
 *     @OA\Property(property="emails", ref="#/components/schemas/Email"),
 * )
 */
class OfferUpdatorRequest extends FormRequest
{
    /**
     * Determine if the Offer is authorized to make this request.
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
            'name' => 'required|string',
            'description' => 'required|string',
            'status' => 'required|in:ACTIVE,INACTIVE',
        ];
    }
}