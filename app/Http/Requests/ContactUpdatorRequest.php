<?php

namespace App\Http\Requests;

use App\Contact;
use Illuminate\Foundation\Http\FormRequest;


/**
 * @OA\Schema(
 *     schema="ContactUpdatorRequest",
 *     type="object",
 *     title="Contact Update form request",
 *     @OA\Property(property="code", type="integer", example="001"),
 *     @OA\Property(property="function", type="integer", example="00.0001/0004.14"),
 *     @OA\Property(property="name", type="string", example="Teste"),
 *     @OA\Property(property="email", type="string", example="teste@domain.com"),
 *     @OA\Property(property="telephone", type="string", example="112345647"),
 * )
 */
class ContactUpdatorRequest extends FormRequest
{
    /**
     * Determine if the Contact is authorized to make this request.
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
            'function' => 'required|string',
            'name' => 'required|string',
            'email' => 'required|email',
            'telephone' => 'required|string'
        ];
    }
}
