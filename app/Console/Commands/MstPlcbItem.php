<?php

namespace pos2020\Console\Commands;

use Illuminate\Console\Command;
use pos2020\Store;
use pos2020\Item;
use pos2020\MST_PLCB_ITEM;
use pos2020\TRN_PURCHASEORDERDETAIL;
use pos2020\TRN_PURCHASEORDER;
use pos2020\MST_PLCB_ITEM_DETAIL;
use pos2020\MST_PLCB_BUCKET_TAG;
use Session;
use PDF;
use Mail;

class MstPlcbItem extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mstplcbitem:mstplcbitem_update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'mst_plcb_item table update prev_mo_beg_qty value';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->mstPlcbItem();
        $this->mstPlcbItemDetails();
        $this->mstPlcbReportEmail();
    }

    public function mstPlcbItem(){

        $stores = Store::all();

        foreach ($stores as $key => $store) {
            if($store->plcb_product == 'Y'){
                $store->plcbsetdb($store);

                $plcbitems =  MST_PLCB_ITEM::pluck('id');
                
                if(count($plcbitems) > 0){
                    foreach ($plcbitems as $plcbitem) {
                        $plcb_update = MST_PLCB_ITEM::find($plcbitem);
                        $mst_item = Item::find($plcb_update->item_id);
                       
                        $plcb_update->prev_mo_beg_qty = $plcb_update->prev_mo_end_qty;
                        $plcb_update->prev_mo_end_qty = $mst_item->iqtyonhand;
                        $plcb_update->save();
                    }
                }
            }
        }
    }

    public function mstPlcbItemDetails(){

        $stores = Store::all();

        foreach ($stores as $key => $store) {
            if($store->plcb_report == 'Y'){
                $store->plcbsetdb($store);

                $plcbitems =  MST_PLCB_ITEM::all();
                
                $truncate = MST_PLCB_ITEM_DETAIL::truncate();
                
                if(count($plcbitems) > 0){

                    $dates[0] = \Carbon\Carbon::now()->setTimezone('EST')->subMonth()->startOfMonth()->format('Y-m-d');
                    $dates[1] = \Carbon\Carbon::now()->setTimezone('EST')->subMonth()->endOfMonth()->format('Y-m-d');

                    foreach ($plcbitems as $plcbitem) {
                        
                        $plcbdetails = TRN_PURCHASEORDERDETAIL::leftJoin('trn_purchaseorder','trn_purchaseorder.ipoid','=','trn_purchaseorderdetail.ipoid')
                        ->where('trn_purchaseorderdetail.vitemid',$plcbitem->item_id)
                        ->where('trn_purchaseorder.estatus','Close')
                        ->whereBetween('trn_purchaseorderdetail.LastUpdate',$dates)
                        ->get();
                        
                        if(count($plcbdetails) > 0){
                            $main_arr = array();
                            foreach ($plcbdetails as $key => $plcbdetail) {
                                if(array_key_exists($plcbdetail['vvendorid'], $main_arr)){
                                    $main_arr[$plcbdetail['vvendorid']]['prev_mo_purchase'] = $main_arr[$plcbdetail['vvendorid']]['prev_mo_purchase'] + 1;

                                }else{
                                    $main_arr[$plcbdetail['vvendorid']] = array(
                                                                        'plcb_item_id' => $plcbitem->item_id,
                                                                        'supplier_id' => $plcbdetail['vvendorid'],
                                                                        'prev_mo_purchase' => 1
                                                                        );

                                }
                            }

                            $main_plcb_details = array();
                            foreach ($main_arr as $main_array) {
                               $main_plcb_details[] =  $main_array;
                            }

                            foreach ($main_plcb_details as  $main_plcb_detail) {
                                $mst_plcb_item_details = new MST_PLCB_ITEM_DETAIL();
                                $mst_plcb_item_details->plcb_item_id = $main_plcb_detail['plcb_item_id'];
                                $mst_plcb_item_details->supplier_id = $main_plcb_detail['supplier_id'];
                                $mst_plcb_item_details->prev_mo_purchase = $main_plcb_detail['prev_mo_purchase'];
                                $mst_plcb_item_details->SID = $store->id;
                                $mst_plcb_item_details->save();
                            }
                        }
                    }
                }
            }
        }
    }

    public function mstPlcbReportEmail(){

        $stores = Store::all();

        foreach ($stores as $key => $store) {
            if($store->plcb_report == 'Y'){
                $store->plcbsetdb($store);

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

                if(!empty($store->user()->first()->email)){

                    $user_email = $store->user()->first()->email;
                    $store_name = $store->name;

                    Mail::send('emails.pdf_report', array(),function($message) use ($main_bucket_arr,$main_supplier_arr,$user_email,$store_name,$buckets,$schedule_a,$main_bucket_arr_end,$main_bucket_arr_malt){

                        $prev_month = \Carbon\Carbon::now()->setTimezone('EST')->subMonth()->format('F, Y');
                        
                        $pdf = PDF::loadView('pdf',compact('main_bucket_arr','main_supplier_arr','store_name','buckets','schedule_a','main_bucket_arr_end','main_bucket_arr_malt'));

                        $message->subject('PLCB Report of '.$prev_month);
                        $message->to($user_email);
                        $message->cc('samaj.patel@gmail.com');

                        $message->from('pos2020order@gmail.com','POS2020');

                        $message->attachData($pdf->output(), 'plcb_report.pdf');
                    });
                }
            }
        }
    }
}
