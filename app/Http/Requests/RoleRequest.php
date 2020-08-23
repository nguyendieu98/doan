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
            'name.required'=>'Role name must not be blank!',
            'permission_id.required'=>'Permission must not be blank!',
            'name.unique' => 'Role Name already exists!',
            'name.max'=>'Name role maximum length is 255 characters!',
            'display_name.required'=>'Display name must not be blank!',
            'display_name.max'=>'Display name maximum length is 255 characters!'
        ];
    }
}
