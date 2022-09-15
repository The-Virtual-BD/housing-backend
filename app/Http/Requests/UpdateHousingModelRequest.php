<?php

namespace App\Http\Requests;

use App\Models\Photo;
use Illuminate\Foundation\Http\FormRequest;

class UpdateHousingModelRequest extends FormRequest
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
            'heading' => 'string',
            'location' => 'string',
            'description' => 'string',
            'bedrooms' => 'nullable|string',
            'bathrooms' => 'nullable|string',
            'width' => 'nullable|string',
            'garages' => 'nullable|string',
            'patios' => 'nullable|string',
            'gallery' => 'array|exclude',
            'master_plan' => 'mimes:jpg,jpeg,png|exclude',
            'basic_plan' => 'mimes:jpg,jpeg,png|exclude',
            'include_in_application' => 'string'
        ];
    }

    public function validated()
    {
        return array_merge(parent::validated(), [
            'include_in_application' => $this->include_in_application === "true"
        ]);
    }
}
