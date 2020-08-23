<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BannerRequest extends FormRequest
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
            'link' => 'required',
            'url_img' => 'required', 
        ];
    }
    public function messages()
    {
        return [
           'link.required' => 'Link must not be blank!',
            'url_img.required' => 'Url_Img must not be blank!',
        ];
    }
}