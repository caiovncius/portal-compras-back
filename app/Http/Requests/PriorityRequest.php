<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="PriorityRequest",
 *     type="object",
 *     title="Priority form request",
 *     required={"description", "status", "partners"},
 *     @OA\Property(property="description", type="string", example="Name"),
 *     @OA\Property(property="status", ref="#/components/schemas/UserStatus"),
 *     @OA\Property(
 *         property="partners",
 *         type="array",
 *         @OA\Items(
 *              type="integer"
 *         )
 *     ),
 * )
 */

class PriorityRequest extends FormRequest
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
            'description' => 'string|required',
            'status' => 'required|in:ACTIVE,INACTIVE',
            'nationalPartner' => 'array|required',
            'nationalPartner.*' => 'numeric|exists:distributors,id',
            'regionalPartners' => 'array|required',
            'regionalPartners.*' => 'numeric|exists:distributors,id'
        ];
    }
}
