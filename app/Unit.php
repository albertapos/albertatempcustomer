<?php

namespace pos2020;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'mst_unit';
}
