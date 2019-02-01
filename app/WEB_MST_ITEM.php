<?php

namespace pos2020;

use Illuminate\Database\Eloquent\Model;
use Validator;
use Request;
use DB;
use Session;
use Config;

class WEB_MST_ITEM extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'web_mst_item';
    public $timestamps = false;
    protected $primaryKey = "iitemid";
    const STATUS_ACTIVE = "Active";
    const PRODUCT_IMAGEPATH = 'images/assets/productImages/';

    protected $appened = array('product_image');

    protected $visible = array(
        "iitemid",
        "vitemtype",
        "vitemname",
        "vunitcode",
        "dunitprice",
        "vdepcode",
        "vsize",
        "npack",
        "dcostprice",
        "nunitcost",
        "vbarcode",
        "vdescription",
        "vsuppliercode",
        "vcategorycode",
        "group",
        "nsellunit",
        "nsaleprice",
        "vsequence",
        "vcolorcode",
        "vshowsalesinzreport",
        "iqtyonhand",
        "nlevel2",
        "nlevel4",
        "visinventory",
        "vageverify",
        "ebottledeposit",
        "ireorderpoint",
        "nlevel3",
        "ndiscountper",
        "vfooditem",
        "vtax1",
        "vtax2",
        "vbarcodetype",
        "vdiscount",
        "norderqtyupto",
        "SID",
        "product_image",
        "updatetype",
        "mstid"
    );

    public static function Validate($data) {
        $rules = array(
            'vitemname' => array('required'),
            'vbarcode' => array('required'),
            'ndiscountper' => array('required'),
            'npack' => array('required'),
            'nunitcost' => array('required'),
            'dcostprice' => array('required'),
            'nsellunit' => array('required'),
            'nsaleprice' => array('required'),
            'iqtyonhand' => array('required'),
            'nlevel2' => array('required'),
            'nlevel4' => array('required'),
            'ireorderpoint' => array('required'),
            'nlevel3' => array('required'),
          //  'vdiscount' => array('required'),
            'norderqtyupto' => array('required'),
        );  

       $messages = [
            'vitemname.required' => 'Item Name is required.',
            'vbarcode.required' => 'SKU field is required.',
            'ndiscountper.required' => 'Discount(%) is required.',
            'npack.required' => 'Unit Per Case is required.',
            'nunitcost.required' => 'Unit Cost  is required.',
            'dcostprice.required' => 'Case Cost is required.',
            'nsellunit.required' => 'Selling Unit is required.',
            'nsaleprice.required' => 'Selling Price is required.',
            'iqtyonhand.required' => 'Quantity On Hand is required.',
            'nlevel2.required' => 'Level 2 Price is required.',
            'nlevel4.required' => 'Level 4 Price is required.',
            'ireorderpoint.required' => 'Re-Order point is required.',
            'nlevel3.required' => 'Level 3 Price is required.',
            'norderqtyupto.required' => 'Order Qty Upto is required.',
        ];
        return Validator::make($data, $rules,$messages);
    }

}
