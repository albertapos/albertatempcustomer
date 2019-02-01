<?php

namespace pos2020\Http\Controllers\Admin;


use Request;
use pos2020\Http\Controllers\Controller;
use Bican\Roles\Models\Role;
use Bican\Roles\Models\Permission;
use pos2020\Http\Requests;
use pos2020\User;
use pos2020\Store;
use Auth;

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
        $users = User::all();
       
        $stores = Store::all();
        $store_array = array();
        foreach ($stores as $storesData) {
           $store_array[$storesData->id] = $storesData->name;
        }

        if (Request::isJson()){
            return $users->toJson();
        }else{
             return view('admin.user.index',compact('users','store_array'));
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roleUser = Role::all();
        $role_array = array();
        foreach ($roleUser as $roleData) {
            $role_array[$roleData->id] = $roleData->name;
        }
        $stores = Store::all();
        $store_array = array();
        foreach ($stores as $storesData) {
           $store_array[$storesData->id] = $storesData->name;
        }
        if (Request::isJson()){
           return config('app.RETURN_MSG.SUCCESS');
        }

        return view('admin.user.create',compact('role_array','store_array'));
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
        $checked = Request::get('mobileuser') ;

      
        if($validation->fails() === false)
        {
            $user = User::create(User::userFillData());
            $role = Request::get('roleName');
            if($role != 0){
                $user->attachRole($role);

            }
            if((Request::get('roleName')) == 2){
              $user->store()->attach(Request::get('storeName'));  
            }
            if (Request::isJson()){
               return config('app.RETURN_MSG.SUCCESS');
            }
            return redirect('admin/users')->withSuccess('User Created!');
        }
        else
        {
            if (Request::isJson()){
                return  $validation->errors()->all();
            }
          
            return redirect('/admin/users/create')->withInput()
                      ->withErrors($validation);
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

        $roleUser = Role::all();
        $role_array = array();
        foreach ($roleUser as $roleData) {
            $role_array[$roleData->id] = $roleData->name;
        }
        $stores = Store::all();
        $store_array = array();
        foreach ($stores as $storesData) {
           $store_array[$storesData->id] = $storesData->name;
        }

        foreach ($user->role()->get() as $role) {
            $id = $role->role_id;
        }
        foreach ($user->store()->get() as $store) {
            $storeId = $store->id;
        }

        if (Request::isJson()){
            return $user->toJson();
        }else{
             return view('admin.user.edit',compact('user','role_array','store_array','id'));
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

        $user = User::with('role','store')->findOrFail($id);

        $validation = User::updateValidate(Request::all());
       // dd(Request::all());

        if($validation->fails() === false)
        {
            $user->fill(User::userFillData());
            $user->save();

            $userRole = $user->role()->get();

            foreach ($userRole as $role) {
             $roleId[] = $role->role_id;
            }  

            $role = Request::get('roleName');
            if($role != 0)
            {
                if($userRole->count() > 0){
                    $user->detachRole($roleId);
                }
                $user->attachRole($role);
                $user->save();
            }else{
                $user->detachRole($roleId);
                $user->save();
            }
         
            if(Request::get('roleName') == 2 && Request::get('storeName')){
              $user->store()->detach();
              $user->store()->attach(Request::get('storeName'));
              $user->save();
            }
            return redirect('admin/users')->withSuccess('User Updated Successfully');
        }
        else{

            if (Request::isJson()){
                if($validation->fails() === false)
                {
                   return config('app.RETURN_MSG.SUCCESS');
                }
                else{
                  return redirect('admin/users/'.$user->id.'/edit')
                        ->withErrors($validation);
                }
            }
            return redirect('admin/users/'.$user->id.'/edit')->withInput()
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

        $user =  User::findOrFail($id);
        foreach ($user->userStores()->get() as $store) {
            $store->delete();
        }
        $user->store()->delete();
        $user->delete();

        if (Request::isJson()){
           return config('app.RETURN_MSG.SUCCESS');
        }else{
            return redirect('admin/users')->withSuccess('User Deleted!');
        }
    }
    public function postEdit(Request $request, $id){

        $user = User::with('role','store')->findOrFail($id);

        $validation = User::Validate(Request::all());
      
        //dd(Request::all());
        if($validation->fails() === false)
        {
            $user->fill(Request::userFillData());
            $user->save();

            $userRole = $user->role()->get();

            foreach ($userRole as $role) {
               $roleId = $role->role_id;
            }
            $role = Request::get('roleName');
            if($role != 0){
                $user->detachRole($roleId);
                $user->attachRole($role);
                $user->save(); 
            }
            
            
            if(Request::get('roleName') == 2 && Request::get('storeName')){
              $user->store()->detach();
              $user->store()->attach(Request::get('storeName'));
              $user->save();
            }
            if (Request::isJson()){
                return config('app.RETURN_MSG.SUCCESS');
            }
            return redirect('admin/users')->withSuccess('User Updated Successfully');;
        }
        else{
            if (Request::isJson()){
                return  $validation->errors()->all();
            }
            return redirect('admin/users/'.$user->id.'/edit')->withInput()
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
        $userStores = $user->store()->get();
        return view('admin.user.userView',compact('user','store_array','stores'));
    }
}
