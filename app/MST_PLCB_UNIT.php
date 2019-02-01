<?php

namespace pos2020;

use Illuminate\Database\Eloquent\Model;

class MST_PLCB_UNIT extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'mst_item_unit';
    public $timestamps = false;
    protected $primaryKey = "id";
}
