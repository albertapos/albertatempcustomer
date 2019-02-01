<?php

namespace pos2020;

use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Authenticatable;
use Bican\Roles\Models\Permission;
use Illuminate\Auth\Passwords\CanResetPassword;
use Laravel\Passport\HasApiTokens;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;


use Bican\Roles\Traits\HasRoleAndPermission;
use Bican\Roles\Contracts\HasRoleAndPermission as HasRoleAndPermissionContract;
use Validator;
use Request;
use Config;
use Session;
use Auth;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract, HasRoleAndPermissionContract
{
    use Authenticatable, CanResetPassword, HasRoleAndPermission;
    use Notifiable;
    use HasApiTokens;


    protected $table = 'users';
    const SUCCESS = 'Send Data successfully';
    //const MASTER_PASSWORD   = "admin";
    protected $visible = array(
        "id",
        "fname",
        "lname",
        "phone",
        "email",
        "role",
        "store"
    );
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'fname', 'lname', 'phone', 'email', 'password','api_token','is_mobile_user','agent_office_id',
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','api_token',
    ];

    public static function Validate($data) {
        $rules = array(
            'fname' => array('required'),
            'lname' => array('required'),
            'phone' => 'required|min:10|numeric',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
            
        );
        return Validator::make($data, $rules);
    }
    public static function updateValidate($data) {
        $rules = array(
           'fname' => 'required|min:3|max:255',
            'lname' => 'required|min:3|max:255',
            'phone' => 'required|min:10|numeric',
            'password' => 'confirmed',
            
        );
        return Validator::make($data, $rules);
    }
    public static function userFillData()
    { 

        $data = [
            'fname' => Request::get('fname'),
            'lname' => Request::get('lname'),
            'phone' => Request::get('phone'),
            'email' => Request::get('email'),
            'api_token' => str_random(60),
            'is_mobile_user' => (Request::get('is_mobile_user') ? Request::get('is_mobile_user') : 'False'),
            //'agent_office_id' => Auth::User()->agent_office_id

           // 'agent_office_id' => Request::get('officeName')
        ];
        //dd(Request::get('officeName'));
        $data['agent_office_id'] = Request::get('officeName');
        foreach (Auth::user()->roles()->get() as $role){
            if ($role->name != 'Sales Admin'){
                $data['agent_office_id'] = Auth::User()->agent_office_id;
            }
       }
        $password = Request::get('password', null);
        if($password && strlen(trim($password)) > 1 ){ 
            $data['password'] = bcrypt(Request::get('password'));
        }
        return $data;
    }
    public static function messages()
    {
        return [
            'storeName.required' => 'Plesse Select the role',
        ];
    }

    public function store()
    {
        return $this->belongsToMany('pos2020\Store', 'user_stores', 'user_id', 'store_id');
    }

    public function stores()
    {
        return $this->belongsToMany('pos2020\Store', 'sales_stores', 'user_id', 'store_id');
    }

    public function userStores()
    {
        return $this->hasMany(UserStores::class)->with('user');
    }
    public function role()
    {
        return $this->hasMany('pos2020\RoleUser');
    }
    public function office()
    {
        return $this->hasOne('pos2020\agentOffice','id','agent_office_id');
    }
    public static function changeStore($storeId = null){
        $user = Auth::User();

        if(is_null($storeId))
        {
            if($user->roles()->first()->name == "Admin") {
                $store = Store::first();
            } else if(in_array($user->roles()->first()->name, array('Sales Manager','Sales Admin','Sales Agent'))) {
                $store = $user->stores->first();
            } else {
                $store = $user->store->first();
            }
        
        }else{

            if($user->roles()->first()->name == "Admin") {
                $store = Store::where('id',$storeId)->first();
            } else if(in_array($user->roles()->first()->name, array('Sales Manager','Sales Admin','Sales Agent'))) {
                $store = $user->stores->where('id',$storeId)->first();
            } else {
                $store = $user->store->where('id',$storeId)->first();
            }
        }
        if($store){

            Session::put('selected_store_id',$store->id);
            Session::put('s_db_name',$store->db_name);
            Session::put('s_db_username',$store->db_username);
            Session::put('s_db_password',$store->db_password);
            Session::put('s_db_host',$store->db_hostname); 
            Session::put('selected_store_title',$store->name); 
            $data1 = Request::session()->all();
            return $store;
        }
            
    }
}
