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
            'title.required' => 'Please Enter Information.',
            'name.required' => 'Please Enter Information.',
            'address.required' => 'Please Enter Information.',
            'phone.required' => 'Please Enter Information.',
            'content.required' =>'Please Enter Information.',
            'email.required' => 'Please Enter Information.',
            'logo.required' => 'Please Select a picture.',   
            'title.max:255' => 'No more than 255 characters.',
            'content.max:255' => 'No more than 255 characters.',
            'email.email' => 'Invalid email.',
            'phone.numeric' =>'Invalid Phone Number.'
        ];
    }
}