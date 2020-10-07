<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
/**
 * @OA\Schema(
 *     schema="ProgramMassUpdatorRequest",
 *     type="object",
 *     title="Program updator request",
 *     required={"data"},
 *     @OA\Property(
 *         property="data",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/ProgramCreatorRequest")
 *     ),
 * )
 */
class ProgramMassUpdatorRequest extends FormRequest
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
            'data.*.status' => 'required|in:ACTIVE,INACTIVE',
            'data.*.contacts' => 'array',
            'data.*.contacts.*.function' => 'required|string',
            'data.*.contacts.*.name' => 'required|string',
            'data.*.contacts.*.email' => 'required|email',
            'data.*.contacts.*.telephone' => 'required|string',
        ];
    }
}
