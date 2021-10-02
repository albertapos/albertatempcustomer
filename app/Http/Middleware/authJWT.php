<?php

namespace pos2020\Http\Middleware;

use Closure;
use JWTAuth;
use pos2020\User;
use Request;
use Bican\Roles\Models\Role;
use Bican\Roles\Models\Permission;
use Exception;

class authJWT
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Config::set('auth.providers.users.model', OtherUser::class);
        // Config::set('auth.providers.users.table', 'other_users');
        
        \Config::set('jwt.user', "pos2020\StoreMwUsers");
        \Config::set('auth.providers.users.model', \pos2020\StoreMwUsers::class);
        \Config::set('auth.providers.users.table', 'store_mw_users');
        try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }

        } catch (Exception $e) {
            
            // echo "<pre>"; print_r($e->getMessage()); echo "</pre>"; die;
            
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){

                return response()->json(['error'=>'Token is Invalid'],401);

            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){

                return response()->json(['error'=>'Token is Expired'],401);

            }else{

                return response()->json(['error'=>$e->getMessage()],401);
            }
        }
        // dd($user);
        

        $url = $request->url();

        if (strpos($url, '7daysSales') !== false) {
            return $next($request);
        }
        
        if (strpos($url, '7daysCustomer') !== false) {
            return $next($request);
        }

        if (strpos($url, 'topCategory') !== false) {
            return $next($request);
        }

        if (strpos($url, 'topItem') !== false) {
            return $next($request);
        }
        
        if (strpos($url, 'dailySummary') !== false) {
            return $next($request);
        }
        
        if (strpos($url, 'api/admin/customer') !== false) {
            return $next($request);
        }


        if($user->mob_user != 'Y'){
            return response()->json(['error'=>'No more mobile user'],401);
        }
        
        // print_r($request);die;
     
        //Request::header('Content-Type','application/json');

        // $sid = null;
        // if($request->sid && $request->sid > 0 )
        // {
        //     $sid = $request->sid;
        // }
        // User::changeStore($sid);
        // dd($next);
        return $next($request);

    }

}
