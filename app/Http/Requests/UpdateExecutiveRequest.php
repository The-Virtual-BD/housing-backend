<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class UpdateExecutiveRequest extends FormRequest
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

    public function prepareForValidation()
    {
        $this->merge(['executive_id' => isExecutive() ? auth()->id() : $this->executive->id]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'string|min:3|max:50',
            'email' => 'email|unique:approvers,email,'.$this->executive_id,
            'password' => 'string|min:6|max:50',
            'is_active' => isAdmin() ? 'boolean' : 'exclude'
        ];
    }

    public function validated()
    {
        if($this->has('password')){
            return array_merge(parent::validated(), ['password' => Hash::make($this->password)]);
        }

        return parent::validated();
    }
}
