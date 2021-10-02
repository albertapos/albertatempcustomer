<?php

namespace pos2020;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $connection = 'mysql';
    protected $table = 'mst_unit';
    protected $primaryKey = 'iunitid';
    public $timestamps = false;
}
