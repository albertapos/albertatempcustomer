<?php

namespace pos2020;

use Illuminate\Database\Eloquent\Model;
use Validator;
use Request;
use DB;
use Session;
use Config;
class Item extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'mst_item';
    public $timestamps = false;
    protected $primaryKey = "iitemid";
    const STATUS_ACTIVE = "Active";
    const PRODUCT_IMAGEPATH = 'images/assets/productImages/';
    /*public static $VITEMTYPE = array(
        1 => 'Statndard',
        2 => 'Lot Martix',
        3 => 'Lotterry'
    );
    public static $YESNO = array(
        1 => 'Yes',
        2 => 'No',
    );
    public static $VFOODITEM = array(
        1 => 'Y',
        2 => 'N',
    );*/
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
        "product_image"
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
    public function GetItemPrice(){
       $itemPrice = Item:://where('MST_ITEM.ISALESID','=',$iSalesID)
                        // ->currentStore();
                         get(array('mst_item.vbarcode',
                                    'mst_item.vitemname',
                                    'mst_item.vitemtype',
                                    'mst_item.npack',
                                    'mst_item.nunitcost',
                                    'mst_item.dcostprice',
                                    'mst_item.nsaleprice'
                                ));

        if (Request::isJson()){
            return $itemPrice->toJson();
        }
        else{
            return $itemPrice;
        }
    }
    public function getProductImageAttribute(){
        return url('/api/admin/products/image/'. $this->attributes['iitemid']);
    }
    public function group()
    {
        return $this->hasMany('pos2020\ITEMGROUPDETAIL');
    }
    public function scopeCurrentStore($query) {
        return  $query->where('mst_item.SID', SESSION::get('selected_store_id'));
    }
    public function store()
    {
        return $this->belongsTo(Store::class);
    }
   /* public function category()
    {
        return $this->hasMany('pos2020\kioskCategory');
    }*/

}
