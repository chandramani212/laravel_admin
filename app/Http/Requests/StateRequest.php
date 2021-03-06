<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class StateRequest extends Request
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
            'state_name' => 'required',
           
           // 'contact_no' => 'size:10|numeric',
           // 'alternate_no' => 'size:10|numeric',
        ];
    }

    public function messages(){
        return [
            'state_name.required'    => ' :attribute is required.',
        ];
    }
}
