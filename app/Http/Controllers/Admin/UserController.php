<?php

namespace pos2020\Http\Controllers\Admin;


use Request;
use pos2020\Http\Controllers\Controller;
use Bican\Roles\Models\Role;
use Bican\Roles\Models\Permission;
use pos2020\Http\Requests;
use pos2020\User;
use pos2020\StoreMwUsers;
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
        $roleUser = Role::whereIn('id', [2,7])->get();
        $role_array = array();
        foreach ($roleUser as $roleData) {
            $role_array[$roleData->id] = $roleData->name;
        }
        $stores = Store::all();
        $store_array = array();
        foreach ($stores as $storesData) {
           $store_array[$storesData->id] = $storesData->name." [{$storesData->id}]";
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
        $input = Request::all();
        
        $store_array = $input['storeName'];
        
        
        
        $return = StoreMwUsers::where('vemail', $input['email'])->where('estatus', 'Active')->first();
        
        if(isset($return)){
            $portal_error = array( array("That email has already been taken." ));
            return redirect('/admin/users/create')->withInput()
                      ->withErrors($portal_error);
        }
        
        $validation = User::Validate($input);
        $checked = Request::get('mobileuser') ;

        if($validation->fails() === false)
        {
            $user = User::create(User::userFillData());
            
            $is_mobile_user = ($user->is_mobile_user == 'True')?'Y':'N';
            
            $check_store_mw_users = \DB::connection('mysql')->select("SELECT * FROM inslocdb.store_mw_users WHERE vemail = '{$input['email']}'");
            
            // echo "<pre>"; print_r($check_store_mw_users); echo "</pre>"; die;
            
            
            if(!isset($check_store_mw_users[0])){
                $store_mw_users_query = "INSERT INTO inslocdb.store_mw_users (`iuserid`, `sid`, `fname`, `lname`, `vemail`, `password`, `web_user`, `mob_user`, `user_role`, `estatus`) 
                      VALUES('{$user->id}', 0, '{$user->fname}', '{$user->lname}', '{$user->email}', '{$user->password}', 'Y', '{$is_mobile_user}', 'StoreAdmin', 'Active')";
            } else {

                $store_mw_user = $check_store_mw_users[0];
                
                $store_mw_users_query = "UPDATE inslocdb.store_mw_users ";
                $store_mw_users_query .= "SET `iuserid`='{$user->id}', `sid`=0, `fname`='{$user->fname}', `lname`='{$user->lname}', `vemail`='{$user->email}', ";
                
                // if($user->password == $return->)
                $store_mw_users_query .= "`password` = '{$user->password}', ";
                $store_mw_users_query .= "`web_user`='Y', `mob_user`='{$is_mobile_user}', `user_role`='StoreAdmin', `estatus`='Active' ";
                $store_mw_users_query .= "WHERE id='{$store_mw_user->id}'";
            }
            
            
            
            $run_query = \DB::connection('mysql')->statement($store_mw_users_query);
            
            
            $role = Request::get('roleName');
            if($role != 0){
                $user->attachRole($role);

            }
            if((Request::get('roleName')) == 2){
              $user->store()->attach(Request::get('storeName'));  
            }
            $store_mw_users_iuserid = \DB::connection('mysql')->select("SELECT * FROM inslocdb.store_mw_users WHERE iuserid = '".$user->id."' ");
          
         
          
            $user_iuserid = $store_mw_users_iuserid[0]->iuserid;
            $user_mob_user = $store_mw_users_iuserid[0]->mob_user;
            $user_user_role = $store_mw_users_iuserid[0]->user_role;
            
            foreach($store_array as $store){
                $table_exists = \DB::connection('mysql')->select("SELECT * FROM information_schema.tables WHERE table_schema = 'u".$store."'  AND table_name = 'mst_permission'");
                $check_mst_userpermission = \DB::connection('mysql')->select("SELECT * FROM information_schema.tables WHERE table_schema = 'u".$store."'  AND table_name = 'mst_userpermissions'");
                
                if(count($table_exists) > 0 && count($check_mst_userpermission) > 0){
                    if($user_user_role == 'StoreAdmin'){
                        $permissions = \DB::connection('mysql')->select("SELECT  distinct(vpermissioncode) FROM u".$store.".mst_permission where vpermissiontype = 'WEB' OR vpermissiontype = 'MOB' ");
                       
                        foreach ($permissions as $permission) {
                            $user_perms_insert = "INSERT INTO u".$store.".mst_userpermissions(userid, permission_id, status, created_id, updated_id) values( '".$user_iuserid."', '".$permission->vpermissioncode."', 'Active', '".$user_iuserid."', '".$user_iuserid."' )";
                            $insert = \DB::connection('mysql')->statement($user_perms_insert);
                        } 
                    }     
                }else {
                    if($user_user_role == 'StoreAdmin'){
                        $db = "u".$store;
                        $this->DatabaseAction($db, $store,  $user_iuserid);
                    } 
                }
                        
            }
            
            
            
            if (Request::isJson()){
               return config('app.RETURN_MSG.SUCCESS');
            }
            return redirect('admin/users')->withSuccess('User Created!');
        }
        else
        {
            // var_dump($validation); die;
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

        $roleUser = Role::whereIn('id', [2,7])->get();
        $role_array = array();
        foreach ($roleUser as $roleData) {
            $role_array[$roleData->id] = $roleData->name;
        }
        $stores = Store::all();
        $store_array = array();
        foreach ($stores as $storesData) {
           $store_array[$storesData->id] = $storesData->name." [{$storesData->id}]";
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
        $input = Request::all();
        
        $return = StoreMwUsers::where('vemail', $input['email'])->where('estatus', 'Active')->first();
        
        if(isset($return) && ($return->iuserid != $id)){
            $portal_error = array( array("That email has ALREADY been taken." ));
            return redirect('/admin/users/create')->withInput()
                      ->withErrors($portal_error);
        }

        $user = User::with('role','store')->findOrFail($id);

        $input['user_id'] = $id;

        $validation = User::updateValidate($input);

        if($validation->fails() === false)
        {
            $user->fill(User::userFillData());
            $user->save();
            
            $is_mobile_user = ($user->is_mobile_user == 'True')?'Y':'N';
            
            $check_store_mw_users = \DB::connection('mysql')->select("SELECT * FROM inslocdb.store_mw_users WHERE vemail = '{$input['email']}'");
            
            // echo "<pre>"; print_r($check_store_mw_users); echo "</pre>"; die;
            
            
            if(!isset($check_store_mw_users[0])){
                $store_mw_users_query = "INSERT INTO inslocdb.store_mw_users (`iuserid`, `sid`, `fname`, `lname`, `vemail`, `password`, `web_user`, `mob_user`, `user_role`, `estatus`) 
                      VALUES('{$user->id}', 0, '{$user->fname}', '{$user->lname}', '{$user->email}', '{$user->password}', 'Y', '{$is_mobile_user}', 'StoreAdmin', 'Active')";
            } else {

                $store_mw_user = $check_store_mw_users[0];
                
                $store_mw_users_query = "UPDATE inslocdb.store_mw_users ";
                $store_mw_users_query .= "SET `iuserid`='{$user->id}', `sid`=0, `fname`='{$user->fname}', `lname`='{$user->lname}', `vemail`='{$user->email}', ";

                if($user->password != $store_mw_user->password){
                    $store_mw_users_query .= "`password` = '{$user->password}', ";
                }
                
                $store_mw_users_query .= "`web_user`='Y', `mob_user`='{$is_mobile_user}', `user_role`='StoreAdmin', `estatus`='Active' ";
                $store_mw_users_query .= "WHERE id='{$store_mw_user->id}'";
            }
            
            
            
            $run_query = \DB::connection('mysql')->statement($store_mw_users_query);

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
                $user->detachRole($role);
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
        $user = User::find($id);
        $return = StoreMwUsers::where('vemail', $user->email)->where('estatus', 'Active')->first();
        
        if(isset($return)){
            
            if($return->iuserid != $id){
                $portal_error = array( array("That user cannot be deleted because it is linked to a user from another store." ));
                return redirect('/admin/users')->withInput()
                      ->withErrors($portal_error);
            } else {
               $return->estatus = 'Inactive';
               $return->save();
            }
        } else {
            $portal_error = array( array("That user is not found in the database."));
            return redirect('/admin/users')->withInput()
                      ->withErrors($portal_error);
        }
        
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
    
    
    
    /*******************For Store Admin Inserting Function********************/
    public function DatabaseAction($sid, $store_id, $user_id)
    {
        $sql ="CREATE TABLE IF NOT EXISTS ".$sid.".mst_permission (
                                      Id  int(11) NOT NULL AUTO_INCREMENT,  
                                      vpermissioncode varchar(20) NOT NULL,
                                      vpermissionname varchar(50) NOT NULL,
                                      vmenuname varchar(20) NOT NULL,
                                      vpermissiontype varchar(20) DEFAULT NULL ,
                                      vppercode varchar(20) NOT NULL,
                                      ivorder int(11) NOT NULL,
                                      vdesc varchar(100) NOT NULL,
                                      etransferstatus varchar(50) DEFAULT NULL,
                                      LastUpdate TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                                      SID int(11) NOT NULL  DEFAULT ".$store_id.",
                                      PRIMARY KEY (id)
                )";
        $sql_user_permissions= "CREATE TABLE IF NOT EXISTS ".$sid.".mst_userpermissions (
              Id int(11) NOT NULL AUTO_INCREMENT,
              userid int(11) NOT NULL,
              permission_id varchar(255) NOT NULL,
              status enum('Active','Inactive') NOT NULL DEFAULT 'Active',
              created_id int(11) NOT NULL,
              created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
              updated_id int(11) DEFAULT NULL,
              LastUpdate timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
              SID int(11) NOT NULL DEFAULT ".$store_id.",
              PRIMARY KEY (Id)
            )";
        $sql_excute = \DB::connection('mysql')->select($sql);
        $sql_user_permissions_excute = \DB::connection('mysql')->select($sql_user_permissions);
        
        $insert_data = "INSERT INTO ".$sid.".mst_permission
                            (vpermissioncode, vpermissionname, vmenuname, vpermissiontype, vppercode, ivorder, vdesc, etransferstatus, LastUpdate, SID)  
                        VALUES 
                            ('PER1001','DASHBOARD','DASHBOARD','WEB','',1,'Dashborad ','', CURRENT_TIMESTAMP, ".$store_id."),
                            ('PER1002','VENDOR','VENDORS','WEB','',2,'Vendors','', CURRENT_TIMESTAMP, ".$store_id."),
                            ('PER1003','CUSTOMER','CUSTOMER','WEB','',1,'Customer','', CURRENT_TIMESTAMP, ".$store_id."),
                            ('PER1004','USERS','USER','WEB','',1,'USER','', CURRENT_TIMESTAMP, ".$store_id."),
                            ('PER1005','STORE','STORE','WEB','',1,'STORE','', CURRENT_TIMESTAMP, ".$store_id."),
                            ('PER1006','ITEMS','ITEM','WEB','',1,'Item','', CURRENT_TIMESTAMP, ".$store_id."),
                            ('PER1007','INVENTORY','INVENTORY','WEB','',1,'Inventory','', CURRENT_TIMESTAMP, ".$store_id."),
                            ('PER1008','ADMINISTRATION','ADMINISTRATION','WEB','',1,'Administration','', CURRENT_TIMESTAMP, ".$store_id."),
                            ('PER1009','REPORTS','REPORTS','WEB','',1,'Reports','', CURRENT_TIMESTAMP, ".$store_id."),
                            ('PER1010','SETTINGS','SETTINGS','WEB','',1,'Settings','', CURRENT_TIMESTAMP, ".$store_id."),
                            ('PER1011','LOYALITY','LOYALITY','WEB','',1,'Loyality','', CURRENT_TIMESTAMP, ".$store_id."),
                            ('PER1012','GENERAL','GENERAL','WEB','',1,'General','', CURRENT_TIMESTAMP, ".$store_id.")
                            ('PER2001','QUICK REPORT','QUICK REPORT','MOB','',3,'Quick Report','library-books', CURRENT_TIMESTAMP, ".$store_id."),
                            ('PER2002','REPORTS','REPORTS','MOB','#52c6d8, #45c0d4, #3',1,'Reports','library-books', CURRENT_TIMESTAMP, ".$store_id."),
                            ('PER2003','ADD/EDIT ITEM','ADD/EDIT ITEM','MOB','#f4d60c, #edc425, #e',2,'Add/Edit Item', 'library-books', CURRENT_TIMESTAMP, ".$store_id."),
                            ('PER2004','CHANGE PRICE','CHANGE PRICE','MOB','#f4d60c, #edc425, #e',2,'Change Price','library-books', CURRENT_TIMESTAMP, ".$store_id."),
                            ('PER2005','UPDATE QUANTITY','UPDATE QUANTITY','MOB','#f4d60c, #edc425, #e',2,'Update Quantity','library-books', CURRENT_TIMESTAMP, ".$store_id."),
                            ('PER2006','NOTIFICATIONS','NOTIFICATIONS','MOB','#f4d60c, #edc425, #e',1,'Notifications','library-books', CURRENT_TIMESTAMP, ".$store_id."),
                            ('PER2007','RECEIVE ORDER','RECEIVE ORDER','MOB','#52c6d8, #45c0d4, #3',1,'Receive Order','library-books', CURRENT_TIMESTAMP, ".$store_id."),
                            ('PER2008','PRINT LABEL','PRINT LABEL','MOB','#f58120, #f4771f, #f',1,'Print Label','library-books', CURRENT_TIMESTAMP, ".$store_id.")
                            ('PER2009','PROMOTION','Promotion','MOB','',1,'Promotion','', CURRENT_TIMESTAMP, ".$store_id.")
                            ";
                            
        $insert_data_excute = \DB::connection('mysql')->statement($insert_data);
        
        $permissions = \DB::connection('mysql')->select("SELECT  distinct(vpermissioncode) FROM ".$sid.".mst_permission where vpermissiontype = 'WEB' OR vpermissiontype = 'MOB'  ");
       
        foreach ($permissions as $permission) {
            $user_perms_insert = "INSERT INTO ".$sid.".mst_userpermissions(userid, permission_id, status, created_id, updated_id) values('".$user_id."', '".$permission->vpermissioncode."', 'Active', '".$user_id."', '".$user_id."' )";
            $insert = \DB::connection('mysql')->statement($user_perms_insert);
                
        } 
    }
}
