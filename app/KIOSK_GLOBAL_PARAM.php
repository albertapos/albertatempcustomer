<?php

namespace pos2020;

use Illuminate\Database\Eloquent\Model;

class KIOSK_GLOBAL_PARAM extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'kiosk_global_param';
    public $timestamps = false;
    protected $primaryKey = "UId";
}
