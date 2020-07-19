<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class RoleRequest extends FormRequest
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
                'name'=>'required|max:255|unique:roles,name,'.$request->get('id'),
                'permission_id' => 'required',
                'display_name' => 'required|max:255'
            ];
        }else{
            return [ 
                'name'=>'required|max:255|unique:roles,name,'.$this->id,
                'permission_id' => 'required',
                'display_name' => 'required|max:255'
            ];
        } 
    }
    public function messages()
    {
        return [
            'name.required'=>'Please enter a role name.',
            'permission_id.required'=>'Please select permission.',
            'name.unique' => 'Role name already exists.',
            'name.max'=>'Maximum length is 255 characters.',
            'display_name.required'=>'Please enter a display name.',
            'display_name.max'=>'Maximum length is 255 characters.'
        ];
    }
}
