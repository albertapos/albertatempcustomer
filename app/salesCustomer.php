<?php

namespace pos2020;

use Illuminate\Database\Eloquent\Model;
use DB;
use SESSION;
class salesCustomer extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'trn_salescustomer';
    public $timestamps = false;

    public function getCustomerByDates($date = null,$storeId = null){
        if(is_null($date)) {
            $date = date("Y-m-d");
            $dates[] = date("Y-m-d", (strtotime($date)) - (7*24*60*60));
            $dates[] = $date ;
        }  
        else if(is_array($date)) {
            $dates = $date;
        }
        else  {
            $dates[] = date("Y-m-d", (strtotime($date)) - (7*24*60*60));
            $dates[] = $date ;
        }

        $obj =  self::whereBetween('dtrandate',$dates) 
                        ->orderBy('trn_salescustomer.dtrandate','desc')
                        ->groupBy('dtrandate')
                        ->groupBy('trn_salescustomer.SID');

        if(!is_null($storeId) && $storeId > 0 ){
            $obj->where('trn_salescustomer.SID',$storeId);
        }
            
        $data = $obj->get(array(DB::raw("DATE_FORMAT(dtrandate, '%Y-%m-%d' ) as  date"), 
                                    DB::raw('count(isalesid) AS total ')))
                         ->toArray(); 
            return $data;
                        
        return $data;
    }
    public function getTodayCustomer($dates = null){
        if(is_null($dates)) {
            $dates = date("Y-m-d");
        } 
        $data =  self::where('dtrandate',$dates) 
                        ->orderBy('trn_salescustomer.dtrandate','desc')
                        ->groupBy('dtrandate')
                        ->currentStore()
                        ->get(array( DB::raw('count(isalesid) AS total ')));
                      
       
        return $data;
    }
    public function getYesterdayCustomer($dates = null){

        if(is_null($dates)) {
            $dates = date("Y-m-d");
        } 
        $dates = date("Y-m-d", (strtotime($dates)) - (24*60*60));
        $data =  self::where('dtrandate',$dates) 
                        ->orderBy('trn_salescustomer.dtrandate','desc')
                        ->groupBy('dtrandate')
                        ->currentStore()
                        ->get(array(DB::raw('count(isalesid) AS total ')));
                       
       
        return $data;
    }
    public function getCustomerByHour($date = null){
       
        if(is_null($date)) {
            $date = date("Y-m-d");
            $dates[] = date("Y-m-d", (strtotime($date)) - (7*24*60*60));
            $dates[] = $date ;
        }  
        else if(is_array($date)) {
            $dates = $date;
        }
        else  {
            $dates[] = date("Y-m-d", (strtotime($date)) - (7*24*60*60));
            $dates[] = $date ;
        }

        $data =  self::whereBetween('dtrandate',$dates) 
                        ->orderBy('trn_salescustomer.dtrandate','desc')
                        ->currentStore()
                        ->groupBy('dtrandate')
                        ->get(array(DB::raw("DATE_FORMAT(dtrandate,   '%b-%d'  ) as  date"),
                            DB::raw('count(isalesid) AS total ')))
                        ->toArray();

        return $data;
    }
    public function scopeCurrentStore($query) {
        return  $query->where('trn_salescustomer.SID', SESSION::get('selected_store_id'));
    }

}
