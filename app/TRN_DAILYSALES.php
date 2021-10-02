<?php

namespace pos2020;

use Illuminate\Database\Eloquent\Model;
use DB;
use Request;
use Session;
use pos2020\Store;
class TRN_DAILYSALES extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'trn_dailysales';
    public $timestamps = false;


    public function getDailySales($dates = null){
    	$query = new trn_dailysales;

        if(is_null($dates) ) {
            $dates[] = date("Y-m-d", time() - (7*24*60*60));
            $dates[] = date("Y-m-d");
        }
    
		// $objDailysales = trn_dailysales::groupBy('trn_dailysales.ddate')
  //                                       ->whereBetween('ddate',$dates)
  //                                       ->currentStore();

  //       $data = $objDailysales->get(array(
  //                       	 		DB::raw('sum(trn_dailysales.nopeningbalance) as beg_balance'),
  //                       	        DB::raw('sum(trn_dailysales.nnetcashpickup) as cash_pickup'),
  //                       	        DB::raw('sum(trn_dailysales.nnetaddcash) as cash_added'),
  //                       	        DB::raw('sum(trn_dailysales.ntotalsales) as total_sale'),
  //                       			DB::raw('sum(trn_dailysales.ntotaltax) AS total_tax'),
  //                       	        DB::raw('sum(trn_dailysales.ntotalcashsales) as total_cashSales'),
  //                       	        DB::raw('sum(trn_dailysales.ntotalcreditsales) as total_creditSales'),
  //                       	        DB::raw('sum(trn_dailysales.ntotalreturns) as total_returns'),
  //                       	        DB::raw('sum(trn_dailysales.ntotalgiftsales) as total_giftSales'),
  //                       	        DB::raw('sum(trn_dailysales.ntotalchecksales) as total_checkSales'),
  //                       	        DB::raw('sum(trn_dailysales.ntotaltaxable) as total_taxableSales'),
  //                       	        DB::raw('sum(trn_dailysales.ntotalnontaxable) as total_nonTaxableSales'),
  //                       	        DB::raw('sum(trn_dailysales.nnetpaidout) as total_paidOut'),
  //                       	        DB::raw('sum(trn_dailysales.ntotaldiscount) as total_discount'),
  //                       	        DB::raw('sum(trn_dailysales.ntotaldebitsales) as total_debitSales'),
  //                       	        DB::raw('sum(trn_dailysales.ntotalebtsales) as total_ebtSales'),
  //                       	        DB::raw("DATE_FORMAT(trn_dailysales.ddate,   '%b-%d'  ) as  date")
  //                       	        ))->toArray();
        if(is_null($dates) ) {
            $dt = \Carbon\Carbon::now()->setTimezone('EST')->format('m-d-Y');
        }else{
            $dt = $dates[0];
        }
        

        $store_id = Session::get('selected_store_id');
    
        $data = DB::connection('mysql2')->select("call rp_salessummarychart('".$dt."','".$store_id."')");
        
        //dd($data);
        
        // dd(gettype($data));

        $return_data = array();
        $return_data[0] = array();
        
        // dd($data[0]);
        
        return $data[0];
        
        $return_data[0]['beg_balance'] = $data[0]['nopeningbalance'];
        $return_data[0]['cash_pickup'] = $data[0]['npickup'];
        $return_data[0]['cash_added'] = $data[0]['naddcash'];
        $return_data[0]['total_sale'] = $data[0]['nettotal'];
        $return_data[0]['total_tax'] = $data[0]['ntaxtotal'];
        $return_data[0]['total_cashSales'] = $data[0]['ncashamount'];
        $return_data[0]['total_creditSales'] = $data[0]['nopeningbalance'];
        $return_data[0]['total_returns'] = $data[0]['nreturnamount'];
        $return_data[0]['total_giftSales'] = $data[0]['ngiftsales'];
        $return_data[0]['total_checkSales'] = $data[0]['ncheckamount'];
        $return_data[0]['total_taxableSales'] = $data[0]['ntaxable'];
        $return_data[0]['total_nonTaxableSales'] = $data[0]['nnontaxabletotal'];
        $return_data[0]['total_paidOut'] = $data[0]['npaidout'];
        $return_data[0]['total_discount'] = $data[0]['ndiscountamt'];
        $return_data[0]['total_debitSales'] = $data[0]['ndebitsales'];
        $return_data[0]['total_ebtSales'] = $data[0]['nebtsales'];
        
        dd($return_data);

      return $return_data;
	
    }
    public function getSummary($date = null, $sid = null){
        $query = new trn_dailysales;

        if(is_null($date)) {
            $date = date("Y-m-d");
            $dates[] = date("Y-m-d", (strtotime($date)) - (7*24*60*60));
            $dates[] = date("Y-m-d", (strtotime($date)) - (24*60*60));
        }  
        else if(is_array($date)) {
            // $dates = $date;
            $dt = \Carbon\Carbon::now()->setTimezone('EST')->format('m-d-Y');

        }
        else  {
            $dates[] = date("Y-m-d", (strtotime($date)) - (7*24*60*60));
            $dates[] = date("Y-m-d", (strtotime($date)) - (24*60*60));
        }

        // $objDailysales = trn_dailysales::groupBy('trn_dailysales.ddate')
        //                                 ->whereBetween('DDATE',$dates);
        // if(!is_null($sid) && $sid > 0 ) {
        //     $objDailysales->where('sid',$sid);
        // } else {
        //     $objDailysales->currentStore();
        // }

        // $data = $objDailysales->get(array(
        //                             DB::raw('sum(trn_dailysales.nopeningbalance) as beg_balance'),
        //                             DB::raw('sum(trn_dailysales.nnetcashpickup) as cash_pickup'),
        //                             DB::raw('sum(trn_dailysales.nnetaddcash) as cash_added'),
        //                             DB::raw('sum(trn_dailysales.ntotalsales) as total_sale'),
        //                             DB::raw('sum(trn_dailysales.ntotaltax) AS total_tax'),
        //                             DB::raw('sum(trn_dailysales.ntotalcashsales) as total_cashSales'),
        //                             DB::raw('sum(trn_dailysales.ntotalcreditsales) as total_creditSales'),
        //                             DB::raw('sum(trn_dailysales.ntotalreturns) as total_returns'),
        //                             DB::raw('sum(trn_dailysales.ntotalgiftsales) as total_giftSales'),
        //                             DB::raw('sum(trn_dailysales.ntotalchecksales) as total_checkSales'),
        //                             DB::raw('sum(trn_dailysales.ntotaltaxable) as total_taxableSales'),
        //                             DB::raw('sum(trn_dailysales.ntotalnontaxable) as total_nonTaxableSales'),
        //                             DB::raw('sum(trn_dailysales.nnetpaidout) as total_paidOut'),
        //                             DB::raw('sum(trn_dailysales.ntotaldiscount) as total_discount'),
        //                             DB::raw('sum(trn_dailysales.ntotaldebitsales) as total_debitSales'),
        //                             DB::raw('sum(trn_dailysales.ntotalebtsales) as total_ebtSales'),
        //                             DB::raw("DATE_FORMAT(trn_dailysales.ddate,   '%c-%d'  ) as  date")
        //                             ));
        
        //$store = Store::where('id',Session::get('selected_store_id'))->first();

        //$store->setdb();

        // $data = DB::connection('mysql2')->table('trn_dailysales')->get();
        // $data = trn_dailysales::all();

        $store_id = Session::get('selected_store_id');
        
        $data = DB::connection('mysql2')->select("call rp_salessummarychart('".$dt."','".$store_id."')");
        // dd($data);
        
        return $data;    
    }
    public function getSummaryDetail($date = null, $sid = null){
         
        // $query = new trn_dailysales;

        // if(is_null($date)) {
        //     $date = date("Y-m-d");
        //     $dates[] = date("Y-m-d", (strtotime($date)) - (7*24*60*60));
        //     $dates[] = date("Y-m-d", (strtotime($date)) - (24*60*60));
        // }  
        // else if(is_array($date)) {
        //     $dates = $date;
        // }
        // else  {
        //     $dates[] = date("Y-m-d", (strtotime($date)) - (7*24*60*60));
        //     $dates[] = date("Y-m-d", (strtotime($date)) - (24*60*60));
        // }
        // $objDailysales = trn_dailysales::groupBy('trn_dailysales.ddate')
        //                                 ->whereBetween('ddate',$dates);
        // if(!is_null($sid) && $sid > 0 ) {
        //     $objDailysales->where('SID',$sid);
        // } else {
        //     $objDailysales->currentStore();
        // }
        // $data = $objDailysales->get(array(
        //                             DB::raw('sum(trn_dailysales.nopeningbalance) as beg_balance'),
        //                             DB::raw('sum(trn_dailysales.nnetcashpickup) as cash_pickup'),
        //                             DB::raw('sum(trn_dailysales.nnetaddcash) as cash_added'),
        //                             DB::raw('sum(trn_dailysales.ntotalsales) as total_sale'),
        //                             DB::raw('sum(trn_dailysales.ntotaltax) AS total_tax'),
        //                             DB::raw('sum(trn_dailysales.ntotalcashsales) as total_cashSales'),
        //                             DB::raw('sum(trn_dailysales.ntotalcreditsales) as total_creditSales'),
        //                             DB::raw('sum(trn_dailysales.ntotalreturns) as total_returns'),
        //                             DB::raw('sum(trn_dailysales.ntotalgiftsales) as total_giftSales'),
        //                             DB::raw('sum(trn_dailysales.ntotalchecksales) as total_checkSales'),
        //                             DB::raw('sum(trn_dailysales.ntotaltaxable) as total_taxableSales'),
        //                             DB::raw('sum(trn_dailysales.ntotalnontaxable) as total_nonTaxableSales'),
        //                             DB::raw('sum(trn_dailysales.nnetpaidout) as total_paidOut'),
        //                             DB::raw('sum(trn_dailysales.ntotaldiscount) as total_discount'),
        //                             DB::raw('sum(trn_dailysales.ntotaldebitsales) as total_debitSales'),
        //                             DB::raw('sum(trn_dailysales.ntotalebtsales) as total_ebtSales'),
        //                             DB::raw("DATE_FORMAT(trn_dailysales.ddate,   '%c-%d'  ) as  date")
        //                             ));

        // return $data;

        //new code
        if(is_null($date) ) {
            $dt = \Carbon\Carbon::now()->setTimezone('EST')->format('m-d-Y');
        }else{
            $dt = $date[0];
            $dt = date('m-d-Y',strtotime($dt));
        }
        
        $store_id = $sid;
    
        //$dt='06-03-2020';
        $db = "u".$store_id;
        
        // $data = DB::connection('mysql')->select("call inslocdb.rp_salessummarychart('".$dt."','".$store_id."')");
        
        $data = DB::connection('mysql')->select("call ".$db.".rp_salessummarychart('".$dt."','".$store_id."')");
        $m = $data[0];

        $return_data = array();
        $return_data[0]['beg_balance'] = $m->nopeningbalance;
        $return_data[0]['cash_pickup'] = $m->npickup;
        $return_data[0]['cash_added'] = $m->naddcash;
        $return_data[0]['total_sale'] = $m->nettotal;
        $return_data[0]['total_tax'] = $m->ntaxtotal;
        $return_data[0]['total_cashSales'] = $m->ncashamount;
        $return_data[0]['total_creditSales'] = $m->ncreditsales;
        $return_data[0]['total_creditCardSales'] = $m->ncreditcardsales;
        $return_data[0]['total_returns'] = $m->nreturnamount;
        $return_data[0]['total_giftSales'] = $m->ngiftsales;
        $return_data[0]['total_checkSales'] = $m->ncheckamount;
        $return_data[0]['total_taxableSales'] = $m->ntaxable;
        $return_data[0]['total_nonTaxableSales'] = $m->nnontaxabletotal;
        $return_data[0]['total_paidOut'] = $m->npaidout;
        $return_data[0]['total_discount'] = $m->ndiscountamt;
        $return_data[0]['total_debitSales'] = $m->ndebitsales;
        $return_data[0]['total_ebtSales'] = $m->nebtsales;
        $return_data[0]['ddate'] = date('n-d',strtotime($m->osdate));

      return $return_data;    
    }
    
    public function scopeCurrentStore($query) {
       return  $query->where('trn_dailysales.SID', SESSION::get('selected_store_id'));
    }
}
