<?php

namespace pos2020\Http\Requests;

use pos2020\Http\Requests\Request;

class createStoreRequest extends Request
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
            'name' => 'required|min:3|max:255',
            //'user_id' => 'required',
            'phone' => 'required',
        ];
    }
}
