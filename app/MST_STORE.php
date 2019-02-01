<?php

namespace pos2020;

use Illuminate\Database\Eloquent\Model;

class MST_STORE extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'mst_store';
    public $timestamps = false;

    public function dailySales(){
    	return $this->hasMany('pos2020\TRN_DAILYSALES');
    }

   public function getStoreInfo($sid){
   	$getStoreInfo = mst_store::where('SID',$sid)->get();
    return $getStoreInfo;
   }
}
