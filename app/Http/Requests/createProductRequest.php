<?php

namespace pos2020\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class createProductRequest extends FormRequest
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
            'itemName' => 'required',
            'sku' => 'required',
            'discount_per' => 'required',
            'unitPerCase' => 'required',
            'unitCost' => 'required',
            'caseCost' => 'required',
            'sellingUnit' => 'required',
            'sellingPrice' => 'required',
            'qtyOnHand' => 'required',
            'level2Price' => 'required',
            'level4Price' => 'required',
            'reOrderPoint' => 'required',
            'level3Price' => 'required',
            'discount' => 'required',
            'orderQtyUpTo' => 'required'
          
        ];
    }
}
