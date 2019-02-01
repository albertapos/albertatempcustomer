<?php

namespace pos2020\Http\Controllers\Auth;

use pos2020\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Bican\Roles\Models\Role;
use Bican\Roles\Models\Permission;
use Auth;
//use Illuminate\Http\Request;
use Validator;
use pos2020\User;
use Request;
use JWTAuth;




class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }
    public function postLogin(Request $request) {
        $request = Request::all();
        $credentials = Request::only(['email', 'password']);
        $validation = $this->validateEmail($credentials);
             
        if($validation->fails() === false) {
            if (auth()->attempt($credentials, Request::has('remember'))) {
                $user = Auth::user();
                $is_mobile_user = $user->is_mobile_user;
                if($is_mobile_user == 'False'){
                    return redirect('/auth/logout')->withErrors(array('Login Fail'));
                    //return redirect('/')->withErrors($validation);
                }
                if (Request::isJson())
                {
                        $token = JWTAuth::fromUser($user);
                        $result  = $user->toArray();
                        $result['token']  = $token;
                        $result['Stores']  = $user->store->toArray();
                        return $result;
                }
                 foreach ($user->roles()->get() as $role)
                {
                    if ($role->name == 'Admin')
                    {
                        User::changeStore(); 
                        return redirect('/admin');
                    }

                    if ($role->name == 'Vendor')
                    {
                        User::changeStore();
                         return redirect('/admin');
                    }
                    if ($role->name == 'Sales Admin')
                    {
                        User::changeStore();
                        return redirect('/sales/agentoffice');
                    }
                    if ($role->name == 'Sales Manager')
                    {
                        User::changeStore();
                        return redirect('/sales/users');
                    }
                    if ($role->name == 'Sales Agent')
                    {
                        User::changeStore();
                        return redirect('/sales/users');
                    }
                    if ($role->name == 'Store Manager')
                    {
                        User::changeStore();
                        return redirect('/admin');
                    }
                    return redirect('/sales/vendors');
                    
                }
            } else {
                if (Request::isJson())
                {
                        return 'Login Fail';
                }
                return redirect('/login')->withErrors(array('Login Fail'));
            }
        }else{

            if (Request::isJson())
            {
                    return $validation->errors()->all();
            }
            return redirect('/login')->withErrors($validation);
        }
    }
    protected function validateEmail(array $data) {
        return Validator::make($data, [
                'email' => 'required|email',
                //'password' =>bcrypt($data['password']),
                'password' => 'required'
            ]);
    }
    public function logout(Request $request)
    {
        
        if(Request::session()->has('exce_error')){
            $check_exce = Request::session()->get('exce_error');
        }else{
            $check_exce = '';
        }
        
        $this->guard()->logout();

        Request::session()->flush();

        Request::session()->regenerate();

        if (Request::isJson()){
            return config('app.RETURN_MSG.SUCCESS');
        }
        else{
            if($check_exce == 'yes'){
                return redirect('/login')->withErrors(array('Something went wrong please login again!!!'));
            }else{
                return redirect('/login');
            }
            
        }

        
    }
    public function redirectPath()
    {
        $user = Auth::user();
        foreach ($user->roles()->get() as $role)
        {
            if ($role->name == 'Admin')
            {
                 return '/admin';
            }
            if ($role->name == 'Vendor')
            {
                 return '/vendor';
            }
            return '/sales';
        }
    }
}
