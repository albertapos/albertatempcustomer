<?php

namespace pos2020;

use Illuminate\Database\Eloquent\Model;

class kioskPageFlowHeader extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'kiosk_page_flow_header';

    public function options(){
    	return $this->hasMany('pos2020\kioskPageFlowDetail','PageId','PageId');
    }
      public function pageTitle(){
        return $this->hasOne('pos2020\kioskPageMaster','PageId','PageId');
    }
}
