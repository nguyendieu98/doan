<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BrandRequest extends FormRequest
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
    public function rules(Request $request)
    {
        if ($this->method()=='PUT') {
            return [
                'name'=>[
                    'required',
                    'max:255',
                    Rule::unique('brands')->where(function ($query) use($request) {
                        $query->where('isdelete', 0)->where('id','<>',$request->get('id'));
                    }),
                ], 
                'description' => 'required|max:500'
            ];
        }else{
            return [ 
                'name'=> [
                    'required',
                    'max:255',
                    Rule::unique('brands')->where(function ($query) {
                        $query->where('isdelete', 0);
                    }),
                ],
                'description' => 'required|max:500'
            ];
        } 
    }
    public function messages()
    {
        return [
            'name.required'=>'Brand name must not be blank!',
            'name.unique' => 'Brand Name already exists!',
            'name.max'=>'Brand name maximum length is 255 characters!',
            'description.required'=>'Description must not be blank!',
            'description.max'=>'Description maximum length is 500 characters!'
        ];
    }
}