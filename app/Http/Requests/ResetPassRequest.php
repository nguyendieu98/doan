<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResetPassRequest extends FormRequest
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
            'token' => 'required',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|min:8|same:confirm_password',
            'confirm_password' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'field email is required.',
            'password.required' => 'field email is required.',
            'confirm_password.required' => 'field email is required.',
        ];
    }
}
