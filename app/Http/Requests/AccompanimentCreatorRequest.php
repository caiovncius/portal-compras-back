<?php

namespace App\Http\Requests;

use App\Accompaniment;
use Illuminate\Foundation\Http\FormRequest;


/**
 * @OA\Schema(
 *     schema="AccompanimentCreatorRequest",
 *     type="object",
 *     title="Accompaniment form request",
 *     required={"code_order", "code_pharmacy", "date_create", "date_publish", "commercial", "type_send", "status"},
 *     @OA\Property(property="code_order", type="integer", example="001"),
 *     @OA\Property(property="code_pharmacy", type="integer", example="001"),
 *     @OA\Property(property="date_create", type="date", example="1992-01-87"),
 *     @OA\Property(property="date_publish", type="date", example="1992-10-87"),
 *     @OA\Property(property="commercial", type="string", example="TESTE"),
 *     @OA\Property(property="type_send", type="string", example="TESTE"),
 *     @OA\Property(property="status", type="string", example="Enviado"),
 * )
 */
class AccompanimentCreatorRequest extends FormRequest
{
    /**
     * Determine if the Accompaniment is authorized to make this request.
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
            'code_order' => 'required|integer',
            'code_pharmacy' => 'required|integer',
            'date_create' => 'required|string',
            'date_publish' => 'required|string',
            'commercial' => 'required|string',
            'type_send' => 'required|string',
            'status' => 'required|string',
        ];
    }
}
