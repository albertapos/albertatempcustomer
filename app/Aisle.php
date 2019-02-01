<?php

namespace pos2020;

use Illuminate\Database\Eloquent\Model;

class Aisle extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'mst_aisle';
}
