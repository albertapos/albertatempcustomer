<?php

namespace pos2020;

use Illuminate\Database\Eloquent\Model;
use Request;
use DB;
use SESSION;

class tmp_priceupdate extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'tmp_priceupdate';
    public $timestamps = false;

    
}