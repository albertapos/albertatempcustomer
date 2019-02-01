<?php

namespace pos2020;

use Illuminate\Database\Eloquent\Model;
use Request;
use DB;
use SESSION;

class TRN_SALES extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'trn_sales';
    public $timestamps = false;

    public  function getLast20Transaction($sid){
    	$query = new trn_sales;
            $last20Transaction = trn_sales::where('vtrntype','Transaction')
                                    ->where('SID',$sid)
                                    ->orderBy('trn_sales.dtrandate','desc')
                                    ->take(20)
                                    ->get();
            
        return $last20Transaction;
	}
   /* public function getTrnSales($iSalesID){
        $trnSales = trn_sales::where('trn_sales.isalesid','=',$iSalesID)
                       //->currentStore();
                          ->get(array('trn_sales.vtrntype',
                                    'trn_sales.isalesid',
                                    'trn_sales.vusername',
                                    'trn_sales.vcustomername',
                                    'trn_sales.dtrandate',
                                    'trn_sales.vterminalid',
                                    'trn_sales.vtrntype',
                                    'trn_sales.vdiscountname',
                                    'trn_sales.nnontaxabletotal',
                                    'trn_sales.ntaxabletotal',
                                    'trn_sales.ntaxtotal',
                                    'trn_sales.nsubtotal',
                                    'trn_sales.nnettotal',
                                    'trn_sales.ndiscountamt',
                                    'trn_sales.nsaletotalamt',
                                    'trn_sales.nchange',
                                    'trn_sales.vtendertype'
                                ));

        if (Request::isJson()){
            return $trnSales->toJson();
        }
        else{
            return $trnSales;
        }

    }*/
    public function getTransactionSales($sid,$salesId){

        $objTransaction = trn_sales::take(10);

        $getTransactionSales = $objTransaction
                            ->where('trn_sales.SID',$sid)
                            ->Where('trn_sales.isalesid',$salesId)
                            ->get();
       
         return $getTransactionSales;
    }
    public function getTransaction($sid){

        $objTransaction = trn_sales::take(10);

        $getTransaction = $objTransaction
                            ->where('trn_sales.SID',$sid)
                            ->get(array('SID',
                                'isalesid',
                                'dtrandate',
                                'vterminalid',
                                'vtrntype',
                                'nnettotal',
                                'LastUpdate',
                                'vtendertype'
                                ));
       
         return $getTransaction;
    }
    public function getSalesByDays($dates = null) {
     
        if(is_null($dates) ) {
            $dates[] = date("Y-m-d ", time() - (30*24*60*60));
            $dates[] = date("Y-m-d");
        }
        $dates[0] = $dates[0].' 00:00:00';
        $dates[1] = $dates[1].' 23:59:59';
        $data =  trn_sales::whereBetween('dtrandate',$dates)
                        ->where('vtrntype','Transaction') 
                        ->orderBy('date')
                        ->currentStore()
                        ->groupBy('date')
                        ->get(array(DB::raw("DATE_FORMAT(trn_sales.dtrandate,   '%b-%d'  ) as  date"), DB::raw('sum(nnettotal) AS total ')))
                        ->toArray();
       // dd($data);
        return $data;
    }

    /*public function getTopCategoryByDate($dates = null){

        if(is_null($dates) ) {
            $dates[] = date("Y-m-d", time() - (30*24*60*60));
            $dates[] = date("Y-m-d");
        }
        $data =  trn_sales::join('trn_salesdetail','trn_salesdetail.isalesid','=','trn_sales.isalesid')
                        ->join('mst_category','mst_category.vcategorycode','=','trn_salesdetail.vcatcode')
                        ->whereBetween('dtrandate',$dates) 
                        ->currentStore()
                        ->groupBy('trn_salesdetail.vcatcode')
                        ->groupBy('mst_category.vcategoryname')
                        ->orderBy('total','DESC')
                        ->get(array(DB::raw('count(trn_salesdetail.vcatcode) AS total '),DB::raw('mst_category.vcategoryname AS category ')))
                        ->take(5)
                        ->toArray();

        return $data;
    }*/
    public function getTopCategoryByDate($dates = null){

        if(is_null($dates) ) {
            $dates[] = date("Y-m-d", time() - (30*24*60*60));
            $dates[] = date("Y-m-d");
        }

        $dates[0] = $dates[0].' 00:00:00';
        $dates[1] = $dates[1].' 23:59:59';

        $data =  trn_sales::join('trn_salesdetail','trn_salesdetail.isalesid','=','trn_sales.isalesid')
                        ->join('mst_category','mst_category.vcategorycode','=','trn_salesdetail.vcatcode')
                        ->whereBetween('dtrandate',$dates) 
                        ->currentStore()
                        ->groupBy('mst_category.vcategoryname')
                        ->orderBy('total','DESC')
                        ->get(array(DB::raw('sum(trn_salesdetail.nextunitprice) AS total'),DB::raw('mst_category.vcategoryname AS category')))
                        ->take(5)
                        ->toArray();

        return $data;
    }
    public function getCustomerByDates($dates = null,$storeId = null, $date_format = '%Y-%m-%d'){
        if(is_null($dates) ) {
            $dates[] = date("Y-m-d", time() - (30*24*60*60));
            $dates[] = date("Y-m-d 23:59:59");
        }
        $dates[0] = $dates[0].' 00:00:00';
        $dates[1] = $dates[1].' 23:59:59';
        $obj =  trn_sales::whereBetween('dtrandate',$dates) 
                        ->groupBy('date')
                        ->orderBy('date')
                        ->groupBy('trn_sales.SID');
        if(!is_null($storeId) && $storeId > 0 ){
            $obj->where('trn_sales.SID','=',$storeId);
        }
        $data = $obj->get(array(DB::raw("DATE_FORMAT(dtrandate,   '".$date_format."'  ) as  date "),
                            DB::raw('count(trn_sales.isalesid) AS total '), 'trn_sales.SID' ))
                        ->toArray();
        return $data;
    }

    public function getVoidByDates($dates = null,$storeId = null){
        if(is_null($dates) ) {
            $dates[] = date("Y-m-d", time() - (30*24*60*60));
            $dates[] = date("Y-m-d");
        }
        $dates[0] = $dates[0].' 00:00:00';
        $dates[1] = $dates[1].' 23:59:59';
        $obj =  trn_sales::whereBetween('dtrandate',$dates) 
                        ->where('vtrntype','Void')
                        ->groupBy('date')
                        ->groupBy('trn_sales.SID');
        if(!is_null($storeId) && $storeId > 0 ){
            $obj->where('trn_sales.SID','=',$storeId);
        }
        $data = $obj->get(array(DB::raw("DATE_FORMAT(dtrandate,   '%Y-%m-%d'  ) as  date "),
                            DB::raw('count(trn_sales.isalesid) AS total '), 'trn_sales.SID' ))
                        ->toArray();
        return $data;
    }

    public function getCustomerDashboard($date = null){


        if(is_null($date)) {
            $date = date("Y-m-d");
        } 
        $fdate = date("Y-m-d 00:00:00", (strtotime($date)) - (7*24*60*60));
        $tdate = date("Y-m-d 23:59:59", (strtotime($date)) - (24*60*60));
        $ydate = date("Y-m-d", (strtotime($date)) - (24*60*60));

        $result = array();
        $data1 =  self::where('dtrandate','>',$date .' 00:00:00') 
                        ->where('dtrandate','<',$date .' 23:59:59')
                        ->groupBy('SID')
                        ->currentStore()
                        ->get(array( DB::raw('count(isalesid) AS total '), 'SID'));
        $result['today'] = count($data1)> 0 ?$data1[0]->total:0;
        $data2 =  self::whereBetween('dtrandate',array($ydate.' 00:00:00',$ydate.' 23:59:59')) 
                        ->groupBy('SID')
                        ->currentStore()
                        ->get(array( DB::raw('count(isalesid) AS total '), 'SID'));
        $result['yesterday'] = count($data2)> 0 ?$data2[0]->total:0;
        $data =  self::whereBetween('dtrandate',array($fdate,$date)) 
                        ->groupBy('SID')
                        ->currentStore()
                        ->get(array( DB::raw('count(isalesid) AS total '), 'SID'));
        $result['week'] = count($data)> 0 ?$data[0]->total:0;
        return $result;

        
    }

    public function getVoidDashboard($date = null){


        if(is_null($date)) {
            $date = date("Y-m-d");
        } 
        $fdate = date("Y-m-d 00:00:00", (strtotime($date)) - (7*24*60*60));
        $tdate = date("Y-m-d 23:59:59", (strtotime($date)) - (24*60*60));
        $ydate = date("Y-m-d", (strtotime($date)) - (24*60*60));
        
        $result = array();
        $data =  self::where('dtrandate','>',$date .' 00:00:00') 
                        ->where('dtrandate','<',$date .' 23:59:59')
                        ->where('vtrntype','Void')
                        ->currentStore()
                        ->groupBy('SID')
                        ->get(array( DB::raw('count(isalesid) AS total '), 'SID'));
        $result['today'] = count($data)> 0 ?$data[0]->total:0;
        $data =  self::where('dtrandate','>',$ydate .' 00:00:00') 
                        ->where('dtrandate','<',$ydate .' 23:59:59') 
                        ->where('vtrntype','Void')
                        ->currentStore()
                        ->groupBy('SID')
                        ->get(array( DB::raw('count(isalesid) AS total '), 'SID'));
        $result['yesterday'] = count($data)> 0 ?$data[0]->total:0;
        $data =  self::whereBetween('dtrandate',array($fdate,$date)) 
                        ->where('vtrntype','Void')
                        ->currentStore()
                        ->groupBy('SID')
                        ->get(array( DB::raw('count(isalesid) AS total '), 'SID'));
        $result['week'] = count($data)> 0 ?$data[0]->total:0;
        return $result;

        
    }

     public function getCustomerByHour($date = null){
       
        if(is_null($date)) {
            $date = date("Y-m-d");
            
        }
        $dates = [];
        $dates[] = date("Y-m-d", (strtotime($date)) - (24*60*60));
        $dates[] = $date ;

        $dates[0] = $dates[0].' 00:00:00';
        $dates[1] = $dates[1].' 23:59:59';
      
        $data =  trn_sales::whereBetween('dtrandate',$dates) 
                        ->currentStore()
                        ->groupBy('date')
                        ->get(array(DB::raw("DATE_FORMAT( dtrandate , '%m/%d/%Y' ) as  date "),DB::raw('count(trn_sales.icustomerid) AS total')))
                        ->toArray();
        return $data;
    }

    public function getCustomerByHours($date = null){

        $dates = [];
        
        if(is_null($date)) {
            $dates[1] = \Carbon\Carbon::now()->setTimezone('EST')->toDateTimeString();
            $dates[0] = \Carbon\Carbon::now()->setTimezone('EST')->subDay()->subHour()->toDateTimeString();
        }else{
            $today_date = \Carbon\Carbon::now()->setTimezone('EST')->format('Y-m-d');
            if($date == $today_date){
                $dates[1] = \Carbon\Carbon::now()->setTimezone('EST')->toDateTimeString();
                $dates[0] = \Carbon\Carbon::now()->setTimezone('EST')->subDay()->subHour()->toDateTimeString();
            }else{
                $dates[0] = $date.' 00:00:00';
                $dates[1] = $date.' 23:59:59';
            }
            
        }
        // $data =  trn_sales::whereBetween('LastUpdate',$dates) 
        //                 ->currentStore()
        //                 ->groupBy('date')
        //                 ->get(array(DB::raw("DATE_FORMAT( LastUpdate , '%m/%d/%Y' ) as  date "),DB::raw('count(trn_sales.icustomerid) AS total')))
        //                 ->toArray();
        // dd($dates);

        //testing for golden db
        // $datas =  trn_sales::whereBetween('LastUpdate',array($dates[0],$dates[1])) 
        //                 // ->currentStore()
        //                 ->where('SID',1000)
        //                 ->groupBy('hour')
        //                 ->orderBy('hour','desc')
        //                 ->get(array(DB::raw("DATE_FORMAT( LastUpdate , '%H' ) as  hour "),DB::raw('count(1) AS custcount')))
        //                 ->toArray();
        //testing for golden db
        // dd($datas);

        $datas =  trn_sales::whereBetween('dtrandate',array($dates[0],$dates[1])) 
                        ->currentStore()
                        // ->where('SID',1000)
                        ->groupBy('hour')
                        ->orderBy('hour','desc')
                        ->get(array(DB::raw("DATE_FORMAT( dtrandate , '%H' ) as  hour "),DB::raw('count(1) AS custcount')))
                        ->toArray();
        //reverse array
        
        $date_arr = array();
        $data_hours = array();

        $first_date = \Carbon\Carbon::now()->setTimezone('EST')->toDateTimeString();
        
        $nn = \Carbon\Carbon::now()->setTimezone('EST')->toDateTimeString();
        for($n = 0 ;$n <= 23; $n++){

            if($n == 0){
                $nn = \Carbon\Carbon::parse($first_date)->toDateTimeString();
            }else{
                $nn = \Carbon\Carbon::parse($nn)->subHour()->toDateTimeString();
            }
            array_push($data_hours, \Carbon\Carbon::parse($nn)->hour);
        }

        $data_hours = array_reverse($data_hours, true);
        
        $main_date_data = array();
        foreach ($data_hours as $hour) {
            foreach ($datas as $key => $data) {
                if($data['hour'] == $hour){
                    $temporary = array();
                    $temporary['date'] = "".$hour.":00";
                    $temporary['total'] = "".$data['custcount']."";
                    $main_date_data[$hour] = $temporary;
                }else{
                    if (!array_key_exists($hour, $main_date_data)){
                        $temporary = array();
                        $temporary['date'] = "".$hour.":00";
                        $temporary['total'] = "0";
                        $main_date_data[$hour] = $temporary;
                    }
                }
            }
        }
        $chart_data = array();
        foreach ($main_date_data as $main_date_datas) {
            $chart_data[] = $main_date_datas;
        }
        
        // dd($chart_data);
                      
        return $chart_data;
    }
  
    public function getTopSaleItemByDate($dates = null,$storeId = null){
        if(is_null($dates) ) {
            $dates[] = date("Y-m-d", time() - (30*24*60*60));
            $dates[] = date("Y-m-d");
        }
        $dates[0] = $dates[0].' 00:00:00';
        $dates[1] = $dates[1].' 23:59:59';
        if(!is_null($storeId) && $storeId > 0 ){
            $data =  trn_sales::join('trn_salesdetail','trn_salesdetail.isalesid','=','trn_sales.isalesid')
                        ->join('mst_item','mst_item.vitemcode','=','trn_salesdetail.vitemcode')
                        ->whereBetween('dtrandate',$dates) 
                        //->where('trn_sales.SID','=',$storeId)
                        ->groupBy('trn_sales.isalesid')
                        ->groupBy('date')
                        ->groupBy('trn_sales.SID')
                        ->get(array(DB::raw("DATE_FORMAT(dtrandate,   '%m/%d/%Y'  ) as  date "),DB::raw('count(trn_sales.isalesid) AS total ')))
                        ->toArray();
            return $data;
        }
        $data =  trn_sales::join('trn_salesdetail','trn_salesdetail.isalesid','=','trn_sales.isalesid')
                        ->join('mst_item','mst_item.vitemcode','=','trn_salesdetail.vitemcode')
                        ->whereBetween('dtrandate',$dates) 
                        ->currentStore()
                       // ->groupBy('trn_salesDETAIL.VITEMCODE')
                        ->groupBy('trn_salesdetail.ndebitqty')
                        ->groupBy('mst_item.vitemname')
                        ->orderBy('Quantity','DESC')
                        ->get(array(DB::raw('count(trn_salesdetail.ndebitqty) AS Quantity '),DB::raw('mst_item.vitemname AS Item ')))
                        ->take(5)
                        ->toArray();
        return $data;
    }
  

    public function getSaleByDate($dates = null,$storeId = null){
        if(is_null($dates) ) {
            $dates[] = date("Y-m-d", time() - (30*24*60*60));
            $dates[] = date("Y-m-d");
        }

        $dates[0] = $dates[0].' 00:00:00';
        $dates[1] = $dates[1].' 23:59:59';

        // $obj =  trn_sales::join('trn_salesdetail','trn_salesdetail.isalesid','=','trn_sales.isalesid')
        //                 ->join('mst_item','mst_item.vitemcode','=','trn_salesdetail.vitemcode')
        //                 ->whereBetween('dtrandate',$dates) 
        //                 // ->groupBy('dtrandate')
        //                 ->groupBy('trn_sales.SID');
        // if(!is_null($storeId) && $storeId > 0 ){
        //     $obj->where('trn_sales.SID','=',$storeId);
        // }
        // $data = $obj->groupBy('date')
        //         ->get(array(DB::raw("DATE_FORMAT(dtrandate,   '%Y-%m-%d'  ) as  date "),
        //                     DB::raw('count(trn_sales.isalesid) AS total '), 'trn_sales.SID' ))
        //                 ->toArray();

        $data =  trn_sales::where('dtrandate','>',$dates[0]) 
                        ->where('dtrandate','<',$dates[1])
                        ->where('vtrntype','Transaction')
                        ->groupBy('date')
                        ->currentStore()
                        ->get(array(DB::raw("DATE_FORMAT(trn_sales.dtrandate,   '%Y-%m-%d'  ) as  date"), DB::raw('sum(nnettotal) AS total ')));
        return $data;
    }


    public function getTopSaleItemByAmount($dates = null){

        if(is_null($dates) ) {
            $dates[] = date("Y-m-d", time() - (7*24*60*60));
            $dates[] = date("Y-m-d");
        }
        $data =  trn_sales::join('trn_salesdetail','trn_salesdetail.isalesid','=','trn_sales.isalesid')
                        ->join('mst_item','mst_item.vitemcode','=','trn_salesdetail.vitemcode')
                        ->whereBetween('dtrandate',$dates) 
                        ->currentStore()
                       // ->groupBy('trn_salesdetail.VITEMCODE')
                        ->groupBy('trn_salesdetail.ncostprice')
                        ->groupBy('mst_item.vitemname')
                        ->orderBy('Price','DESC')
                        ->get(array(DB::raw('count(trn_salesdetail.ncostprice) AS Price '),DB::raw('mst_item.vitemname AS Item ')))
                        ->take(10)
                        
                        ->toArray();
        return $data;
    }

    public function getProducts($fdate,$tdate){
    
        $data = trn_sales::join('trn_salesdetail','trn_salesdetail.isalesid','=','trn_sales.isalesid')
                            ->join('mst_item','mst_item.vitemcode','=','trn_salesdetail.vitemcode')
                            ->whereBetween('dtrandate',[$fdate,$tdate]) 
                            ->currentStore()
                            ->groupBy('mst_item.vitemname')
                            ->groupBy('dtrandate')
                            ->get(array(DB::raw("DATE_FORMAT(dtrandate,   '%c-%d'  ) as  date "),DB::raw('mst_item.vitemname as Item ')))
                            ->toArray();
                           
        return $data;
    }

    public function getTodaySale($dates = null){
    
        
        if(is_null($dates)) {
            $dates = date("Y-m-d");
        } 
        $data =  trn_sales::where('dtrandate','>',$dates .' 00:00:00') 
                            ->where('dtrandate','<',$dates .' 23:59:59')
                            ->where('vtrntype','Transaction')
                            ->orderBy('date','desc')
                            ->groupBy('date')
                            ->currentStore()
                            ->get(array(DB::raw("DATE_FORMAT(trn_sales.dtrandate,   '%b-%d'  ) as  date"), DB::raw('sum(nnettotal) AS total ')));
        return $data;
    }
    public function getYesterdaySale($dates = null){
       
        if(is_null($dates)) {
            $dates = date("Y-m-d");
        } 
        $dates = date("Y-m-d", (strtotime($dates)) - (24*60*60));
        $data =  trn_sales::where('dtrandate','>',$dates .' 00:00:00') 
                        ->where('dtrandate','<',$dates .' 23:59:59')
                        ->where('vtrntype','Transaction')
                        ->orderBy('date','desc')
                        ->groupBy('date')
                        ->currentStore()
                        ->get(array(DB::raw("DATE_FORMAT(trn_sales.dtrandate,   '%b-%d'  ) as  date"), DB::raw('sum(nnettotal) AS total ')));
        return $data;
    }
    public function getWeeklySales($date = null){
        if(is_null($date) ) {
            $date = date("Y-m-d");
        } 
        $dates[] = date("Y-m-d 00:00:00", strtotime($date) - (7*24*60*60));
        $dates[] = $date. ' 23:59:59';
        
        $data =  trn_sales::whereBetween('dtrandate',$dates)
                        ->where('vtrntype','Transaction') 
                        ->currentStore()
                        ->groupBy('sid')
                        ->get(array(DB::raw('sum(nnettotal) AS total '), 'sid'));
        return $data;
    }

	public function scopeCurrentStore($query) {
       return  $query->where('trn_sales.SID', SESSION::get('selected_store_id'));
    }
}