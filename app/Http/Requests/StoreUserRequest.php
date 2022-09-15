<?php

namespace App\Http\Requests;

use App\Constants;
use App\Models\Photo;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
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
            'password' => 'required|string|min:6|max:50',
            'photo' => 'string|exists:photos,uniqid',
            'nib' => 'string',
            'dob' => 'date',
            'gender' => ['string', Rule::in(Constants::GENDERS)],
            'country_of_birth' => 'string',
            'island_of_birth' => 'string',
            'country_of_citizenship' => 'string',
            'description' => 'string'
        ];
    }

    public function validated(): array
    {
        $updates = array_merge(parent::validated(), ['password' => Hash::make($this->password)]);

        if ($this->has('photo')) {
            $photo = Photo::where('uniqid', $this->photo)->first();
            $updates = array_merge($updates, ['photo' => $photo->path]);
        }

        return $updates;
    }
}
