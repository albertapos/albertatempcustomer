<?php

namespace pos2020;

use Illuminate\Database\Eloquent\Model;

class salesStores extends Model
{
    protected $table = 'sales_stores';

   public function user(){

    	return $this->belongsTo('pos2020\User');
    }
}
