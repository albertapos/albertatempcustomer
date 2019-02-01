<?php

namespace pos2020;

use Illuminate\Database\Eloquent\Model;
use Validator;


class systemOption extends Model
{
    protected $table = 'system_option';

     public static function Validate($data) {
        $rules = array(
            'name' => array('required'),
            'value' => array('required'),
        );
        return Validator::make($data, $rules);
    }
}
