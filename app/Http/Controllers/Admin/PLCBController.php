<?php

namespace pos2020\Http\Controllers\Admin;

use Request;
use pos2020\Http\Requests;
use pos2020\Http\Controllers\Controller;
use pos2020\Store;
use pos2020\Item;
use pos2020\MST_PLCB_UNIT;
use pos2020\MST_PLCB_BUCKET_TAG;
use pos2020\MST_ITEM_SIZE;
use pos2020\MST_PLCB_ITEM;
use pos2020\MST_PLCB_ITEM_DETAIL;
use Session;
use PDF;
use Mail;

class PLCBController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        ini_set('memory_limit', '1G');
        ini_set('max_execution_time', 300);

        $stores = Store::all();
        $store_array = array();
        foreach ($stores as $storesData) {
           $store_array[$storesData->id] = $storesData->name;
        }

        $appends = array();

        // $product_lists = Item::pluck('vitemname','iitemid');

        $productObj = Item::
                     currentStore()
                    //where('mst_item.SID', 100077)
                    ->leftJoin('mst_item_size','mst_item_size.item_id','=','mst_item.iitemid')
                    ->leftJoin('mst_plcb_item','mst_plcb_item.item_id','=','mst_item.iitemid')
                    ->leftJoin('mst_item_unit','mst_item_unit.id','=','mst_item_size.unit_id')
                    ->leftJoin('mst_item_bucket','mst_item_bucket.id','=','mst_plcb_item.bucket_id');

        if(!empty(Request::get('product_name')) && Request::get('product_name') == 'desc'){
           $productObj = $productObj->orderBy('mst_item.vitemname','desc');
           $appends['product_name'] = Request::get('product_name');
        }elseif(!empty(Request::get('product_name')) && Request::get('product_name') == 'asc'){
            $productObj = $productObj->orderBy('mst_item.vitemname','asc');
            $appends['product_name'] = Request::get('product_name');
        }elseif(!empty(Request::get('bucket_name')) && Request::get('bucket_name') == 'asc'){
            $productObj = $productObj->orderBy('mst_item_bucket.bucket_name','asc');
            $appends['bucket_name'] = Request::get('bucket_name');
        }elseif(!empty(Request::get('bucket_name')) && Request::get('bucket_name') == 'desc'){
            $productObj = $productObj->orderBy('mst_item_bucket.bucket_name','desc');
            $appends['bucket_name'] = Request::get('bucket_name');
        }else{
            $productObj = $productObj->orderBy('mst_item.dcreated','desc');
        }

        $plcb_products = $productObj->paginate(25);

        $plcb_products->appends($appends);

        $units = MST_PLCB_UNIT::all();
        $buckets = MST_PLCB_BUCKET_TAG::all();
        
        return view('admin.plcb.index',compact('store_array', 'plcb_products', 'units', 'buckets'));
    }


    public function plcbReports()
    {
        ini_set('memory_limit', '1G');
        ini_set('max_execution_time', 300);

        $stores = Store::all();
        $store_array = array();
        foreach ($stores as $storesData) {
           $store_array[$storesData->id] = $storesData->name;
        }

        $buckets = MST_PLCB_BUCKET_TAG::all();

        $today_date = \Carbon\Carbon::now()->setTimezone('EST')->format('Y-m-d');
        $last_month_start = \Carbon\Carbon::now()->setTimezone('EST')->subMonth()->startOfMonth()->format('Y-m-d');
        $last_month_end = \Carbon\Carbon::now()->setTimezone('EST')->subMonth()->endOfMonth()->format('Y-m-d');
        $dates[0] = $last_month_start;
        $dates[1] = $last_month_end;

        $mst_plcb_items = MST_PLCB_ITEM::leftJoin('mst_item_size','mst_item_size.item_id','=','mst_plcb_item.item_id')->leftJoin('mst_item_bucket','mst_item_bucket.id','=','mst_plcb_item.bucket_id')->get();
        
        $arr = array();
        foreach ($mst_plcb_items as $key => $mst_plcb_item) {
           $temp = array();
           $temp['id'] = $mst_plcb_item['id'];
           $temp['item_id'] = $mst_plcb_item['item_id'];
           $temp['bucket_id'] = $mst_plcb_item['bucket_id'];
           $temp['bucket_name'] = $mst_plcb_item['bucket_name'];
           $temp['unit_id'] = $mst_plcb_item['unit_id'];
           $temp['unit_value'] = (int)$mst_plcb_item['unit_value'];
           $temp['tot_qty'] = $mst_plcb_item['prev_mo_beg_qty'] * (int)$mst_plcb_item['unit_value'];
           $arr[] = $temp;
        }
       
        $bucket_arr = array();
        foreach ($arr as $key => $value) {
           if(array_key_exists($value['bucket_id'], $bucket_arr)){
                $bucket_arr[$value['bucket_id']]['tot_qty'] = $bucket_arr[$value['bucket_id']]['tot_qty'] + $value['tot_qty'];
           }else{
                $bucket_arr[$value['bucket_id']] = array(
                                                        'bucket_id' => $value['bucket_id'],
                                                        'bucket_name' => $value['bucket_name'],
                                                        'tot_qty' => $value['tot_qty']
                                                        );
           }
        }

        $main_bucket_arr = array();
        foreach ($bucket_arr as $key => $bucket_array) {
            $main_bucket_arr[] = $bucket_array;
        }

        $mst_plcb_item_details = MST_PLCB_ITEM_DETAIL::leftJoin('mst_plcb_item','mst_plcb_item.item_id','=','mst_plcb_item_detail.plcb_item_id')->leftJoin('mst_item_size','mst_item_size.item_id','=','mst_plcb_item_detail.plcb_item_id')->leftJoin('mst_item_bucket','mst_item_bucket.id','=','mst_plcb_item.bucket_id')->leftJoin('mst_supplier','mst_supplier.isupplierid','=','mst_plcb_item_detail.supplier_id')->get();
        
        $newarr = array();
        foreach ($mst_plcb_item_details as $mst_plcb_item_detail) {
           $newtemp = array();
           $newtemp['id'] = $mst_plcb_item_detail['id'];
           $newtemp['item_id'] = $mst_plcb_item_detail['plcb_item_id'];
           $newtemp['bucket_id'] = $mst_plcb_item_detail['bucket_id'];
           $newtemp['bucket_name'] = $mst_plcb_item_detail['bucket_name'];
           $newtemp['supplier_id'] = $mst_plcb_item_detail['supplier_id'];
           $newtemp['supplier_name'] = $mst_plcb_item_detail['vcompanyname'];
           $newtemp['unit_id'] = $mst_plcb_item_detail['unit_id'];
           $newtemp['unit_value'] = (int)$mst_plcb_item_detail['unit_value'];
           $newtemp['tot_qty'] = $mst_plcb_item_detail['prev_mo_purchase'] * (int)$mst_plcb_item_detail['unit_value'];
           $newarr[] = $newtemp;
        }
        
        $newsupp_arr = array();
        foreach ($newarr as $key => $value) {
            if(array_key_exists($value['supplier_id'], $newsupp_arr)){
                $newtemparr = $newsupp_arr[$value['supplier_id']];
                if(array_key_exists($value['bucket_id'], $newtemparr)){
                    $newsupp_arr[$value['supplier_id']][$value['bucket_id']]['tot_qty'] = $newsupp_arr[$value['supplier_id']][$value['bucket_id']]['tot_qty'] + $value['tot_qty'];
                }else{
                    $newsupp_arr[$value['supplier_id']][$value['bucket_id']] = array(
                                                        'supplier_id' => $value['supplier_id'],
                                                        'supplier_name' => $value['supplier_name'],
                                                        'bucket_id' => $value['bucket_id'],
                                                        'bucket_name' => $value['bucket_name'],
                                                        'tot_qty' => $value['tot_qty']
                                                        );
                }
            }else{
                $newsupp_arr[$value['supplier_id']][$value['bucket_id']] = array(
                                                        'supplier_id' => $value['supplier_id'],
                                                        'supplier_name' => $value['supplier_name'],
                                                        'bucket_id' => $value['bucket_id'],
                                                        'bucket_name' => $value['bucket_name'],
                                                        'tot_qty' => $value['tot_qty']
                                                        );
            }
        }

        $main_supplier_arr = array();
        foreach ($newsupp_arr as $value) {
            $temp_arr = array();
            foreach ($value as  $v) {
                $temp_arr[] = $v;
            }
           $main_supplier_arr[] =  $temp_arr;
            
        }
        // dd($main_supplier_arr);


        foreach($buckets as $bucket){
          ${'bucket_id_total'.$bucket->id} = 0 ;
        }

        if(count($main_supplier_arr) > 0){
            foreach($main_supplier_arr as $k => $main_supplier_array){
                if(count($main_supplier_array) > 0){
                    foreach($buckets as $bucket){
                        foreach($main_supplier_array as $supplier_array){
                            if($bucket->id == $supplier_array['bucket_id']){
                                ${'bucket_id_total'.$bucket->id} = ${'bucket_id_total'.$bucket->id} + $supplier_array['tot_qty'];
                            }
                        }
                    }
                }
            }
        }

        $schedule_a = array();
        foreach($buckets as $bucket){
            $schedule_a[$bucket->id] = ${'bucket_id_total'.$bucket->id};
        }


        //month end qty
        $arr_end = array();
        foreach ($mst_plcb_items as $key => $mst_plcb_item) {
           $temp = array();
           $temp['id'] = $mst_plcb_item['id'];
           $temp['item_id'] = $mst_plcb_item['item_id'];
           $temp['bucket_id'] = $mst_plcb_item['bucket_id'];
           $temp['bucket_name'] = $mst_plcb_item['bucket_name'];
           $temp['unit_id'] = $mst_plcb_item['unit_id'];
           $temp['unit_value'] = (int)$mst_plcb_item['unit_value'];
           $temp['tot_qty'] = $mst_plcb_item['prev_mo_end_qty'] * (int)$mst_plcb_item['unit_value'];
           $arr_end[] = $temp;
        }
       
        $bucket_arr_end = array();
        foreach ($arr_end as $key => $value) {
           if(array_key_exists($value['bucket_id'], $bucket_arr_end)){
                $bucket_arr_end[$value['bucket_id']]['tot_qty'] = $bucket_arr_end[$value['bucket_id']]['tot_qty'] + $value['tot_qty'];
           }else{
                $bucket_arr_end[$value['bucket_id']] = array(
                                                        'bucket_id' => $value['bucket_id'],
                                                        'bucket_name' => $value['bucket_name'],
                                                        'tot_qty' => $value['tot_qty']
                                                        );
           }
        }
        
        $main_bucket_arr_end = array();
        foreach($buckets as $bucket){
            if(array_key_exists($bucket->id, $bucket_arr_end)){
                $main_bucket_arr_end[$bucket->id] = $bucket_arr_end[$bucket->id]['tot_qty'];
            }else{
                $main_bucket_arr_end[$bucket->id] = 0; 
            }
        }

        //Sales of Malt Beverage
        $arr_malt = array();
        foreach ($mst_plcb_items as $key => $mst_plcb_item) {
            if($mst_plcb_item['malt'] == 1){
                $temp = array();
                $temp['id'] = $mst_plcb_item['id'];
                $temp['item_id'] = $mst_plcb_item['item_id'];
                $temp['bucket_id'] = $mst_plcb_item['bucket_id'];
                $temp['bucket_name'] = $mst_plcb_item['bucket_name'];
                $temp['unit_id'] = $mst_plcb_item['unit_id'];
                $temp['unit_value'] = (int)$mst_plcb_item['unit_value'];
                $temp['tot_qty'] = $mst_plcb_item['prev_mo_beg_qty'] * (int)$mst_plcb_item['unit_value'];
                $arr_malt[] = $temp;
            }
        }
       
        $bucket_arr_malt = array();
        foreach ($arr_malt as $key => $value) {
           if(array_key_exists($value['bucket_id'], $bucket_arr_malt)){
                $bucket_arr_malt[$value['bucket_id']]['tot_qty'] = $bucket_arr_malt[$value['bucket_id']]['tot_qty'] + $value['tot_qty'];
           }else{
                $bucket_arr_malt[$value['bucket_id']] = array(
                                                        'bucket_id' => $value['bucket_id'],
                                                        'bucket_name' => $value['bucket_name'],
                                                        'tot_qty' => $value['tot_qty']
                                                        );
           }
        }
        
        $main_bucket_arr_malt = array();
        foreach($buckets as $bucket){
            if(array_key_exists($bucket->id, $bucket_arr_malt)){
                $main_bucket_arr_malt[$bucket->id] = $bucket_arr_malt[$bucket->id]['tot_qty'];
            }else{
                $main_bucket_arr_malt[$bucket->id] = 0; 
            }
        }

        return view('admin.plcb.plcb_reports',compact('store_array','main_bucket_arr','main_supplier_arr', 'buckets', 'schedule_a', 'main_bucket_arr_end', 'main_bucket_arr_malt'));
    }

    public function plcbReportsPdf()
    {
        
        ini_set('memory_limit', '1G');
        ini_set('max_execution_time', 300);

        $buckets = MST_PLCB_BUCKET_TAG::all();

        $today_date = \Carbon\Carbon::now()->setTimezone('EST')->format('Y-m-d');
        $last_month_start = \Carbon\Carbon::now()->setTimezone('EST')->subMonth()->startOfMonth()->format('Y-m-d');
        $last_month_end = \Carbon\Carbon::now()->setTimezone('EST')->subMonth()->endOfMonth()->format('Y-m-d');
        $dates[0] = $last_month_start;
        $dates[1] = $last_month_end;

        $mst_plcb_items = MST_PLCB_ITEM::leftJoin('mst_item_size','mst_item_size.item_id','=','mst_plcb_item.item_id')->leftJoin('mst_item_bucket','mst_item_bucket.id','=','mst_plcb_item.bucket_id')->get();
        
        $arr = array();
        foreach ($mst_plcb_items as $key => $mst_plcb_item) {
           $temp = array();
           $temp['id'] = $mst_plcb_item['id'];
           $temp['item_id'] = $mst_plcb_item['item_id'];
           $temp['bucket_id'] = $mst_plcb_item['bucket_id'];
           $temp['bucket_name'] = $mst_plcb_item['bucket_name'];
           $temp['unit_id'] = $mst_plcb_item['unit_id'];
           $temp['unit_value'] = (int)$mst_plcb_item['unit_value'];
           $temp['tot_qty'] = $mst_plcb_item['prev_mo_beg_qty'] * (int)$mst_plcb_item['unit_value'];
           $arr[] = $temp;
        }
       
        $bucket_arr = array();
        foreach ($arr as $key => $value) {
           if(array_key_exists($value['bucket_id'], $bucket_arr)){
                $bucket_arr[$value['bucket_id']]['tot_qty'] = $bucket_arr[$value['bucket_id']]['tot_qty'] + $value['tot_qty'];
           }else{
                $bucket_arr[$value['bucket_id']] = array(
                                                        'bucket_id' => $value['bucket_id'],
                                                        'bucket_name' => $value['bucket_name'],
                                                        'tot_qty' => $value['tot_qty']
                                                        );
           }
        }

        $main_bucket_arr = array();
        foreach ($bucket_arr as $key => $bucket_array) {
            $main_bucket_arr[] = $bucket_array;
        }

        $mst_plcb_item_details = MST_PLCB_ITEM_DETAIL::leftJoin('mst_plcb_item','mst_plcb_item.item_id','=','mst_plcb_item_detail.plcb_item_id')->leftJoin('mst_item_size','mst_item_size.item_id','=','mst_plcb_item_detail.plcb_item_id')->leftJoin('mst_item_bucket','mst_item_bucket.id','=','mst_plcb_item.bucket_id')->leftJoin('mst_supplier','mst_supplier.isupplierid','=','mst_plcb_item_detail.supplier_id')->get();
        
        $newarr = array();
        foreach ($mst_plcb_item_details as $mst_plcb_item_detail) {
           $newtemp = array();
           $newtemp['id'] = $mst_plcb_item_detail['id'];
           $newtemp['item_id'] = $mst_plcb_item_detail['plcb_item_id'];
           $newtemp['bucket_id'] = $mst_plcb_item_detail['bucket_id'];
           $newtemp['bucket_name'] = $mst_plcb_item_detail['bucket_name'];
           $newtemp['supplier_id'] = $mst_plcb_item_detail['supplier_id'];
           $newtemp['supplier_name'] = $mst_plcb_item_detail['vcompanyname'];
           $newtemp['unit_id'] = $mst_plcb_item_detail['unit_id'];
           $newtemp['unit_value'] = (int)$mst_plcb_item_detail['unit_value'];
           $newtemp['tot_qty'] = $mst_plcb_item_detail['prev_mo_purchase'] * (int)$mst_plcb_item_detail['unit_value'];
           $newarr[] = $newtemp;
        }
        
        $newsupp_arr = array();
        foreach ($newarr as $key => $value) {
            if(array_key_exists($value['supplier_id'], $newsupp_arr)){
                $newtemparr = $newsupp_arr[$value['supplier_id']];
                if(array_key_exists($value['bucket_id'], $newtemparr)){
                    $newsupp_arr[$value['supplier_id']][$value['bucket_id']]['tot_qty'] = $newsupp_arr[$value['supplier_id']][$value['bucket_id']]['tot_qty'] + $value['tot_qty'];
                }else{
                    $newsupp_arr[$value['supplier_id']][$value['bucket_id']] = array(
                                                        'supplier_id' => $value['supplier_id'],
                                                        'supplier_name' => $value['supplier_name'],
                                                        'bucket_id' => $value['bucket_id'],
                                                        'bucket_name' => $value['bucket_name'],
                                                        'tot_qty' => $value['tot_qty']
                                                        );
                }
            }else{
                $newsupp_arr[$value['supplier_id']][$value['bucket_id']] = array(
                                                        'supplier_id' => $value['supplier_id'],
                                                        'supplier_name' => $value['supplier_name'],
                                                        'bucket_id' => $value['bucket_id'],
                                                        'bucket_name' => $value['bucket_name'],
                                                        'tot_qty' => $value['tot_qty']
                                                        );
            }
        }

        $main_supplier_arr = array();
        foreach ($newsupp_arr as $value) {
            $temp_arr = array();
            foreach ($value as  $v) {
                $temp_arr[] = $v;
            }
            $main_supplier_arr[] =  $temp_arr;  
        }

        foreach($buckets as $bucket){
          ${'bucket_id_total'.$bucket->id} = 0 ;
        }

        if(count($main_supplier_arr) > 0){
            foreach($main_supplier_arr as $k => $main_supplier_array){
                if(count($main_supplier_array) > 0){
                    foreach($buckets as $bucket){
                        foreach($main_supplier_array as $supplier_array){
                            if($bucket->id == $supplier_array['bucket_id']){
                                ${'bucket_id_total'.$bucket->id} = ${'bucket_id_total'.$bucket->id} + $supplier_array['tot_qty'];
                            }
                        }
                    }
                }
            }
        }

        $schedule_a = array();
        foreach($buckets as $bucket){
            $schedule_a[$bucket->id] = ${'bucket_id_total'.$bucket->id};
        }


        //month end qty
        $arr_end = array();
        foreach ($mst_plcb_items as $key => $mst_plcb_item) {
           $temp = array();
           $temp['id'] = $mst_plcb_item['id'];
           $temp['item_id'] = $mst_plcb_item['item_id'];
           $temp['bucket_id'] = $mst_plcb_item['bucket_id'];
           $temp['bucket_name'] = $mst_plcb_item['bucket_name'];
           $temp['unit_id'] = $mst_plcb_item['unit_id'];
           $temp['unit_value'] = (int)$mst_plcb_item['unit_value'];
           $temp['tot_qty'] = $mst_plcb_item['prev_mo_end_qty'] * (int)$mst_plcb_item['unit_value'];
           $arr_end[] = $temp;
        }
       
        $bucket_arr_end = array();
        foreach ($arr_end as $key => $value) {
           if(array_key_exists($value['bucket_id'], $bucket_arr_end)){
                $bucket_arr_end[$value['bucket_id']]['tot_qty'] = $bucket_arr_end[$value['bucket_id']]['tot_qty'] + $value['tot_qty'];
           }else{
                $bucket_arr_end[$value['bucket_id']] = array(
                                                        'bucket_id' => $value['bucket_id'],
                                                        'bucket_name' => $value['bucket_name'],
                                                        'tot_qty' => $value['tot_qty']
                                                        );
           }
        }
        
        $main_bucket_arr_end = array();
        foreach($buckets as $bucket){
            if(array_key_exists($bucket->id, $bucket_arr_end)){
                $main_bucket_arr_end[$bucket->id] = $bucket_arr_end[$bucket->id]['tot_qty'];
            }else{
                $main_bucket_arr_end[$bucket->id] = 0; 
            }
        }

        //Sales of Malt Beverage
        $arr_malt = array();
        foreach ($mst_plcb_items as $key => $mst_plcb_item) {
            if($mst_plcb_item['malt'] == 1){
                $temp = array();
                $temp['id'] = $mst_plcb_item['id'];
                $temp['item_id'] = $mst_plcb_item['item_id'];
                $temp['bucket_id'] = $mst_plcb_item['bucket_id'];
                $temp['bucket_name'] = $mst_plcb_item['bucket_name'];
                $temp['unit_id'] = $mst_plcb_item['unit_id'];
                $temp['unit_value'] = (int)$mst_plcb_item['unit_value'];
                $temp['tot_qty'] = $mst_plcb_item['prev_mo_beg_qty'] * (int)$mst_plcb_item['unit_value'];
                $arr_malt[] = $temp;
            }
        }
       
        $bucket_arr_malt = array();
        foreach ($arr_malt as $key => $value) {
           if(array_key_exists($value['bucket_id'], $bucket_arr_malt)){
                $bucket_arr_malt[$value['bucket_id']]['tot_qty'] = $bucket_arr_malt[$value['bucket_id']]['tot_qty'] + $value['tot_qty'];
           }else{
                $bucket_arr_malt[$value['bucket_id']] = array(
                                                        'bucket_id' => $value['bucket_id'],
                                                        'bucket_name' => $value['bucket_name'],
                                                        'tot_qty' => $value['tot_qty']
                                                        );
           }
        }
        
        $main_bucket_arr_malt = array();
        foreach($buckets as $bucket){
            if(array_key_exists($bucket->id, $bucket_arr_malt)){
                $main_bucket_arr_malt[$bucket->id] = $bucket_arr_malt[$bucket->id]['tot_qty'];
            }else{
                $main_bucket_arr_malt[$bucket->id] = 0; 
            }
        }

        $store_name = Session::get('selected_store_title');

        $pdf = PDF::loadView('pdf',compact('main_bucket_arr','main_supplier_arr','store_name', 'buckets', 'schedule_a', 'main_bucket_arr_end', 'main_bucket_arr_malt'));

        return $pdf->download('plcb_report.pdf'); 

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
        ini_set('memory_limit', '1G');
        ini_set('max_execution_time', 300);

        $stores = Store::all();
        $store_array = array();
        foreach ($stores as $storesData) {
           $store_array[$storesData->id] = $storesData->name;
        }
        $appends = array();

        // $product_lists = Item::pluck('vitemname','iitemid');

        $productObj = Item::orderBy('mst_plcb_item.LastUpdate','desc')
                    ->currentStore()
                    //->where('mst_item.SID', 100077)
                    ->leftJoin('mst_item_size','mst_item_size.item_id','=','mst_item.iitemid')
                    ->leftJoin('mst_plcb_item','mst_plcb_item.item_id','=','mst_item.iitemid')
                    ->leftJoin('mst_item_unit','mst_item_unit.id','=','mst_item_size.unit_id')
                    ->leftJoin('mst_item_bucket','mst_item_bucket.id','=','mst_plcb_item.bucket_id');

        if(!empty(Request::get('product_id'))){
            $productObj->where('mst_item.iitemid',Request::get('product_id'));
        }

        $plcb_products = $productObj->paginate(25);
        $plcb_products->appends($appends);

        $units = MST_PLCB_UNIT::all();
        $buckets = MST_PLCB_BUCKET_TAG::all();
        
        return view('admin.plcb.index',compact('store_array', 'plcb_products', 'units', 'buckets'));
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
        $stores = Store::all();
        $store_array = array();
        foreach ($stores as $storesData) {
           $store_array[$storesData->id] = $storesData->name;
        }

        $plcb_product = Item::orderBy('mst_item.LastUpdate','desc')
                    ->currentStore()
                    //->where('mst_item.SID', 100077)
                    ->leftJoin('mst_item_size','mst_item_size.item_id','=','mst_item.iitemid')
                    ->leftJoin('mst_plcb_item','mst_plcb_item.item_id','=','mst_item.iitemid')
                    ->leftJoin('mst_item_unit','mst_item_unit.id','=','mst_item_size.unit_id')
                    ->leftJoin('mst_item_bucket','mst_item_bucket.id','=','mst_plcb_item.bucket_id')
                    ->where('iitemid',$id)
                    ->first();
        $units = MST_PLCB_UNIT::all();
        $buckets = MST_PLCB_BUCKET_TAG::all();

        return view('admin.plcb.edit',compact('store_array', 'plcb_product','units','buckets'));

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
        $return = array();
        $plcb_product = Item::findOrFail($id);
        $validation = MST_PLCB_ITEM::Validate(Request::all());
        
        if($validation->fails() === false){
            $mst_item_size = MST_ITEM_SIZE::where('item_id',$id)->first();
            
            if(count($mst_item_size) > 0){
                $mst_item_size->unit_id = (int)Request::get('unit_id');
                $mst_item_size->unit_value = Request::get('unit_value');
                $mst_item_size->SID = (int)Session::get('selected_store_id');
                $mst_item_size->save();
            }else{
                $mst_item_size_new = new MST_ITEM_SIZE();
                $mst_item_size_new->item_id = (int)$id;
                $mst_item_size_new->unit_id = (int)Request::get('unit_id');
                $mst_item_size_new->unit_value = Request::get('unit_value');
                $mst_item_size_new->SID = (int)Session::get('selected_store_id');
                $mst_item_size_new->save();
            }

            $mst_plcb_item = MST_PLCB_ITEM::where('item_id',$id)->first();

            if(count($mst_plcb_item) > 0){
                $mst_plcb_item->bucket_id = (int)Request::get('bucket_id');
                $mst_plcb_item->prev_mo_beg_qty = (int)Request::get('prev_mo_beg_qty');
                if(Request::get('prev_mo_end_qty') != ''){
                    $mst_plcb_item->prev_mo_end_qty = (int)Request::get('prev_mo_end_qty');
                }
                $mst_plcb_item->malt = (Request::get('malt') ? (int)Request::get('malt') : 0);
                $mst_plcb_item->SID = (int)Session::get('selected_store_id');
                $mst_plcb_item->save();
            }else{
                $mst_plcb_item_new = new MST_PLCB_ITEM();
                $mst_plcb_item_new->item_id = (int)$id;
                $mst_plcb_item_new->bucket_id = (int)Request::get('bucket_id');
                $mst_plcb_item_new->prev_mo_beg_qty = (int)Request::get('prev_mo_beg_qty');
                
                if(Request::get('prev_mo_end_qty') != ''){
                    $mst_plcb_item_new->prev_mo_end_qty = (int)Request::get('prev_mo_end_qty');
                }

                $mst_plcb_item_new->malt = (Request::get('malt') ? (int)Request::get('malt') : 0);
                $mst_plcb_item_new->SID = (int)Session::get('selected_store_id');

                $mst_plcb_item_new->save();
            }

            $return['code'] = 1;
        }else{
            $form_error = $validator->errors()->all();
            $return['code'] = 0;
            $return['response'] = $form_error;
        }

        return response()->json($return);
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


    public function insertData()
    {
        ini_set('memory_limit', '1G');

        $products = Item::all();
        
        $unitid = 1;
        $unitvalue = 5;
        $bucketid = 1;
        foreach ($products as $key => $value) {
            if($unitid == 11){
                $unitid = 1;
            }

            if($unitvalue == 25){
                $unitvalue = 5;
            }

            if($bucketid == 13){
                $bucketid = 1;
            }

            $mst_item_size = new MST_ITEM_SIZE();
            $mst_item_size->item_id = $value->iitemid;
            $mst_item_size->unit_id = $unitid;
            $mst_item_size->unit_value = $unitvalue;
            $mst_item_size->SID = 100077;
            $mst_item_size->save();

            $mst_plcb_item = new MST_PLCB_ITEM();
            $mst_plcb_item->item_id = $value->iitemid;
            $mst_plcb_item->bucket_id = $bucketid;
            $mst_plcb_item->prev_mo_beg_qty = $value->iqtyonhand;
            $mst_plcb_item->prev_mo_end_qty = $value->iqtyonhand - 10;
            $mst_plcb_item->malt = 1;
            $mst_plcb_item->SID = 100077;
            $mst_plcb_item->save();

            $unitid++;
            $bucketid++;

            $unitvalue = $unitvalue + 5;
        }
        // dd($products[0]);
        dd('Data Inserted Successfully!!!');
    }

    public function getProductList()
    {
        if(!empty(Request::get('term'))){
            $productObj = Item::where('mst_item.vitemname','like','%'.Request::get('term') .'%')->get();
            return response()->json($productObj);
        }else{
            return 'Something Went Wrong!!!';
        }
    }
}
