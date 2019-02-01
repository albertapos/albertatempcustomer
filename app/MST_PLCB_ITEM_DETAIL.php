<?php

namespace pos2020;

use Illuminate\Database\Eloquent\Model;

class MST_PLCB_ITEM_DETAIL extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'mst_plcb_item_detail';
    public $timestamps = false;
    protected $primaryKey = "id";
}
