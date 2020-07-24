<?php

namespace App\Http\Requests;

use App\Offer;
use Illuminate\Foundation\Http\FormRequest;


/**
 * @OA\Schema(
 *     schema="OfferCreatorRequest",
 *     type="object",
 *     title="Offer form request",
 *     required={"code", "name", "status", "description"},
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
 *     @OA\Property(property="status", ref="#/components/schemas/UserStatus"),
 * )
 */
class OfferCreatorRequest extends FormRequest
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
            'code' => 'required|string|numeric|unique:offers',
            'name' => 'required|string',
            'description' => 'required|string',
            'status' => 'required|in:ACTIVE,INACTIVE',
            'sendType' => 'nullable|in:MANUAL,AUTOMATIC',
            'offerType' => 'nullable|in:NORMAL,COMBO,COLLECTIVE_BUYING',
            'startDate' => 'date',
            'endDate' => 'date|after_or_equal:startDate',
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
            'code' => 'Código',
            'name' => 'Nome',
            'status' => 'Status',
            'sendType' => 'Tipo de envio',
            'offer_type' => 'Tipo de oferta',
            'description' => 'Descrição',
            'sendType' => 'Tipo de Envio',
            'startDate' => 'Data inicial',
            'endDate' => 'Data final',
        ];
    }
}
