<?php

namespace pos2020;

use Illuminate\Database\Eloquent\Model;

class TRN_PURCHASEORDER extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'trn_purchaseorder';
    public $timestamps = false;
}
