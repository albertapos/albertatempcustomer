<?php

namespace pos2020\Http\Requests;

use pos2020\Http\Requests\Request;

class UserUpdateRequest extends Request
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
            'fname' => 'required|min:3|max:255',
            'lname' => 'required|min:3|max:255',
            'phone' => 'required',
            'password' => 'confirmed|min:6',
        ];
    } 
    public function userFillData()
    {
        return [
            'fname' => $this->fname,
            'lname' => $this->lname,
            'phone' => $this->phone,
            'email' => $this->email,
            'password' => bcrypt($this->password),
        ];
    }
}
