<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CustomerRequest extends Request
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
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'email',
           // 'contact_no' => 'size:10|numeric',
           // 'alternate_no' => 'size:10|numeric',
        ];
    }

    public function messages(){
        return [
            'first_name.required'    => ' :attribute is required.',
            'last_name.required'    => ' :attribute is required.',
        ];
    }
}
