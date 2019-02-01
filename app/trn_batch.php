<?php

namespace pos2020;

use Illuminate\Database\Eloquent\Model;
use DB;
use Request;

class trn_batch extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'trn_batch';
    public $timestamps = false;

    public function getXSales(){
    	$query = new trn_batch;
        
        $objXSalesDetail = trn_batch::groupBy('trn_batch.SID');
                                        //->where('trn_batch.ISTOREID','101');
                                        // ->currentStore();

         //dd($objDailysales);
        $XSales = $objXSalesDetail->get(array(
                                    DB::raw('sum(trn_batch.nopeningbalance) as beg_balance'),
                                    DB::raw('sum(trn_batch.nnetcashpickup) as cash_pickup'),
                                    DB::raw('sum(trn_batch.nnetaddcash) as cash_added'),
                                    DB::raw('sum(trn_batch.ntotalsales) as total_sale'),
                                    DB::raw('sum(trn_batch.ntotaltax) AS total_sales'),
                                    DB::raw('sum(trn_batch.ntotalcashsales) as total_cashSales'),
                                    DB::raw('sum(trn_batch.ntotalcreditsales) as total_creditSales'),
                                    DB::raw('sum(trn_batch.ntotalreturns) as total_returns'),
                                    DB::raw('sum(trn_batch.ntotalgiftsales) as total_giftSales'),
                                    DB::raw('sum(trn_batch.ntotalchecksales) as total_checkSales'),
                                    DB::raw('sum(trn_batch.ntotaltaxable) as total_taxableSales'),
                                    DB::raw('sum(trn_batch.ntotalnontaxable) as total_nonTaxableSales'),
                                    DB::raw('sum(trn_batch.nnetpaidout) as total_paidOut'),
                                    DB::raw('sum(trn_batch.ntotaldiscount) as total_discount'),
                                    DB::raw('sum(trn_batch.ntotaldebitsales) as total_debitSales'),
                                    DB::raw('sum(trn_batch.ntotalebtsales) as total_ebtSales'),
                                    'trn_batch.SID'
                                    ));

        if (Request::isJson()){
            return $XSales->toJson();
        }
        else{
            return $XSales;
        }
    }
    public function scopeCurrentStore($query) {
        return  $query->where('trn_batch.SID', SESSION::get('selected_store_id'));
    }
}
