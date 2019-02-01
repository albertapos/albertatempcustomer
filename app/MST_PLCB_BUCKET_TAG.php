<?php

namespace pos2020;

use Illuminate\Database\Eloquent\Model;

class MST_PLCB_BUCKET_TAG extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'mst_item_bucket';
    public $timestamps = false;
    protected $primaryKey = "id";
}
