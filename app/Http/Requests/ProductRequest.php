<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
                'name'=>'required|max:255|unique:products,name,'.$request->get('id'),
                'description' => 'required|max:500',
                'price' =>'required|numeric',
                'promotion' =>'required|numeric',
                'brand_id' => 'required',
                'category_id' => 'required',
                'image' => 'required',
                'selectsize' => 'required'
            ];
        }else{
            return [
                'product_code' => 'required|max:100',
                'name'=>'required|max:255|unique:products,name,'.$this->id,
                'description' => 'required|max:500',
                'price' =>'required|numeric',
                'promotion' =>'required|numeric',
                'brand_id' => 'required',
                'category_id' => 'required',
                'image' => 'required',
                'selectsize' => 'required'
            ];
        } 
    }
    public function messages()
    {
        return [
            'product_code.required'=>'Please enter your product key.',
            'product_code.max'=>'Maximum length is 100 characters.',
            'name.required'=>'Please enter a product name.',
            'name.max'=>'Maximum length is 100 characters.', 
            'price.required'=>'Please enter the product price.',
            'promotion.required'=>'Please enter the product promotion.',
            'price.numeric'=>'You entered the wrong data type.',
            'description.required'=>'Please enter the product content.',
            'description.max'=>'Maximum length is 500 characters.',
            'brand_id.required'=>'Please select a brand. ',
            'category_id.required'=>'Please select a category. ',
            'image.required'=>'Please select a picture. ',

        ];
    }
}
 