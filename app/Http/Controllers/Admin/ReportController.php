<?php

namespace pos2020\Http\Controllers\Admin;

//use Illuminate\Http\Request;
use Request;
use pos2020\Http\Requests;
use pos2020\Http\Controllers\Controller;
use pos2020\TRN_DAILYSALES;
use pos2020\TRN_SALES;
use pos2020\trn_batch;
use pos2020\trnSalesDetail;
use pos2020\trnSalesTender;
use pos2020\Item;
use pos2020\salesCustomer;
use DB;
use Auth;
use Response;
use pos2020\Store;
use pos2020\MST_STORE;


class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       // $query = "select vBarCode, vItemName, vItemType, iPack, nUnitCost, nTotalCost, vQOH, nPrice, 'Yes' as showcost from mst_item where vstorecode = $store_id and vBarcode = '$barcode'";
       return 'In index method';
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function getDailySales(){
        $dailySales = new TRN_DAILYSALES;
        $dates[] = Request::get('fdate') != '' ? Request::get('fdate'):date('Y-m-1');
        $dates[] = Request::get('tdate') != '' ? Request::get('tdate'):date('Y-m-t');
        $charts['data'] = $dailySales->getDailySales($dates);
        return response()->json($charts);
    }
    /*public function getXSales(){
        $xSales = new trn_batch;
        return $xSales->getXSales();
    }*/
    /*public function getTrnSales(){
        $trnSales = new TRN_SALES;
        $iSalesID = '16080111';
        return $trnSales->getTrnSales($iSalesID);
    }*/
    public function getTrnSalesDetail(){
        $trnSalesDetail = new trnSalesDetail;
        $iSalesID = '16080111';
        return $trnSalesDetail->getTrnSalesDetail($iSalesID);
    }
    public function getSalesTenderDetail(){
        $trnSalesTenderDetail = new trnSalesTender;
        $iSalesID = '16080111';
        return $trnSalesTenderDetail->getSalesTenderDetail($iSalesID);
    }
    public function GetItemPrice(){
        $itemPrice = new Item;
        return $itemPrice->GetItemPrice();
    }
    public function getSalesByDays(){
        $last7daysSales = new TRN_SALES; 
        $dates[] = Request::get('fdate') != '' ? Request::get('fdate'):date('Y-m-1');
        $dates[] = Request::get('tdate') != '' ? Request::get('tdate'):date('Y-m-t');
        
        $charts['data'] = $last7daysSales->getSalesByDays($dates);
        return response()->json($charts);
    }
    public function getCustomerByDates(){
        $last7daysCustomer = new TRN_SALES;
        $dates[] = Request::get('fdate') != '' ? Request::get('fdate'):date('Y-m-1');
        $dates[] = Request::get('tdate') != '' ? Request::get('tdate'):date('Y-m-t');
        $charts['data'] = $last7daysCustomer->getCustomerByDates($dates,null,'%b-%d');
        return response()->json($charts);
    }
    public function getCategoryByAmount(){
        $topCategory = new TRN_SALES;
        $dates[] = Request::get('fdate') != '' ? Request::get('fdate'):date('Y-m-1');
        $dates[] = Request::get('tdate') != '' ? Request::get('tdate'):date('Y-m-t');
        $charts['data'] = $topCategory->getTopCategoryByDate($dates);
        return response()->json($charts);
    }
    public function getTopSaleItemByDate(){
        $topItem = new TRN_SALES;
        $dates[] = Request::get('fdate') != '' ? Request::get('fdate'):date('Y-m-1');
        $dates[] = Request::get('tdate') != '' ? Request::get('tdate'):date('Y-m-t');
        $charts['data'] = $topItem->getTopSaleItemByDate($dates);
        return response()->json($charts);
    }
    public function getStatus(){
        $sale = new TRN_SALES;
        $sale_item['sales']['today'] = $sale->getTodaySale();
        $sale_item['sales']['yesterday'] = $sale->getYesterdaySale();
        $sale_item['sales']['week'] = $sale->getWeeklySales();

        $customer = new salesCustomer;
        $sale_item['customer']['today'] = $customer->getTodayCustomer();
        $sale_item['customer']['yesterday'] = $customer->getYesterdayCustomer();
        $sale_item['customer']['week'] = $customer->getCustomerByDates();
     
        return response()->json($sale_item);
    }
    public function getSummary(){
        $summary = new TRN_DAILYSALES;
        $dates[] = Request::get('fdate') != '' ? Request::get('fdate'):date('Y-m-1');
        $dates[] = Request::get('tdate') != '' ? Request::get('tdate'):date('Y-m-t');
        $sid = Request::get('sid') != '' ? Request::get('sid') : null;
        $charts = $summary->getSummary($dates,$sid);
        return $charts;
    }
     public function getSummaryDetail(){
        $summary = new TRN_DAILYSALES;
        $dates[] = Request::get('fdate') != '' ? Request::get('fdate'):date('Y-m-1');
        $dates[] = Request::get('tdate') != '' ? Request::get('tdate'):date('Y-m-t');
        $sid = Request::get('sid') != '' ? Request::get('sid') : null;
        $charts = $summary->getSummaryDetail($dates,$sid);
        return $charts;
    }
    public function getReports(){
        
        foreach (Auth::user()->roles()->get() as $role){
            $stores = array();
            if ($role->name == 'Vendor' || $role->name == 'Store Manager') {

                $stores_data = Auth::user()->store()->get()->toArray();
                if(count($stores_data) > 0 ) {
                    unset($store_array);
                    foreach($stores_data as $k=>$v){
                        $store_array[$v['id']] = $v['name'];
                    }
                }
            }
            else
            {
                $stores = Store::all();
                $store_array = array();
                foreach ($stores as $storesData) {
                   $store_array[$storesData->id] = $storesData->name;
                }
            }
        }
      
        $option = Request::get('option');
        $dates[] = Request::get('fdate',date('Y-m-1'));
        $dates[] = Request::get('tdate',date('Y-m-t'));

       
        return view('admin.report.index',compact('store_array'));
    }
    public function postReports(Request $request){

        $option1 = Request::get('option1');
        $storeId = Request::get('store');

        $dates[] = Request::get('fdate',date('Y-m-1'));
        $dates[] = Request::get('tdate',date('Y-m-t'));

        $stores = Store::all();
        $store_array = array();
        foreach ($stores as $storesData) {
           $store_array[$storesData->id] = $storesData->name;
        }
        $trnSales = new TRN_SALES;
        if($option1 == 'Sales')
        {
            
            $charts['data'] = $trnSales->getSaleByDate($dates,$storeId);
            return response()->json($charts);
        }
        else if($option1 == 'Customer')
        {
            $charts['data'] = $trnSales->getCustomerByDates($dates,$storeId);
            return response()->json($charts);
        }
        else if($option1 == 'Void')
        {
            $charts['data'] = $trnSales->getVoidByDates($dates,$storeId);
            return response()->json($charts);
        }
        else
        {
            
        }
      
    }
    public function postView(){
       $stores = Store::all();
        $store_array = array();
        foreach ($stores as $storesData) {
           $store_array[$storesData->id] = $storesData->name;
        }
        return view('admin.report.reports',compact('store_array'));
    }
    public function getCustomerByHour(){
        $last24hourCustomer = new TRN_SALES;
        $date = Request::get('date') != '' ? Request::get('date'):null;
        $charts['data'] = $last24hourCustomer->getCustomerByHour($date);
        return response()->json($charts);
    }

    public function getCustomerByHours(){
        $last24hourCustomer = new TRN_SALES;
        $date = Request::get('date') != '' ? Request::get('date'):null;
        $charts['data'] = $last24hourCustomer->getCustomerByHours($date);
        return response()->json($charts);
    }

    //-------------------------------------------- API function -------------------------------------------

    public function dailySalesByDate(Request $request) {
        $date = Request::get('date',date('Y-m-d'));
        $sid = Request::get('sid',null);
     
        if(!is_null($date) ) { 
            $obj = TRN_DAILYSALES::where('trn_dailysales.ddate',$date)
                            ->groupBy('trn_dailysales.ddate');
           if(!is_null($sid)){ 
                  $obj->where('trn_dailysales.SID',$sid);
            }
          //  dd($obj->toSql());
            $data = $obj->get(array(DB::raw('sum(trn_dailysales.nopeningbalance) as beg_balance'),
                                    DB::raw('sum(trn_dailysales.nnetcashpickup)  as cash_pickup'),
                                    DB::raw('sum(trn_dailysales.nnetaddcash) as cash_added'),
                                    DB::raw('sum(trn_dailysales.ntotalsales) as total_sale'),
                                    DB::raw('sum(trn_dailysales.ntotaltax) as total_tax'),
                                    DB::raw('sum(trn_dailysales.ntotalcashsales) as total_cashSales'),
                                    DB::raw('sum(trn_dailysales.ntotalcreditsales) as total_creditSales'),
                                    DB::raw('sum(trn_dailysales.ntotalreturns) as total_returns'),
                                    DB::raw('sum(trn_dailysales.ntotalgiftsales) as total_giftSales'),
                                    DB::raw('sum(trn_dailysales.ntotalchecksales) as total_checkSales'),
                                    DB::raw('sum(trn_dailysales.ntotaltaxable) as total_taxableSales'),
                                    DB::raw('sum(trn_dailysales.ntotalnontaxable) as total_nonTaxableSales'),
                                    DB::raw('sum(trn_dailysales.nnetpaidout) as total_paidOut'),
                                    DB::raw('sum(trn_dailysales.ntotaldiscount) as total_discount'),
                                    DB::raw('sum(trn_dailysales.ntotaldebitsales) as total_debitSales'),
                                    DB::raw('sum(trn_dailysales.ntotalebtsales) as total_ebtSales'),
                                    'trn_dailysales.ddate'
                ));
            return $data->toArray();

        } else {
            return response()->json(['error'=>'Date is  missing '],401);
        }
    }
    public function xSales(Request $request){
       $sid = Request::get('sid',null);
       $date = Request::get('date',date('Y-m-d'));
       $data = array();
       if(!is_null($sid)){ 
            $obj = trn_batch::groupBy('SID');                 
            $obj->where('SID',$sid);
            $obj->where('dbatchstarttime','>=',$date .' 00:00:00') ;
            $obj->where('dbatchstarttime','<',$date .' 23:59:59');
           // $obj->whereBetween('dbatchstarttime',array($date.' 00:00:00', $date.' 23:59:59'));
          // dd($obj->toSql());
            $alldata = $obj->get(array(
                                        DB::raw('sum(trn_batch.nopeningbalance) as total_beg_balance'),
                                        DB::raw('sum(trn_batch.nnetcashpickup) as total_cash_pickup'),
                                        DB::raw('sum(trn_batch.nnetaddcash) as total_cash_added'),
                                        DB::raw('sum(trn_batch.ntotalsales) as total_sale'),
                                        DB::raw('sum(trn_batch.ntotaltax) AS total_tax'),
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
                                        DB::raw(' trn_batch.SID')
                                        )
                                    )->toArray();
        if(count($alldata) > 0 ) {
            $data['All'] = $alldata[0];
        }
        $obj = trn_batch::join('mst_register','mst_register.iregisterid','=','trn_batch.vterminalid')
                    ->orderBy('mst_register.vsequence') ;
            
        $obj->where('trn_batch.SID',$sid);
        $obj->whereBetween('dbatchstarttime',array($date.' 00:00:00', $date.' 23:59:59'));
        $regs = $obj->get(array(
                                    DB::raw('(trn_batch.nopeningbalance) as total_beg_balance'),
                                    DB::raw('(trn_batch.nnetcashpickup) as total_cash_pickup'),
                                    DB::raw('(trn_batch.nnetaddcash) as total_cash_added'),
                                    DB::raw('(trn_batch.ntotalsales) as total_sale'),
                                    DB::raw('(trn_batch.ntotaltax) AS total_tax'),
                                    DB::raw('(trn_batch.ntotalcashsales) as total_cashSales'),
                                    DB::raw('(trn_batch.ntotalcreditsales) as total_creditSales'),
                                    DB::raw('(trn_batch.ntotalreturns) as total_returns'),
                                    DB::raw('(trn_batch.ntotalgiftsales) as total_giftSales'),
                                    DB::raw('(trn_batch.ntotalchecksales) as total_checkSales'),
                                    DB::raw('(trn_batch.ntotaltaxable) as total_taxableSales'),
                                    DB::raw('(trn_batch.ntotalnontaxable) as total_nonTaxableSales'),
                                    DB::raw('(trn_batch.nnetpaidout) as total_paidOut'),
                                    DB::raw('(trn_batch.ntotaldiscount) as total_discount'),
                                    DB::raw('(trn_batch.ntotaldebitsales) as total_debitSales'),
                                    DB::raw('(trn_batch.ntotalebtsales) as total_ebtSales'),
                                    DB::raw('trn_batch.SID'),
                                    DB::raw('trn_batch.ibatchid'),
                                    DB::raw('trn_batch.vterminalid'),
                                    DB::raw('mst_register.vregistername'),
                                    DB::raw('mst_register.vprintername'),
                                    DB::raw('trn_batch.dbatchstarttime')
                                    
                                    )
                                );

            foreach($regs as $reg) { 
                $data[$reg->vprintername] = $reg;
            }
            return $data;                
        }
        else {
            return response()->json(['error'=>'SID is  missing'],401);
        }
    }
    public function getLast20Transaction(Request $request){
        $last20Transaction =  new TRN_SALES ;
        $sid = Request::get('sid',null);

        if(!is_null($sid)){
            $data = $last20Transaction->getLast20Transaction($sid);
            return $data->toArray();

        } else {
            return response()->json(['error'=>'SID is  missing'],401);
        }
    }
    public function getTop10SalesByAmount(Request $request){
        $top10SalesByAmount = new trnSalesDetail;

        $sid = Request::get('sid',null);
        $date = Request::get('date',null);
        
        if(!is_null($sid) && !is_null($date)){
                $data = $top10SalesByAmount->getTop10SalesByAmount($sid,$date);
                return $data->toArray();
        } else {
            return response()->json(['error'=>'Invalid argument supplied...Please Enter SID and Date '],401);
        }
    }
    public function getTop10SalesByQty(Request $request){
        $top10SalesByQty = new trnSalesDetail;

        $sid = Request::get('sid');
        $date = Request::get('date');
        
        if((!is_null($sid)) && $date){
                $data = $top10SalesByQty->getTop10SalesByQty($sid,$date);
                return $data->toArray();
        } else {
            return response()->json(['error'=>'Invalid argument supplied...Please Enter SID and Date '],401);
        }
    }
    public function getStoreInfo(Request $request){
        $getStore = new MST_STORE;
        $sid = Request::get('sid',null);

        if(!is_null($sid)){
                $data = $getStore->getStoreInfo($sid);
                return $data->toArray();
        } else {
            return response()->json(['error'=>'Invalid argument supplied...Please Enter SID'],401);
        }
    }
    public function getTransactionDetail(Request $request){
        $transactionDetail = new trnSalesDetail;
        $salestender = new trnSalesTender;
        $sales = new TRN_SALES;

        $sid = Request::get('sid',null);
        $salesId = Request::get('salesId',null);

        if(!is_null($salesId) && !is_null($sid)){
                $data['Sales'] = $sales->getTransactionSales($sid,$salesId);
                $data['SalesDetail'] = $transactionDetail->getTransactionDetail($sid,$salesId);
                $data['SalesTenderDetail'] = $salestender->getTransactionSalesTenderDetail($sid,$salesId);
                return $data;
        }else
        {
            return response()->json(['error'=>'Invalid argument supplied...Please Enter SID and salesId'],401);

        }
    }
    public function getTransaction(Request $request){
        $transaction = new TRN_SALES;
        $sid = Request::get('sid',null);

        if(!is_null($sid)){
            $data = $transaction->getTransaction($sid);
            return $data->toArray();
        }else{
            return response()->json(['error'=>'Invalid argument supplied...Please Enter SID '],401);
        }
    }
}
