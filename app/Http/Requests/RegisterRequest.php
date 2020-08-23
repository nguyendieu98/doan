<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|regex:/^[0][0-9]*$/|size:10',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|email',
            'password' => 'required|min:8|same:confirm_password',
            'confirm_password' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'first_name.required' => trans('regis.first_name'),
            'last_name.required' =>  trans('regis.last_name'),
            'address.required' => trans('regis.add'),
            'email.required' => trans('regis.email'),
            'email.email' => trans('regis.emailerr'),
            'phone.required' => trans('regis.phone'),
            'username.required' => trans('regis.Username'),
            'username.unique' => trans('regis.Userunique'),
            'username.max' => trans('regis.Usermax'),
            'password.required' => trans('regis.pass'),
            'password.min' => trans('regis.passmin'),
            'password.same' => trans('regis.passsame'),
            'confirm_password.required' => trans('regis.passcf'),


        ];
    }
}
