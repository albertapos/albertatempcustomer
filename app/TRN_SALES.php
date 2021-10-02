<?php

namespace pos2020;

use Illuminate\Database\Eloquent\Model;
use Request;
use DB;
use SESSION;

class TRN_SALES extends Model
{
    protected $connection = 'mysql';
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
        // dd(__FUNCTION__.': '.__LINE__);
        $sid = Request::get('sid',null);
        
        //---(important)-> date_format convert date to string-----------
        
        $query = "select DATE_FORMAT(trn_sales.dtrandate,   '%b-%d') as  date, STR_TO_DATE(trn_sales.dtrandate, '%Y-%m-%d') as num_date, sum(nnettotal) AS total  from u{$sid}.`trn_sales` where 
                    `dtrandate` between '{$dates[0]}' and '{$dates[1]}' and `vtrntype` = 'Transaction' and 
                    `trn_sales`.`SID` = '{$sid}' group by `date`, num_date ORDER BY num_date ASC";
        $data = \DB::connection('mysql')->select($query); 
        /*$data =  trn_sales::whereBetween('trandate',$dates)
                        ->where('vtrntype','Transaction') 
                        ->orderBy('date')
                        ->currentStore()
                        ->groupBy('date')
                        ->get(array(DB::raw("DATE_FORMAT(trn_sales.dtrandate,   '%b-%d'  ) as  date"), DB::raw('sum(nnettotal) AS total ')))
                        ->toArray();*/
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
        
        $db = 'u'.Session::get('selected_store_id');
        
        $sql = 'select sum(trn_salesdetail.nextunitprice) AS total, mst_category.vcategoryname AS category from '.$db.'.`trn_sales` 
                inner join '.$db.'.`trn_salesdetail` on `trn_salesdetail`.`isalesid` = `trn_sales`.`isalesid` 
                inner join '.$db.'.`mst_category` on `mst_category`.`vcategorycode` = `trn_salesdetail`.`vcatcode` 
                where `dtrandate` between \''.$dates[0].'\' and \''.$dates[1].'\' group by `mst_category`.`vcategoryname` order by `total` desc LIMIT 0, 5';

        $result = DB::connection('mysql')->select($sql);

        /*$data =  trn_sales::join('trn_salesdetail','trn_salesdetail.isalesid','=','trn_sales.isalesid')
                        ->join('mst_category','mst_category.vcategorycode','=','trn_salesdetail.vcatcode')
                        ->whereBetween('drandate',$dates) 
                        ->currentStore()
                        ->groupBy('mst_category.vcategoryname')
                        ->orderBy('total','DESC')
                        ->get(array(DB::raw('sum(trn_salesdetail.nextunitprice) AS total'),DB::raw('mst_category.vcategoryname AS category')))
                        ->take(5)
                        ->toArray();*/

        return $result;
    }
    public function getCustomerByDates($dates = null,$storeId = null, $date_format = '%Y-%m-%d'){
        if(is_null($dates) ) {
            $dates[] = date("Y-m-d", time() - (30*24*60*60));
            $dates[] = date("Y-m-d 23:59:59");
        }
        $dates[0] = $dates[0].' 00:00:00';
        $dates[1] = $dates[1].' 23:59:59';
        
        
        $sid = Request::get('sid',null);

        $query = "select DATE_FORMAT(dtrandate,   '%b-%d'  ) as  date ,STR_TO_DATE(trn_sales.dtrandate, '%Y-%m-%d') as num_date, count(trn_sales.isalesid) AS total , `trn_sales`.`SID` 
                    from u{$sid}.`trn_sales` where `dtrandate` between '{$dates[0]}' and '{$dates[1]}' group by `date`, 
                    `trn_sales`.`SID`, num_date ORDER BY num_date ASC";
        
        /*$obj =  trn_sales::whereBetween('trandate',$dates) 
                        ->groupBy('date')
                        ->orderBy('date')
                        ->groupBy('trn_sales.SID');
        if(!is_null($storeId) && $storeId > 0 ){
            $obj->where('trn_sales.SID','=',$storeId);
        }
        $data = $obj->get(array(DB::raw("DATE_FORMAT(dtrandate,   '".$date_format."'  ) as  date "),
                            DB::raw('count(trn_sales.isalesid) AS total '), 'trn_sales.SID' ))
                        ->toArray();*/
                        
        $data = \DB::connection('mysql')->select($query);
        
        $data[0] = (array)$data[0];
                        
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
    
    
    public function getCustomerDashboard_mobile($date = null, $sid){

        if(is_null($date)) {
            $date = date("Y-m-d");
        }
        
        $fdate = date("Y-m-d 00:00:00", (strtotime($date)) - (7*24*60*60));
        $tdate = date("Y-m-d 23:59:59", (strtotime($date)) - (24*60*60));
        $ydate = date("Y-m-d", (strtotime($date)) - (24*60*60));

        $result = array();
        
        $query = "select count(isalesid) AS total , `SID` from u{$sid}.`trn_sales` 
                    where `dtrandate` > '{$date} 00:00:00' and `dtrandate` < '{$date} 23:59:59' and `trn_sales`.`SID` = '{$sid}' group by `SID`";
        
        $data1 = \DB::connection('mysql')->select($query);
        $result['today'] = count($data1)> 0 ?$data1[0]->total:0;
        
        
        
        $query = "select count(isalesid) AS total , `SID` from u{$sid}.`trn_sales` 
                    where `dtrandate` between '{$ydate} 00:00:00' and '{$ydate} 23:59:59' and 
                    `trn_sales`.`SID` = '{$sid}' group by `SID`";
                    
        $data2 = \DB::connection('mysql')->select($query);
        $result['yesterday'] = count($data2)> 0 ?$data2[0]->total:0;
        
        
        
        $query = "select count(isalesid) AS total , `SID` from u{$sid}.`trn_sales`
                        where `dtrandate` between '{$fdate} 00:00:00' and '{$date} 23:59:59' and \n
                        `trn_sales`.`SID` = '{$sid}' group by `SID`";
        
        $data = \DB::connection('mysql')->select($query);
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
    
    
    public function getVoidDashboard_mobile($date = null, $sid){

        if(is_null($date)) {
            $date = date("Y-m-d");
        } 
        $fdate = date("Y-m-d 00:00:00", (strtotime($date)) - (7*24*60*60));
        $tdate = date("Y-m-d 23:59:59", (strtotime($date)) - (24*60*60));
        $ydate = date("Y-m-d", (strtotime($date)) - (24*60*60));
        
        $result = array();
        
        $query = "select count(isalesid) AS total , `SID` from u{$sid}.`trn_sales` where 
                    `dtrandate` > '{$date} 00:00:00' and `dtrandate` < '{$date} 23:59:59' and 
                    `vtrntype` = 'Void' and `trn_sales`.`SID` = '{$sid}' group by `SID`";
        
        $data = \DB::connection('mysql')->select($query);
        $result['today'] = count($data)> 0 ?$data[0]->total:0;
        
        
        $query = "select count(isalesid) AS total , `SID` from u{$sid}.`trn_sales` where 
                    `dtrandate` > '{$ydate} 00:00:00' and `dtrandate` < '{$ydate} 23:59:59' and 
                    `vtrntype` = 'Void' and `trn_sales`.`SID` = '{$sid}' group by `SID`";
        
        /*$data =  self::where('trandate','>',$ydate .' 00:00:00') 
                        ->where('dtrandate','<',$ydate .' 23:59:59') 
                        ->where('vtrntype','Void')
                        ->currentStore()
                        ->groupBy('SID')
                        ->get(array( DB::raw('count(isalesid) AS total '), 'SID'));*/
        $data = \DB::connection('mysql')->select($query);
        $result['yesterday'] = count($data)> 0 ?$data[0]->total:0;
        
        $query = "select count(isalesid) AS total , `SID` from u{$sid}.`trn_sales` where 
                `dtrandate` between '{$fdate} 00:00:00' and '{$date} 23:59:59' and 
                `vtrntype` = 'Void' and `trn_sales`.`SID` = '{$sid}' group by `SID`";
                
        
        /*$data =  self::whereBetween('trandate',array($fdate,$date)) 
                        ->where('vtrntype','Void')
                        ->currentStore()
                        ->groupBy('SID')
                        ->get(array( DB::raw('count(isalesid) AS total '), 'SID'));*/
        $data = \DB::connection('mysql')->select($query);
        
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

        $db = 'u'.Session::get('selected_store_id');


        $query = 'select DATE_FORMAT( dtrandate , \'%H\' ) as  hour , count(1) AS custcount from '.$db.'.`trn_sales` 
                  where `dtrandate` between \''.$dates[0].'\' and \''.$dates[1].'\' 
                  group by `hour` order by `hour` desc';

        
        $datas = DB::connection('mysql')->select($query);

        /*$datas =  trn_sales::whereBetween('drandate',array($dates[0],$dates[1])) 
                        ->currentStore()
                        // ->where('SID',1000)
                        ->groupBy('hour')
                        ->orderBy('hour','desc')
                        ->get(array(DB::raw("DATE_FORMAT( dtrandate , '%H' ) as  hour "),DB::raw('count(1) AS custcount')))
                        ->toArray();*/
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
                if($data->hour == $hour){
                    $temporary = array();
                    $temporary['date'] = "".$hour.":00";
                    $temporary['total'] = "".$data->custcount."";
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
        
        $db = 'u'.Session::get('selected_store_id');
        
        // $query = 'select count(trn_salesdetail.ndebitqty) AS Quantity , mst_item.vitemname AS Item  from '.$db.'.`trn_sales` 
        //           inner join '.$db.'.`trn_salesdetail` on `trn_salesdetail`.`isalesid` = `trn_sales`.`isalesid` 
        //           inner join '.$db.'.`mst_item` on `mst_item`.`vitemcode` = `trn_salesdetail`.`vitemcode` 
        //           where `dtrandate` between \''.$dates[0].'\' and \''.$dates[1].'\' group by `trn_salesdetail`.`ndebitqty`, `mst_item`.`vitemname` 
        //           order by `Quantity` desc LIMIT 0, 5';
        
        $date = date('Y-m-d');
        $d1=date("Y-m-d", (strtotime($date)) - (6 * 24 * 60 * 60));
        
                  
        $query='select sum(trn_salesdetail.ndebitqty) AS Quantity , mst_item.vitemname AS Item  from '.$db.'.`trn_sales`
                  inner join '.$db.'.`trn_salesdetail` on `trn_salesdetail`.`isalesid` = `trn_sales`.`isalesid` 
                  inner join '.$db.'.`mst_item` on `mst_item`.`vitemcode` = `trn_salesdetail`.`vitemcode` 
                  where ibatchid in (select d.batchid from '.$db.'.trn_endofday e join '.$db.'.trn_endofdaydetail d on e.id=d.eodid 
                   where date(e.dstartdatetime) between \''.$d1.'\' and \''.$date.'\' )
                  group by `mst_item`.`vitemname` 
                  order by `Quantity` desc LIMIT 0, 5';
                  
        //dd($query);
//  \''.$dates[0].'\' and \''.$dates[1].'\' group by `mst_category`.`vcategoryname` order by `total` desc LIMIT 0, 5';

        $result = DB::connection('mysql')->select($query);       
        
        /*$data =  trn_sales::join('trn_salesdetail','trn_salesdetail.isalesid','=','trn_sales.isalesid')
                        ->join('mst_item','mst_item.vitemcode','=','trn_salesdetail.vitemcode')
                        ->whereBetween('drandate',$dates) 
                        ->currentStore()
                       // ->groupBy('trn_salesDETAIL.VITEMCODE')
                        ->groupBy('trn_salesdetail.ndebitqty')
                        ->groupBy('mst_item.vitemname')
                        ->orderBy('Quantity','DESC')
                        ->get(array(DB::raw('count(trn_salesdetail.ndebitqty) AS Quantity '),DB::raw('mst_item.vitemname AS Item ')))
                        ->take(5)
                        ->toArray();*/
        return $result;
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
        
        $data =  TRN_SALES::where('dtrandate','>',$dates .' 00:00:00') 
                            ->where('dtrandate','<',$dates .' 23:59:59')
                            ->where('vtrntype','Transaction')
                            ->orderBy('date','desc')
                            ->groupBy('date')
                            ->currentStore()
                            ->get(array(DB::raw("DATE_FORMAT(trn_sales.dtrandate,   '%b-%d'  ) as  date"), DB::raw('sum(nnettotal) AS total ')));
        
        // dd($data);
        return $data;
    }
    
    
    public function getTodaySale_mobile($dates = null, $sid){
    
        
        if(is_null($dates)) {
            $dates = date("Y-m-d");
        } 
        
        $query = "select DATE_FORMAT(trn_sales.dtrandate,   '%b-%d'  ) as  date, sum(nnettotal) AS total  from u{$sid}.`trn_sales` 
        where `dtrandate` > '{$dates} 00:00:00' and `dtrandate` < '{$dates} 23:59:59' and `vtrntype` = 'Transaction' and `trn_sales`.`SID` = '{$sid}' 
        group by `date` order by `date` desc";
        
        $data = \DB::connection('mysql')->select($query);

        return $data;
    }
    
    
    public function getYesterdaySale($dates = null){
       
        if(is_null($dates)) {
            $dates = date("Y-m-d", strtotime('-1 day'));
        } 
        $dates = date("Y-m-d", (strtotime($dates)) - (24*60*60));
        
        $data =  TRN_SALES::where('dtrandate','>',$dates .' 00:00:00') 
                        ->where('dtrandate','<',$dates .' 23:59:59')
                        ->where('vtrntype','Transaction')
                        ->orderBy('date','desc')
                        ->groupBy('date')
                        ->currentStore()
                        ->get(array(DB::raw("DATE_FORMAT(trn_sales.dtrandate,   '%b-%d'  ) as  date"), DB::raw('sum(nnettotal) AS total ')));
        return $data;
    }
    
    
    public function getYesterdaySale_mobile($dates = null, $sid){
       
        if(is_null($dates)) {
            $dates = date("Y-m-d", strtotime('-1 day'));
        } 
        $dates = date("Y-m-d", (strtotime($dates)) - (24*60*60));
        
        $query =    "select DATE_FORMAT(trn_sales.dtrandate,   '%b-%d'  ) as  date, sum(nnettotal) AS total  from u{$sid}.`trn_sales` 
                    where `dtrandate` > '{$dates} 00:00:00' and `dtrandate` < '{$dates} 23:59:59' and `vtrntype` = 'Transaction' and 
                    `trn_sales`.`SID` = '{$sid}' group by `date` order by `date` desc";
        
        $data = \DB::connection('mysql')->select($query);

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
    
    
    public function getWeeklySales_mobile($date = null, $sid){
        if(is_null($date) ) {
            $date = date("Y-m-d");
        } 
        $dates[] = date("Y-m-d 00:00:00", strtotime($date) - (7*24*60*60));
        $dates[] = $date. ' 23:59:59';

        $query = "select sum(nnettotal) AS total , `sid` from u{$sid}.`trn_sales` where `dtrandate` between '{$dates[0]}' and '{$dates[1]}' and 
                `vtrntype` = 'Transaction' and `trn_sales`.`SID` = '{$sid}' group by `sid`";
        
        $data = \DB::connection('mysql')->select($query);

        return $data;
    }

	public function scopeCurrentStore($query) {
       return  $query->where('trn_sales.SID', SESSION::get('selected_store_id'));
    }
    static function apiGetTransactionSales_new($sid,$salesId){
        
        $db = "u".$sid;
        
        $query = "SELECT * FROM ".$db.".trn_sales WHERE SID = ".$sid." AND isalesid=".$salesId." LIMIT 10";
        
        $getTransactionSales = DB::connection('mysql')->select($query);

        /*$getTransactionSales = $objTransaction
                            ->where('trn_sales.SID',$sid)
                            ->Where('trn_sales.isalesid',$salesId)
                            ->get();*/
       
         return $getTransactionSales;
    }
    
}