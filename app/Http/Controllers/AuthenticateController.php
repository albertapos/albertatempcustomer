<?php
namespace pos2020\Http\Controllers;
use Illuminate\Http\Request;
use pos2020\Http\Requests;
use pos2020\Http\Controllers\Controller;
use pos2020\Store;
use DB;

use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthenticateController extends Controller
{
    public function authenticate(Request $request)
    {
        // grab credentials from the request
        $credentials = $request->only('email', 'password');

        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        // all good so return the token
        return response()->json(compact('token'));
    }

    public function getUserByToken(){
        $userObj = JWTAuth::parseToken()->toUser();
        $user = $userObj->toArray();
        
        $roles = $userObj->roles()->get()->toArray();
        $user['roles'] = [];
        foreach($roles as $k => $role){
            
            if(isset($role['name'])){
                $user['roles'][]= $role;
            }
        }
        
        if($userObj->roles()->first()->name == 'Admin') {
            $stores  =  Store::all()->toArray();
        } else {
            $stores  = $userObj->store->toArray();    
        }
        
        $user['stores'] = [];
        foreach($stores as $k => $store){
            
            // if($store['id'] != 1097) { continue;}
            
            $db = "u".$store['id'];
        
            $query_db = 'USE DATABASE '.$db;
            
            
        
            DB::raw($query_db);
          
        
            // $query = "SELECT sum(case when vtrntype='Transaction' then nnettotal else 0.00 end) sales, sum(case when vtrntype='Void' then 1 else 0 end) voids, (SELECT count(*) deletes FROM " . $db . ".mst_deleteditem where date(LastUpdate)=date(current_date())) deletes FROM " . $db . ".trn_sales where vtrntype in ('Void','Transaction') and date(dtrandate)=date(current_date())";
            
            $query = "SELECT ifnull(sum(case when vtrntype='Transaction' then nnettotal else 0.00 end),0) sales, 
            ifnull(sum(case when vtrntype='No Sale' then 1 else 0 end),0) No_Sales ,
            ifnull(sum(case when vtrntype='Transaction' then ntaxtotal else 0.00 end),0) tax, ifnull(sum(case when vtrntype='Void' then 1 else 0 end),0) voids, (SELECT count(*) deletes 
        	FROM ".$db.".mst_deleteditem where date(LastUpdate)=date(current_date()))
        	deletes, (select ifnull(sum(namount),0) from ".$db.".trn_paidout 
        	tp join ".$db.".trn_paidoutdetail tpd on tp.ipaidouttrnid=tpd.ipaidouttrnid where 
        	date(tp.ddate)=date(current_date())) paidout, (select ifnull( sum(nextunitprice),0) 
           from ".$db.".trn_salesdetail tsd join ".$db.".trn_sales ts on tsd.isalesid=ts.isalesid 
           where date(ts.dtrandate)=date(current_date()) and ndebitqty<0 ) rtrn FROM ".$db.".trn_sales where vtrntype in 
            ('Void','Transaction','No Sale') and date(dtrandate)=date(current_date())";
            
            $select = DB::select(DB::raw($query));
            
            // echo $query; die;
            
            // echo $db.": ".json_encode($select).PHP_EOL;
            
            $exist="SELECT * FROM information_schema.tables WHERE table_schema = '".$db."' AND table_name = 'mst_version' LIMIT 1";
         //echo  $exist;die;
            $exist_records = DB::select($exist);

        
              if(count($exist_records) > 0)
              {
                    $user['stores'][$k] = $store;
                    $user['stores'][$k]['voids'] = (int)$select[0]->voids;
                    $user['stores'][$k]['sales'] = $select[0]->sales === NULL?0.00:number_format($select[0]->sales,2);
                    $user['stores'][$k]['deletes'] = (int)$select[0]->deletes;
                    $user['stores'][$k]['tax'] = number_format($select[0]->tax,2);
                    $user['stores'][$k]['paid_out'] = $select[0]->paidout;
                    $user['stores'][$k]['No_Sales'] = $select[0]->No_Sales;
                    $user['stores'][$k]['returns'] = $select[0]->rtrn;  
                    $user['stores'][$k]['isnewdatabase'] = 1;
              }else{

                    $user['stores'][$k] = $store;
                    $user['stores'][$k]['voids'] = (int)$select[0]->voids;
                    $user['stores'][$k]['sales'] = $select[0]->sales === NULL?0.00:number_format($select[0]->sales,2);
                    $user['stores'][$k]['deletes'] = (int)$select[0]->deletes;
                    $user['stores'][$k]['tax'] = number_format($select[0]->tax,2);
                    $user['stores'][$k]['paid_out'] = $select[0]->paidout;
                    $user['stores'][$k]['No_Sales'] = $select[0]->No_Sales;
                    $user['stores'][$k]['returns'] = $select[0]->rtrn;   
                    $user['stores'][$k]['isnewdatabase'] = 0;
              }
            
            
            
        }
        
        // die;
        
        return response()->json(compact('user'));
    }
    
    
    public function getStoreDetail($sid){
        
            
            
            // if($store['id'] != 1097) { continue;}
            
            $db = "u".$sid;
        
            $query_db = 'USE DATABASE '.$db;
            
            
        
            DB::raw($query_db);
            
            
            // $query = "SELECT sum(case when vtrntype='Transaction' then nnettotal else 0.00 end) sales, sum(case when vtrntype='Void' then 1 else 0 end) voids, (SELECT count(*) deletes FROM " . $db . ".mst_deleteditem where date(LastUpdate)=date(current_date())) deletes FROM " . $db . ".trn_sales where vtrntype in ('Void','Transaction') and date(dtrandate)=date(current_date())";
            
            
            
            $query = "SELECT ifnull(sum(case when vtrntype='Transaction' then nnettotal else 0.00 end),0) sales, ifnull(sum(case when vtrntype='Transaction' then ntaxtotal else 0.00 end),0) tax, ifnull(sum(case when vtrntype='Void' then 1 else 0 end),0) voids, (SELECT count(*) deletes 
	FROM ".$db.".mst_deleteditem where date(LastUpdate)=date(current_date())) deletes, (select ifnull(sum(namount),0) from ".$db.".trn_paidout tp join ".$db.".trn_paidoutdetail tpd on tp.ipaidouttrnid=tpd.ipaidouttrnid where date(tp.ddate)=date(current_date())) paidout, (select ifnull( sum(nextunitprice),0) 
from ".$db.".trn_salesdetail tsd join ".$db.".trn_sales ts on tsd.isalesid=ts.isalesid where date(ts.dtrandate)=date(current_date()) and ndebitqty<0 ) rtrn FROM ".$db.".trn_sales where vtrntype in ('Void','Transaction') and date(dtrandate)=date(current_date())";
            
            $select = DB::select(DB::raw($query));
            
            
            $query_store = "SELECT id, name, description, phone, address, country, state, city, zip FROM inslocdb.stores WHERE id=".$sid;
            
            $run_query_store = DB::select(DB::raw($query_store));
            
            // echo $query; die;
            
            // echo $db.": ".json_encode($select).PHP_EOL;
            
            $store = [];
            
            // return (array)$run_query_store[0];
            
            $store = (array)$run_query_store[0];
            $store['voids'] = (int)$select[0]->voids;
            $store['sales'] = $select[0]->sales === NULL?0.00:number_format($select[0]->sales,2);
            $store['deletes'] = (int)$select[0]->deletes;
            $store['tax'] = number_format($select[0]->tax,2);
            $store['paid_out'] = $select[0]->paidout;
            $store['returns'] = $select[0]->rtrn;   
            
            
            // return $store;
            

        
        // die;
        
        return response()->json($store);
    }
     public function getStoreDetailBydate(Request $request){
        
           $input = $request->all();
           $sid = $input['sid'];
           
           $sdate=date("Y-m-d", strtotime($input['sdate']));
           
            
            // if($store['id'] != 1097) { continue;}
            
            $db = "u".$sid;
            
            $query_db = 'USE DATABASE '.$db;
            
            
        
            DB::raw($query_db);
            
            
            // $query = "SELECT sum(case when vtrntype='Transaction' then nnettotal else 0.00 end) sales, sum(case when vtrntype='Void' then 1 else 0 end) voids, (SELECT count(*) deletes FROM " . $db . ".mst_deleteditem where date(LastUpdate)=date(current_date())) deletes FROM " . $db . ".trn_sales where vtrntype in ('Void','Transaction') and date(dtrandate)=date(current_date())";
            
            
            
 $query = "SELECT ifnull(sum(case when vtrntype='Transaction' then nnettotal else 0.00 end),0) sales, ifnull(sum(case when vtrntype='Transaction' then ntaxtotal else 0.00 end),0) tax, ifnull(sum(case when vtrntype='Void' then 1 else 0 end),0) voids, (SELECT count(*) deletes 
	FROM ".$db.".mst_deleteditem where date(LastUpdate)=date($sdate)) deletes, (select ifnull(sum(namount),0) from ".$db.".trn_paidout tp join ".$db.".trn_paidoutdetail tpd on tp.ipaidouttrnid=tpd.ipaidouttrnid where date(tp.ddate)=date($sdate)) paidout, (select ifnull( sum(nextunitprice),0) 
from ".$db.".trn_salesdetail tsd join ".$db.".trn_sales ts on tsd.isalesid=ts.isalesid where date(ts.dtrandate)=date($sdate) and ndebitqty<0 ) rtrn FROM ".$db.".trn_sales where vtrntype in ('Void','Transaction') and date(dtrandate)=date($sdate)";
            
            $select = DB::select(DB::raw($query));
            
            
            $query_store = "SELECT id, name, description, phone, address, country, state, city, zip FROM inslocdb.stores WHERE id=".$sid;
            
            $run_query_store = DB::select(DB::raw($query_store));
            
            // echo $query; die;
            
            // echo $db.": ".json_encode($select).PHP_EOL;
            
            $store = [];
            
            // return (array)$run_query_store[0];
            
            $store = (array)$run_query_store[0];
            $store['voids'] = (int)$select[0]->voids;
            $store['sales'] = $select[0]->sales === NULL?0.00:number_format($select[0]->sales,2);
            $store['deletes'] = (int)$select[0]->deletes;
            $store['tax'] = number_format($select[0]->tax,2);
            $store['paid_out'] = $select[0]->paidout;
            $store['returns'] = $select[0]->rtrn;   
            
            
            // return $store;
            

        
        // die;
        
        return response()->json($store);
    }
    public function getUserByToken_new_date(Request $request){
        $input      = $request->all();
        $dateformat = date_create_from_format('m-d-Y', $input['date']);
        $date       = date_format($dateformat,'Y-m-d');
           
        $userObj    = JWTAuth::parseToken()->toUser();
        
        
        // dd($userObj);
        $user       = $userObj->toArray();
        // print_r($user);die;
        $user['email'] = $user['vemail'];
        unset($user['vemail']);
        
        if($user['user_role'] =='SuperAdmin')
        {
            $stores  = Store::all()->toArray();
        } 
        else if($user['user_role'] =='StoreAdmin')
        {
            $storesQuery  = "SELECT stores.* FROM inslocdb.user_stores us JOIN inslocdb.stores stores on stores.id = us.store_id WHERE us.user_id = '".$user['iuserid']."' ";    
            $stores = DB::select($storesQuery);
            $stores = json_decode(json_encode((array) $stores), true);
        }
        else
        {
            $storesQuery  = "SELECT stores.* FROM inslocdb.stores WHERE id = '".$user['sid']."' "; 
            $stores = DB::select($storesQuery);
            $stores = json_decode(json_encode((array) $stores), true);
        }
// return $stores;
        $user['stores'] = [];
        
        // return $user;
        
        foreach($stores as $k => $store){
            
            $db = "u".$store['id'];
            
            $query_db_exists = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '".$db."'";
                
            $run_db_exists = DB::select($query_db_exists);
            
            if (count($run_db_exists) === 0){ continue; }
            
            
            
            $query_table_exists = "SELECT * FROM information_schema.tables WHERE table_schema = '".$db."' AND table_name = 'trn_sales' LIMIT 1";

            $run_table_exists = DB::select($query_table_exists);
            
            if (count($run_table_exists) === 0){ continue; }
            
            
            
            $query_db = 'USE DATABASE '.$db;
        
            DB::raw($query_db);
          
        
        
            /*$query = "SELECT sum(case when vtrntype='Transaction' then nnettotal else 0.00 end) sales, sum(case when vtrntype='Void' then 1 else 0 end) voids, (SELECT count(*) deletes FROM " . $db . ".mst_deleteditem where date(LastUpdate)=date(current_date())) deletes FROM " . $db . ".trn_sales where vtrntype in ('Void','Transaction') and date(dtrandate)=date(current_date())";*/
            
        //     $query = "SELECT ifnull(sum(case when vtrntype='Transaction' then nnettotal else 0.00 end),0) sales, 
        //     ifnull(sum(case when vtrntype='No Sale' then 1 else 0 end),0) No_Sales ,
        //     ifnull(sum(case when vtrntype='Transaction' then ntaxtotal else 0.00 end),0) tax, ifnull(sum(case when vtrntype='Void' then 1 else 0 end),0) voids, (SELECT count(*) deletes 
        // 	FROM ".$db.".mst_deleteditem where date(LastUpdate)=date(current_date()))
        // 	deletes, (select ifnull(sum(namount),0) from ".$db.".trn_paidout 
        // 	tp join ".$db.".trn_paidoutdetail tpd on tp.ipaidouttrnid=tpd.ipaidouttrnid where 
        // 	date(tp.ddate)=date(current_date())) paidout, (select ifnull( sum(nextunitprice),0) 
        //   from ".$db.".trn_salesdetail tsd join ".$db.".trn_sales ts on tsd.isalesid=ts.isalesid 
        //   where date(ts.dtrandate)=date(current_date()) and ndebitqty<0 ) rtrn FROM ".$db.".trn_sales where vtrntype in 
        //     ('Void','Transaction','No Sale') and date(dtrandate)=date(current_date())";
           // echo $query;die;
            // $query = "SELECT ifnull(sum(case when vtrntype='Transaction' then nnettotal else 0.00 end),0) sales,
            // ifnull(sum(case when vtrntype='No Sale' then 1 else 0 end),0) No_Sales ,
            // ifnull(sum(case when vtrntype='Transaction' then ntaxtotal else 0.00 end),0) tax, ifnull(sum(case when vtrntype='Void'
            // then 1 else 0 end),0) voids, (SELECT count(*) deletes
            // FROM ".$db.".mst_deleteditem where date_format(LastUpdate, '%Y-%m-%d')=current_date())
            // deletes, (select ifnull(sum(namount),0) from ".$db.".trn_paidout
            // tp join ".$db.".trn_paidoutdetail tpd on tp.ipaidouttrnid=tpd.ipaidouttrnid where
            // date(tp.ddate)=date(current_date())) paidout, (select ifnull( sum(nextunitprice),0)
            // from ".$db.".trn_salesdetail tsd join ".$db.".trn_sales ts on tsd.isalesid=ts.isalesid
            // where date_format(ts.dtrandate, '%Y-%m-%d')=current_date() and ndebitqty<0 ) rtrn FROM ".$db.".trn_sales where 
            // vtrntype in('Void','Transaction','No Sale') 
            // and date_format(dtrandate, '%Y-%m-%d' )=current_date()";
            
            $query = "SELECT ifnull(sum(case when vtrntype='Transaction' then nnettotal else 0.00 end),0) sales,
            ifnull(sum(case when vtrntype='No Sale' then 1 else 0 end),0) No_Sales ,
            ifnull(sum(case when vtrntype='Transaction' then ntaxtotal else 0.00 end),0) tax, ifnull(sum(case when vtrntype='Void'
            then 1 else 0 end),0) voids, (SELECT count(*) deletes
            FROM ".$db.".mst_deleteditem where date_format(LastUpdate, '%Y-%m-%d')='" . $date . "')
            deletes, (select ifnull(sum(namount),0) from ".$db.".trn_paidout
            tp join ".$db.".trn_paidoutdetail tpd on tp.ipaidouttrnid=tpd.ipaidouttrnid where
            date(tp.ddate)=date(current_date())) paidout, (select ifnull( sum(nextunitprice),0)
            from ".$db.".trn_salesdetail tsd join ".$db.".trn_sales ts on tsd.isalesid=ts.isalesid
            where date_format(ts.dtrandate, '%Y-%m-%d')=current_date() and ndebitqty<0 ) rtrn FROM ".$db.".trn_sales where 
            vtrntype in('Void','Transaction','No Sale') 
            and date_format(dtrandate, '%Y-%m-%d' )='" . $date . "'";
            //echo $query;die;
            $select = DB::select(DB::raw($query));
            
            $exist="SELECT * FROM information_schema.tables WHERE table_schema = '".$db."' AND table_name = 'mst_version' LIMIT 1";
            
            $exist_records = DB::select($exist);
            
            // if(!isset($user['stores'][$k])){
            //     $user['stores'][$k]=[];
                
            // }
            
            // return $k;
            
            $temp_array = [];
          
            if(count($exist_records) > 0) {
              
                // $user['stores'][$k]['id'] = "23456";
                $temp_array['id'] = (int)$store['id'];
                $temp_array['name'] = $store['name'];
                $temp_array['description'] = $store['description'];
                $temp_array['phone'] = $store['phone'];
                $temp_array['address'] = $store['address'];
                $temp_array['country'] = $store['country'];
                $temp_array['state'] = $store['state'];
                $temp_array['zip'] = $store['zip'];
                $temp_array['SID'] = isset($store['SID']) ? (int)$store['SID'] : (int)$store['id'];
                $temp_array['country'] = $store['country'];
                
                $temp_array['voids'] = (int)$select[0]->voids;
                $temp_array['sales'] = $select[0]->sales === NULL?0.00:number_format($select[0]->sales,2);
                $temp_array['deletes'] = (int)$select[0]->deletes;
                $temp_array['tax'] = number_format($select[0]->tax,2);
                $temp_array['paid_out'] = $select[0]->paidout;
                $temp_array['No_Sales'] = $select[0]->No_Sales;
                $temp_array['returns'] = $select[0]->rtrn;  
                $temp_array['isnewdatabase'] = 1;
                
            }else{
                
                // $user['stores'][$k]['id'] = "12345";
                
                $temp_array['id'] = (int)$store['id'];
                $temp_array['name'] = $store['name'];
                $temp_array['description'] = $store['description'];
                $temp_array['phone'] = $store['phone'];
                $temp_array['address'] = $store['address'];
                $temp_array['country'] = $store['country'];
                $temp_array['state'] = $store['state'];
                $temp_array['zip'] = $store['zip'];
                $temp_array['SID'] = isset($store['SID']) ? (int)$store['SID'] : (int)$store['id'];
                
                
                $temp_array['voids'] = (int)$select[0]->voids;
                $temp_array['sales'] = $select[0]->sales === NULL?0.00:number_format($select[0]->sales,2);
                $temp_array['deletes'] = (int)$select[0]->deletes;
                $temp_array['tax'] = number_format($select[0]->tax,2);
                $temp_array['paid_out'] = $select[0]->paidout;
                $temp_array['No_Sales'] = $select[0]->No_Sales;
                $temp_array['returns'] = $select[0]->rtrn;   
                $temp_array['isnewdatabase'] = 0;
            }
            
            $user['stores'][] = $temp_array;
            
        }
        //return $user;
        
        //return gettype($user['stores']);
        
        // $user['stores'] = (array)$user['stores'];
        
        $user['iuserid'] = (int)$user['iuserid'];
        
        return response()->json(compact('user'));
    }
     public function getStoreDetail_new($sid, Request $request){
        
            $input = $request->all();
           // return $input;
            // if($store['id'] != 1097) { continue;}
            
            $db = "u".$sid;
        
            $query_db = 'USE DATABASE '.$db;
            
            
        
            DB::raw($query_db);
            
            
            // $query = "SELECT sum(case when vtrntype='Transaction' then nnettotal else 0.00 end) sales, sum(case when vtrntype='Void' then 1 else 0 end) voids, (SELECT count(*) deletes FROM " . $db . ".mst_deleteditem where date(LastUpdate)=date(current_date())) deletes FROM " . $db . ".trn_sales where vtrntype in ('Void','Transaction') and date(dtrandate)=date(current_date())";
            
            if(isset($input['date'])){
                
                $myDateTime = \DateTime::createFromFormat('m-d-Y', $input['date']);
                $input['date'] = $myDateTime->format('Y-m-d');
                
                $date = "date('".$input['date']."')";
            } else {
               $date = "date(current_date())"; 
            }
            
            // return $date;
            
        //$query = "SELECT ifnull(sum(case when vtrntype='Transaction' then nnettotal else 0.00 end),0) sales, ifnull(sum(case when vtrntype='Transaction' then ntaxtotal else 0.00 end),0) tax, ifnull(sum(case when vtrntype='Void' then 1 else 0 end),0) voids, (SELECT count(*) deletes 
        // 	FROM ".$db.".mst_deleteditem where date(LastUpdate)=".$date.") deletes, (select ifnull(sum(namount),0) from ".$db.".trn_paidout tp join ".$db.".trn_paidoutdetail tpd on tp.ipaidouttrnid=tpd.ipaidouttrnid where date(tp.ddate)=".$date.") paidout, (select ifnull( sum(nextunitprice),0) 
        // from ".$db.".trn_salesdetail tsd join ".$db.".trn_sales ts on tsd.isalesid=ts.isalesid where date(ts.dtrandate)=".$date." and ndebitqty<0 ) rtrn FROM ".$db.".trn_sales where vtrntype in ('Void','Transaction') and date(dtrandate)=".$date."";
             $query = "SELECT ifnull(sum(case when vtrntype='Transaction' then nnettotal else 0.00 end),0) sales, ifnull(sum(case when vtrntype='Transaction' then ntaxtotal else 0.00 end),0) tax, ifnull(sum(case when vtrntype='Void' then 1 else 0 end),0) voids,ifnull(sum(case when vtrntype='No Sale' then 1 else 0 end),0) nosale,  (SELECT count(*) deletes 
	         FROM ".$db.".mst_deleteditem where date(LastUpdate)=".$date.") deletes, (select ifnull(sum(namount),0) from ".$db.".trn_paidout tp join ".$db.".trn_paidoutdetail tpd on tp.ipaidouttrnid=tpd.ipaidouttrnid where date(tp.ddate)=".$date.") paidout, (select ifnull( sum(nextunitprice),0) 
             from ".$db.".trn_salesdetail tsd join ".$db.".trn_sales ts on tsd.isalesid=ts.isalesid where date(ts.dtrandate)=".$date." and ndebitqty<0 ) rtrn FROM ".$db.".trn_sales where vtrntype in ('Void','Transaction','No Sale') and date(dtrandate)=".$date."";
         
            // echo $query = "SELECT current_date()";
            
           //echo $query;die;
            
            $select = DB::select(DB::raw($query));
            
            // print_r($select); die;
            
            $query_store = "SELECT id, name, description, phone, address, country, state, city, zip FROM inslocdb.stores WHERE id=".$sid;
            
            $run_query_store = DB::select(DB::raw($query_store));
            
            // echo $query; die;
            
            // echo $db.": ".json_encode($select).PHP_EOL;
            
            $store = [];
            
            // return (array)$run_query_store[0];
            
            $store = (array)$run_query_store[0];
            $store['voids'] = (int)$select[0]->voids;
            $store['sales'] = $select[0]->sales === NULL?0.00:number_format($select[0]->sales,2);
            $store['No_Sales'] = (int)$select[0]->nosale;
            $store['deletes'] = (int)$select[0]->deletes;
            $store['tax'] = number_format($select[0]->tax,2);
            $store['paid_out'] = $select[0]->paidout;
            $store['returns'] = $select[0]->rtrn;   
            
            
            // return $store;
            

        
        // die;
        
        return response()->json($store);
    }
    
    /*public function authenticate_new(Request $request)
    
    {
        // grab credentials from the request
        \Config::set('jwt.user', "pos2020\StoreMwUsers");
        \Config::set('auth.providers.users.model', \pos2020\StoreMwUsers::class);
        
        $credentials = $request->only('email', 'password');
        $credentials =  ['vemail' => $request->email, 'password' => $request->password];
        // $credentials = $request->only('email', 'password');

        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        // all good so return the token
        return response()->json(compact('token'));
    }*/
    
    
    //development code transferred on June 26, 2020
    public function authenticate_new(Request $request)
    
    {
        
        // grab credentials from the request
        \Config::set('jwt.user', "pos2020\StoreMwUsers");
        \Config::set('auth.providers.users.model', \pos2020\StoreMwUsers::class);
        
        $credentials = $request->only('email', 'password');
        $credentials =  ['vemail' => $request->email, 'password' => $request->password];
        // $credentials = $request->only('email', 'password');

        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
            if (! $token = JWTAuth::invalidtoken($credentials)) {
                return response()->json(['error' => 'No Mobile Permission!!'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
        // all good so return the token
        return response()->json(compact('token'));
    }


}