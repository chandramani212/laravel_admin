<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class product_attribute_pricesRequest extends Request
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

          $attribute = $this->input('attribute');

          if(!empty( $attribute) ||  $attribute!=null){
                  $rules = [];
                foreach($attribute['price'] as $key => $val)
                    {
                         $rules['attribute.price.' . $key] = 'required';
                          $rules['attribute.sale_price.' . $key] = 'required';
                         
                    }
                return $rules;
             }else{      
                return [
                    "price"=>'required',
                    "sale_price"=>'required',
                ];
             }
    }
}
