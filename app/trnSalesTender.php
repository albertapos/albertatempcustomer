<?php

namespace pos2020;

use Illuminate\Database\Eloquent\Model;
use Request;

class trnSalesTender extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'trn_salestender';
    public $timestamps = false;

    /*public function getSalesTenderDetail($iSalesID){
        $trnSalesTender = trnSalesTender::where('trn_salestender.isalesid','=',$iSalesID)
                        // ->currentStore();
                          ->get(array('trn_salestender.*'));

        if (Request::isJson()){
            return $trnSalesTender->toJson();
        }
        else{
            return $trnSalesTender;
        }

    }*/
    public function getTransactionSalesTenderDetail($sid,$salesId){
       // $query = new trnSalesTender;
        $objTransaction = trnSalesTender::take(10);

        $getTransactionSalesTenderDetail = $objTransaction
                            ->where('trn_salestender.SID',$sid)
                            ->Where('trn_salestender.isalesid',$salesId)
                            ->orderBy('itenerid')
                            ->get();

       
         return $getTransactionSalesTenderDetail;
     
    }
    public function scopeCurrentStore($query) {
        return  $query->where('trn_salestender.SID', SESSION::get('selected_store_id'));
    }
}
