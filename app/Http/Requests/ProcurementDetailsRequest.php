<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ProcurementDetailsRequest extends Request
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
        if(!empty($attribute) || $attribute !=null){
            $rules = [];
            foreach($attribute['uom'] as $key => $val)
            {
                $rules['attribute.uom.' . $key] = 'required';
                $rules['attribute.purchase_qty.' .$key]='required';
            }
            //print_r($rules);exit;
            return $rules;
        }else{
            return [
               'attribute.uom'=>'required',
               'attribute.purchase_qty'=>'required'
            ];
        }
    }
}
