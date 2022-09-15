<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSupportConversation extends FormRequest
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
            'language' => 'required|string',
            'fname' => 'required|string',
            'lname' => 'required|string',
            'email' => 'required|email',
            'subject' => 'required|string',
            'description' => 'required|string',
            'attachment' => 'mimes:jpeg,jpg,png,pdf'
        ];
    }
}
