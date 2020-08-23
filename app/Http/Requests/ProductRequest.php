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
            'product_code.required'=>'Product code must not be blank!',
            'product_code.max'=>'Product code maximum length is 100 characters!',
            'name.required'=>'Product name must not be blank!',
            'name.max'=>'product name maximum length is 100 characters!', 
            'price.required'=>'Price must not be blank!',
            'promotion.required'=>'Promotion must not be blank!',
            'price.numeric'=>'You entered the wrong data type!',
            'description.required'=>'Description must not be blank!',
            'description.max'=>'Description maximum length is 500 characters!',
            'brand_id.required'=>'Brand must not be blank!',
            'category_id.required'=>'Category must not be blank!',
            'image.required'=>'Image must not be blank!',

        ];
    }
}
 