<?php

namespace pos2020;

use Illuminate\Database\Eloquent\Model;

class UserStores extends Model
{
    protected $table = 'user_stores';

   public function user(){

    	return $this->belongsTo('pos2020\User');
    }
}
