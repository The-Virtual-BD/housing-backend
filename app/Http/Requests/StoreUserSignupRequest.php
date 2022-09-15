<?php

namespace App\Http\Requests;

use App\Constants;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class StoreUserSignupRequest extends FormRequest
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
            'fname' => 'required|string|min:3|max:30',
            'lname' => 'required|string|min:3|max:30',
            'email' => 'required|email|unique:users',
            'phone' => 'required|string',
            'nib' => 'required|string|unique:users',
            'password' => 'required|string|min:6|max:50',
        ];
    }

    public function validated(): array
    {
        return array_merge(parent::validated(), ['password' => Hash::make($this->password)]);

    }
}
