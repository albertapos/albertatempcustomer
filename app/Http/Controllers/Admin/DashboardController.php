<?php

namespace pos2020\Http\Controllers\Admin;

//use Illuminate\Http\Request;
use Request;


use pos2020\Http\Requests;

use pos2020\Http\Controllers\Controller;
use pos2020\Store;
use pos2020\TRN_SALES;
use pos2020\salesCustomer;
use pos2020\User;
use Session;
use Auth;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
     //  dd($data);
        $stores = Store::all();
        $store_array = array();
        foreach ($stores as $storesData) {
           $store_array[$storesData->id] = $storesData->name;
        }

        $topItem = new TRN_SALES;
        $date = Request::get('date',date('Y-m-d'));
        $fdate = date("Y-m-d", (strtotime($date)) - (7*24*60*60));
        $tdate = date("Y-m-d", (strtotime($date)) - (24*60*60));
        $sale_item['sales']['today'] = $topItem->getTodaySale($date);
      
        $sale_item['sales']['yesterday'] = $topItem->getYesterdaySale($date);
        $sale_item['sales']['week'] = $topItem->getWeeklySales($date);

        $sale_item['customer'] = $topItem->getCustomerDashboard($date);

        $sale_item['void'] = $topItem->getVoidDashboard($date);        
      
        $todaySale = $sale_item['sales']['today'];
        $yesterdaySales = $sale_item['sales']['yesterday'];
        $weeklySale = $sale_item['sales']['week'];

        return view('admin.dashboard',compact('store_array','todaySale','yesterdaySales','weeklySale',
                    'stores', 'date',
                    'fdate','tdate','sale_item'));
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
    public function getDashbord(Request $request){

        $stores = Store::all();
        $store_array = array();
        foreach ($stores as $storesData) {
           $store_array[$storesData->id] = $storesData->name;
        }
        
        if(!empty(Request::get('sid'))){
            Auth::user()->changeStore(Request::get('sid'));
        }else{
            return 'SID not found!!!';
        }

        if(!empty(Request::get('token'))){
            $token = Request::get('token');
        }else{
            return 'Token not Found!!!';
        }
        

        $topItem = new TRN_SALES;
        // $date = Request::get('date',date('Y-m-d'));
        $date = date('Y-m-d');
        $fdate = date("Y-m-d", (strtotime($date)) - (7*24*60*60));
        $tdate = date("Y-m-d", (strtotime($date)) - (24*60*60));
        $sale_item['sales']['today'] = $topItem->getTodaySale($date);
      
        $sale_item['sales']['yesterday'] = $topItem->getYesterdaySale($date);
        $sale_item['sales']['week'] = $topItem->getWeeklySales($date);

        $sale_item['customer'] = $topItem->getCustomerDashboard($date);

        $sale_item['void'] = $topItem->getVoidDashboard($date);        
      
        $todaySale = $sale_item['sales']['today'];
        $yesterdaySales = $sale_item['sales']['yesterday'];
        $weeklySale = $sale_item['sales']['week'];

        return view('admin.apiDashboard',compact('store_array','todaySale','yesterdaySales','weeklySale',
                    'stores', 'date',
                    'fdate','tdate','sale_item','token'));
    }
}
