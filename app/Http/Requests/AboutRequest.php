<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AboutRequest extends FormRequest
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
            'title' => 'required|max:255',
            'name' => 'required|max:255',
            'address' => 'required|max:255',
            'content' => 'required|max:255',
            'phone' => 'required|numeric|',
            'email' => 'required|email',
            'logo' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'title.required' => 'Title must not be blank!',
            'name.required' => 'Name must not be blank!',
            'address.required' => 'Address must not be blank!',
            'phone.required' => 'Mobile number must not be blank!',
            'content.required' =>'Content must not be blank!',
            'email.required' => 'Email must not be blank!',
            'logo.required' => 'Please select a picture!',   
            'title.max:255' => 'No more than 255 characters!',
            'content.max:255' => 'Content no more than 255 characters!',
            'email.email' => 'Invalid email!',
            'phone.numeric' =>'Invalid Phone Number!'
        ];
    }
}