<?php

namespace pos2020\Http\Controllers\Admin;

use Request;
use pos2020\Http\Controllers\Controller;
use pos2020\Http\Requests;
use Validator;
use pos2020\custMob;
use pos2020\Store;
use pos2020\storeComputer;
use pos2020\MST_CUSTOMER;
use DB;

class CustmobController extends Controller
{
    public function temporary_insert_mobile(Request $request){
        
        $input = Request::all();
        
        // Validation
        if(!isset($input['sid'])){
            return response()->json(['error' => 'It is manadatory to send sid', 'status' => 'error'], 400);
        }
        
        if(!isset($input['reg_no'])){
            return response()->json(['error' => 'It is manadatory to send reg_no', 'status' => 'error'], 400);

        }
        
        if(!isset($input['mobile_no'])){
            return response()->json(['error' => 'It is manadatory to send mobile_no', 'status' => 'error'], 400);
        }


        
        // Check if the store exists in the database;
        $store = Store::find($input['sid']);
        if(empty($store)){
           return response()->json(['error' => 'That store does not exist in the database.', 'status' => 'error'], 400); 
        }
        
        // Check if the register exists in the store
        $store_computer = storeComputer::where('store_id', '=', $input['sid'])->where('uid','=',$input['reg_no'])->first();
        if(empty($store_computer)){
           return response()->json(['error' => 'That register does not exist in the store.', 'status' => 'error'], 400); 
        }
        
        // Check if the entered mobile number exists in the mst_customer table of the relevant db
        
        $db = "u".$input['sid'];
        
        $query_db = 'USE DATABASE '.$db;
        
        DB::raw($query_db);
        
        $phone = (string)$input['mobile_no'];
        
        $query_select = "SELECT * FROM ".$db.".mst_customer WHERE vphone=?";
        
        $customer = DB::select($query_select, array($phone));

        if(empty($customer)){
            return response()->json(['error' => 'Un-registered Customer.', 'status' => 'error'], 200);
        } else {
            
            $cust = custMob::where('sid', '=', $input['sid'])->where('reg_no','=',$input['reg_no'])->first();
            
            if(isset($cust->id)){
            
                // Update
                $cust->mobile_no = $input['mobile_no'];
                $cust->taken = 0;
                $cust->save();
            } else {
                
                // Insert
                $cust = new custMob;
                $cust->sid = $input['sid'];
                $cust->reg_no = $input['reg_no'];
                $cust->mobile_no = $input['mobile_no'];
                $cust->taken = 0;
                $cust->save();
            }
            
            
            return response()->json(['message' => 'Thank you for your co-operation.', 'status' => 'ok'], 200);
        }
    }
    
    
    public function get_mobile(Request $request){
        
        $input = Request::all();
        
        // Validation
        if(!isset($input['sid'])){
            return response()->json(['error' => 'It is mandatory to send sid', 'status' => 'error'], 400);
        }
        
        if(!isset($input['reg_no'])){
            return response()->json(['error' => 'It is mandatory to send reg_no', 'status' => 'error'], 400);
        }
        
        // Check if the store exists in the database;
        $store = Store::find($input['sid']);
        if(!isset($store->id)){
           return response()->json(['error' => 'That store does not exist in the database.', 'status' => 'error'], 400); 
        }
        
        // Check if the register exists in the store
        $store_computer = storeComputer::where('store_id', '=', $input['sid'])->where('uid','=',$input['reg_no'])->first();
        if(!isset($store_computer->uid) || empty($store_computer)){
           return response()->json(['error' => 'That register does not exist in the store.', 'status' => 'error'], 400); 
        }
        
        $cust = custMob::where('sid', '=', $input['sid'])->where('reg_no','=',$input['reg_no'])->where('taken','=',0)->first();
        
        if(isset($cust->id)){
            
            $cust->taken = 1;
            $cust->save();
            
            return response()->json(['message' => $cust->mobile_no, 'status' => 'ok'], 200);            
        } else {
            
            return response()->json(['error' => 'No relevant data present in the database.', 'status' => 'error'], 200);
        }
        
    }
    
    
    public function insert_mobile_customer(Request $request){
        
        $input = Request::all();
        
        // Validation
        if(!isset($input['sid'])){
            return response()->json(['error' => 'It is manadatory to send sid', 'status' => 'error'], 400);
        }
        
        if(!isset($input['reg_no'])){
            return response()->json(['error' => 'It is manadatory to send reg_no', 'status' => 'error'], 400);

        }
        
        if(!isset($input['mobile_no'])){
            return response()->json(['error' => 'It is manadatory to send mobile_no', 'status' => 'error'], 400);
        }
        
        // Check if the entered mobile number exists in the mst_customer table of the relevant db
        
        $db = "u".$input['sid'];
        
        $query_db = 'USE DATABASE '.$db;
        
        DB::raw($query_db);
        
        $phone = (string)$input['mobile_no'];
        
        $query_select = "SELECT * FROM ".$db.".mst_customer WHERE vphone=?";
        
        $customer = DB::select($query_select, array($phone));
        
        if(empty($customer)){
            
            //Insert into mob_cust table
            $cust = custMob::where('sid', '=', $input['sid'])->where('reg_no','=',$input['reg_no'])->first();
            
            if(isset($cust->id)){
            
                // Update
                $cust->mobile_no = $input['mobile_no'];
                $cust->taken = 0;
                $cust->save();
            } else {
                
                // Insert
                $cust = new custMob;
                $cust->sid = $input['sid'];
                $cust->reg_no = $input['reg_no'];
                $cust->mobile_no = $input['mobile_no'];
                $cust->taken = 0;
                $cust->save();
            }
            
            

            $account_first_part = "ALC";
            
            $like_account = "%".$account_first_part."%";
            
            $query_check_ac_no = "SELECT icustomerid, vaccountnumber FROM ".$db.".mst_customer WHERE vaccountnumber LIKE ? ORDER BY icustomerid DESC LIMIT 1";
            
            $matching_records = DB::select($query_check_ac_no, array($like_account));
            
            $account_second_part = isset($matching_records[0])?(int)substr($matching_records[0]->vaccountnumber, 3)+1:1000000;
            
            
            $new_ac_number = $account_first_part.$account_second_part;
            
            
            $insert_query = 'INSERT INTO '.$db.'.mst_customer (vcustomername, vtaxable, vaccountnumber, vphone, estatus, sid, note) VALUES (?, ?, ?, ?, ?, ?, ?)';
            
            $return = DB::statement($insert_query, array($phone, 'Yes', $new_ac_number, $phone, 'Active', $input['sid'], 'Inserted By API'));
            
            
            
            //====================== Send SMS ============================
            
            // get the parameters needed
            $message = "Test Message\nThank you for registering with us.\nYour account no. is ".$new_ac_number."\nAlberta Team.";
            $message = urlencode($message);
            
            $api_key = "6u69665t3171ar1eqlberiv452ozenafh";
            $sender_id = "SEDEMO";
            
            $to = $input['mobile_no'];
            
		    $params = "web/send/?apikey=$api_key&sender=$sender_id&to=$to&message=$message";
		    
		    $api_url = 'http://instantalerts.co/api/';
		    
		    $eurl = $api_url.$params;	
		    
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_POST, 0);
            curl_setopt($ch, CURLOPT_URL, $eurl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $output = curl_exec($ch);
            curl_close($ch);
		//$output = file_get_contents($eurl);
            // return $output;	
            
            
            
            
            
            return response()->json(['message' => 'Thank you for registering.', 'status' => 'ok'], 200);
            
        }
            
        return response()->json(['error' => 'The details of that customer already exists in the database.', 'status' => 'error'], 400);
;
    }

}