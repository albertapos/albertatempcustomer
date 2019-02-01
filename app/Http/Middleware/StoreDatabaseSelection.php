<?php

namespace pos2020\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Config;
use Session;

class StoreDatabaseSelection
{

    public function handle($request, Closure $next )
    {
        Config::set('database.connections.mysql2', array(
                
            'driver' => 'mysql',
            'host' =>  Session::get('s_db_host'),
            'port' => env('DB_PORT', '3306'),
            'database' => Session::get('s_db_name'),
            'username' => Session::get('s_db_username'),
            'password' => Session::get('s_db_password'),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        
        ));
        return $next($request);
    }
}
