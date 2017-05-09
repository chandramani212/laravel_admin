<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class LocalityRequest extends Request
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
            'locality_name' => 'required',
            'city_id' => 'required',
            'state_id' => 'required',
           
           // 'contact_no' => 'size:10|numeric',
           // 'alternate_no' => 'size:10|numeric',
        ];
    }

    public function messages(){
        return [
            'locality_name.required'    => ' :attribute is required.',
            'city_id.required'    => ' Please choose City.',
            'state_id.required'    => ' Please choose State.',
        ];
    }
}
