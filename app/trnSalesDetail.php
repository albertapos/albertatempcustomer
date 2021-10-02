<?php

namespace pos2020;

use Illuminate\Database\Eloquent\Model;
use Request;
use DB;

class trnSalesDetail extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'trn_salesdetail';
    public $timestamps = false;

    public function GetTop10SalesByQty($sid,$date){

    	$objSalesQty = trnSalesDetail::join('mst_store','mst_store.SID','=','trn_salesdetail.SID')
                        ->orderBy('trn_salesdetail.ndebitqty','desc')
                        ->take(10);

        $top10SalesByQty =  $objSalesQty
                            ->where('trn_salesdetail.SID',$sid)
                             ->where('trn_salesdetail.LastUpdate','>',$date .' 00:00:00') 
                            ->where('trn_salesdetail.LastUpdate','<',$date .' 23:59:59')
                            ->get(array('trn_salesdetail.*'
                                ,'mst_store.vstorename',
                                DB::raw("DATE_FORMAT(trn_salesdetail.LastUpdate,   '%Y-%m-%d'  ) as  LastUpdate ")
                            ));
        return $top10SalesByQty;
    }
    public function getTop10SalesByAmount($sid,$date){

    	$objSalesAmount = trnSalesDetail::join('mst_store','mst_store.SID','=','trn_salesdetail.SID')
                        ->orderBy('trn_salesdetail.nunitprice','desc')
                        ->take(10);


        $top10SalesByAmount = $objSalesAmount
                            ->where('trn_salesdetail.SID',$sid)
                            ->where('trn_salesdetail.LastUpdate','>',$date .' 00:00:00') 
                            ->where('trn_salesdetail.LastUpdate','<',$date .' 23:59:59')
                           // ->Where('trn_salesdetail.LastUpdate','LIKE', "%".$date."%")
                            ->get(array('trn_salesdetail.*'
                        		,'mst_store.vstorename',
                                DB::raw("DATE_FORMAT(trn_salesdetail.LastUpdate,   '%Y-%m-%d'  ) as  LastUpdate ")
                        	));

         return $top10SalesByAmount;
     
    }
    public function getTransactionDetail($sid,$salesId){

        $objTransaction = trnSalesDetail::take(10);

        $getTransactionDetail = $objTransaction
                            ->where('trn_salesdetail.SID',$sid)
                            ->Where('trn_salesdetail.isalesid',$salesId)
                            ->get();

       
         return $getTransactionDetail;
     
    }
    
    public function getTrnSalesDetail($iSalesID){
        $trnSales = trnSalesDetail::where('trn_salesdetail.ISALESID','=',$iSalesID)
                        // ->currentStore();
                          ->get(array(
                                    'trn_salesdetail.isalesid',
                                    'trn_salesdetail.vitemname',
                                    'trn_salesdetail.vcatname',
                                    'trn_salesdetail.vdepname',
                                    'trn_salesdetail.vtax',
                                    'trn_salesdetail.ndebitqty',
                                    'trn_salesdetail.ncreditqty',
                                    'trn_salesdetail.nunitprice',
                                    'trn_salesdetail.ncostprice',
                                    'trn_salesdetail.nextunitprice',
                                    'trn_salesdetail.nextcostprice',
                                    'trn_salesdetail.ndebitamt',
                                    'trn_salesdetail.ncreditamt',
                                    'trn_salesdetail.ndiscountper',
                                    'trn_salesdetail.ndiscountamt',
                                    'trn_salesdetail.nsaleamt',
                                    'trn_salesdetail.nsaleprice',
                                    'trn_salesdetail.nitemtax'
                                ));

        if (Request::isJson()){
            return $trnSales->toJson();
        }
        else{
            return $trnSales;
        }

    }
    public function scopeCurrentStore($query) {
        return  $query->where('trn_salesdetail.SID', SESSION::get('selected_store_id'));
    }
    
    public function getTransactionDetailreturnvalue_new($sid,$salesId){
         
        $objTransaction = trnSalesDetail::take(10);

        // $getTransactionDetail = $objTransaction
        //                     ->where('trn_salesdetail.SID',$sid)
        //                     ->Where('trn_salesdetail.isalesid',$salesId)
        //                     ->get();
        $db = "u".$sid;
        
        // $sold_getTransactionDetail = DB::select("select isalesid, vitemcode, CONCAT(vitemname,' ','@',' ','$',nextunitprice,' ', 'Discount', ' ','$',ndiscountamt)vitemname,vcatname, vdepcode, vdepname, ndebitqty, ncreditqty, 
        //                                     nunitprice, ncostprice, nextunitprice, nextcostprice, ndebitamt, ncreditamt, ndiscountamt, nsaleamt, nsaleprice, 
        //                                     vtax, vunitcode, vunitname, vreason, vadjtype, vuniquetranid, idettrnid, ereturnitem, nitemtax, iunitqty, npack, vsize, 
        //                                     vitemtype, LastUpdate, SID, updateqoh, itemdiscountvalue, itemdiscounttype, itemtaxrateone, itemtaxratetwo, liabilityamount, 
        //                                     preqoh from ".$db.".trn_salesdetail where SID=$sid and isalesid=$salesId and ndebitamt > 0");
        
        //return $salesId; die;
        $returned_getTransactionDetail_value = DB::select("select  sum(ndebitqty) NoReturnitems,  sum(ndebitamt) subTotal ,sum(nitemtax) tax
  from ".$db.".trn_salesdetail where SID=$sid and isalesid=$salesId and ndebitamt < 0 and vitemcode NOT IN('6','10','22','23')");
       
        return $returned_getTransactionDetail_value;
     
    }
    public function getTransactionDetail_new($sid,$salesId){
         
        $objTransaction = trnSalesDetail::take(10);

        // $getTransactionDetail = $objTransaction
        //                     ->where('trn_salesdetail.SID',$sid)
        //                     ->Where('trn_salesdetail.isalesid',$salesId)
        //                     ->get();
        $db = "u".$sid;
        
        $sold_getTransactionDetail = DB::select("select isalesid, vitemcode, CONCAT(vitemname,' ','@',' ','$',nextunitprice,' ', 'Discount', ' ','$',ndiscountamt)vitemname,vcatname, vdepcode, vdepname, ndebitqty, ncreditqty, 
                                            nunitprice, ncostprice, nextunitprice, nextcostprice, ndebitamt, ncreditamt, ndiscountamt, nsaleamt, nsaleprice, 
                                            vtax, vunitcode, vunitname, vreason, vadjtype, vuniquetranid, idettrnid, ereturnitem, nitemtax, iunitqty, npack, vsize, 
                                            vitemtype, LastUpdate, SID, updateqoh, itemdiscountvalue, itemdiscounttype, itemtaxrateone, itemtaxratetwo, liabilityamount, 
                                            preqoh from ".$db.".trn_salesdetail where SID=$sid and isalesid=$salesId and ndebitamt > 0");

        // $returned_getTransactionDetail = DB::select("select isalesid, vitemcode, CONCAT(vitemname,' ','@',' ','$',nextunitprice,' ', 'Discount', ' ','$',ndiscountamt)vitemname,vcatname, vdepcode, vdepname, ndebitqty, ncreditqty, 
        //                                     nunitprice, ncostprice, nextunitprice, nextcostprice, ndebitamt, ncreditamt, ndiscountamt, nsaleamt, nsaleprice, 
        //                                     vtax, vunitcode, vunitname, vreason, vadjtype, vuniquetranid, idettrnid, ereturnitem, nitemtax, iunitqty, npack, vsize, 
        //                                     vitemtype, LastUpdate, SID, updateqoh, itemdiscountvalue, itemdiscounttype, itemtaxrateone, itemtaxratetwo, liabilityamount, 
        //                                     preqoh from ".$db.".trn_salesdetail where SID=$sid and isalesid=$salesId and ndebitamt < 0 and vitemcode NOT IN('6','10','22','23')");
       
        return $sold_getTransactionDetail ;
     
    }
    public function getTransactionDetailreturn_new($sid,$salesId){
         
        $objTransaction = trnSalesDetail::take(10);

        // $getTransactionDetail = $objTransaction
        //                     ->where('trn_salesdetail.SID',$sid)
        //                     ->Where('trn_salesdetail.isalesid',$salesId)
        //                     ->get();
        $db = "u".$sid;
        
        // $sold_getTransactionDetail = DB::select("select isalesid, vitemcode, CONCAT(vitemname,' ','@',' ','$',nextunitprice,' ', 'Discount', ' ','$',ndiscountamt)vitemname,vcatname, vdepcode, vdepname, ndebitqty, ncreditqty, 
        //                                     nunitprice, ncostprice, nextunitprice, nextcostprice, ndebitamt, ncreditamt, ndiscountamt, nsaleamt, nsaleprice, 
        //                                     vtax, vunitcode, vunitname, vreason, vadjtype, vuniquetranid, idettrnid, ereturnitem, nitemtax, iunitqty, npack, vsize, 
        //                                     vitemtype, LastUpdate, SID, updateqoh, itemdiscountvalue, itemdiscounttype, itemtaxrateone, itemtaxratetwo, liabilityamount, 
        //                                     preqoh from ".$db.".trn_salesdetail where SID=$sid and isalesid=$salesId and ndebitamt > 0");

        $returned_getTransactionDetail = DB::select("select isalesid, vitemcode, CONCAT(vitemname,' ','@',' ','$',abs(nextunitprice),' ', 'Discount', ' ','$',abs(ndiscountamt))vitemname,vcatname, vdepcode, vdepname, ndebitqty, ncreditqty, 
                                            nunitprice, ncostprice, nextunitprice, nextcostprice, abs(ndebitamt) as ndebitamt, ncreditamt, ndiscountamt, nsaleamt, nsaleprice, 
                                            vtax, vunitcode, vunitname, vreason, vadjtype, vuniquetranid, idettrnid, ereturnitem, nitemtax, iunitqty, npack, vsize, 
                                            vitemtype, LastUpdate, SID, updateqoh, itemdiscountvalue, itemdiscounttype, itemtaxrateone, itemtaxratetwo, liabilityamount, 
                                            preqoh from ".$db.".trn_salesdetail where SID=$sid and isalesid=$salesId and ndebitamt < 0 and vitemcode NOT IN('6','10','22','23')");
       
        return $returned_getTransactionDetail;
     
    }
     static function getTransactionSalesGrandDetail_new($sid,$salesId){
         
        $objTransaction = trnSalesDetail::take(10);

        
        $db = "u".$sid;
       
        $returned_getTransactionDetail_total = DB::select("select b.vtendertype, ABS(a.namount) namount ,b.vTenderTag,b.itenderid from 
        $db.trn_salestender a, $db.mst_tentertype b where a.itenerid = b.itenderid and itenderid<>120 AND a.isalesid =$salesId");
       
        return $returned_getTransactionDetail_total;
     
    }
    public function getTransactionSalesGrandDetailDiscount_new($sid,$salesId){
         
        $objTransaction = trnSalesDetail::take(10);

        
        $db = "u".$sid;
        
      
        $returned_discount = DB::select("SELECT distinct a.isalesid,b.nsaleamt as discount,a.NCHANGE,a.NNETTOTAL,a.nsubtotal+a.ntaxtotal as Tender
      FROM $db.trn_sales a,$db.trn_salesdetail b,$db.mst_item C,mst_category d WHERE b.VITEMCODE = C.VITEMCODE AND a.ISALESID = b.ISALESID 
         AND C.vCategoryCode = d.vCategoryCode AND a.ISALESID=$salesId");
       
        return $returned_discount;
     
    }
}
