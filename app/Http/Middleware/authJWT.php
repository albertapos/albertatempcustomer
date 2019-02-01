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
        try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }

        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){

                return response()->json(['error'=>'Token is Invalid'],401);

            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){

                return response()->json(['error'=>'Token is Expired'],401);

            }else{

                return response()->json(['error'=>'Something is wrong'],401);
            }
        }

        if($user->roles()->first()->name != 'Admin' && $user->is_mobile_user == 'False'){
            return response()->json(['error'=>'No more mobile user'],401);
        }
     
        //Request::header('Content-Type','application/json');

        $sid = null;
        if($request->sid && $request->sid > 0 )
        {
            $sid = $request->sid;
        }
        User::changeStore($sid);
        return $next($request);

    }

}
