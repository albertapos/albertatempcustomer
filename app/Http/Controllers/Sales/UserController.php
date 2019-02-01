<?php

namespace pos2020\Http\Controllers\Sales;

use Request;
use pos2020\Http\Controllers\Controller;
use Bican\Roles\Models\Role;
use Bican\Roles\Models\Permission;
use pos2020\RoleUser;
use Auth;
use pos2020\Http\Requests;
use pos2020\User;
use pos2020\Store;
use pos2020\agentOffice;
//use pos2020\Http\Requests\UserCreateRequest;
//use pos2020\Http\Requests\UserUpdateRequest;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      
        foreach (Auth::user()->roles()->get() as $role)
        {
            if($role->name == 'Sales Admin'){
                $roleUser = RoleUser::with('user')->where('role_id','=',4)
                                        ->orWhere('role_id','=',7)
                                        ->orWhere('role_id','=',6)
                                        ->orWhere('role_id','=',8)
                                        ->orWhere('role_id','=',9)
                                        ->orWhere('role_id','=',2)
                                        ->get();
                $roleId = array();
    
                foreach ($roleUser as $role) {
                    $roleId[] = $role->user_id;
                }
                $users = User::whereIn('id',$roleId)->get();
            }
            if($role->name == 'Sales Manager'){
                $roleUser = RoleUser::with('user')->where('role_id','=',7)->orWhere('role_id','=',6)->get();
                $roleId = array();
    
                foreach ($roleUser as $role) {
                    $roleId[] = $role->user_id;
                }
                $users = User::where('agent_office_id','=',Auth::user()->office->id)->get();
            }  
            if($role->name == 'Sales Agent'){
                $roleUser = RoleUser::with('user')->where('role_id','=',2)->orWhere('role_id','=',8)->orWhere('role_id','=',9)->get();
                $roleId = array();
    
                foreach ($roleUser as $role) {
                    $roleId[] = $role->user_id;
                }

                $users = User::whereIn('id',$roleId)->where('agent_office_id','=',Auth::user()->office->id)->get();
            }
            if($role->name == 'Sales Executive'){
                $roleUser = RoleUser::with('user')->where('role_id','=',3)->get();

            }
            if($role->name == 'Store Manager'){
                $roleUser = RoleUser::with('user')->where('role_id','=',8)->get();

            }
        }

       // $roleUser = RoleUser::with('user')->where('role_id','=',2)->get();
       
       // $user=Auth::user()->office->id;
        //dd($user);
       // dd($roleId);
      //$users = User::whereIn('id',$roleId)->paginate(10);
      // $users = User::where('agent_office_id','=',Auth::user()->office->id)->paginate(10);

        $stores = Auth::User()->store()->get();
        $store_array = array();
        foreach ($stores as $storesData) {
           $store_array[$storesData->id] = $storesData->name;
        }

        if (Request::isJson()){
            return $users->toJson();
        }else{
            return view('sales.user.index',compact('users','store_array'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        /*$stores = Auth::User()->store()->get();
        $store_array = array();
        foreach ($stores as $storesData) {
           $store_array[$storesData->id] = $storesData->name;
        }*/

         $stores = Store::salesStore()->get();
        $store_array = array();
        foreach ($stores as $storesData) {
           $store_array[$storesData->id] = $storesData->name;
        }

        $roleUser = RoleUser::with('user')->where('role_id','!=',1)
                                          ->get();
        foreach ($roleUser as $role) {
              $userName = User::where('id','=',$role->user_id)->orderBy('fname')->get();
              foreach ($userName as $name) {
                 $user_array[$name->id] = $name->fname ." " . $name->fname ."(".$name->email .")";
             
          }
        }

        foreach (Auth::user()->roles()->get() as $role)
        {
            if($role->name == 'Sales Admin'){
                $roleUser = Role::where('id','=',4)->get();
            }
            if($role->name == 'Sales Manager'){
                $roleUser = Role::where('id','=',6)->orWhere('id','=',7)->get();
            }  
            if($role->name == 'Sales Agent'){
                $roleUser = Role::where('id','=',2)->orWhere('id','=',8)->orWhere('id','=',9)->get();
            }  
            if($role->name == 'Sales Executive'){
                $roleUser = RoleUser::with('user')->where('role_id','=',3)->get();

            }
        }
        
        $role_array = array();
        foreach ($roleUser as $roleData) {
            $role_array[$roleData->id] = $roleData->name;
        }
        $agentOffices = agentOffice::all();
        $agent_arry = array();

        foreach ($agentOffices as $office) {
            $agent_arry[$office->id]= $office->title;
        }

        if (Request::isJson()){
           return config('app.RETURN_MSG.SUCCESS');
        }

        return view('sales.user.create',compact('store_array','role_array','agent_arry'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = User::Validate(Request::all());
      
        if($validation->fails() === false)
        {
            $user = User::create(User::userFillData());
          //  $role = Role::where('slug', 'salesexecutive')->first();

            foreach (Auth::user()->roles()->get() as $role)
            {

                if($role->name == 'Sales Admin'){
                   $roleName = Request::get('roleName');
                }
                if($role->name == 'Sales Manager'){
                     $roleName = Request::get('roleName');
                }  
                if($role->name == 'Sales Agent'){
                   $roleName = Request::get('roleName');
                }  
                if($role->name == 'Sales Executive'){
                   $roleName = Role::where('slug', 'salesexecutive')->first();
                }
            }
            $user->store()->attach(Request::get('storeName'));  
            $user->attachRole($roleName);
            if (Request::isJson())
            {
                return config('app.RETURN_MSG.SUCCESS');
            }
            return redirect('sales/users')->withSuccess('User Successfully Created.');
        }else
        {
            if (Request::isJson()){
                return  $validation->errors()->all();
            }
            return redirect('/sales/users/create')->withInput()->withErrors($validation);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::with('role','store')->findOrFail($id);
       
         $stores = Store::salesStore()->get();
        $store_array = array();
        foreach ($stores as $storesData) {
           $store_array[$storesData->id] = $storesData->name;
        }

        foreach (Auth::user()->roles()->get() as $role)
        {
            if($role->name == 'Sales Admin'){
                $roleUser = Role::where('id','=',4)->get();
            }
            if($role->name == 'Sales Manager'){
                $roleUser = Role::where('id','=',6)->orWhere('id','=',7)->get();
            }  
            if($role->name == 'Sales Agent'){
                $roleUser = Role::where('id','=',2)->orWhere('id','=',8)->orWhere('id','=',9)->get();
            }  
            
        }
        
        if($role->name != 'Sales Executive'){
            $role_array = array();
            foreach ($roleUser as $roleData) {
                $role_array[$roleData->id] = $roleData->name;
            }
            $agentOffices = agentOffice::all();
            $agent_arry = array();

            foreach ($agentOffices as $office) {
                $agent_arry[$office->id]= $office->title;
            }
        }

        foreach ($user->role()->get() as $role) {
            $id = $role->role_id;
        }
        if (Request::isJson()){
            return $user->toJson();
        }else{
          return view('sales.user.edit',compact('user','store_array','role_array','agent_arry','id'));
        } 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $user = User::findOrFail($id);

        $validation = User::updateValidate(Request::all());
      
        if($validation->fails() === false)
        {
            $user = User::findOrFail($id);
            $user->fill(User::userFillData());
            $user->save();
            return redirect('sales/users')->withSuccess('User Updated Successfully');
        }
        else{
            if (Request::isJson()){
                if($validation->fails() === false)
                {
                   return config('app.RETURN_MSG.SUCCESS');
                }
                else{
                  return redirect('sales/users/'.$user->id.'/edit')
                        ->withErrors($validation);
                }
            }
            return redirect('sales/users/'.$user->id.'/edit')->withInput()
                        ->withErrors($validation);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        foreach ($user->userStores()->get() as $store) {
            $store->delete();
        }
        $user->store()->delete();
        $user->delete();

        if (Request::isJson()){
            return config('app.RETURN_MSG.SUCCESS');
        }else{
             return redirect('sales/users')->withSuccess('User Deleted!');
        }

    }
    public function postEdit(Request $request,$id){

        $user = User::findOrFail($id);
        $validation = User::Validate(Request::all());
      
        if($validation->fails() === false)
        {
            $user = User::findOrFail($id);
            $user->fill(User::userFillData());
            $user->save();

            if (Request::isJson()){
                return config('app.RETURN_MSG.SUCCESS');
            }
            return redirect('sales/users')->withSuccess('User Updated Successfully');
        }
        else
        {
            if (Request::isJson()){
                return  $validation->errors()->all();
            }

            return redirect('sales/users/'.$user->id.'/edit')
                    ->withErrors($validation);
               
        }
          

    }
    public function getUserView(Request $request , $id){
        $user = User::findOrFail($id);
        $stores = Store::all();
        $store_array = array();
        foreach ($stores as $storesData) {
           $store_array[$storesData->id] = $storesData->name;
        }

        return view('sales.user.userView',compact('user','store_array'));
    }
}
