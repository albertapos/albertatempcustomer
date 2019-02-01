<?php

namespace pos2020;

use Illuminate\Database\Eloquent\Model;

class KIOSK_PAGE_MASTER extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'kiosk_page_master';
    public $timestamps = false;
    protected $primaryKey = "PageId";
}
