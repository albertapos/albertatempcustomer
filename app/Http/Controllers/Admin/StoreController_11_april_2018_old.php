<?php

namespace pos2020\Http\Controllers\Admin;


use Request;
use pos2020\Http\Controllers\Controller;
use pos2020\RoleUser;
use pos2020\User;
use pos2020\Store;
use Illuminate\Support\Facades\Redirect;
use pos2020\Http\Requests;
//use pos2020\Http\Requests\createStoreRequest;
use Illuminate\Support\Facades\Input;
use html;
use Auth;
use Session;
use pos2020\storeComputer;
use pos2020\UserStores;
use pos2020\KIOSK_GLOBAL_PARAM;
use pos2020\KIOSK_PAGE_MASTER;
use pos2020\MST_PLCB_UNIT;
use pos2020\MST_PLCB_BUCKET_TAG;
use pos2020\Web_store_Settings;
use pos2020\MST_STORE;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      $titming = '';  
      $titming .= 'Time stamp loading store listing method: '.date("H:i:s");
      $titming .= '-----';
     
        $stores = Store::all();

        $titming .= 'Time stamp after fetch all stores query: '.date("H:i:s");
        $titming .= '-----';

        $title = 'All Stores';
        $store_array = array();
        foreach ($stores as $storesData) {
           $store_array[$storesData->id] = $storesData->name;
        }
        $titming .= 'Time stamp after generating all stores array for drop down (header): '.date("H:i:s");
        $titming .= '-----';

        $storesJson =  $stores->toJson();
        //$storeComputer = storeComputer::all();
      //  $numberOfComputer = storeComputer::where('store_id','=',$id)->count();
    
        if (Request::isJson()){
            return $stores->toJson();
        }else{

            $titming .= 'Time stamp before return on store listing page: '.date("H:i:s");
          
            $mytimefile=fopen(storage_path()."/logs/timelog.txt","a");
            $timetxt= $titming."\n";
            fwrite($mytimefile,$timetxt);
            fclose($mytimefile);

            return view('admin.vendor.index',compact('stores','store_array','numberOfComputer','storeComputer'));
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
        foreach ($roleUser as $role) {
         /* if($role->role_id == 3){
              $userName = User::where('id','=',$role->user_id)->orderBy('fname')->get();
              foreach ($userName as $name) {
                 $user_array[$name->id] = $name->fname ." " . $name->lname ."(Sales User)";
              }
          }
          else{*/
              $userName = User::where('id','=',$role->user_id)->orderBy('fname')->get();
              foreach ($userName as $name) {
                 $user_array[$name->id] = $name->fname ." " . $name->lname ."(".$name->email .")";
              //}
          }
           
        }
        $stores = Store::all();
        $store_array = array();
        foreach ($stores as $storesData) {
           $store_array[$storesData->id] = $storesData->name;
        }
        if (Request::isJson()){
           return config('app.RETURN_MSG.SUCCESS');
        }
        return view('admin.vendor.create',compact('user_array','store_array'));
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

        $count =  Request::get('no_of_computers', 0);
        for($i=1;$i<=$count;$i++){
            $hexacodes = storeComputer::where('hashcode',Request::get('hexa_'.$i))->get();
            
            if(count($hexacodes) > 0){
              if (Request::isJson()){
                return  $validation->errors()->all();
              }
                  return redirect('/admin/vendors/create')->withInput()
                        ->withErrors($validation);
              }
        }

        if($validation->fails() === false)
        {
            $store = new Store;
            $store->name = Request::get('name');
            $store->business_name = Request::get('business_name');
            $store->description = Request::get('description');
            $store->phone = Request::get('phone');
            $store->contact_name = Request::get('contact_name');
            $store->address = Request::get('address');
            $store->country = Request::get('country');
            $store->state = Request::get('state');
            $store->city = Request::get('city');
            $store->zip = Request::get('zip');   
            $store->db_name = Request::get('db_name'); 
            $store->db_username = Request::get('db_username'); 
            $store->db_password = Request::get('db_password'); 
            $store->db_hostname = Request::get('db_hostname');

            $store->store_view_permission = 1;  

            $store->pos = (Request::get('pos1') ? Request::get('pos1') : 'N');
            $store->kiosk = (Request::get('kiosk1') ? Request::get('kiosk1') : 'N');
            $store->mobile = (Request::get('mobile1') ? Request::get('mobile1') : 'N');
            $store->creditcard = (Request::get('card1') ? Request::get('card1') : 'N');
            $store->webstore = (Request::get('webstore1') ? Request::get('webstore1') : 'N');
            $store->portal = (Request::get('portal1') ? Request::get('portal1') : 'N');
            $store->plcb_product = (Request::get('plcb_product') ? Request::get('plcb_product') : 'N');
            $store->plcb_report = (Request::get('plcb_report') ? Request::get('plcb_report') : 'N');
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

            if(Request::get('userName')){
               $userId = UserStores::where('user_id','=',Request::get('userName'))->pluck('user_id');
               if(UserStores::whereIn('user_id',$userId)->exists()){
                  $user = User::where('id','=',$userId)->first();
                   foreach ($user->roles()->get() as $role)
                    {
                        if($role->name == 'Store Manager'){
                            return redirect('/admin/vendors/create')->withErrors(array('Assigned  ONE STORE ONLY !!!'));
                        }else{
                          $store->user()->attach(Request::get('userName'));
                        }
                    }
               }
              else
              {
                  $store->user()->attach(Request::get('userName'));
              }
            }
          
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

            //set default sid
            $store->setDefaultSID();

            //store value insert
            $mst_stores = MST_STORE::all();

            if(count($mst_stores) == 0){
              $phone = $store->phone;

              if(preg_match('/^(\d{3})(\d{3})(\d{4})$/',$phone,$matches)){
                $phone = $matches[1] . '-' .$matches[2] . '-' . $matches[3];
              }

              $mst_store = new MST_STORE();
              $mst_store->istoreid = 101;
              $mst_store->vcompanycode = 'COM'.$store->id;
              $mst_store->vstorename = $store->business_name;
              $mst_store->vstoredesc = $store->description;
              $mst_store->vstoreabbr = $store->business_name;
              $mst_store->vaddress1 = $store->address;
              $mst_store->vcity = $store->city;
              $mst_store->vstate = $store->state;
              $mst_store->vzip = $store->zip;
              $mst_store->vcountry = $store->country;
              $mst_store->vphone1 = $phone;
              $mst_store->vphone2 = '';
              $mst_store->vfax1 = '';
              $mst_store->vemail = '';
              $mst_store->vwebsite = '';
              $mst_store->vcontactperson = $store->contact_name;
              $mst_store->isequence = 0;
              $mst_store->dregdate = $store->created_at;
              $mst_store->vmessage1 = '';
              $mst_store->vmessage2 = '';
              $mst_store->estatus = 'Active';
              $mst_store->ionupload = '1';
              $mst_store->etransferstatus = '';
              $mst_store->SID = $store->id;

              $mst_store->save();
            }

            //store value insert
            
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

            $lexp_date = date('m-d-Y', strtotime(Request::get('lexpdate')));

            $web_store_settings = new Web_store_Settings();
            $web_store_settings->Id = 1;
            $web_store_settings->variablename = 'ExpiredDate';
            $web_store_settings->variablevalue = $lexp_date;
            $web_store_settings->SID = $store->id;
            $web_store_settings->save();

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
            $message .= "<b>Store Service Type PLCB Product:</b> ".$store->plcb_product."<br>";
            $message .= "<b>Store Service Type PLCB Report:</b> ".$store->plcb_report."<br>";
            $message .= "<b>Store Service Type License Expiry Date:</b> ".$store->license_expdate."<br>";
            
           
            $header = "From:sales@pos2020.com \r\n";
            $header .= "MIME-Version: 1.0\r\n";
            $header .= "Content-type: text/html\r\n";
           
            $retval = mail ($to,$subject,$message,$header);

            //email notification
            
            if (Request::isJson()){
                 return config('app.RETURN_MSG.SUCCESS');
             }
            return redirect('admin/vendors')->withSuccess('Store Created Successfully');
        }
        else
        {

            if (Request::isJson()){
               return  $validation->errors()->all();
            }
                return redirect('/admin/vendors/create')->withInput()
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
        $roleUser = RoleUser::with('user')->where('role_id','!=',3)->where('role_id','!=',1)
                                          ->get();
        $user_array = array();

        $stores = Store::all();
        $store_array = array();
        foreach ($stores as $storesData) {
           $store_array[$storesData->id] = $storesData->name;
        }

        $storeComputer = storeComputer::where('store_id','=',$id)->get();
       // dd($storeComputer);
        $numberOfComputer = storeComputer::where('store_id','=',$id)->count();
        foreach ($roleUser as $role) {
          
              $userName = User::where('id','=',$role->user_id)->orderBy('fname')->get();
              foreach ($userName as $name) {
                 $user_array[$name->id] = $name->fname ." " . $name->lname ."(".$name->email .")";
           
          }
        }
        if (Request::isJson()){
            return $store->toJson();
        }else{
             return view('admin.vendor.edit', compact('store','user_array','store_array','storeComputer','numberOfComputer'));
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
        $store = Store::findOrFail($id);
        $validation = Store::Validate(Request::all());
        $checked = Request::get('multistore') ;
        if($validation->fails() === false)
        {
            $store->name = Request::get('name');
            $store->business_name = Request::get('business_name');
            $store->description = Request::get('description');
            $store->phone = Request::get('phone');
            $store->contact_name = Request::get('contact_name');
            $store->address = Request::get('address');
            $store->country = Request::get('country');
            $store->state = Request::get('state');
            $store->city = Request::get('city');
            $store->zip = Request::get('zip');   
            $store->db_name = Request::get('db_name'); 
            $store->db_username = Request::get('db_username'); 
            $store->db_password = Request::get('db_password'); 
            $store->db_hostname = Request::get('db_hostname'); 

            $store->pos = (Request::get('pos1') ? Request::get('pos1') : 'N');
            $store->kiosk = (Request::get('kiosk1') ? Request::get('kiosk1') : 'N');
            $store->mobile = (Request::get('mobile1') ? Request::get('mobile1') : 'N');
            $store->creditcard = (Request::get('card1') ? Request::get('card1') : 'N');
            $store->webstore = (Request::get('webstore1') ? Request::get('webstore1') : 'N');
            $store->portal = (Request::get('portal1') ? Request::get('portal1') : 'N');
            $store->plcb_product = (Request::get('plcb_product') ? Request::get('plcb_product') : 'N');
            $store->plcb_report = (Request::get('plcb_report') ? Request::get('plcb_report') : 'N');
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
            
            if(Request::get('userName')){
              $store->user()->detach();
              $store->user()->attach(Request::get('userName'));
            }

            $store->setdb();

            $lexp_date = date('m-d-Y', strtotime(Request::get('lexpdate')));

            $web_store_settings = Web_store_Settings::where('variablename','ExpiredDate')->first();
            if(count($web_store_settings) > 0){
              $web_store_setting = Web_store_Settings::where('variablename','ExpiredDate')->update(['Id' => 1, 'variablevalue' => $lexp_date]);
            }else{
              $web_store_setting = new Web_store_Settings();
              $web_store_setting->Id = 1;
              $web_store_setting->variablename = 'ExpiredDate';
              $web_store_setting->variablevalue = $lexp_date;
              $web_store_setting->SID = $store->id;
              $web_store_setting->save();
            }

            //store value insert
            $mst_stores = MST_STORE::all();

            if(count($mst_stores) > 0){
              $mst_store = MST_STORE::where('istoreid',101)->first();

              $phone = $store->phone;

              if(preg_match('/^(\d{3})(\d{3})(\d{4})$/',$phone,$matches)){
                $phone = $matches[1] . '-' .$matches[2] . '-' . $matches[3];
              }

              if(count($mst_store) > 0){
                $mst_store->vstorename = $store->business_name;
                $mst_store->vstoredesc = $store->description;
                $mst_store->vstoreabbr = $store->business_name;
                $mst_store->vaddress1 = $store->address;
                $mst_store->vcity = $store->city;
                $mst_store->vstate = $store->state;
                $mst_store->vzip = $store->zip;
                $mst_store->vcountry = $store->country;
                $mst_store->vphone1 = $phone;
                $mst_store->vphone2 = '';
                $mst_store->vfax1 = '';
                $mst_store->vemail = '';
                $mst_store->vwebsite = '';
                $mst_store->vcontactperson = $store->contact_name;
                $mst_store->isequence = 0;
                $mst_store->dregdate = $store->created_at;
                $mst_store->vmessage1 = '';
                $mst_store->vmessage2 = '';
                $mst_store->estatus = 'Active';
                $mst_store->ionupload = '1';
                $mst_store->etransferstatus = '';
                $mst_store->save();
              }

            }else{
              $phone = $store->phone;

              if(preg_match('/^(\d{3})(\d{3})(\d{4})$/',$phone,$matches)){
                $phone = $matches[1] . '-' .$matches[2] . '-' . $matches[3];
              }

              $mst_store = new MST_STORE();
              $mst_store->istoreid = 101;
              $mst_store->vcompanycode = 'COM'.$store->id;
              $mst_store->vstorename = $store->business_name;
              $mst_store->vstoredesc = $store->description;
              $mst_store->vstoreabbr = $store->business_name;
              $mst_store->vaddress1 = $store->address;
              $mst_store->vcity = $store->city;
              $mst_store->vstate = $store->state;
              $mst_store->vzip = $store->zip;
              $mst_store->vcountry = $store->country;
              $mst_store->vphone1 = $phone;
              $mst_store->vphone2 = '';
              $mst_store->vfax1 = '';
              $mst_store->vemail = '';
              $mst_store->vwebsite = '';
              $mst_store->vcontactperson = $store->contact_name;
              $mst_store->isequence = 0;
              $mst_store->dregdate = $store->created_at;
              $mst_store->vmessage1 = '';
              $mst_store->vmessage2 = '';
              $mst_store->estatus = 'Active';
              $mst_store->ionupload = '1';
              $mst_store->etransferstatus = '';
              $mst_store->SID = $store->id;
              $mst_store->save();
            }

            //store value insert
            


            /*if(Request::get('userName')){
               $userId = UserStores::where('user_id','=',Request::get('userName'))->pluck('user_id');
               if(UserStores::whereIn('user_id',$userId)->exists()){
                  $user = User::where('id','=',$userId)->first();
                   foreach ($user->roles()->get() as $role)
                    {
                        if($role->name == 'Store Manager'){
                          return redirect('admin/vendors/'.$store->id.'/edit')->withErrors(array('Assigned  ONE STORE ONLY !!!'));
                           
                        }
                    }
               }
              else
              {
                  $store->user()->detach();
                  $store->user()->attach(Request::get('userName'));
              }
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

            $store_computer_server_ip = storeComputer::where('store_id',$id)->first();

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
                if(!is_null($store_computer_server_ip->server_ip)){
                  $store_computer->server_ip = $store_computer_server_ip->server_ip;
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

                if(!is_null($store_computer_server_ip->server_ip)){
                  $strComputer->server_ip = $store_computer_server_ip->server_ip;
                }
                
                $strComputer->save();
              }
            }
           
            if (Request::isJson()){
                 return config('app.RETURN_MSG.SUCCESS');
             }
            return redirect('admin/vendors')->withSuccess('Store Updated Successfully');
        }
        else
        {
            if (Request::isJson()){
                return  $validation->errors()->all();
            }
            return redirect('admin/vendors/'.$store->id.'/edit')
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
        $store->storeComputer()->delete();
        $store->delete();

        if (Request::isJson()){
            return config('app.RETURN_MSG.SUCCESS');
         }else{
            return redirect('admin/vendors')->withSuccess('Store Deleted!');
        }
        
       // return redirect()->route('admin.vendors.index')->withSuccess('Vendor deleted.');

    }  
    public function changeStore(Request $request,$id)
    {
        $stores = Store::where('id',$id)->get();
        foreach ($stores as $storeData) {
            $storeId = $storeData->id;
        }
        $data =  User::changeStore($storeId);

        if($data){
            Session::put('selected_store_id',$data->id);
            Session::put('s_db_name',$data->db_name);
            Session::put('s_db_username',$data->db_username);
            Session::put('s_db_password',$data->db_password);
            Session::put('s_db_host',$data->db_hostname); 
            Session::put('selected_store_title',$data->name); 

        }
        if (Request::isJson()){
            return $data->toJson();
        }else{
           return redirect('/admin')->withData($data);
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
        if($primaryStore){
          $primaryStoreName = $primaryStore->name;
          return view('admin.vendor.storeView',compact('user_role','store','store_array','numberOfComputer','storeComputer','primaryStoreName','primaryStore'));

        }
    
        return view('admin.vendor.storeView',compact('user_role','store','store_array','numberOfComputer','storeComputer','primaryStore'));
    }  
    public function postEdit(Request $request,$id){
        $store = Store::findOrFail($id);
        $validation = Store::Validate(Request::all());
        $checked = Request::get('multistore') ;
        if($validation->fails() === false)
        {
            $store->name = Request::get('name');
            $store->business_name = Request::get('business_name');
            $store->description = Request::get('description');
            $store->phone = Request::get('phone');
            $store->contact_name = Request::get('contact_name');
            $store->address = Request::get('address');
            $store->country = Request::get('country');
            $store->state = Request::get('state');
            $store->city = Request::get('city');
            $store->zip = Request::get('zip');   
            $store->db_name = Request::get('db_name'); 
            $store->db_username = Request::get('db_username'); 
            $store->db_password = Request::get('db_password'); 
            $store->db_hostname = Request::get('db_hostname'); 

            $store->pos = (Request::get('pos1') ? Request::get('pos1') : 'N');
            $store->kiosk = (Request::get('kiosk1') ? Request::get('kiosk1') : 'N');
            $store->mobile = (Request::get('mobile1') ? Request::get('mobile1') : 'N');
            $store->creditcard = (Request::get('card1') ? Request::get('card1') : 'N');
            $store->webstore = (Request::get('webstore1') ? Request::get('webstore1') : 'N');
            $store->portal = (Request::get('portal1') ? Request::get('portal1') : 'N');
            $store->license_expdate = Request::get('lexpdate');

            if($checked == 'Y')
            {
               $store->multistore = (Request::get('multistore') ? Request::get('multistore') : 'N');
               $store->primary_storeId = Request::get('storeName');
              
            }

            $store->save();

            if(Request::get('userName')){
              $store->user()->detach();
              $store->user()->attach(Request::get('userName'));
            }

            $storeComputer = storeComputer::where('store_id',$id)->get();
         

            foreach ($storeComputer as $computer) {

              $uidData = Request::get('uid_'.$computer->id);
              $registerData = Request::get('register_'.$computer->id);
              $kioskdata = Request::get('kiosk_'.$computer->id);
              $serverData = Request::get('server_'.$computer->id);
              $hexaData = Request::get('hexa_'.$computer->id);
              $status = Request::get('status_'.$computer->id);

              $computer->store_id = $id;
              $computer->uid = $uidData;
              $computer->register = $registerData;
              $computer->kiosk = $kioskdata;
              $computer->server = $serverData;
              $computer->hashcode = $hexaData;
              $computer->status = $status;
              $computer->save();
           
            }
          
            $message = 'Vendor is updated';
             if (Request::isJson()){
                 return config('app.RETURN_MSG.SUCCESS');
             }
            return redirect('admin/vendors')->withMessage($message);
        }
        else
        {
            if (Request::isJson()){
               return $validation->errors()->all();
            }
            return redirect('admin/vendors/'.$store->id.'/edit')
                        ->withErrors($validation);
        }
    }

    public function getStoreList()
    {
        if(!empty(Request::get('term'))){
            $StoreObj = Store::where('name','like','%'.Request::get('term') .'%')->get();
            return response()->json($StoreObj);
        }else{
            return 'Something Went Wrong!!!';
        }
    }
}
