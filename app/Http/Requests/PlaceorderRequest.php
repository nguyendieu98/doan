<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlaceorderRequest extends FormRequest
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
            'first_name'   => 'required',
            'last_name' => 'required',
            'address' => 'required',
            'email' => 'required',
            'phone' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'first_name.required' => 'First name must not be blank!',
            'last_name.required' => 'Last name must not be blank!',
            'address.required' => 'Address must not be blank!',
            'email.required' => 'Email must not be blank!',
            'phone.required' => 'Mobile number must not be blank!',
    }
}
