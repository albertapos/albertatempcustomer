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
}
