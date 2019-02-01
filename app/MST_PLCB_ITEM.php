<?php

namespace pos2020;

use Validator;
use Illuminate\Database\Eloquent\Model;

class MST_PLCB_ITEM extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'mst_plcb_item';
    public $timestamps = false;
    protected $primaryKey = "id";

    public static function Validate($data) {
        $rules = array(
            'prduct_name' => array('required'),
            'unit_value' => array('required','integer'),
            'prev_mo_beg_qty' => array('required','integer'),
        );  

       $messages = [
            'prduct_name.required' => 'Item Name is required.',
            'unit_value.required' => 'Unit Value is required.',
            'unit_value.integer' => 'Unit Value Must be Numeric.',
            'prev_mo_beg_qty.required' => 'Previous Month Beginning Qty is required.',
            'prev_mo_beg_qty.integer' => 'Previous Month Beginning Qty Must be Numeric.',
        ];
        return Validator::make($data, $rules,$messages);
    }
}
