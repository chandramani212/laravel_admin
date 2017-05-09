<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CityRequest extends Request
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
            'city_name' => 'required',
            'state_id' => 'required',
           
           // 'contact_no' => 'size:10|numeric',
           // 'alternate_no' => 'size:10|numeric',
        ];
    }

    public function messages(){
        return [
            'city_name.required'    => ' :attribute is required.',
            'state_id.required'    => ' Please choose State first.',
        ];
    }
}
