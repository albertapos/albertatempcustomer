<?php

namespace pos2020;

use Illuminate\Database\Eloquent\Model;

class Web_store_Settings extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'web_store_settings';
    public $timestamps = false;
}
