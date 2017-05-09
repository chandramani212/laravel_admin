<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ProductRequest extends Request
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
        $product = $this->input('product');
         if(!empty($product) || $product !=null){
            $rules = [];
            foreach($product['product_name'] as $key => $val)
            {
                $rules['product.product_name.' . $key] = 'required';
                
            }
            return $rules;
         }else{
        return [
            "product_name"=>'required'
            
        ];
    }
    }
}
