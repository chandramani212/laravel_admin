<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class StockRequest extends Request
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
            'product_id' => 'required',
            'attribute_id' => 'required',
        ];
    }

    public function messages(){
        return [
            'product_id.required'    => ' Please select product.',
            'attribute_id.required'    => ' Please select Attribute.',
        ];
    }
}
