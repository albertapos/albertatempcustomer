<?php

namespace pos2020\Http\Controllers\Admin;

// use Illuminate\Http\Request;
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
use pos2020\kioskMenuHeader;
use pos2020\MST_STORESETTING;
use DB;
use pos2020\MST_ITEM;
use DateTime;

use Validator;


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

            // return view('admin.vendor.index',compact('stores','store_array','numberOfComputer','storeComputer'));
            return view('admin.vendor.index',compact('stores','store_array'));
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
        //
        
        //return Request::all();
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
               $userId = UserStores::where('user_id','=',Request::get('userName'))->distinct('user_id')->pluck('user_id');
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
            
            //Create an entry in kioskMenuHeader
            /*$kiosk_menu_header = new kioskMenuHeader();
            $kiosk_menu_header->MenuId = 100;
            $kiosk_menu_header->Title = "Menu";
            $kiosk_menu_header->StartTime = "00:00:00";
            $kiosk_menu_header->ImageLoc = "";
            $kiosk_menu_header->Status = "Active";
            $kiosk_menu_header->SID = $store->id;
            $kiosk_menu_header->LastUpdate = ;
            $kiosk_menu_header->EndTime = ;
            $kiosk_menu_header->RowSize = 4;
            $kiosk_menu_header->ColumnSize = 4;
            $kiosk_menu_header->Sequence = 0;
            $kiosk_menu_header->save();*/
            
            //======insert 2 default row in mst_storesetting table=====
            $mst_storesetting = new MST_STORESETTING();
            // $mst_storesetting->Id = 1;
            $mst_storesetting->istoreid = 101;
            $mst_storesetting->vsettingname = 'EndOfDay';
            $mst_storesetting->vsettingvalue = 'Yes';
            $mst_storesetting->estatus = 'Active';
            $mst_storesetting->SID = $store->id;
            $mst_storesetting->save();
            
            $mst_storesetting = new MST_STORESETTING();
            $mst_storesetting->istoreid = 101;
            $mst_storesetting->vsettingname = 'EndOfDayTime';
            $mst_storesetting->vsettingvalue = '11:59';
            $mst_storesetting->estatus = 'Active';
            $mst_storesetting->SID = $store->id;
            $mst_storesetting->save();
            
            //====setting crone jobe=========
            $EndOfDayTime = MST_STORESETTING::where('vsettingname', '=', 'EndOfDayTime')->first();
            
            //=====Convert into UTC time(simce crone job runs according to UTC Timezone(5 hours ahead of us time))============
                $newdate = new DateTime($EndOfDayTime->vsettingvalue);
                $newdate->modify('+5 hours');
                $EndOfDayTimeUTC = $newdate->format("H:i"); 
                // echo $EndOfDayTimeUTC; die;
                
                $hour = DateTime::createFromFormat('H:i', $EndOfDayTimeUTC);
                $hour = $hour->format('H');
                
                $minute = DateTime::createFromFormat('H:i', $EndOfDayTimeUTC);
                $minute = $minute->format('i');
                
                $cronfiles=exec('crontab -l',$output); //========check carefully====don't remove this
                
                //=====store all previous crone job in file==
                $sid = (int)($store->id);
                
                // $cronejob = "* * * * * wget -q -O /dev/null https://devportal.albertapayments.com/endofday/index?sid=".$sid." > /dev/null 2>&1";
                // $cronejob = $minute." ".$hour." * * * wget -q -O /dev/null https://devportal.albertapayments.com/endofday/index?sid=".$sid." > /dev/null 2>&1";
                $cronejob = $minute." ".$hour." * * * wget -q -O /dev/null https://portal.albertapayments.com/endofday/index?sid=".$sid." > /dev/null 2>&1";
               
                
			    exec('echo -e "`crontab -l`\n'.$cronejob.'" | crontab -');
			    
			//============end cronejob settimg =================

            //email notification

            $registers = storeComputer::where('register', 'Y')->where('store_id',$store->id)->count();
            $kiosks = storeComputer::where('kiosk', 'Y')->where('store_id',$store->id)->count();
            $servers = storeComputer::where('server', 'Y')->where('store_id',$store->id)->count();

            
            $to = "adarsh.s.chacko@gmail.com";
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
            
            // dd($web_store_settings); die;
            // if(count($web_store_settings) > 0){
            if($web_store_settings !== null){
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

            //   if(count($mst_store) > 0){
            if($mst_store !== null){
                $mst_store = MST_STORE::where('istoreid',101)
                ->update(['vstorename' => $store->business_name, 'vstoredesc' => $store->description, 'vstoreabbr' => $store->business_name, 'vaddress1' => $store->address,'vcity' => $store->city, 'vstate' => $store->state, 'vzip' => $store->zip, 'vcountry' => $store->country, 'vphone1' => $phone, 'vphone2' => '', 'vfax1' => '', 'vemail' => '', 'vwebsite' => '', 'vcontactperson' => $store->contact_name, 'isequence' => 0, 'dregdate' => $store->created_at, 'vmessage1' => '', 'vmessage2' => '', 'estatus' => 'Active', 'ionupload' => '1', 'etransferstatus' => '' ]);
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
    
    public function get_current_25_transactions($store_id){
        
        $db = "u".$store_id;
        
        $query_db = 'USE DATABASE '.$db;
        DB::raw($query_db);
        
        $query_select = "SELECT dtrandate, nnettotal,isalesid  FROM " . $db . ".trn_sales WHERE vtrntype = 'Transaction' ORDER BY dtrandate DESC LIMIT 25";
        
        $matching_records = DB::select($query_select);
        
        $SNo=1; $table_data = $chart_data = [];
        foreach($matching_records as $k => $v){
            
            $table_data[] = ["SNO"=>$SNo++,"Date"=>$v->dtrandate,"SaleAmount"=> $v->nnettotal,"SalesId"=>(int)$v->isalesid ];
            $chart_data[] = ["x"=>$v->dtrandate, "y"=>(float)$v->nnettotal];
        }
        
        $table_title = ['Date', 'Sales Amount ($)','SalesId'];
        
        $response = ["table_title" => $table_title, "table_data" => $table_data, "chart_data" => $chart_data];
        
        return response()->json($response);
    }
    

    public function get_last_7days_transactions(Request $request){
       
        
        $validator = Validator::make(Request::all(), [
            'store_id' => 'required',
            'date' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
             return response()->json($errors);
        }else {
                $input = Request::all();
                // dd($input);
                $db = "u".$input['store_id'];
                
                $query_db = 'USE DATABASE '.$db;
                // $input_date = $input['date'];
                
                DB::raw($query_db);
                $input_date = DateTime::createFromFormat('m-d-Y', $input['date']);
        
                $end_date = $input_date->format('Y-m-d');

                //Set a specific date.
                $dateTime = new DateTime($end_date);
                $dateTime->modify('-7 day');
                $start_date = $dateTime->format("Y-m-d");
                // dd($start_date." - ". $end_date);
        
        
        // $query_select = "select t1.*, ifnull(No_of_Deletes,0) No_of_Deletes from (select date(dtrandate) saledt, sum(case when vtrntype='Transaction' then nnettotal else 0 end) Sales_Amount, sum(case when vtrntype='Void' then 1 else 0 end) No_of_Voids from ".$db.".trn_sales group by date(dtrandate) order by date(dtrandate) desc limit 7) t1 left join (SELECT date(LastUpdate) dt,count(*) No_of_Deletes FROM ".$db.".mst_deleteditem group by date(LastUpdate) order by date(LastUpdate) desc limit 7)t2 on t1.saledt=t2.dt";
        
        $query_select = "select t1.*, ifnull(No_of_Deletes,0) No_of_Deletes from 
                        (select date_format(e.dstartdatetime,'%m-%d-%Y') saledt, sum(case when vtrntype='Transaction' then nnettotal else 0 end) Sales_Amount, 
                        sum(case when vtrntype='Void' then 1 else 0 end) No_of_Voids 
                        from ".$db.".trn_sales s 
                        join ".$db.".trn_endofdaydetail d on s.ibatchid=d.batchid
                        JOIN ".$db.".trn_endofday e ON e.id=d.eodid
                        where date(e.dstartdatetime) between  '".$start_date."'  and '".$end_date."'
                        group by date_format(e.dstartdatetime,'%m-%d-%Y') 
                        ) t1 
                         join 
                        (SELECT date_format(e.dstartdatetime,'%m-%d-%Y') saledt, count(*) No_of_Deletes FROM ".$db.".mst_deleteditem l 
                         join ".$db.".trn_endofdaydetail d on l.batchid=d.batchid
                        JOIN ".$db.".trn_endofday e ON e.id=d.eodid
                        where date(e.dstartdatetime) between '".$start_date."' and '".$end_date."'
                        group by date_format(e.dstartdatetime,'%m-%d-%Y'))t2 
                            on t1.saledt=t2.saledt";
        
        $matching_records = DB::select($query_select);
        
        $table_data = $chart_data = [];
        foreach($matching_records as $k => $v){
            
            $table_data[] = [$v->saledt, $v->Sales_Amount, $v->No_of_Voids, $v->No_of_Deletes];
            $chart_data[] = ["x"=>$v->saledt, "y"=>(float)$v->Sales_Amount];
        }

        $table_title = ['Date ', 'Sales ($)', 'Void', 'Delete'];
        
        $response = ["table_title" => $table_title, "table_data" => $table_data, "chart_data" => $chart_data];
        
        return response()->json($response);
        }
    
        
    }
    
    public function get_last_4weeks_transactions($store_id){
        
        $db = "u".$store_id;
        // $query_select = "select case when t1.weekno=weekofyear(current_date()) then 'Current Week' when t1.weekno=weekofyear(current_date())-1 then 'Week 2' when t1.weekno=weekofyear(current_date())-2 then 'Week 3' when t1.weekno=weekofyear(current_date())-3 then 'Week 4' else t1.weekno end Week_name, t1.*, ifnull(No_of_Deletes,0) No_of_Deletes from (select weekofyear(dtrandate) weekno, date(DATE_ADD(dtrandate, INTERVAL(0-weekday(dtrandate)) DAY)) start_date, date(DATE_ADD(dtrandate, INTERVAL(6-weekday(dtrandate)) DAY)) end_date, sum(case when vtrntype='Transaction' then nnettotal else 0 end) Sales_Amount, sum(case when vtrntype='Void' then 1 else 0 end) No_of_Voids from ".$db.".trn_sales where date(dtrandate)>date(date_add(current_date(), INTERVAL -5 WEEK)) group by weekofyear(dtrandate),date(DATE_ADD(dtrandate, INTERVAL(0-weekday(dtrandate)) DAY)), date(DATE_ADD(dtrandate, INTERVAL(6-weekday(dtrandate)) DAY)) order by  weekofyear(dtrandate) desc limit 4) t1 left join (SELECT weekofyear(LastUpdate) wn,count(*) No_of_Deletes FROM ".$db.".mst_deleteditem where date(LastUpdate)>date(date_add(current_date(), INTERVAL -5 WEEK)) group by weekofyear(LastUpdate) order by weekofyear(LastUpdate) desc limit 4)t2 on t1.weekno=t2.wn";
        // dd($db);
        $query_select = "select 
                        	case when t1.weekno=weekofyear(current_date()) then 'Current Week' 
                        		when t1.weekno=weekofyear(current_date())-1 then 'Week 2' 
                                when t1.weekno=weekofyear(current_date())-2 then 'Week 3' 
                                when t1.weekno=weekofyear(current_date())-3 then 'Week 4' 
                                else t1.weekno end Week_name, t1.*,
                        	ifnull(No_of_Deletes,0) No_of_Deletes from 
                            
                            (select weekofyear(e.dstartdatetime) weekno, 
                            date(DATE_ADD(e.dstartdatetime, INTERVAL(0-weekday(e.dstartdatetime)) DAY)) start_date, 
                            date(DATE_ADD(e.dstartdatetime, INTERVAL(6-weekday(e.dstartdatetime)) DAY)) end_date, 
                            sum(case when vtrntype='Transaction' then nnettotal else 0 end) Sales_Amount, 
                            sum(case when vtrntype='Void' then 1 else 0 end) No_of_Voids 
                            from ".$db.".trn_sales s 
                        	join ".$db.".trn_endofdaydetail d on s.ibatchid=d.batchid
                        	JOIN ".$db.".trn_endofday e ON e.id=d.eodid
                        	where date(e.dstartdatetime)>date(date_add(current_date(), INTERVAL -5 WEEK)) 
                            group by weekofyear(e.dstartdatetime),date(DATE_ADD(e.dstartdatetime, INTERVAL(0-weekday(e.dstartdatetime)) DAY)), 
                            date(DATE_ADD(e.dstartdatetime, INTERVAL(6-weekday(e.dstartdatetime)) DAY)) 
                            order by  weekofyear(e.dstartdatetime) desc limit 4) t1 
                            
                            left join 
                            
                            (SELECT weekofyear(e.dstartdatetime) wn,
                            count(*) No_of_Deletes 
                            FROM ".$db.".mst_deleteditem s 
                        	join ".$db.".trn_endofdaydetail d on s.batchid=d.batchid
                        	JOIN ".$db.".trn_endofday e ON e.id=d.eodid
                        	where date(e.dstartdatetime)>date(date_add(current_date(), INTERVAL -5 WEEK)) 
                            group by weekofyear(e.dstartdatetime) order by weekofyear(e.dstartdatetime) desc limit 4) t2 
                            on t1.weekno=t2.wn
                            where t1.weekno >= weekofyear(current_date())-3";
                            
        // dd($query_select);
       
        //  $query_select = "select t1.*, ifnull(No_of_Deletes,0) No_of_Deletes from 
        //                 (select date_format(e.dstartdatetime,'%m-%d-%Y') saledt, sum(case when vtrntype='Transaction' then nnettotal else 0 end) Sales_Amount, 
        //                 sum(case when vtrntype='Void' then 1 else 0 end) No_of_Voids 
        //                 from ".$db.".trn_sales s 
        //                 join ".$db.".trn_endofdaydetail d on s.ibatchid=d.batchid
        //                 JOIN ".$db.".trn_endofday e ON e.id=d.eodid
        //                 where date(e.dstartdatetime) between  '".$start_date."'  and '".$end_date."'
        //                 group by date_format(e.dstartdatetime,'%m-%d-%Y') 
        //                 ) t1 
        //                  join 
        //                 (SELECT date_format(e.dstartdatetime,'%m-%d-%Y') saledt, count(*) No_of_Deletes FROM ".$db.".mst_deleteditem l 
        //                  join ".$db.".trn_endofdaydetail d on l.batchid=d.batchid
        //                 JOIN ".$db.".trn_endofday e ON e.id=d.eodid
        //                 where date(e.dstartdatetime) between '".$start_date."' and '".$end_date."'
        //                 group by date_format(e.dstartdatetime,'%m-%d-%Y'))t2" ;
        
        //$query_select = "select case when t1.weekno=weekofyear(current_date()) then 'Current Week' when t1.weekno=weekofyear(current_date())-1 then 'Week 2' when t1.weekno=weekofyear(current_date())-2 then 'Week 3' when t1.weekno=weekofyear(current_date())-3 then 'Week 4' else t1.weekno end Week_name, t1.*, ifnull(No_of_Deletes,0) No_of_Deletes from (select weekofyear(dtrandate) weekno, date(DATE_ADD(dtrandate, INTERVAL(1-DAYOFWEEK(dtrandate)) DAY)) start_date, date(DATE_ADD(dtrandate, INTERVAL(7-DAYOFWEEK(dtrandate)) DAY)) end_date, sum(case when vtrntype='Transaction' then nnettotal else 0 end) Sales_Amount, sum(case when vtrntype='Void' then 1 else 0 end) No_of_Voids from ".$db.".trn_sales where date(dtrandate)>date(date_add(current_date(), INTERVAL -5 WEEK)) group by weekofyear(dtrandate),date(DATE_ADD(dtrandate, INTERVAL(1-DAYOFWEEK(dtrandate)) DAY)), date(DATE_ADD(dtrandate, INTERVAL(7-DAYOFWEEK(dtrandate)) DAY)) order by  weekofyear(dtrandate) desc limit 4) t1 left join (SELECT weekofyear(LastUpdate) wn,count(*) No_of_Deletes FROM ".$db.".mst_deleteditem where date(LastUpdate)>date(date_add(current_date(), INTERVAL -5 WEEK)) group by weekofyear(LastUpdate) order by weekofyear(LastUpdate) desc limit 4)t2 on t1.weekno=t2.wn";
        
        //$query_select="select case when t1.weekno=weekofyear(current_date()) then 'Current Week'
        // when t1.weekno=weekofyear(current_date())-1 then 'Week 2' 
        // when t1.weekno=weekofyear(current_date())-2 then 'Week 3'
        // when t1.weekno=weekofyear(current_date())-3 then 'Week 4' 
        // else t1.weekno end Week_name, 
        
        // t1.*, ifnull(No_of_Deletes,0) No_of_Deletes 
        // from (
        // select weekofyear(dtrandate) weekno, 
        // date(DATE_ADD(dtrandate, INTERVAL(1-DAYOFWEEK(dtrandate)) DAY)) start_date, 
        // date(DATE_ADD(dtrandate, INTERVAL(7-DAYOFWEEK(dtrandate)) DAY)) end_date, 
        // sum(case when vtrntype='Transaction' then nnettotal else 0 end) Sales_Amount, 
        // sum(case when vtrntype='Void' then 1 else 0 end) No_of_Voids, dtrandate
        // from ".$db.".trn_sales where date(dtrandate)>date(date_add(current_date(), INTERVAL -5 WEEK)) 
        // group by weekofyear(dtrandate) 
        // order by  weekofyear(dtrandate) desc limit 4) t1 
        // left join (SELECT weekofyear(LastUpdate) wn,count(*) No_of_Deletes FROM ".$db.".mst_deleteditem where 
        // date(LastUpdate)>date(date_add(current_date(), INTERVAL -5 WEEK)) group by weekofyear(LastUpdate) order by weekofyear(LastUpdate) 
        // desc limit 4)t2 on t1.weekno=t2.wn";
        //echo $query_select;die;

         $matching_records = DB::select($query_select);
        // dd($matching_records);
        $table_data = $chart_data = [];
        foreach($matching_records as $k => $v){
              
            $chart_data[] = ["x"=> $v->Week_name, "y" => (float)number_format(((float)$v->Sales_Amount), 2, '.', '')];
            
            $key = $v->Week_name."\n(".$v->start_date." to ".$v->end_date.")";
            $table_data[] = [$key, $v->Sales_Amount, $v->No_of_Voids, $v->No_of_Deletes];
        }
        
        $table_title = ['Date ', 'Sales ($)', 'Void ', 'Delete'];
        
        $response = ["table_title" => $table_title, "table_data" => $table_data, "chart_data" => $chart_data];
        
        return response()->json($response);
    }
    
    public function get_last_12months_transactions($store_id){
        
        $db = "u".$store_id;
        
        // $query_select = "select t1.*, ifnull(No_of_Deletes,0) No_of_Deletes from (select DATE_FORMAT(dtrandate,'%b %Y')  month_no, sum(case when vtrntype='Transaction' then nnettotal else 0 end) Sales_Amount, sum(case when vtrntype='Void' then 1 else 0 end) No_of_Voids from ".$db.".trn_sales  where date(dtrandate)>date(date_add(current_date(), INTERVAL -13 MONTH)) group by DATE_FORMAT(dtrandate,'%b %Y'), DATE_FORMAT(dtrandate,'%Y%m') order by  DATE_FORMAT(dtrandate,'%Y%m') desc limit 12) t1 left join (SELECT DATE_FORMAT(LastUpdate,'%b %Y')  mn,count(*) No_of_Deletes FROM ".$db.".mst_deleteditem where date(LastUpdate)>date(date_add(current_date(), INTERVAL -13 MONTH)) group by DATE_FORMAT(LastUpdate,'%b %Y') limit 12)t2 on t1.month_no=t2.mn;";
        
        $query_select = "select t1.*, ifnull(No_of_Deletes,0) No_of_Deletes 
                        from 
                        (select DATE_FORMAT(e.dstartdatetime,'%b %Y')  month_no, 
                        sum(case when vtrntype='Transaction' then nnettotal else 0 end) Sales_Amount, 
                        sum(case when vtrntype='Void' then 1 else 0 end) No_of_Voids 
                        from ".$db.".trn_sales s 
                        	join ".$db.".trn_endofdaydetail d on s.ibatchid=d.batchid
                        	JOIN ".$db.".trn_endofday e ON e.id=d.eodid
                         
                        where date(e.dstartdatetime)>date(date_add(current_date(), INTERVAL -13 MONTH)) 
                        group by DATE_FORMAT(e.dstartdatetime,'%b %Y'), DATE_FORMAT(e.dstartdatetime,'%Y%m') 
                        order by DATE_FORMAT(e.dstartdatetime,'%Y%m') desc limit 12
                        ) t1 
                        left join 
                        (
                        SELECT DATE_FORMAT(e.dstartdatetime,'%b %Y') mn, count(*) No_of_Deletes 
                        FROM ".$db.".mst_deleteditem s 
                        	join ".$db.".trn_endofdaydetail d on s.batchid=d.batchid
                        	JOIN ".$db.".trn_endofday e ON e.id=d.eodid
                        where date(e.dstartdatetime)>date(date_add(current_date(), INTERVAL -13 MONTH)) 
                        group by DATE_FORMAT(e.dstartdatetime,'%b %Y') limit 12
                        )t2 
                        on t1.month_no=t2.mn";
                        
        $matching_records = DB::select($query_select);
        $matching_records = array_reverse($matching_records );
        $table_data = $chart_data = [];
        // dd($matching_records);
        foreach($matching_records as $k => $v){
           
            $chart_data[] = ["x"=> $v->month_no, "y" => (float)$v->Sales_Amount];
            $table_data[] = [$v->month_no, $v->Sales_Amount, $v->No_of_Voids, $v->No_of_Deletes];
        }
        
        $table_title = ['Date ', 'Sales ($)', 'Void', 'Delete'];
        
        $response = ["table_title" => $table_title, "table_data" => $table_data, "chart_data" => $chart_data];
        
        return response()->json($response);
    }
    
    
    public function notifications($store_id){
        
        $db = "u".$store_id;
        
        // $query = "select dtrandate dt, isalesid saleid_barcode, '' itemname, nnettotal amount_qty ,vtrntype tran_type from ".$db.".trn_sales where vtrntype in ('Void','No Sale') and dtrandate> (date_add(current_date(), INTERVAL -7 DAY)) union select LastUpdate dt, barcode saleid_barcode, itemname , Qty amount_qty, 'Delete' tran_type  from ".$db.".mst_deleteditem where LastUpdate> (date_add(current_date(), INTERVAL -7 DAY))";
    
        $query = "select dtrandate dt, isalesid saleid_barcode, '' itemname, nnettotal amount_qty ,vtrntype tran_type, vterminalid from ".$db.".trn_sales where vtrntype in ('Void','No Sale') and dtrandate > (date_add(current_date(), INTERVAL -7 DAY)) union select md.LastUpdate dt, barcode saleid_barcode, itemname , Qty amount_qty, 'Delete' tran_type, vterminalid from ".$db.".mst_deleteditem md join ".$db.".trn_batch tb on md.batchid=tb.ibatchid where md.LastUpdate> (date_add(current_date(), INTERVAL -7 DAY))";
        
        $matching_records = DB::select($query);
        
        $void = $no_sale = $delete = [];
        $count = 0;
        foreach($matching_records as $k => $v){
           
            /*switch($v->tran_type){
                
                case "Void":
                    $void[] = ["time" => $v->dt, "barcode" => $v->saleid_barcode, "itemname" => $v->itemname, "amount" => $v->amount_qty];
                    break;
                
                case "No Sale":
                    $no_sale[] = ["time" => $v->dt, "barcode" => $v->saleid_barcode, "itemname" => $v->itemname, "amount" => $v->amount_qty];
                    break;
                    
                case "Delete":
                    $delete[] = ["time" => $v->dt, "barcode" => $v->saleid_barcode, "itemname" => $v->itemname, "amount" => $v->amount_qty];
                    break;
            }*/
            
            switch($v->tran_type){
                
                case "Void":
                    if($count <= 11){
                        $void[] = ["message" => "Void Transaction ".$v->saleid_barcode, "time" => $v->dt];
                    }
                    $count++;
                    break;
                
                case "No Sale":
                    $no_sale[] = ["message" => "No Sale from Reg# ".$v->vterminalid, "time" => $v->dt];
                    break;
                    
                case "Delete":
                    $delete[] = ["message" => $v->itemname."(".$v->saleid_barcode.") Qty. ".$v->amount_qty." is deleted from Reg #".$v->vterminalid, "time" => $v->dt];
                    break;
            }
        }
        
        $void = count($void) === 0?[array('message' => 'No data found', "time" => '')]:$void;
        $no_sale = count($no_sale) === 0?[array('message' => 'No data found', "time" => '')]:$no_sale;
        $delete = count($delete) === 0?[array('message' => 'No data found', "time" => '')]:$delete;
        
        
        $response = ["void" => $void, "no_sale" => $no_sale, "delete" => $delete];
        
        // $response = ["table_title" => $table_title, "table_data" => $table_data, "chart_data" => $chart_data];
        
        return response()->json($response);
    }
    
    
    
    public function get_batches(Request $request){
        
        
        $input = Request::all();
        
        $db = "u".$input['sid'];
        
        $input_date = DateTime::createFromFormat('m-d-Y', $input['date']);
        
        $date = $input_date->format('Y-m-d');
        
        
        // $date = date('Y-m-d', strtotime($input['date']));
        
        $query = "select * from ".$db.".trn_endofday eod join ".$db.".trn_endofdaydetail eodd on eod.id=eodd.eodid where date(dstartdatetime) = date('".$date."')";
        
        $file_path = public_path()."/mobile.log";

		$myfile = fopen( $file_path, "a");
		
		$text = $query.PHP_EOL;

		fwrite($myfile,$text);
		fclose($myfile);
        
    
        $matching_records = DB::select($query);

        $response = [];
        foreach($matching_records as $k => $v){
            $array = [];
            $array['value'] = $v->batchid;
            $array['label'] = "Batch ".$v->batchid;
            // $array['start_date_time'] = $v->dstartdatetime;
            // $array['end_date_time'] = $v->denddatetime;
            
            $response[] = $array;
        }
        
        return response()->json($response);
    }
    

    
    public function get_batch_detail(Request $request){
        
        
        $input = Request::all();
        
        $db = "u".$input['sid'];
        
        $batch_id = $input['batch_id'];
        
        $query = "select ibatchid, vbatchname, dbatchstarttime, dbatchendtime, vterminalid, ntotalnontaxable, ntotaltaxable, ntotaltax, ntotalsales, nnetsales, nnetpaidout, nnetcashpickup, nnetaddcash, nopeningbalance, nclosingbalance, nuserclosingbalance from ".$db.".trn_batch WHERE ibatchid = ".$batch_id;
        
        $matching_records = DB::select($query);
        
        if(count($matching_records) == 0){
            
            // $eos_report_title = ['Title','Value'];
            
            $eos_report_title = ['No data found'];
            
            $eos_report_data = [];
            
            $response = ['eos_report_title' => $eos_report_title, 'eos_report_data' => $eos_report_data];
            
            return response()->json($response);
        }
        
        $data = $matching_records[0];
        $eos_report_title = ['Title','Value'];
        
        $cash_short_over = $data->nclosingbalance - $data->nuserclosingbalance;
        
        $eos_report_data = [
                                ['Opening Balance',$data->nopeningbalance],
                                ['Taxable Sales',$data->ntotaltaxable],
                                ['Total Tax',$data->ntotaltax],
                                ['Nontaxable Sales',$data->ntotalnontaxable],
                                ['Total Sales',$data->ntotalsales],
                                ['Closing Balance',$data->nclosingbalance],
                                ['Actual Cash',$data->nuserclosingbalance],
                                ['Cash Short / Over', (float)$cash_short_over]
                            ];
                            
        $response = ['eos_report_title' => $eos_report_title, 'eos_report_data' => $eos_report_data];


        
        return response()->json($response);
    }
    
    
    
    public function get_eod_detail(Request $request){
        
        
        $input = Request::all();
        
        $db = "u".$input['sid'];
        
        // $date = date('Y-m-d', strtotime($input['date']));
        
        $input_date = DateTime::createFromFormat('m-d-Y', $input['date']);
        
        $date = $input_date->format('Y-m-d');
        
        
        
        $query = "select * from ".$db.".trn_endofday WHERE date(dstartdatetime) = date('".$date."')";
        
        
        $file_path = public_path()."/mobile.log";

		$myfile = fopen( $file_path, "a");
		
		$text = "======================================================= EOD QUERY STARTS ===================================".PHP_EOL;
		
		$text .= $query.PHP_EOL;
		
		$text .= "======================================================= EOD QUERY ENDS ===================================".PHP_EOL;
		

		fwrite($myfile,$text);
		fclose($myfile);
        
        
        
        $matching_records = DB::select($query);
        // return count($matching_records);
        
        if(count($matching_records) == 0){
            
            // $eos_report_title = ['Title','Value'];
            
            $eos_report_title = ["No data found"];
            
            $eos_report_data = [];
            
            $response = ['eod_report_title' => $eos_report_title, 'eod_report_data' => $eos_report_data];
            
            return response()->json($response);
        }
        
        $data = $matching_records[0];
        $eos_report_title = ['Title','Value'];
        
        $cash_short_over = $data->nclosingbalance - $data->nuserclosingbalance;
        
        $eos_report_data = [
                                ['Opening Balance',$data->nopeningbalance],
                                ['Taxable Sales',$data->ntotaltaxable],
                                ['Total Tax',$data->ntotaltax],
                                ['Nontaxable Sales',$data->ntotalnontaxable],
                                ['Total Sales',$data->ntotalsales],
                                ['Closing Balance',$data->nclosingbalance],
                                ['Actual Cash',$data->nuserclosingbalance],
                                ['Cash Short / Over', (float)$cash_short_over]
                            ];
                            
        $response = ['eod_report_title' => $eos_report_title, 'eod_report_data' => $eos_report_data];
        
        
        
        
        return response()->json($response);
    }
    

    public function fileUpload(Request $request) {
        // return 973;
        /*$this->validate($request, [
            'input_img' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);*/

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            // $name = time().'.'.$image->getClientOriginalExtension();
            // $destinationPath = public_path('/images');
            // $image->move($destinationPath, $name);
            
            // $mst_item = MST_ITEM
            
            // Input::file('file');
            
            $imagedata = file_get_contents($image);
            // print_r($imagedata); die;
            
            $base64 = base64_encode($imagedata);
            
            return $mst_item = MST_ITEM::find($barcode);
            $oUser->avatar = $base64;
            
            
            $img_string = base64_encode($image);
            $img_string = base64_decode($this->request->post['pre_itemimage']);
            
            
            $this->save();
    
            return response()->json('success','Image Upload successfully');
        } else {
            return "Upload a file";
        }
    }
    
    public function get_report_by_seles_date(Request $request){
        
        $input = Request::all();
        
        $sid = $input['sid'];
        
        
        $start_date = date("Y-m-d", strtotime($input['start_date']));
        $end_date = date("Y-m-d", strtotime($input['end_date']));
       
       // $start_date = $input['start_date'];
        //$end_date = $input['end_date'];
        $starttime=$input['s_time'];
        $endtime=$input['e_time'];
        $start_amount = $input['start_amount'];
        $end_amount = $input['end_amount'];
        if($starttime!=NULL)
        {
            $starttime=$starttime;
            
        }
        if($starttime==NULL)
        {
            $starttime='00:00:00';
            
        }
        if($endtime!=NULL)
        {
            $endtime=$endtime;
            
        }
        if(($endtime==NULL))
        {
            $endtime='23:59:59';
        }
        if($start_date==null){
            return response()->json(['error' => 'Enter From Date.', 'status' => 'error'], 400);
        }
        if($end_date==null){
            return response()->json(['error' => 'Enter To Date.', 'status' => 'error'], 400);
        }
        // if($end_amount<=$start_amount){
        // return response()->json(['error' => 'End amount Should not be less than start amount.', 'status' => 'Date Error'], 400);
        
            
        // }
        
        $check_table_query = "select isalesid,dtrandate,nnettotal from u".$sid.".trn_sales  
        where dtrandate  BETWEEN '".$start_date." ". $starttime."' AND '".$end_date ." ".$endtime."' OR 
        nnettotal  BETWEEN '".$start_amount."' AND '".$end_amount."'ORDER BY dtrandate DESC LIMIT 25";
        //nnettotal  BETWEEN '".$start_amount."' AND '".$end_amount."'LIMIT 25";
       
        $check_table = DB::connection('mysql')->select($check_table_query);
        
        
        
        if(count($check_table) === 0){
            return response()->json(['error' => 'No Sales found in this store.', 'status' => 'error'], 400);
        } 
        else {
            $SNo=1;
            $table_data = [];
            foreach($check_table as $k => $v){
                $table_data[] = ["SNO"=>$SNo++, "saleId"=>$v->isalesid,"Date"=>$v->dtrandate,"Amount"=>$v->nnettotal,];
            }
        
            $table_title = ['Sno','Saleid','Date', 'Sales Amount($)'];
        
            $response = ["status" => 'success',"table_title" => $table_title, "table_data" => $table_data];
            
            return response()->json($response, 200);   
        }
    }

    public function get_current_25_transactions_new($store_id){
       
        $db = "u".$store_id;
        
        $query_db = 'USE DATABASE '.$db;
        
        DB::raw($query_db);
        
        
        
        $query_select = "SELECT dtrandate, nnettotal,isalesid  FROM " . $db . ".trn_sales WHERE vtrntype = 'Transaction' ORDER BY dtrandate DESC LIMIT 25";
        
        $matching_records = DB::select($query_select);
        
        $SNo=1;
        $table_data = $chart_data = [];
        foreach($matching_records as $k => $v){
            
            $table_data[] = ["SNO"=>$SNo++,"Date"=>$v->dtrandate,"SaleAmount"=> $v->nnettotal,"SalesId"=>$v->isalesid ];
            $chart_data[] = ["x"=>$v->dtrandate, "y"=>(float)$v->nnettotal];
        }
        
        $table_title = ['Date', 'Sales Amount ($)','SalesId'];
        
        $response = ["table_title" => $table_title, "table_data" => $table_data, "chart_data" => $chart_data];
        
        return response()->json($response);
    }
    
    public function get_eod_detail_new(Request $request){
         $input = Request::all();
         $db = "u".$input['sid'];
         $date = $input['date'];
         
         $query_db = 'USE DATABASE '.$db;
         DB::raw($query_db);
         
         $tax="SELECT ifnull(sum(nnettotal),0.00) Sales_With_Tax, ifnull(sum(nnontaxabletotal),0.00) Non_Taxable_Sales, 
         ifnull(sum(ntaxabletotal),0.00) Taxable_Total, ifnull(sum(case when vtendertype='On Account' then nnettotal else 0 end),0)
         House_Charged, ifnull(sum(ntaxtotal),0) Total_Tax, ifnull(sum(case when vtendertype='EBT' then nnettotal else 0 end),0) EBT_Cash_Payments, 
         ifnull(sum(case when vtendertype='Check' then nnettotal else 0 end),0) Check_Payments, ifnull(sum(case when vtendertype='Credit Card' then nnettotal else 0 end),0)
         Credit_Card_Payments, ifnull(sum(case when vtendertype='Debit Card' then nnettotal else 0 end),0) Debit_Card_Payments, ifnull(sum(ndiscountamt),0) Discount_Amount 
         FROM ".$db.".trn_sales where vtrntype='Transaction' and ibatchid in (SELECT ed.batchid FROM ".$db.".trn_endofday e join ".$db.".trn_endofdaydetail ed on e.id=ed.eodid
         where date_format(e.dstartdatetime,'%m-%d-%Y' ) = '". $date ."')";
        
         $queary_tax= DB::select($tax);
         
        
         
         
                $liabilitySales="select ifnull(sum(liabilityamount),0) Liability_Amount, ifnull(sum((itemtaxrateone*nunitprice/100)*ndebitqty),0)
                Tax1_Total, 
                ifnull(sum((itemtaxratetwo*nunitprice/100)*ndebitqty),0) Tax2_Total, 
                 ifnull(sum(case when vitemcode = 20 then nextunitprice else 0 end),0) Lot_Sales, 
                 ifnull(sum(case when vitemcode in (6, 22) then nextunitprice else 0 end),0) Lot_Redeem,
                 ifnull(sum(case when vitemcode = 21 then nextunitprice else 0 end),0) Inst_Sales,
                 ifnull(sum(case when vitemcode = 23 then nextunitprice else 0 end),0) Inst_Redeem, 
                 ifnull(sum(case when vitemcode = 1 and ndebitqty>0 then nextunitprice else 0 end),0) Bottle_Deposit, 
                 ifnull(sum(case when vitemcode = 10 then nextunitprice else 0 end),0) Bottle_Deposit_Redeem,
                 ifnull(sum(case when vitemcode = 18 then nextunitprice else 0 end),0)Coupon_Redeem, 
                 ifnull(sum(nextunitprice),0) Gross_Sales, ifnull(sum(nextcostprice),0) Gross_Cost, 
                 ifnull(sum(case when vitemcode <> 1 and ndebitqty<0  and vitemcode NOT IN(6,10,22,23) then (nextunitprice+(ndebitqty*((itemtaxrateone+itemtaxratetwo)*nunitprice/100))) else 0 end),0) Return_Amount 
                 from ".$db.".trn_sales s join ".$db.".trn_salesdetail d on s.isalesid=d.isalesid
                 where vtrntype='Transaction' and ibatchid in (SELECT ed.batchid 
                 FROM ".$db.".trn_endofday e join ".$db.".trn_endofdaydetail ed on e.id=ed.eodid where date_format(e.dstartdatetime,'%m-%d-%Y' ) = '". $date ."')";
                
            $deleteitem="SELECT ifnull(sum(extprice),0) Deleted_Items_Amount, count(extprice) No_of_Trn_Items_Deleted FROM ".$db.".mst_deleteditem d 
            join ".$db.".trn_batch b on d.batchid=b.ibatchid and ibatchid in (SELECT ed.batchid FROM ".$db.".trn_endofday e join ".$db.".trn_endofdaydetail 
            ed on e.id=ed.eodid where date_format(e.dstartdatetime,'%m-%d-%Y' ) = '". $date ."')";
            
            $voidamount="SELECT ifnull(sum(nnettotal),0) Void_Amount FROM ".$db.".trn_sales where vtrntype='Void' 
            and ibatchid in (SELECT ed.batchid FROM ".$db.".trn_endofday e join ".$db.".trn_endofdaydetail ed 
            on e.id=ed.eodid where date_format(e.dstartdatetime,'%m-%d-%Y' ) ='". $date ."')";
            
            $housecharge="SELECT ifnull(sum(ndebitamt),0) housecharge_payments from ".$db.".trn_customerpay where 
            vtrantype='Payment' and date_format(dtrandate,'%m-%d-%Y') = '". $date ."'";
            
            $saletotal="select ifnull(sum(case when vtrntype='Transaction' then 1 else 0 end),0) No_of_Sales, 
            ifnull(sum(case when vtrntype='Transaction' then nnettotal else 0 end),0) Sales_amount, 
            ifnull(sum(case when vtrntype='Void' then 1 else 0 end),0) No_of_Void, 
            ifnull(sum(case when vtrntype='Void' then nnettotal else 0 end),0) Void_Amount, 
            ifnull(sum(case when vtrntype='No Sale' then 1 else 0 end),0) No_Sales 
            from ".$db.".trn_sales where ibatchid in 
            (SELECT ed.batchid FROM ".$db.".trn_endofday e join ".$db.".trn_endofdaydetail ed on e.id=ed.eodid where 
            date_format(e.dstartdatetime,'%m-%d-%Y' ) = '". $date ."')";
            
            $Hours="SELECT CONCAT(date_format(dtrandate,'%h:00 %p to '), date_format(date_add(dtrandate, interval 1 hour),'%h:00 %p'))
             Hours, ifnull(sum(nnettotal),0) Amount FROM ".$db.".trn_sales where ibatchid in (SELECT ed.batchid 
             FROM ".$db.".trn_endofday e join ".$db.".trn_endofdaydetail ed on e.id=ed.eodid 
             where date_format(e.dstartdatetime,'%m-%d-%Y' ) = '". $date ."') 
             group by CONCAT(date_format(dtrandate,'%h:00 %p to ') , 
             date_format(date_add(dtrandate, interval 1 hour),'%h:00 %p')),date_format(dtrandate,'%H') 
             order by date_format(dtrandate,'%H')";
             
            $startcash="SELECT ifnull(sum(nopeningbalance),0) start_cash, ifnull(sum(nnetcashpickup),0) 
            cash_pickup, ifnull(sum(nnetaddcash),0)
            add_cash FROM  ".$db.".trn_batch WHERE ibatchid in (SELECT ed.batchid FROM  ".$db.".trn_endofday e join 
            ".$db.".trn_endofdaydetail 
            ed on e.id=ed.eodid where date_format(e.dstartdatetime,'%m-%d-%Y' ) = '". $date ."')";
            
            $department="select vdepname Dept, sum(ndebitqty) Qty, sum(ndebitamt) Amount from ".$db.".trn_sales s join 
            ".$db.".trn_salesdetail d on s.isalesid=d.isalesid
            where vtrntype='Transaction' and ibatchid in (SELECT ed.batchid FROM ".$db.".trn_endofday e 
            join ".$db.".trn_endofdaydetail ed on e.id=ed.eodid 
            where date_format(e.dstartdatetime,'%m-%d-%Y' ) = '". $date ."') group by vdepname";
             
             $amex="SELECT count(trn_mps.nauthamount) as transaction_number, ifnull(SUM(trn_mps.nauthamount),0) 
             as nauthamount, trn_mps.vcardtype as vcardtype FROM ".$db.".trn_mpstender trn_mps WHERE 
             trn_mps.vcardtype ='amex' AND trn_mps.nauthamount !=0 AND trn_mps.itranid in (select vuniquetranid 
             from ".$db.".trn_sales ts join trn_batch tb on ts.ibatchid=tb.ibatchid where ts.ibatchid in (SELECT ed.batchid FROM ".$db.".trn_endofday e join ".$db.".trn_endofdaydetail ed 
             on e.id=ed.eodid where date_format(e.dstartdatetime,'%m-%d-%Y' ) = '". $date ."')) GROUP BY trn_mps.vcardtype";
             
             $mastercard="SELECT count(trn_mps.nauthamount) as transaction_number, ifnull(SUM(trn_mps.nauthamount),0) 
             as nauthamount, trn_mps.vcardtype as vcardtype FROM ".$db.".trn_mpstender trn_mps WHERE 
             trn_mps.vcardtype ='mastercard' AND trn_mps.nauthamount !=0 AND trn_mps.itranid in (select vuniquetranid 
             from ".$db.".trn_sales ts join ".$db.".trn_batch tb on ts.ibatchid=tb.ibatchid where ts.ibatchid in (SELECT ed.batchid FROM ".$db.".trn_endofday e join ".$db.".trn_endofdaydetail ed 
             on e.id=ed.eodid where date_format(e.dstartdatetime,'%m-%d-%Y' ) = '". $date ."')) GROUP BY trn_mps.vcardtype";
             
             $ebt="SELECT count(trn_mps.nauthamount) as transaction_number, ifnull(SUM(trn_mps.nauthamount),0) 
             as nauthamount, trn_mps.vcardtype as vcardtype FROM ".$db.".trn_mpstender trn_mps WHERE 
             trn_mps.vcardtype ='EBT' AND trn_mps.nauthamount !=0 AND trn_mps.itranid in (select vuniquetranid 
             from ".$db.".trn_sales ts join trn_batch tb on ts.ibatchid=tb.ibatchid where ts.ibatchid in (SELECT ed.batchid FROM ".$db.".trn_endofday e join ".$db.".trn_endofdaydetail ed 
             on e.id=ed.eodid where date_format(e.dstartdatetime,'%m-%d-%Y' ) = '". $date ."')) GROUP BY trn_mps.vcardtype";
             
              $visa="SELECT count(trn_mps.nauthamount) as transaction_number, ifnull(SUM(trn_mps.nauthamount),0) 
             as nauthamount, trn_mps.vcardtype as vcardtype FROM ".$db.".trn_mpstender trn_mps WHERE 
             trn_mps.vcardtype ='visa' AND trn_mps.nauthamount !=0 AND trn_mps.itranid in (select vuniquetranid 
             from ".$db.".trn_sales ts join ".$db.".trn_batch tb on ts.ibatchid=tb.ibatchid where ts.ibatchid in (SELECT ed.batchid FROM ".$db.".trn_endofday e join ".$db.".trn_endofdaydetail ed 
             on e.id=ed.eodid where date_format(e.dstartdatetime,'%m-%d-%Y' ) = '". $date ."')) GROUP BY trn_mps.vcardtype";
                // return $visa;die;
                
            $disc="SELECT count(trn_mps.nauthamount) as transaction_number, ifnull(SUM(trn_mps.nauthamount),0) 
             as nauthamount, trn_mps.vcardtype as vcardtype FROM ".$db.".trn_mpstender trn_mps WHERE 
             trn_mps.vcardtype ='discover' AND trn_mps.nauthamount !=0 AND trn_mps.itranid in (select vuniquetranid 
             from ".$db.".trn_sales ts join trn_batch tb on ts.ibatchid=tb.ibatchid where ts.ibatchid in (SELECT ed.batchid FROM ".$db.".trn_endofday e join ".$db.".trn_endofdaydetail ed 
             on e.id=ed.eodid where date_format(e.dstartdatetime,'%m-%d-%Y' ) = '". $date ."')) GROUP BY trn_mps.vcardtype";
             
            $vendor="SELECT ifnull(vpaidoutname,' ') Vendor_Name, sum(namount) Amount FROM 
            ".$db.".trn_paidoutdetail tpd join ".$db.".trn_paidout tp on tpd.ipaidouttrnid=tp.ipaidouttrnid 
            where date_format(ddate,'%m-%d-%Y') = '". $date ."' 
            GROUP BY vpaidoutname WITH ROLLUP";
           
            
            $payout="SELECT vpaidoutname, sum(namount) Amount FROM ".$db.".trn_paidoutdetail tpd 
            join ".$db.".trn_paidout tp on tpd.ipaidouttrnid=tp.ipaidouttrnid where date_format(ddate,'%m-%d-%Y')
             = '". $date ."' GROUP BY vpaidoutname WITH ROLLUP";
         
           $total_sales=$queary_tax[0]->Sales_With_Tax;
         
            
          $queary_payout=DB::select($payout); 
          
          $payoutcount=(count($queary_payout));
          $paid_out_index=$payoutcount-1;
          if($paid_out_index>0){
                $payouts_value=$queary_payout[$paid_out_index]->Amount;
          }
          else{
                $payouts_value=0;
          }
         
          if($total_sales>0){
        
         
          $queary_vendor= DB::select($vendor);                                
          $queary_liabilitySales= DB::select($liabilitySales);  
          $queary_deleteitem= DB::select($deleteitem); 
          $queary_voidamount= DB::select($voidamount); 
          $queary_housecharge= DB::select($housecharge); 
          $queary_saletotal= DB::select($saletotal); 
          $queary_Hours= DB::select($Hours);
          $queary_startcash= DB::select($startcash);
          $queary_department= DB::select($department);
          $queary_amex= DB::select($amex);
        
          $queary_mastercard = DB::select($mastercard); 
          $queary_mastercard;
          
          $queary_ebt= DB::select($ebt);
          
          $queary_visa= DB::select($visa);
          
          $queary_disc= DB::select($disc);
          $tax1=$queary_liabilitySales[0]->Tax1_Total;
          $tax2=$queary_liabilitySales[0]->Tax2_Total;
          
          $groscost=$queary_liabilitySales[0]->Gross_Cost;
          $total_sales=$queary_tax[0]->Sales_With_Tax;
          
          $notranscationcount=$queary_saletotal[0]->No_of_Sales;
          $noofvoid=$queary_saletotal[0]->No_of_Void;
          $Number_of_Sales=$notranscationcount-$noofvoid;
          
          $Grossprofit=$total_sales-$groscost;
          $avgsale=$notranscationcount!= 0?($total_sales/$notranscationcount): 0.00;
          $grosprofitpercentage=$total_sales!= 0?(($Grossprofit/$total_sales)*100): 0.00;
          $Lotto_Sales=(($queary_liabilitySales[0]->Lot_Sales)+($queary_liabilitySales[0]->Inst_Sales)+($queary_liabilitySales[0]->Lot_Redeem)+($queary_liabilitySales[0]->Inst_Redeem));
          
          $Total_Sales_Tax=$tax1+$tax2;
          
            $data0=$queary_tax[0];
            $data1=$queary_liabilitySales[0];
            $data2=$queary_deleteitem[0];
            $data3=$queary_voidamount[0];
            $data4=$queary_housecharge[0];
            $data5=$queary_saletotal[0];
            $data6=$queary_startcash[0];
            $Liability_Amount=$data1->Liability_Amount;
            $Other_Liability_sales=($Liability_Amount-$Lotto_Sales);
            $cash=($data0->Sales_With_Tax-$data0->Credit_Card_Payments);
            $liability_deposit=($Lotto_Sales-$Other_Liability_sales);
            $drawer_total = ($cash + $data6->start_cash + $Lotto_Sales + $Other_Liability_sales +
            $data4->housecharge_payments + $data1->Bottle_Deposit - $payouts_value - 
            $data0->House_Charged - $data1->Bottle_Deposit_Redeem - $data0->Credit_Card_Payments - $data0->Check_Payments - $data1->Coupon_Redeem);
            $collectedcash=$drawer_total - $data6->start_cash ; 
            $store_deposit = $drawer_total - $Other_Liability_sales - $Lotto_Sales ;
            $OvershortCash=$collectedcash - $drawer_total - $data6->start_cash ;
            
            $eos_report_data = [
                                ['Store Sales with Tax',number_format($queary_tax[0]->Sales_With_Tax-$queary_liabilitySales[0]->Liability_Amount, 2, '.', '')],
                                ['Liability Sale',number_format(($data1->Liability_Amount), 2, '.', '')],
                                ['Fuel Sales',number_format(0.00, 2, '.', '')],
                                ['Total Sales',$data0->Sales_With_Tax],
                                ['Taxable Sales',$data0->Taxable_Total],
                                ['Non Taxable Sales',$data0->Non_Taxable_Sales],
                                ['Total Store Sales',number_format(($data0->Taxable_Total+$data0->Non_Taxable_Sales), 2, '.', '')],
                                ['Tax1 Total',number_format($data1->Tax1_Total, 2, '.', '')],
                                ['Tax2 Total',number_format($data1->Tax2_Total, 2, '.', '')],
                                ['Total sales tax',number_format($Total_Sales_Tax, 2, '.', '')],
                                
                                ['Lottery Sales',$data1->Lot_Sales],
                                ['Instant Sales',$data1->Inst_Sales],
                                ['Lottery Redeem',$data1->Lot_Redeem],
                                ['Instant Redeem',$data1->Inst_Redeem],
                                ['Lotto sales',number_format($Lotto_Sales, 2, '.', '')],
                                ['Other Liability_sales',number_format($Other_Liability_sales, 2, '.', '')],
                                
                                ['House Charged',$data0->House_Charged],
                                ['Housecharge payments',$data4->housecharge_payments],
                                ['Bottle Deposit',$data1->Bottle_Deposit],
                                ['Bottle Deposit_Redeem',$data1->Bottle_Deposit_Redeem],
                                ['Payout Total',number_format($payouts_value, 2, '.', '')],
                                ['Cash',number_format($cash, 2, '.', '')],
                                ['Coupon',$data1->Coupon_Redeem],
                                ['Check',$data0->Check_Payments],
                                
                                ['MasterCard',isset($queary_mastercard[0]->nauthamount) ? $queary_mastercard[0]->nauthamount:"0.00"],
                                ['Visa', isset($queary_visa[0]->nauthamount) ? $queary_visa[0]->nauthamount:"0.00"],
                                ['Discover',isset($queary_disc[0]->nauthamount) ? $queary_disc[0]->nauthamount:"0.00"],
                                //['Total_Tax',$data0->Total_Tax],
                                
                                ['EBT Cash',$data0->EBT_Cash_Payments],
                                
                                ['Amex',isset($queary_amex[0]->nauthamount) ? $queary_amex[0]->nauthamount:"0.00"],
                                
                                ['EBT',isset($queary_ebt[0]->nauthamount) ? $queary_ebt[0]->nauthamount:"0.00"],
                                //last upade format
                                
                                ['Start Cash',$data6->start_cash],
                                ['Drawer With Start Amount',number_format($drawer_total, 2, '.', '')],
                                ['Store Deposit',number_format($store_deposit, 2, '.', '')],
                                ['Liablity Deposit',number_format($liability_deposit, 2, '.', '')],
                                ['Collected Cash',number_format($collectedcash, 2, '.', '')],
                                ['Over/Short Cash',number_format($OvershortCash, 2, '.', '')],
                                ['Add cash',$data6->add_cash],
                                ['Cash pickup',$data6->cash_pickup],
                                ['Discount Total',$data0->Discount_Amount],
                                
                                ['Void Total',$data3->Void_Amount],
                                ['Deleted Total',$data2->Deleted_Items_Amount],
                                // ['Transaction_Count',$data5->No_of_Sales],
                                ['Check Payments',$data0->Check_Payments],
                                ['Number of Sales',$Number_of_Sales],
                                ['Number of void_sale',$noofvoid],
                                ['Number of Delete',$data2->No_of_Trn_Items_Deleted],
                                ['Number Of NOSales',$data5->No_Sales],
                                ['Gross Cost',$data1->Gross_Cost],
                                ['GrossProfit',number_format($Grossprofit, 2, '.', '')],
                                
                                ['Gross Profit_(%)',number_format($grosprofitpercentage, 2, '.', '')],
                                ['Average Sales',number_format($avgsale, 2, '.', '')],
                                ['Return Amount',number_format($data1->Return_Amount, 2, '.', '')],
                                
                                
                                
                                ['Credit Card Payments',$data0->Credit_Card_Payments],
                                ['Debit Card Payments',$data0->Debit_Card_Payments],
                              
                                ['Gross Sales',$data1->Gross_Sales],
                               
                                ['Sales amount',$data5->Sales_amount],
                                
                                ['Void Amount',$data5->Void_Amount],
                                
                                //['No of sale',number_format($Number_of_Sales, 2, '.', '')],
                               
                                
                                
                            ];
            $eos_report_title = ['Title','$Value'];    
             
            $data=$eos_report_data; 
            
            $hours_data = [];
            
            foreach($queary_Hours as $value)
            {
                $hours_data[] = [$value->Hours,$value->Amount];
            }
            
            $eos_report_hours_title = ['Hourly Sales','$Amount'];
            
            $hourly_sales_data = $hours_data;
            $vendor_data = [];
            // print_r($queary_Hours);exit;
            $count=1;
            foreach($queary_vendor as $value)
            {   
                if(trim($value->Vendor_Name) === ""){
                    continue;
                }
                $vendor_data[] = [$count++,$value->Vendor_Name,$value->Amount];
            }
            
            $eos_report_vendor_title = ['No.','Vendor Name','$Amount'];
            $vendor_data = $vendor_data;
            $department_data = [];
            foreach($queary_department as $value)
            {
                $department_data[] = [$value->Dept,$value->Qty,$value->Amount];
            }
            
            $eos_report_department_title = ['Department','Quantity','$Price'];
            $department_data = $department_data;
            
            //$data['liabilitySales']=$queary_liabilitySales;
            //$data['Lotto_sales']=number_format($Lotto_Sales, 2, '.', '');
           // $data['Total_sales_tax']=number_format($Total_Sales_Tax, 2, '.', '');
            //$data['Fuel_Sales']=number_format(0.00, 2, '.', '');
           // $data['Deleteitem']=$queary_deleteitem;
            //$data['VoidAmount']=$queary_voidamount;
            //$data['HousechargePayment']=$queary_housecharge;
            //$data['SaleTotal']=$queary_saletotal;
            //$data['No_of_sale']=$Number_of_Sales;
            //$data['startcash']=$queary_startcash;
            //$data['GrossProfit']=number_format($Grossprofit , 2, '.', '');   
            //$data['Average_Sales']=number_format($avgsale , 2, '.', '');
            //$data11['Hours_amount']=$queary_Hours;
            // $data['Hours']=isset($queary_Hours['Hours']) ? $queary_Hours['Hours']: 0;
            // $data['Amount']=isset($queary_Hours['Amount']) ? $queary_Hours['Amount']: 0; 
            //$data['Gross_Profit_(%)']=number_format($grosprofitpercentage, 2, '.', ''); 
            $data11['department']=$queary_department;
            $data11['vendor']=$queary_vendor;
            //$data['Amex']=isset($queary_amex[0]->nauthamount) ? $queary_amex[0]->nauthamount:"0.00";
            //$data['MasterCard']=isset($queary_mastercard[0]->nauthamount) ? $queary_mastercard[0]->nauthamount:"0.00";
            //$data['EBT']=isset($queary_ebt[0]->nauthamount) ? $queary_ebt[0]->nauthamount:"0.00";
            //$data['Visa']=isset($queary_visa[0]->nauthamount) ? $queary_visa[0]->nauthamount:"0.00";
            //$data['Discover']=isset($queary_disc[0]->nauthamount) ? $queary_disc[0]->nauthamount:"0.00";
            //return response()->json($data, 200);
                                 
         $response = [
                        'eod_report_title' => $eos_report_title, 
                        'eod_report_data' => $data,
                        
                        'hourly_sales_table_head' => $eos_report_hours_title,
                        'hourly_sales_table_data' => $hourly_sales_data,
                        
                        'sales_by_vendor_table_head' => $eos_report_vendor_title,
                        'sales_by_vendor_table_data' => $vendor_data,
                        
                        'sales_by_department_table_head' => $eos_report_department_title,
                        'sales_by_department_table_data' => $department_data,
                        
                    ];
                   return response()->json($response);
            
      } 
      
      else {
          //$eos_report_title = ['No Data Found'];  
            $eos_report_title = ['Title','Value'];  
            $error = [
              
                        'eod_report_title' => $eos_report_title, 
                        'eod_report_data' => [["Store Sales with Tax",
             "0.00"
                    ],
        [
            "Liability Sale",
            "0.00"
        ],
        [
            "Fuel Sales",
            "0.00"
        ],
        [
            "Total Sales",
            "0.00"
        ],
        [
            "Taxable Sales",
            "0.00"
        ],
        [
            "Non Taxable Sales",
            "0.00"
        ],
        [
            "Total Store Sales",
            "0.00"
        ],
        [
            "Tax1 Total",
            "0.00"
        ],
        [
            "Tax2 Total",
            "0.00"
        ],
        [
            "Total sales tax",
            "0.00"
        ],
        [
            "Lottery Sales",
            "0.00"
        ],
        [
            "Instant Sales",
            "0.00"
        ],
        [
            "Lottery Redeem",
            "0.00"
        ],
        [
            "Instant Redeem",
            "0.00"
        ],
        [
            "Lotto sales",
            "0.00"
        ],
        [
            "Other Liability_sales",
            0
        ],
        [
            "House Charged",
            "0.00"
        ],
        [
            "Housecharge payments",
            "0.00"
        ],
        [
            "Bottle Deposit",
            "0.00"
        ],
        [
            "Bottle Deposit_Redeem",
            "0.00"
        ],
        [
            "Payout Total",
            "00.00"
        ],
        [
            "Cash",
            "0.00"
        ],
        [
            "Coupon",
            "0.00"
        ],
        [
            "Check",
            "0.00"
        ],
        [
            "MasterCard",
            "0.00"
        ],
        [
            "Visa",
            "0.00"
        ],
        [
            "Discover",
            "0.00"
        ],
        [
            "EBT Cash",
            "0.00"
        ],
        [
            "Amex",
            "0.00"
        ],
        [
            "EBT",
            "0.00"
        ],
        [
            "Start Cash",
            "0.00"
        ],
        [
            "Drawer With Start Amount",
            "00.00"
        ],
        [
            "Store Deposit",
            "00.00"
        ],
        [
            "Liablity Deposit",
            "0.00"
        ],
        [
            "Collected Cash",
            "00.00"
        ],
        [
            "Over/Short Cash",
            "0.00"
        ],
        [
            "Add cash",
            "0.00"
        ],
        [
            "Cash pickup",
            "0.00"
        ],
        [
            "Discount Total",
            "0.00"
        ],
        [
            "Void Total",
            "0.00"
        ],
        [
            "Deleted Total",
            "0.00"
        ],
        [
            "Check Payments",
            "0.00"
        ],
        [
            "Number of Sales",
            0
        ],
        [
            "Number of void_sale",
            "0"
        ],
        [
            "Number of Delete",
            0
        ],
        [
            "Number Of NOSales",
            "0"
        ],
        [
            "Gross Cost",
            "0.00"
        ],
        [
            "GrossProfit",
            "0.00"
        ],
        [
            "Gross Profit_(%)",
            "0.00"
        ],
        [
            "Average Sales",
            "0.00"
        ],
        [
            "Return Amount",
            "0.00"
        ],
        [
            "Credit Card Payments",
            "0.00"
        ],
        [
            "Debit Card Payments",
            "0.00"
        ],
        [
            "Gross Sales",
            "0.00"
        ],
        [
            "Sales amount",
            "0.00"
        ],
        [
            "Void Amount",
            "0.00"
        ],
        [
            "No of sale",
            "0.00"
        ]],
                        ];
     return response()->json($error);
            //return response()->json(['error'=>'No Data Found'],401);
            
           }
      
     }
    
    public function notifications_new($store_id){
        
        $db = "u".$store_id;
        
        // $query = "select dtrandate dt, isalesid saleid_barcode, '' itemname, nnettotal amount_qty ,vtrntype tran_type from ".$db.".trn_sales where vtrntype in ('Void','No Sale') and dtrandate> (date_add(current_date(), INTERVAL -7 DAY)) union select LastUpdate dt, barcode saleid_barcode, itemname , Qty amount_qty, 'Delete' tran_type  from ".$db.".mst_deleteditem where LastUpdate> (date_add(current_date(), INTERVAL -7 DAY))";
    
        //$query = "select dtrandate dt, isalesid saleid_barcode, '' itemname, nnettotal amount_qty ,vtrntype tran_type, vterminalid from ".$db.".trn_sales where vtrntype in ('Void','No Sale') and dtrandate > (date_add(current_date(), INTERVAL -7 DAY)) union select md.LastUpdate dt, barcode saleid_barcode, itemname , Qty amount_qty, 'Delete' tran_type, vterminalid from ".$db.".mst_deleteditem md join ".$db.".trn_batch tb on md.batchid=tb.ibatchid where md.LastUpdate> (date_add(current_date(), INTERVAL -7 DAY))";
        //  $query = "select dtrandate dt, isalesid saleid_barcode, '' 
        //  itemname, nnettotal amount_qty ,vtrntype tran_type, 
        //  vterminalid from ".$db.".trn_sales where vtrntype in ('Void','No Sale') and dtrandate > 
        //  current_date() union select md.LastUpdate dt, barcode saleid_barcode, itemname , Qty amount_qty, 
        //  'Delete' tran_type, vterminalid from ".$db.".mst_deleteditem md join ".$db.".trn_batch tb on md.batchid=tb.ibatchid 
        //  where md.LastUpdate>current_date() order by dt desc";
        // //echo $query;die;
        
            $query = "select dtrandate dt, isalesid saleid_barcode, ''
            itemname, nnettotal amount_qty ,vtrntype tran_type,
            vterminalid from ".$db.".trn_sales where vtrntype in ('Void','No Sale') and date_format(dtrandate , '%Y-%m-%d')=
            current_date() union select md.LastUpdate dt, barcode saleid_barcode, itemname , Qty amount_qty,
            'Delete' tran_type, vterminalid from ".$db.".mst_deleteditem md left join ".$db.".trn_batch tb on md.batchid=tb.ibatchid
            where date_format(md.LastUpdate, '%Y-%m-%d')=current_date() order by dt desc";
        
        
        $matching_records = DB::select($query);
        
        $void = $no_sale = $delete = [];
        $count = 0;
        foreach($matching_records as $k => $v){
           
            /*switch($v->tran_type){
                
                case "Void":
                    $void[] = ["time" => $v->dt, "barcode" => $v->saleid_barcode, "itemname" => $v->itemname, "amount" => $v->amount_qty];
                    break;
                
                case "No Sale":
                    $no_sale[] = ["time" => $v->dt, "barcode" => $v->saleid_barcode, "itemname" => $v->itemname, "amount" => $v->amount_qty];
                    break;
                    
                case "Delete":
                    $delete[] = ["time" => $v->dt, "barcode" => $v->saleid_barcode, "itemname" => $v->itemname, "amount" => $v->amount_qty];
                    break;
            }*/
            
            switch($v->tran_type){
                
                case "Void":
                    if($count <= 11){
                        $void[] = ["message" => "Void Transaction ".$v->saleid_barcode, "time" => date('m-d-Y h:i a ', strtotime($v->dt))];
                    }
                    $count++;
                    break;
                
                case "No Sale":
                    $no_sale[] = ["message" => "No Sale from Reg# ".$v->vterminalid, "time" =>date('m-d-Y h:i a ', strtotime($v->dt))];
                    break;
                    
                case "Delete":
                    $delete[] = ["message" => $v->itemname."(".$v->saleid_barcode.") Qty. ".$v->amount_qty." is deleted from Reg #".$v->vterminalid, 
                    "time" => date('m-d-Y h:i a ', strtotime($v->dt))];
                     
                    break;
            }
        }
        
        $void = count($void) === 0?[array('message' => 'No data found', "time" => '')]:$void;
        $no_sale = count($no_sale) === 0?[array('message' => 'No data found', "time" => '')]:$no_sale;
        $delete = count($delete) === 0?[array('message' => 'No data found', "time" => '')]:$delete;
        
        
        $response = ["void" => $void, "no_sale" => $no_sale, "delete" => $delete];
        
        // $response = ["table_title" => $table_title, "table_data" => $table_data, "chart_data" => $chart_data];
        
        return response()->json($response);
    }
    
    public function add_sub(){
        //print_r("test");die;
        
        $stores = Store::all();
        $store_array = array();
        foreach ($stores as $storesData) {
           $store_array[$storesData->id] = $storesData->id;
           
           $check_table_query = "SELECT TABLE_SCHEMA FROM information_schema.tables WHERE table_schema = 'u".$storesData->id."' AND table_name = 'mst_subcategory' LIMIT 1";
           
           $run_check_table_query = DB::select($check_table_query);
           if(count($run_check_table_query)===0){
               //print_r($storesData->id);
                  $sql="CREATE TABLE IF NOT EXISTS `u".$storesData->id."`.`mst_subcategory` (
              `subcat_id` int(11) NOT NULL AUTO_INCREMENT,
              `cat_id` int(11) NOT NULL,
              `subcat_name` varchar(100) NOT NULL,
              `status` varchar(45) DEFAULT NULL,
              `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
              `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
              `SID` int(11) NOT NULL DEFAULT '".$store_array[$storesData->id]."',
              PRIMARY KEY (`subcat_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1";
            
             $created = DB::statement($sql);
              echo "created table";
              echo "id";
              echo $storesData->id;
           }
         
                        // echo $sql;die;
                        // $created = DB::statement($sql);
        
           }

    }
    
    public function add_purchaseorderdetail(){
       
          $all_stores = Store::all();
        
        
            foreach($all_stores as $store){
            
        
            
            $db = 'u'.$store->id;
            
            
            $check_db_query = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '".$db."'";
            
            $run_check_db_query = DB::Select(DB::raw($check_db_query));
            
            if(count($run_check_db_query) === 0){
                
                echo "Database: {$db} does not exist.<br>";
                
                continue;
            }
            
            
            
            $check_table_query = "SELECT * FROM information_schema.tables WHERE table_schema = '".$db."' AND table_name = 'trn_purchaseorderdetail' LIMIT 1;";
          
            $run_check_table_query = DB::Select(DB::raw($check_table_query));
            
            if(count($run_check_table_query) === 0){
                
                echo "Table 'trn_purchaseorderdetail' in database: {$db} does NOT exist.<br>";
                
                $create_query = "CREATE TABLE IF NOT EXISTS `".$db."`.`trn_purchaseorderdetail` (
                             `ipodetid` int(11) NOT NULL AUTO_INCREMENT,
                              `ipoid` int(11) DEFAULT NULL,
                              `vitemid` varchar(50) DEFAULT NULL,
                              `vitemname` varchar(100) DEFAULT NULL,
                              `vunitcode` varchar(25) DEFAULT NULL,
                              `vunitname` varchar(50) DEFAULT NULL,
                              `po_order_by` varchar(5) NOT NULL DEFAULT 'case',
                              `nordqty` decimal(15,2) DEFAULT '0.00',
                              `nrceqty` decimal(15,2) DEFAULT '0.00',
                              `nordunitprice` decimal(15,2) DEFAULT '0.00',
                              `po_last_costprice` decimal(15,2) DEFAULT '0.00',
                              `nreceunitprice` decimal(15,2) DEFAULT '0.00',
                              `nordtax` decimal(15,2) DEFAULT NULL,
                              `nordextprice` decimal(15,4) DEFAULT '0.0000',
                              `nrceextprice` decimal(15,2) DEFAULT '0.00',
                              `nordtextprice` decimal(15,2) DEFAULT '0.00',
                              `nrcetextprice` decimal(15,2) DEFAULT '0.00',
                              `nnewunitprice` decimal(15,2) DEFAULT '0.00',
                              `vbarcode` varchar(50) DEFAULT NULL,
                              `vvendoritemcode` varchar(50) DEFAULT NULL,
                              `npackqty` int(11) DEFAULT '0',
                              `nunitcost` decimal(15,4) DEFAULT '0.0000',
                              `itotalunit` int(11) DEFAULT '0',
                              `vsize` varchar(100) DEFAULT NULL,
                              `po_total_suggested_cost` decimal(15,2) NOT NULL DEFAULT '0.00',
                              `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                              `SID` int(11) NOT NULL DEFAULT '".$store->id."',
                              `nripamount` decimal(15,2) DEFAULT '0.00',
                              PRIMARY KEY (`ipodetid`),
                              KEY `idx_trn_purchaseorderdetail_id` (`ipoid`,`vitemid`)
                            ) ENGINE=MyISAM DEFAULT CHARSET=utf8";

                //echo $create_query.'<br>';
                DB::statement($create_query);
            
                echo "Created trn_purchaseorderdetail table in database:".$db."<br>";
            } else {
                
                echo "Table 'trn_purchaseorderdetail' in database: {$db} EXISTS.<br>";
                
                $check_column_exists = "SELECT * FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = '".$db."' AND TABLE_NAME = 'trn_purchaseorderdetail' AND COLUMN_NAME = 'po_last_costprice'";
          
                $run_check_column_exists = DB::select(DB::raw($check_column_exists));
                
                
                
                if(count($run_check_column_exists) === 0){
                  
                    $alter_query = "ALTER TABLE `".$db."`.`trn_purchaseorderdetail` ADD COLUMN `po_last_costprice` decimal(15,2) DEFAULT '0.00' AFTER `nordunitprice`;";
                    
                    //echo $alter_query.'<br>'; 
                    
                    DB::statement($alter_query);
            
                    echo "Modified trn_purchaseorderdetail table in database ".$db.": Added po_last_costprice column<br>";  
                } else {
                    
                    echo "po_last_costprice column already exists in trn_purchaseorderdetail table in database ".$db.".<br>";  
                }
                
                echo "<br>";
                
                
                $check_column_exists = "SELECT * FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = '".$db."' AND TABLE_NAME = 'trn_purchaseorderdetail' AND COLUMN_NAME = 'po_order_by'";
          
                $run_check_column_exists = DB::select(DB::raw($check_column_exists));
                
                
                
                if(count($run_check_column_exists) === 0){
                  
                    $alter_query = "ALTER TABLE `".$db."`.`trn_purchaseorderdetail` ADD COLUMN `po_order_by` varchar(5) NOT NULL DEFAULT 'case' AFTER `vunitname`;";
                    
                    //echo $alter_query.'<br>'; 
                    
                    DB::statement($alter_query);
            
                    echo "Modified trn_purchaseorderdetail table in database ".$db.": Added po_order_by column<br>";  
                } else {
                    
                    echo "po_order_by column already exists in trn_purchaseorderdetail table in database ".$db.".<br>";  
                }
                
                echo "<br>";
                
                
                 $check_column_exists = "SELECT * FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = '".$db."' AND TABLE_NAME = 'trn_purchaseorderdetail' AND COLUMN_NAME = 'po_total_suggested_cost'";
          
                $run_check_column_exists = DB::select(DB::raw($check_column_exists));
                
                
                
                if(count($run_check_column_exists) === 0){
                  
                    $alter_query = "ALTER TABLE `".$db."`.`trn_purchaseorderdetail` ADD COLUMN `po_total_suggested_cost` decimal(15,2) NOT NULL DEFAULT '0.00' AFTER `vsize`";
                    
                    //echo $alter_query.'<br>'; 
                    
                    DB::statement($alter_query);
            
                    echo "Modified trn_purchaseorderdetail table in database ".$db.": Added po_total_suggested_cost column<br>";  
                } else {
                    
                    echo "po_total_suggested_cost column already exists in trn_purchaseorderdetail table in database ".$db.".<br>";  
                }
                
                echo "<br>";
                
                
                
                
            }
            
           
            
            
        }
        
        
        return "Done creating table: trn_purchaseorderdetail";
        
        
    }
    
    public function add_taxprocedure(){
         
        // $databaseuser = "alberta";
        // $databasepass = "Jalaram123$";
        // $db_host = "albertapayments.cfixtkqw8bai.us-east-2.rds.amazonaws.com";
        // $databasename = 'sample';

        //echo "mysql -u" . $databaseuser . " -p" . $databasepass . " -h" . $db_host . " -D". $databasename . " < ". storage_path('rp_taxcollection.sql').'<br>';

        //exec("mysql -u" . $databaseuser . " -p" . $databasepass . " -h" . $db_host . " -D". $databasename . " < ". storage_path('golden_blank.sql'));

         
         
         
       
    //       $all_stores = Store::where('id', '<>', '100061')->get();

    //      // $all_stores = Store::where('id', '=', '100566')->get();

        
    //     foreach($all_stores as $store){
         
    //         $db = 'u'.$store->id;
            
    //         echo "Selected {$db} ".'<br>';
    //         $check_db_query = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '".$db."'";
            
    //         $run_check_db_query = DB::Select(DB::raw($check_db_query));
            
    //         if(count($run_check_db_query) === 0){
                
    //             echo "Database: {$db} does not exist.<br>";
                
    //             continue;
    //         }
            
    //         // $sql="USE `$db`";
    //         // $run_statement = DB::statement($sql);
            
    //         $databaseuser = "alberta";
    //         $databasepass = "Jalaram123$";
    //         $db_host = "albertapayments.cfixtkqw8bai.us-east-2.rds.amazonaws.com";
    //         $databasename = $db;
            
    //         //echo "mysql -u" . $databaseuser . " -p" . $databasepass . " -h" . $db_host . " -D". $databasename . " < ". storage_path('rp_taxcollection.sql').'<br>';
            
    //         exec("mysql -u" . $databaseuser . " -p" . $databasepass . " -h" . $db_host . " -D". $databasename . " < ". storage_path('rp_taxcollection.sql'));

            
            
    //         //echo json_encode($run_statement).'<br>';
    //     }
        
        
        //return "Done creating procedure: tax procedure";
        
        
    }
    
    // public function print_label(){

    //     $stores = Store::all();
    //     $store_array = array();
    //     $counter = 0;
    //     foreach ($stores as $storesData) {
            
    //         if($storesData->id == '100569'){continue;}
    //         $store_array[$storesData->id] = $storesData->id;
           
    //         $check_table_query = "SELECT TABLE_SCHEMA FROM information_schema.tables WHERE table_schema = 'u".$storesData->id."' AND table_name = 'label_print' LIMIT 1";
    //         $run_check_table_query = DB::select($check_table_query);
           
    //       if(count($run_check_table_query)===0){
                
    //             $counter++;
    //             $sql= "CREATE TABLE IF NOT EXISTS `u".$storesData->id."`.`label_print` (
    //                       `id` int(11) NOT NULL AUTO_INCREMENT,
    //                       `barcode` varchar(15) DEFAULT NULL,
    //                       `status` enum('Open','Close', 'Print') DEFAULT 'Open',
    //                       `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
    //                       `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    //                       `SID` int(11) NOT NULL DEFAULT '".$storesData->id."',
    //    %2
    
    // please dont remove this code (Store procedure update and  craete code)
    public function add_store_procedure(){
        echo '<br/>';
        // print_r("test");die;
        
        $all_stores = Store::where('id', '100523')->get();
        
        // return $all_stores;
        
        // $all_stores=Store::all();
        foreach($all_stores as $store){
         
            $db = 'u'.$store->id;
            
            echo "Selected {$db} ".'<br>';
            $check_db_query = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '".$db."'";
            
            $run_check_db_query = DB::Select(DB::raw($check_db_query));
            
            if(count($run_check_db_query) === 0){
                
                echo "Database: {$db} does not exist.<br>";
                
                continue;
            }
         
            
            $databaseuser = "alberta";
            $databasepass = "Jalaram123$";
            $db_host = "albertapayments.cfixtkqw8bai.us-east-2.rds.amazonaws.com";
            $databasename = $db;
            
            // $databaseuser = "alberta";
            // $databasepass = "Jalaram123$";
            // $db_host = "devalberta.cfixtkqw8bai.us-east-2.rds.amazonaws.com";
            // $databasename = $db;
            
            
            // $response = exec("mysql -u" . $databaseuser . " -p" . $databasepass . " -h" . $db_host . " -D". $databasename . " < ". storage_path('change_end_of_day.sql'));

            // echo "Ran 'change_end_of_day.sql'. Status: ".json_encode($response).'<br>';
            
            
            /*$query = "ALTER TABLE {$db}.`trn_endofday` RENAME TO {$db}.`trn_endofday_old`";
            $run_query = DB::connection('mysql')->statement($query);
            echo "Rename trn_endofday".json_encode($run_query).'<br/>';

            $query = "ALTER TABLE {$db}.`trn_endofdaydetail` RENAME TO {$db}.`trn_endofdaydetail_old`";
            $run_query = DB::connection('mysql')->statement($query);
            echo "Rename trn_endofdaydetail".json_encode($run_query);

            $query = "update {$db}.trn_batch set endofday=0";
            $run_query = DB::connection('mysql')->statement($query);
            echo "Update trn_batch".json_encode($run_query).'<br/>';*/
            
            
            $query = "CREATE TABLE {$db}.`trn_endofday` (
              `id` bigint(30) NOT NULL,
              `nnetsales` decimal(15,2) DEFAULT '0.00',
              `nnetpaidout` decimal(15,2) DEFAULT '0.00',
              `nnetcashpickup` decimal(15,2) DEFAULT '0.00',
              `estatus` varchar(10) DEFAULT NULL,
              `dstartdatetime` timestamp NULL DEFAULT NULL,
              `denddatetime` timestamp NULL DEFAULT NULL,
              `nopeningbalance` decimal(15,2) DEFAULT '0.00',
              `nclosingbalance` decimal(15,2) DEFAULT '0.00',
              `nuserclosingbalance` decimal(15,2) DEFAULT '0.00',
              `nnetaddcash` decimal(15,2) DEFAULT '0.00',
              `ntotalnontaxable` decimal(15,2) DEFAULT '0.00',
              `ntotaltaxable` decimal(15,2) DEFAULT '0.00',
              `ntotalsales` decimal(15,2) DEFAULT '0.00',
              `ntotaltax` decimal(15,2) DEFAULT '0.00',
              `ntotalcreditsales` decimal(15,2) DEFAULT '0.00',
              `ntotalcashsales` decimal(15,2) DEFAULT '0.00',
              `ntotalgiftsales` decimal(15,2) DEFAULT '0.00',
              `ntotalchecksales` decimal(15,2) DEFAULT '0.00',
              `ntotalreturns` decimal(15,2) DEFAULT '0.00',
              `ntotaldiscount` decimal(15,2) DEFAULT '0.00',
              `ntotaldebitsales` decimal(15,2) DEFAULT '0.00',
              `ntotalebtsales` decimal(15,2) DEFAULT '0.00',
              `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
              `SID` int(11) NOT NULL DEFAULT '{$store->id}',
              PRIMARY KEY (`id`),
              KEY `idx_trn_endofday_id` (`id`)
            ) DEFAULT CHARSET=utf8";
            $run_query = DB::connection('mysql')->statement($query);
            echo "Create trn_endofday".json_encode($run_query).'<br/>';
            
            $query = "CREATE TABLE {$db}.`trn_endofdaydetail` (
              `Id` int(11) NOT NULL AUTO_INCREMENT,
              `eodid` bigint(30) DEFAULT NULL,
              `batchid` bigint(30) DEFAULT NULL,
              `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
              `SID` int(11) NOT NULL DEFAULT '{$store->id}',
              PRIMARY KEY (`Id`)
            ) DEFAULT CHARSET=utf8";
            $run_query = DB::connection('mysql')->statement($query);
            echo "Create trn_endofdaydetail".json_encode($run_query).'<br/>';
        }
        
        
        return "Done running the script";
        
        
    }
    
    public function update_store_procedure(){
        //print_r("test");die;
     
          $all_stores=Store::all();
         foreach($all_stores as $store){
         
            $db = 'u'.$store->id;
            
            echo "Selected {$db} ".'<br>';
            $check_db_query = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '".$db."'";
            
            $run_check_db_query = DB::Select(DB::raw($check_db_query));
            
            if(count($run_check_db_query) === 0){
                
                echo "Database: {$db} does not exist.<br>";
                
                continue;
            }
         
            
            $databaseuser = "alberta";
            $databasepass = "Jalaram123$";
            $db_host = "albertapayments.cfixtkqw8bai.us-east-2.rds.amazonaws.com";
            $databasename = $db;
            
            // $databaseuser = "alberta";
            // $databasepass = "Jalaram123$";
            // $db_host = "devalberta.cfixtkqw8bai.us-east-2.rds.amazonaws.com";
            // $databasename = $db;
            
            
            exec("mysql -u" . $databaseuser . " -p" . $databasepass . " -h" . $db_host . " -D". $databasename . " < ". storage_path('inv.sql'));

            
            
            //echo json_encode($run_statement).'<br>';
        }
        
        
        return "Updated store procedure: Hourly Sales Report";
        
        
    }
    
    public function update_tables(){
        //print_r("test");die;
     
        $all_stores=Store::all();
        foreach($all_stores as $store){
         
            $db = 'u'.$store->id;
            
            echo "Selected {$db} ".'<br>';
            $check_db_query = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '".$db."'";
            
            $run_check_db_query = DB::Select(DB::raw($check_db_query));
            
            if(count($run_check_db_query) === 0){
                
                echo "Database: {$db} does not exist.<br>";
                
                continue;
            }
            
            $result = DB::Select(DB::raw("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE = 'BASE TABLE' AND TABLE_NAME='trn_physicalinventorydetail' AND TABLE_SCHEMA='".$db."'"));
            // dd(count($result));
            
            if(count($result)){
                
                $check_column = DB::Select(DB::raw("SHOW COLUMNS FROM ".$db.".trn_physicalinventorydetail LIKE 'afterQOH'"));
                if(count($check_column) === 0){
                    $alter_query = "ALTER TABLE `".$db."`.`trn_physicalinventorydetail` ADD COLUMN `afterQOH` int(15)";
                        
                    DB::statement($alter_query);
                }
            }
        }
        
        
        return "Updated table column(afterQOH): trn_physicalinventorydetail";
        
        
    }
    
    public function search_item(){
        //print_r("test");die;
     
        $all_stores=Store::all();
        foreach($all_stores as $store){
         
            $db = 'u'.$store->id;
            
            echo "Selected {$db} ".'<br>';
            $check_db_query = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '".$db."'";
            
            $run_check_db_query = DB::Select(DB::raw($check_db_query));
            
            if(count($run_check_db_query) === 0){
                
                echo "Database: {$db} does not exist.<br>";
                
                continue;
            }
            
            $result1 = DB::Select(DB::raw("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE = 'BASE TABLE' AND TABLE_NAME='mst_item' AND TABLE_SCHEMA='".$db."'"));
            if(count($result1)){
                $result = DB::Select(DB::raw("SELECT vitemname, vbarcode, dunitprice, iitemid FROM ".$db.".mst_item WHERE vitemname = 'CASAMIGOS BLANCO TEQUILA 750ml' "));
                // dd(count($result));
            
                if(count($result)){
                    
                    print_r($db);
                    print_r($result);
                }
            }
        }
        
        
        return "completed";
        
        
    }
    
    /*public function add_inv() {
       // print_r("test");die;
        
        $stores = Store::all();
        $store_array = array();
        foreach ($stores as $storesData) {
           $store_array[$storesData->id] = $storesData->id;
           $db = 'u'.$storesData->id;
           
           $check_table_query = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '{$db}' ";
           
           $run_check_table_query = DB::select($check_table_query);
           
           //dd($run_check_table_query);
           if(count($run_check_table_query)===0){
               //print_r($storesData->id);
               
                $sql="CREATE TABLE IF NOT EXISTS {$db}.`trn_inv_snapshot` (
                    `ssid` int(11) NOT NULL AUTO_INCREMENT,
                    `itemid` varchar(45) DEFAULT NULL,
                    `barcode` varchar(45) DEFAULT NULL,
                    `month_year` varchar(45) DEFAULT NULL,
                    `dt1` int(11) DEFAULT NULL,
                    `dt2` int(11) DEFAULT NULL,
                      `dt3` int(11) DEFAULT NULL,
                      `dt4` int(11) DEFAULT NULL,
                      `dt5` int(11) DEFAULT NULL,
                      `dt6` int(11) DEFAULT NULL,
                      `dt7` int(11) DEFAULT NULL,
                      `dt8` int(11) DEFAULT NULL,
                      `dt9` int(11) DEFAULT NULL,
                      `dt10` int(11) DEFAULT NULL,
                      `dt11` int(11) DEFAULT NULL,
                      `dt12` int(11) DEFAULT NULL,
                      `dt13` int(11) DEFAULT NULL,
                      `dt14` int(11) DEFAULT NULL,
                      `dt15` int(11) DEFAULT NULL,
                      `dt16` int(11) DEFAULT NULL,
                      `dt17` int(11) DEFAULT NULL,
                      `dt18` int(11) DEFAULT NULL,
                      `dt19` int(11) DEFAULT NULL,
                      `dt20` int(11) DEFAULT NULL,
                      `dt21` int(11) DEFAULT NULL,
                      `dt22` int(11) DEFAULT NULL,
                      `dt23` int(11) DEFAULT NULL,
                      `dt24` int(11) DEFAULT NULL,
                      `dt25` int(11) DEFAULT NULL,
                      `dt26` int(11) DEFAULT NULL,
                      `dt27` int(11) DEFAULT NULL,
                      `dt28` int(11) DEFAULT NULL,
                      `dt29` int(11) DEFAULT NULL,
                      `dt30` int(11) DEFAULT NULL,
                      `dt31` int(11) DEFAULT NULL,
                      PRIMARY KEY (`ssid`)
                )";
                
                echo "Selected database: {$db}<br />";
                try{
                    $created = DB::statement($sql);
                    echo "Table created";
                }
                catch(Exception $e){
                    echo $e->getMessage();
                }
            } else {
                echo "Database {$db} does not exist.";
            }
         
                // echo $sql;die;
                // $created = DB::statement($sql);
            echo '<br />';
        }

    }*/
    
    // public function add_inv(){
    //     // $all_stores = Store::where('id', '100523')->get();
        
    //     // return $all_stores;
        
    //     $all_stores=Store::all();
    //     //return $all_stores;
    //     foreach($all_stores as $store){
         
    //         $db = 'u'.$store->id;
            
    //         echo "Selected {$db} ".'<br>';
    //         $check_db_query = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '".$db."'";
            
    //         $run_check_db_query = DB::Select(DB::raw($check_db_query));
            
    //         if(count($run_check_db_query) === 0){
                
    //             echo "Database: {$db} does not exist.<br>";
                
    //             continue;
    //         }
    //         $sql="CREATE TABLE IF NOT EXISTS {$db}.`trn_inv_snapshot` (
    //                 `ssid` int(11) NOT NULL AUTO_INCREMENT,
    //                 `itemid` varchar(45) DEFAULT NULL,
    //                 `barcode` varchar(45) DEFAULT NULL,
    //                 `month_year` varchar(45) DEFAULT NULL,
    //                 `dt1` int(11) DEFAULT NULL,
    //                 `dt2` int(11) DEFAULT NULL,
    //                   `dt3` int(11) DEFAULT NULL,
    //                   `dt4` int(11) DEFAULT NULL,
    //                   `dt5` int(11) DEFAULT NULL,
    //                   `dt6` int(11) DEFAULT NULL,
    //                   `dt7` int(11) DEFAULT NULL,
    //                   `dt8` int(11) DEFAULT NULL,
    //                   `dt9` int(11) DEFAULT NULL,
    //                   `dt10` int(11) DEFAULT NULL,
    //                   `dt11` int(11) DEFAULT NULL,
    //                   `dt12` int(11) DEFAULT NULL,
    //                   `dt13` int(11) DEFAULT NULL,
    //                   `dt14` int(11) DEFAULT NULL,
    //                   `dt15` int(11) DEFAULT NULL,
    //                   `dt16` int(11) DEFAULT NULL,
    //                   `dt17` int(11) DEFAULT NULL,
    //                   `dt18` int(11) DEFAULT NULL,
    //                   `dt19` int(11) DEFAULT NULL,
    //                   `dt20` int(11) DEFAULT NULL,
    //                   `dt21` int(11) DEFAULT NULL,
    //                   `dt22` int(11) DEFAULT NULL,
    //                   `dt23` int(11) DEFAULT NULL,
    //                   `dt24` int(11) DEFAULT NULL,
    //                   `dt25` int(11) DEFAULT NULL,
    //                   `dt26` int(11) DEFAULT NULL,
    //                   `dt27` int(11) DEFAULT NULL,
    //                   `dt28` int(11) DEFAULT NULL,
    //                   `dt29` int(11) DEFAULT NULL,
    //                   `dt30` int(11) DEFAULT NULL,
    //                   `dt31` int(11) DEFAULT NULL,
    //                   PRIMARY KEY (`ssid`)
    //             )";
    //             $created = DB::statement($sql);
    //                 echo "Table created";
    //     }
    // }
}