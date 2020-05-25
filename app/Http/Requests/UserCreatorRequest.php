<?php

namespace App\Http\Requests;

use App\User;
use Illuminate\Foundation\Http\FormRequest;

class UserCreatorRequest extends FormRequest
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
            'name' => 'required|string',
            'username' => 'required|string|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'type' => 'required|in:' . User::USER_TYPE_SUPPLIER . ',' . User::USER_TYPE_COMMERCIAL . ',' . User::USER_TYPE_PHARMACY,
            'status' => 'required|in:' . User::USER_STATUS_ACTIVE . ',' . User::USER_STATUS_INACTIVE,
            'profile_id' => 'required|exists:profiles,id',
            'phone_1' => 'numeric',
            'phone_2' => 'numeric',
        ];
    }
}
