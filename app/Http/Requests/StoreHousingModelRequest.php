<?php

namespace App\Http\Requests;

use App\Models\Photo;
use Illuminate\Foundation\Http\FormRequest;

class StoreHousingModelRequest extends FormRequest
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
            'heading' => 'required|string',
            'location' => 'required|string',
            'description' => 'required|string',
            'bedrooms' => 'nullable|string',
            'bathrooms' => 'nullable|string',
            'width' => 'nullable|string',
            'garages' => 'nullable|string',
            'patios' => 'nullable|string',
            'gallery' => 'required|array|exclude',
            'master_plan' => 'required|mimes:jpeg,jpg,png|exclude',
            'basic_plan' => 'required|mimes:jpeg,jpg,png|exclude',
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
