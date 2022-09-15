<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreApplicationRequest extends FormRequest
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
            'fname' => 'required|string',
            'lname' => 'required|string',
            'email' => 'required|email',
            'nib_no' => 'required|string',
            'dob' => 'required|date',
            'phone' => 'required|string',
            'gender' => 'required|string',
            'country_of_birth' => 'required|string',
            'island_of_birth' => 'required|string',
            'country_of_citizenship' => 'required|string',
            'house_no' => 'required|string',
            'street_address' => 'required|string',
            'po_box' => 'required|string',
            'island' => 'required|string',
            'country' => 'required|string',
            'home_phone' => 'required|string',
            'passport_no' => 'nullable|string',
            'passport_expiry' => 'nullable|string',
            'driving_licence_no' => 'nullable|string',
            'employer' => 'string',
            'industry' => 'string',
            'position' => 'string',
            'work_phone' => 'string',
            'housing_model_id' => 'exists:housing_models,id',
            'subdivision_id' => 'exists:subdivisions,id',
            'nib_photo' => 'required|mimes:jpeg,jpg,png,pdf|exclude',
            'passport_photo' => 'nullable|mimes:jpeg,jpg,png,pdf|exclude',
            'pre_approved_letter_photo' => 'required|mimes:jpeg,jpg,png,pdf|exclude',
            'job_letter_document' => 'required|mimes:jpeg,jpg,png,pdf|exclude'
        ];
    }
}
