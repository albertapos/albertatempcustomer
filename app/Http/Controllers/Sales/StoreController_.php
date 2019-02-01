<?php

namespace pos2020\Http\Controllers\Sales;

use Request;
use pos2020\Http\Controllers\Controller;
use pos2020\RoleUser;
use pos2020\User;
use pos2020\Store;
use Illuminate\Support\Facades\Redirect;
use pos2020\Http\Requests;
use pos2020\Http\Requests\createStoreRequest;
use html;
use Auth;
use pos2020\storeComputer;
use pos2020\UserStores;
use pos2020\agentOffice;
use Importer\MySQLImporter;
use pos2020\salesStores;
use Importer\xmlapi;
use Bican\Roles\Models\Role;
use Bican\Roles\Models\Permission;
use pos2020\KIOSK_GLOBAL_PARAM;
use pos2020\KIOSK_PAGE_MASTER;
use pos2020\MST_PLCB_UNIT;
use pos2020\MST_PLCB_BUCKET_TAG;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

       
        $title = 'All Stores';
        $stores = Store::salesStore()->get();
        $store_array = array();
        foreach ($stores as $storesData) {
           $store_array[$storesData->id] = $storesData->name;
        }
        if (Request::isJson()){
            return $stores->toJson();
        }else{

          foreach (Auth::user()->roles()->get() as $role)
            {
              if($role->name == 'Store Manager'){
                  return view('sales.vendor.index',compact('stores','store_array'));
              }
            }
            return view('sales.vendor.index',compact('stores','store_array'));
        }  
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roleUser = RoleUser::with('user')->where('role_id','!=',3)->where('role_id','!=',1)
                                          ->get();
        $user_array = array();
        $user_email = array();
        foreach ($roleUser as $role) {
           $userName = User::where('id','=',$role->user_id)->orderBy('fname')->get();
              foreach ($userName as $name) {
                 $user_array[$name->id] = $name->fname ." " . $name->fname ."(".$name->email .")";
              }
         
        }
         //$stores = Store::with('user')->get();
        $stores = Store::salesStore()->get();
        $store_array = array();
        foreach ($stores as $storesData) {
           $store_array[$storesData->id] = $storesData->name;
        }

        if (Request::isJson()){
           return config('app.RETURN_MSG.SUCCESS');
        }
        return view('sales.vendor.create',compact('user_array','store_array'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validation = Store::Validate(Request::all());
        $checked = Request::get('multistore') ;

        if($validation->fails() === false)
        {  
            $store = new Store;
            $store->name = Request::get('name');
            $store->business_name = Request::get('business_name');
            $store->description =  Request::get('description');
            $store->phone =  Request::get('phone');
            $store->contact_name =  Request::get('contact_name');
            $store->address =  Request::get('address');
            $store->country =  Request::get('country');
            $store->state =  Request::get('state');
            $store->city =  Request::get('city');
            $store->zip =  Request::get('zip');

            $store->pos = (Request::get('pos1') ? Request::get('pos1') : 'N');
            $store->kiosk = (Request::get('kiosk1') ? Request::get('kiosk1') : 'N');
            $store->mobile = (Request::get('mobile1') ? Request::get('mobile1') : 'N');
            $store->creditcard = (Request::get('card1') ? Request::get('card1') : 'N');
            $store->webstore = (Request::get('webstore1') ? Request::get('webstore1') : 'N');
            $store->portal = (Request::get('portal1') ? Request::get('portal1') : 'N');
            //$store->plcb_product = (Request::get('plcb_product') ? Request::get('plcb_product') : 'N');
            //$store->plcb_report = (Request::get('plcb_report') ? Request::get('plcb_report') : 'N');
            $store->license_expdate = Request::get('lexpdate');

            if($checked == 'Y')
            {
               $store->multistore = (Request::get('multistore') ? Request::get('multistore') : 'N');
               $store->primary_storeId = Request::get('storeName');
            }
            else
            {
               $store->multistore = null;
               $store->primary_storeId = null;
            }


            $store->save();

            foreach (Auth::user()->roles()->get() as $role)
            {
              if($role->name == 'Store Manager'){
                $userId = salesStores::where('user_id','=',Auth::user()->id)->pluck('user_id');
                if(salesStores::whereIn('user_id',$userId)->exists()){
                     return redirect('/sales/vendors/create')->withErrors(array('Assigned  ONE STORE ONLY !!!'));
                }
                else{
                  $store->salesUsers()->detach();
                  $store->salesUsers()->attach(Auth::user()->id);
                }
                
              }
            }


            $store->salesUsers()->detach();
            $store->salesUsers()->attach(Auth::user()->id);

            $count =  Request::get('no_of_computers', 0);
            for($i=1;$i<=$count;$i++){
                $uidData = Request::get('uid_'.$i);
                $registerData = Request::get('register_'.$i);
                $kioskdata = Request::get('kiosk_'.$i);
                $serverData = Request::get('server_'.$i);
                $hexaData = Request::get('hexa_'.$i);
                $status = Request::get('status_'.$i);
                $storeComputer = new storeComputer;
                $storeComputer->store_id = $store->id;
                $storeComputer->uid = $uidData;
                $storeComputer->register = $registerData;
                $storeComputer->kiosk = $kioskdata;
                $storeComputer->server = $serverData;
                $storeComputer->hashcode = $hexaData;
                $storeComputer->status = 'N';
                $storeComputer->save();
            }

            if(empty($store->primary_storeId)){
              $store->createStoreDB();
            } else {
              $store->createStoreDB(true);
            }

            $store->setdb();
            
            $kiosk_globs = KIOSK_GLOBAL_PARAM::all();
            
            foreach ($kiosk_globs as $kiosk_glob) {
              $kis_glob_param = KIOSK_GLOBAL_PARAM::where('UId',$kiosk_glob->UId)->first();
              $kis_glob_param->SID = $store->id;
              $kis_glob_param->save();
            }

            $kiosk_page_masters = KIOSK_PAGE_MASTER::all();
            
            foreach ($kiosk_page_masters as $kiosk_page_master) {
              $kis_glob_master = KIOSK_PAGE_MASTER::where('PageId',$kiosk_page_master->PageId)->first();
              $kis_glob_master->SID = $store->id;
              $kis_glob_master->save();
            }

			$mst_plcb_units = MST_PLCB_UNIT::all();
            foreach ($mst_plcb_units as $mst_plcb_unit) {
              $mst_plcb_unit_update = MST_PLCB_UNIT::where('id',$mst_plcb_unit->id)->first();
              $mst_plcb_unit_update->SID = $store->id;
              $mst_plcb_unit_update->save();
            }

            $mst_plcb_bucket_tags = MST_PLCB_BUCKET_TAG::all();
            foreach ($mst_plcb_bucket_tags as $mst_plcb_bucket_tag) {
              $mst_plcb_bucket_tag_update = MST_PLCB_BUCKET_TAG::where('id',$mst_plcb_bucket_tag->id)->first();
              $mst_plcb_bucket_tag_update->SID = $store->id;
              $mst_plcb_bucket_tag_update->save();
            }
			
			
            //email notification

            $registers = storeComputer::where('register', 'Y')->where('store_id',$store->id)->count();
            $kiosks = storeComputer::where('kiosk', 'Y')->where('store_id',$store->id)->count();
            $servers = storeComputer::where('server', 'Y')->where('store_id',$store->id)->count();

            
            $to = "sales@pos2020.com";
            $subject = "New Store ".$store->name." Created";
           
            $message = "<br>";
            $message = "<b>Store Details</b>";
            $message = "<br>";
            $message .= "<b>Store Name:</b> ".$store->name."<br>";
            $message .= "<b>Store Phone:</b> ".$store->phone."<br>";
            $message .= "<b>Store Address:</b> ".$store->address.", ".$store->city.", ".$store->state." - ".$store->zip."<br>";
            $message .= "<b>Store Id:</b> ".$store->id."<br>";
            $message .= "<b>Store Database Name:</b> ".$store->db_name."<br>";
            $message .= "<b>Store Database User:</b> ".$store->db_username."<br>";
            $message .= "<b>Store Created By:</b> ".Auth::user()->fname." ".Auth::user()->lname."<br>";
            $message .= "<b>Store no of computers:</b> ".$count."<br>";
            $message .= "<b>Store no of registers:</b> ".$registers."<br>";
            $message .= "<b>Store no of kiosks:</b> ".$kiosks."<br>";
            $message .= "<b>Store no of servers:</b> ".$servers."<br>";
            $message .= "<b>Store Service Type POS:</b> ".$store->pos."<br>";
            $message .= "<b>Store Service Type Kiosk:</b> ".$store->kiosk."<br>";
            $message .= "<b>Store Service Type Mobile App:</b> ".$store->mobile."<br>";
            $message .= "<b>Store Service Type Credit Card:</b> ".$store->creditcard."<br>";
            $message .= "<b>Store Service Type Web Store:</b> ".$store->webstore."<br>";
            $message .= "<b>Store Service Type Portal:</b> ".$store->portal."<br>";
            //$message .= "<b>Store Service Type PLCB Product:</b> ".$store->plcb_product."<br>";
            //$message .= "<b>Store Service Type PLCB Report:</b> ".$store->plcb_report."<br>";
            $message .= "<b>Store Service Type License Expiry Date:</b> ".$store->license_expdate."<br>";
            
           
            $header = "From:sales@pos2020.com \r\n";
            $header .= "MIME-Version: 1.0\r\n";
            $header .= "Content-type: text/html\r\n";
           
            $retval = mail ($to,$subject,$message,$header);

            //email notification

            if (Request::isJson()){
                 return config('app.RETURN_MSG.SUCCESS');
            }
            return redirect('sales/vendors')->withSuccess('Store Created Successfully');
        }
        else{
              if (Request::isJson()){
                return  $validation->errors()->all();
              }
              return redirect('/sales/vendors/create')->withInput()
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
        $store = Store::with('user')->findOrFail($id);
        $users = $store->user()->get();

        $roleUser = RoleUser::with('user')->where('role_id','!=',3)->where('role_id','!=',1)
                                          ->get();
                  
        $user_array = array();

        foreach ($roleUser as $role) {
              $userName = User::where('id','=',$role->user_id)->orderBy('fname')->get();
              foreach ($userName as $name) {
                 $user_array[$name->id] = $name->fname ." " . $name->fname ."(".$name->email .")";
              }
        }
  
       //$stores = Auth::User()->store()->get();
        $stores = Store::all();
        $store_array = array();
        foreach ($stores as $storesData) {
           $store_array[$storesData->id] = $storesData->name;
        }

        $storeComputer = storeComputer::where('store_id','=',$id)->get();
        $numberOfComputer = storeComputer::where('store_id','=',$id)->count();

        $status = array();
        foreach ($storeComputer as $dataStatus) {
          $status[] = $dataStatus->status;
         }

         if (in_array("Y",$status)){
            $count = 0 ;
         }else
         {
          $count = 1;
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
        $role_array = array('0' => 'Select Role');
        foreach ($roleUser as $roleData) {
            $role_array[$roleData->id] = $roleData->name;
        }

        foreach ($roleUser as $roleData) {
            $role_array[$roleData->id] = $roleData->name;
        }
        $agentOffices = agentOffice::all();
        $agent_arry = array();
        $agent_arry = array('0' => 'Select Agent Office');

        foreach ($agentOffices as $office) {
            $agent_arry[$office->id]= $office->title;
        }

       // $stores = Store::all();

         $stores = Store::salesStore()->get();
        $store_array = array();
        foreach ($stores as $storesData) {
           $store_array[$storesData->id] = $storesData->name;
        }

        $store_array = array();
        foreach ($stores as $storesData) {
           $store_array[$storesData->id] = $storesData->name;
        }

  
        if (Request::isJson()){
            return $store->toJson();
        }else{
            return view('sales.vendor.edit', compact('store','users','user_array','role_array','agent_arry','store_array','storeComputer','numberOfComputer','count'));
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
        $store = Store::with('user')->findOrFail($id);
        $validation = Store::Validate(Request::all());
        $checked = Request::get('multistore') ;

        if($validation->fails() === false)
        {
            $store->name = Request::get('name');
            $store->business_name = Request::get('business_name');
            $store->description =  Request::get('description');
            $store->phone =  Request::get('phone');
            $store->contact_name =  Request::get('contact_name');
            $store->address =  Request::get('address');
            $store->country =  Request::get('country');
            $store->state =  Request::get('state');
            $store->city =  Request::get('city');
            $store->zip =  Request::get('zip');  

            $store->pos = (Request::get('pos1') ? Request::get('pos1') : 'N');
            $store->kiosk = (Request::get('kiosk1') ? Request::get('kiosk1') : 'N');
            $store->mobile = (Request::get('mobile1') ? Request::get('mobile1') : 'N');
            $store->creditcard = (Request::get('card1') ? Request::get('card1') : 'N');
            $store->webstore = (Request::get('webstore1') ? Request::get('webstore1') : 'N');
            $store->portal = (Request::get('portal1') ? Request::get('portal1') : 'N');
            //$store->plcb_product = (Request::get('plcb_product') ? Request::get('plcb_product') : 'N');
            //$store->plcb_report = (Request::get('plcb_report') ? Request::get('plcb_report') : 'N');
            $store->license_expdate = Request::get('lexpdate');

            if($checked == 'Y')
            {
               $store->multistore = (Request::get('multistore') ? Request::get('multistore') : 'N');
               $store->primary_storeId = Request::get('storeName');
              
            }
            else
            {
               $store->multistore = null;
               $store->primary_storeId = null;
            }
            $store->save();

            /*if(Request::get('userName')){
             $store->salesUsers()->detach();
              $store->salesUsers()->attach(Request::get('userName'));
            }*/

            $storeComputer = storeComputer::where('store_id','=',$id)->get();
            
            $num_comp_arr = array();
            foreach ($storeComputer as $k => $comp) {
              if(!empty(Request::get('uid_'.$comp->id))){
                  $num_comp_arr[$comp->id]['uid'] = Request::get('uid_'.$comp->id);
              }
              if(!empty(Request::get('register_'.$comp->id))){
                  $num_comp_arr[$comp->id]['register'] = Request::get('register_'.$comp->id);
              }else{
                  $num_comp_arr[$comp->id]['register'] = null;
              }
              if(!empty(Request::get('kiosk_'.$comp->id))){
                  $num_comp_arr[$comp->id]['kiosk'] = Request::get('kiosk_'.$comp->id);
              }else{
                  $num_comp_arr[$comp->id]['kiosk'] = null;
              }
              if(!empty(Request::get('server_'.$comp->id))){
                  $num_comp_arr[$comp->id]['server'] = Request::get('server_'.$comp->id);
              }else{
                  $num_comp_arr[$comp->id]['server'] = null;
              }
              if(!empty(Request::get('hexa_'.$comp->id))){
                  $num_comp_arr[$comp->id]['hexa'] = Request::get('hexa_'.$comp->id);
              }else{
                  $num_comp_arr[$comp->id]['hexa'] = null;
              }
              if(!empty(Request::get('status_'.$comp->id))){
                  $num_comp_arr[$comp->id]['status'] = Request::get('status_'.$comp->id);
              }else{
                  $num_comp_arr[$comp->id]['status'] = null;
              }
            }

            foreach ($num_comp_arr as $key => $comp_data) {
              $store_computer = storeComputer::where('store_id',$id)->where('id',$key)->first();
              if($store_computer){
                $store_computer->store_id = $id;
                $store_computer->uid = $comp_data['uid'];
                $store_computer->register = $comp_data['register'];
                $store_computer->kiosk = $comp_data['kiosk'];
                $store_computer->server = $comp_data['server'];
                $store_computer->hashcode = $comp_data['hexa'];
                if(!is_null($comp_data['status']))
                {
                    $store_computer->status = $comp_data['status'];
                }else{
                    $store_computer->status = 'N';
                }
                $store_computer->save();
              }
            }

            $new_comp_arr = array();

            if(!empty(Request::get('uid_new')) && is_array(Request::get('uid_new'))){
              for($m=0; $m<count(Request::get('uid_new')); $m++){
                    $temp = [];
                    $temp['uid'] =  Request::get('uid_new')[$m];
                    $temp['register'] =  Request::get('register_new')[$m];
                    $temp['kiosk'] =  Request::get('kiosk_new')[$m];
                    $temp['server'] =  Request::get('server_new')[$m];
                    $temp['hexa'] =  Request::get('hexa_new')[$m];
                    $temp['status'] =  Request::get('status_new')[$m];
                    
                    array_push($new_comp_arr, $temp);
                }
            }

            if(count($new_comp_arr) > 0){
              foreach ($new_comp_arr as $new_comp) {
                $strComputer = new storeComputer;
                $strComputer->store_id = $id;
                $strComputer->uid = $new_comp['uid'];

                if($new_comp['register'] == 'N'){
                  $strComputer->register = null;
                }else{
                  $strComputer->register = 'Y';
                }

                if($new_comp['kiosk'] == 'N'){
                  $strComputer->kiosk = null;
                }else{
                  $strComputer->kiosk = "Y";
                }

                if($new_comp['server'] == 'N'){
                  $strComputer->server = null;
                }else{
                  $strComputer->server = "Y";
                }
                
                $strComputer->hashcode = $new_comp['hexa'];
                $strComputer->status = 'N';
                $strComputer->save();
              }
            }
            
            return redirect('sales/vendors')->withSuccess('Store Updated Successfully');
        }else{
            if (Request::isJson()){
                if($validation->fails() === false)
                {
                   return config('app.RETURN_MSG.SUCCESS');
                }
                else{
                  return redirect('sales/vendors/'.$store->id.'/edit')
                        ->withErrors($validation);
                }
            }
            return redirect('sales/vendors/'.$store->id.'/edit')
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
        $store =  Store::with('userStores','storeComputer')->findOrFail($id);
        $store->userStores()->delete();
        $store->delete();
     
        if (Request::isJson()){
            return config('app.RETURN_MSG.SUCCESS');
        }else{
            return redirect('sales/vendors')->withSuccess('Store Deleted!');
        }
    
    }
    public function getFrom()
    {
        return view('sales.computer');
    }
    public function postEdit(Request $request,$id){
        $store = Store::with('user')->findOrFail($id);
        $validation = Store::Validate(Request::all());
        if($validation->fails() === false)
        {
            $store->name = Request::get('name');
            $store->business_name = Request::get('business_name');
            $store->description =  Request::get('description');
            $store->phone =  Request::get('phone');
            $store->contact_name =  Request::get('contact_name');
            $store->address =  Request::get('address');
            $store->country =  Request::get('country');
            $store->state =  Request::get('state');
            $store->city =  Request::get('city');
            $store->zip =  Request::get('zip');   
            $store->save();
            if (Request::isJson()){
                return config('app.RETURN_MSG.SUCCESS');
            }
            return redirect('sales/vendors')->withSuccess('Store Updated Successfully');
        }else{
              if (Request::isJson()){
                return  $validation->errors()->all();
              }

            return redirect('sales/vendors/'.$store->id.'/edit')
                        ->withErrors($validation);
        }
    }
    public function getStoreView(Request $request , $id){
        foreach (Auth::user()->roles()->get() as $c_user) {
          $user_role = $c_user->name;
        }
        $store = Store::findOrFail($id);
        $stores = Store::all();
        $store_array = array();
        foreach ($stores as $storesData) {
           $store_array[$storesData->id] = $storesData->name;
        }
        $storeComputer = storeComputer::where('store_id','=',$id)->get();
        $numberOfComputer = storeComputer::where('store_id','=',$id)->count();
        $primaryStore = Store::Where('id','=',$store->primary_storeId)->first(); 
       // dd($primaryStore);
        if($primaryStore){
          $primaryStoreName = $primaryStore->name;
          return view('admin.vendor.storeView',compact('user_role','store','store_array','numberOfComputer','storeComputer','primaryStoreName','primaryStore'));

        }

        return view('sales.vendor.storeView',compact('user_role','store','store_array','storeComputer','numberOfComputer','primaryStore'));
    }

    public function postUser(Request $request,$id){
            $store = Store::findOrFail($id);


            $exist_user = User::where('email',Request::get('email'))->first();
            if(!is_null($exist_user)) {

               if(Request::get('exist_user') == 'yes') {
                $store->user()->attach($exist_user->id);
                return 'success';
              }

                $result = 'exits';
                return $result;
            }

            $validation = User::Validate(Request::all());
            if($validation->fails() === false)
            {
              $user = User::create(User::userFillData());
             // $role = Role::where('slug', 'vendor')->first();
             // $user->attachRole($role);
              foreach (Auth::user()->roles()->get() as $role)
               {
                if($role->name == 'Sales Admin'){
                   $roleName = Request::get('role');
                 //  dd($roleName);
                }
                if($role->name == 'Sales Manager'){
                     $roleName = Request::get('role');
                }  
                if($role->name == 'Sales Agent'){
                   $roleName = Request::get('role');
                }  
                if($role->name == 'Sales Executive'){
                   $roleName = Role::where('slug', 'salesexecutive')->first();
                }
            }
              $user->attachRole($roleName);
              $store->user()->attach($user->id);
              return 'success';

            }
            else
            {
                $result = '<ul>';
                foreach($validation->errors()->all() as $error) {
                    $result .= '<li>'. $error .'</li>';
                }
                $result .= '</ul>';
                return $result;
            }
    }

    public function getUserByStore(Request $request,$id){
            $store = Store::findOrFail($id);

            if(Auth::User()->agent_office_id){
              $users = $store->user()->where('agent_office_id',Auth::User()->agent_office_id)->get();
            }
            else
            {
              $users = $store->user()->get();

            }

            return view('sales.vendor.store_vendor',compact('users'));
    }
}
