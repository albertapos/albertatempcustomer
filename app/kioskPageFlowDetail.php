<?php

namespace pos2020;

use Illuminate\Database\Eloquent\Model;

class kioskPageFlowDetail extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'kiosk_page_flow_detail';

    public function item(){
    	return $this->belongsTo('pos2020\Item','iitemid','iitemid');
    }
   
}
