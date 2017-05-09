<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CustomPriceRequest extends Request
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
        $rules = [
            'customer_id' => 'required',
            'address_id' => 'required',
            //'sub_total' => 'required|numeric|min:1',
            //'attribute_id' => 'required',
        ];

        if($this->request->has('product_id'))
        {
            foreach($this->request->get('product_id') as $key => $val)
            {
             $rules['product_id.'.$key] = 'required';
            }
        }
        /*else{

           $rules['product_id'] = 'required'; 
        }*/

        if($this->request->has('attribute_id'))
        {
            foreach($this->request->get('attribute_id') as $key => $val)
            {
             $rules['attribute_id.'.$key] = 'required';
            }
        }
        /*else{

           $rules['attribute_id'] = 'required'; 
        }*/

        return $rules;
    }

    public function messages(){
        return [
            'customer_id.required'    => 'Please Choose Customer',
            'address_id.required'    => 'Please Select address.',
        ];
    }
}
