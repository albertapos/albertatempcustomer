<?php

namespace pos2020;

use Illuminate\Database\Eloquent\Model;

class MST_ITEM_SIZE extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'mst_item_size';
    public $timestamps = false;
    protected $primaryKey = "id";
}
