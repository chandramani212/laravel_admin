<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class product_arttributeRequest extends Request
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
        //print_r($attribute);Exit;
      if(!empty($attribute) || $attribute !=null){
            $rules = [];
            foreach($attribute['uom'] as $key => $val)
            {
                $rules['attribute.uom.' . $key] = 'required';
                
            }
            if( isset($attribute['attribute_name']) )
            {
                foreach($attribute['attribute_name'] as $key => $val){
                    $rules['attribute.attribute_name.' . $key] = 'required';
                }
            }
            return $rules;
       }else{
       
       
        return [
            "attribute_name"=>'required',
            "uom"=>'required'

        ];
      }
    }
}
