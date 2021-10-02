<?php

namespace pos2020;

use Illuminate\Database\Eloquent\Model;
use Validator;
use Request;
use DB;
use Session;
use Config;
class Nplitem extends Model
{
    protected $connection = 'mysql';
    protected $table = 'npl_items';
    public $timestamps = false;
    public $incrementing = false;
    protected $primaryKey = "barcode";
    // const STATUS_ACTIVE = "Active";
    // const PRODUCT_IMAGEPATH = 'images/assets/productImages/';
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
    // protected $appened = array('product_image');
    /*protected $visible = array(
        "barcode",
        "item_type",
        "item_name",
        "description",
        "unit",
        "department",
        "category",
        "supplier",
        "size",
        "cost",
        "selling_price",
        "qty_on_hand",
        "food_stamp",
        "tax1",
        "tax2",
        "selling_unit",
        "food_stamp",
        "WIC_item",
        "age_verification",
    );*/
    
     /*protected $fillable = [
        'barcode','item_type', 'item_name', 'description', 'unit', 'department', 'category','supplier','group','size','cost','selling_price','qty_on_hand','tax1','tax2','selling_unit','food_stamp','WIC_item','age_verification'
    ];*/
    
    protected $guarded = [];


  

}
