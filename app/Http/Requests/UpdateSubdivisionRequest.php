<?php

namespace App\Http\Requests;

use App\Models\Photo;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSubdivisionRequest extends FormRequest
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
            'gallery' => 'array|exclude',
            'category' => ['nullable', Rule::in(['featured', 'new_arrival'])],
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
