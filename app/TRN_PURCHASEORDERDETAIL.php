<?php

namespace pos2020;

use Illuminate\Database\Eloquent\Model;

class TRN_PURCHASEORDERDETAIL extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'trn_purchaseorderdetail';
    public $timestamps = false;
}
