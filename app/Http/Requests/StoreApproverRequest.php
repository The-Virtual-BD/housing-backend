<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class StoreApproverRequest extends FormRequest
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
            'name' => 'required|string|min:3|max:50',
            'email' => 'required|email|unique:approvers',
            'password' => 'required|string|min:6|max:50',
        ];
    }

    public function validated()
    {
        return array_merge(parent::validated(), ['password' => Hash::make('password')]);
    }
}
