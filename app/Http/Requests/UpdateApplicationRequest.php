<?php

namespace App\Http\Requests;

use App\Constants;
use App\Models\Application;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateApplicationRequest extends FormRequest
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
            'status' => ['string', Rule::in(Constants::APPLICATION_STATUSES)],
            'comments' => 'nullable|string'
        ];
    }

    public function validated()
    {
        $updates = [];

        if (
        in_array($this->status, [
            Application::STATUS_APPROVED,
            Application::STATUS_DECLINED
        ])
        ) {
            $updates = array_merge($updates, [
               'approvable_type' => get_class(auth()->user()),
               'approvable_id' => auth()->id()
            ]);
        }

        return array_merge(parent::validated(), $updates);
    }
}
