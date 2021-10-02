<?php

namespace pos2020\Http\Controllers;

use Illuminate\Http\Request;

use pos2020\Http\Requests;
use pos2020\User;
use pos2020\Store;
use Hash;
use JWTAuth;
use DB;

class APIController extends Controller
{
    public function run_script(){
        
        $all_stores = Store::all();
        
        $error_log_mst_user = storage_path('logs/error_script_run_mst_user.log');
        $error_log_mst_version = storage_path('logs/error_script_run_mst_version.log');

        $mst_user_handle = fopen($error_log_mst_user, 'a');
        $mst_version_handle = fopen($error_log_mst_version, 'a');
        
        $mst_version_counter = $mst_user_counter = 0;
        
        foreach($all_stores as $store){
         
            $db = 'u'.$store->id;
            echo "Selected {$db} ".'<br>';
            
            $check_db_query = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '".$db."'";
            $run_check_db_query = DB::Select(DB::raw($check_db_query));
            
            if(count($run_check_db_query) === 0){
                echo "Database: {$db} does not exist.<br/><br/>";
                continue;
            }
         
            
            $databaseuser = "alberta";
            $databasepass = "Jalaram123$";
            $db_host = "albertapayments.cfixtkqw8bai.us-east-2.rds.amazonaws.com";
            $databasename = $db;
            
            try{
                $query = "CREATE TABLE IF NOT EXISTS `{$db}`.`mst_physical_inventory_assign_users` (
                              `assign_id` int(11) NOT NULL AUTO_INCREMENT,
                              `ipiid` int(11) NOT NULL,
                              `user_id` int(11) NOT NULL,
                              `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                              `SID` int(11) NOT NULL DEFAULT '{$store->id}',
                              `status` varchar(255) DEFAULT NULL,
                              PRIMARY KEY (`assign_id`)
                            );
                            
                            CREATE TABLE IF NOT EXISTS `{$db}`.`trn_physical_inventory_usercount` (
                              `piuc_id` int(11) NOT NULL AUTO_INCREMENT,
                              `ipiid` int(11) DEFAULT NULL,
                              `sku` varchar(255) DEFAULT NULL,
                              `physical_qty` varchar(255) DEFAULT NULL,
                              `user_id` int(11) DEFAULT NULL,
                              `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                              `SID` int(11) NOT NULL DEFAULT '{$store->id}',
                              PRIMARY KEY (`piuc_id`)
                            );";

                            
                $run = DB::statement($query);
                echo "Output of create permissions tables: ".json_encode($run);
            }
            catch (Exception $e) { print_r($e);}
            
            echo "<br/>";
            
            

            
            
            try{
                $check_db_query = "SELECT * FROM INFORMATION_SCHEMA.tables WHERE table_schema = '{$db}' AND TABLE_NAME = 'mst_user'";
                $run_check_db_query = DB::Select(DB::raw($check_db_query));
                
                if(count($run_check_db_query) !== 0){
                    $query = "ALTER TABLE `{$db}`.`mst_user` CHANGE COLUMN `mwpassword` `mwpassword` VARCHAR(255) NULL DEFAULT NULL ";
                        
                    $run = DB::statement($query);
                    echo "Output of insert command: ".json_encode($run);
                } else {
                    echo "Table: mst_user does not exist in {$db}.<br/>";
                    
                    $mst_user_counter++;
                    fwrite($mst_user_handle, "{$mst_user_counter}. {$db}".PHP_EOL);
                    // continue;
                }
            
                
                
            }
            catch (Exception $e) { print_r($e);}
            
            echo "<br/>";
            
            
            try{
                $check_db_query = "SELECT * FROM INFORMATION_SCHEMA.tables WHERE table_schema = '{$db}' AND TABLE_NAME = 'mst_version'";
                $run_check_db_query = DB::Select(DB::raw($check_db_query));
                
                if(count($run_check_db_query) !== 0){
                    $query = "UPDATE `{$db}`.`mst_version` SET update_dt=null WHERE ver_id='302' ";
                        
                    $run = DB::statement($query);
                    echo "Output of update command: ".json_encode($run);
                } else {
                    echo "Table: mst_version does not exist in {$db}.<br/>";
                    
                    $mst_version_counter++;
                    fwrite($mst_version_handle, "{$mst_version_counter}. {$db}".PHP_EOL);
                    // continue;
                }
            
                
                
            }
            catch (Exception $e) { print_r($e);}
            
            /*try{
                $output = exec("mysql -u" . $databaseuser . " -p" . $databasepass . " -h" . $db_host . " -D". $databasename . " < ". storage_path('stored_procedure_temp.sql'));
                echo "Ran create stored procedure from stored_procedure_temp.sql script: ".json_encode($output);
            }
            catch (Exception $e) { print_r($e);}
            
            echo "<br/>";*/
            
            
            

            /*try{
                $check_db_query = "SELECT * FROM INFORMATION_SCHEMA.tables WHERE table_schema = '{$db}' AND TABLE_NAME = 'mst_userpermissions'";
                $run_check_db_query = DB::Select(DB::raw($check_db_query));
                
                if(count($run_check_db_query) === 0){
                    echo "Table: mst_userpermissions does not exist in {$db}.<br/>";
                    fwrite($handle, $db.PHP_EOL);
                    continue;
                }
            
                $query = "insert into `{$db}`.`mst_userpermissions` (userid, permission_id,status,created_id)

                            select iuserid, vpermissioncode, 'Active' Status, 1 created_id from `{$db}`.`mst_permission` cross join `{$db}`.`mst_user`
                            where vpermissioncode in ('PER3011','PER3012') and vusertype='Admin' and estatus='Active' 
                            and iuserid not in (select distinct userid from `{$db}`.`mst_userpermissions`);";
                        
                $run = DB::statement($query);
                echo "Output of insert command: ".json_encode($run);
                
            }
            catch (Exception $e) { print_r($e);}*/

            echo "<br/><br/>";

        }
        
        fclose($mst_user_handle);fclose($mst_version_handle);
        
        return 'Done running the script in all stores.';
    }
    
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    
    public function userpermissionsAllStores(){
        //=========initiating the log file
        $file_location = 'user_permission.log';
        $myfile = fopen($file_location, "a") or die("Unable to open file!");
        $txt = PHP_EOL."Insertion Starting Date And time is: ".date("Y-m-d h:i:sa").PHP_EOL;
        fwrite($myfile, $txt);

        //============= getting all stores 
        $stores = DB::table('store_mw_users')
                    ->join('user_stores', 'store_mw_users.iuserid', '=', 'user_stores.user_id')
                    ->join('stores', 'user_stores.store_id', '=', 'stores.id')
                    ->orWhere('store_mw_users.user_role', '=', "StoreAdmin")
                    ->orWhere('store_mw_users.user_role', '=', "SuperAdmin")
                    ->get();
        
        //==========getting the master permission data
        $masterPerms = DB::table('mst_permission')->get();
        
        //==========looping through all stores
        $count_stores = count($stores);
        for($a=0; $a<$count_stores; $a++){
            $store_text = '========================== For '.$stores[$a]->db_name.'===================================='.PHP_EOL;
            fwrite($myfile, $store_text);
            
            //=======get the vpermissioncode from individual stores
            try{
                $onestorepermissions = DB::connection('mysql')->select("select distinct(vpermissioncode) from ".$stores[$a]->db_name.".mst_permission  ");
            }
            
            catch(\Exception $e){
                
                $message = $e->getMessage().PHP_EOL;
                // dd($message);
                fwrite($myfile, $message);
                continue;
            }
            $storeperms = array();
            foreach($onestorepermissions as $perm){
                array_push($storeperms, $perm->vpermissioncode);
            }
            
            // ===========loop through the master perms data
            $count_master_perms = count($masterPerms);
            for($x=0; $x < $count_master_perms; $x++){
                // ==========just check where vpermissioncode is exists in the array of the individual stores
                if(!in_array($masterPerms[$x]->vpermissioncode,  $storeperms)){ 
                    // ========== insert into the mst_permission
                    $insert_permission = "INSERT INTO ".$stores[$a]->db_name.".mst_permission
                            (vpermissioncode, vpermissionname, vmenuname, vpermissiontype, vppercode, ivorder, vdesc, etransferstatus, LastUpdate, SID)  
                        VALUES ('".$masterPerms[$x]->vpermissioncode."', '".$masterPerms[$x]->vpermissionname."', '".$masterPerms[$x]->vmenuname."', '".$masterPerms[$x]->vpermissiontype."', '".$masterPerms[$x]->vppercode."', '".$masterPerms[$x]->ivorder."', '".$masterPerms[$x]->vdesc."', '".$masterPerms[$x]->etransferstatus."', '".$masterPerms[$x]->LastUpdate."', '".$stores[$a]->store_id."' ) ";
                    DB::connection('mysql')->statement($insert_permission );
                    
                    $insert_permission .= PHP_EOL;
                    fwrite($myfile, $insert_permission);
                }
            }
        
            // ========get the data after running the insertion of the mst_permission for single store
            $singlestorepermissions = DB::connection('mysql')->select("select distinct(vpermissioncode) from ".$stores[$a]->db_name.".mst_permission where vpermissiontype = 'WEB' OR vpermissiontype = 'MOB'  ");
            
            try{
                $sameStoreUserPerms  = DB::connection('mysql')->select("SELECT permission_id FROM ".$stores[$a]->db_name.".mst_userpermissions where userid = '".$stores[$a]->iuserid."' ");
            }
            catch(\Exception $e){
                
                $message = $e->getMessage().PHP_EOL;
                fwrite($myfile, $message);
                continue;
            }
            
            $samestoresPermsArray = array();
            foreach($sameStoreUserPerms as $perms){
                array_push($samestoresPermsArray, $perms->permission_id);
            }

            $count_singlestorepermissions = count($singlestorepermissions);
            for($b=0; $b < $count_singlestorepermissions ; $b++){
                if(!in_array($singlestorepermissions[$b]->vpermissioncode, $samestoresPermsArray )){
                    $user_perms_insert = "INSERT INTO ".$stores[$a]->db_name.".mst_userpermissions(userid, permission_id, status, created_id, updated_id) values('".$stores[$a]->iuserid."', '".$singlestorepermissions[$b]->vpermissioncode."', 'Active', '".$stores[$a]->iuserid."', '".$stores[$a]->iuserid."' )";
                    $insert = DB::connection('mysql')->statement($user_perms_insert);
                   
                    $user_perms_insert .= PHP_EOL;
                    fwrite($myfile, $user_perms_insert);
                }
            }
        }
        
        $txt = "Insertion End Date And time is: ".date("Y-m-d h:i:sa").PHP_EOL;
        $txt .= PHP_EOL;
        fwrite($myfile, $txt);
        fclose($myfile);
        
        return 'Done inserting';
    }
}
