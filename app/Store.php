<?php

namespace pos2020;

use Illuminate\Database\Eloquent\Model;
use Validator;
use Importer\xmlapi;
use Auth;
use Request;
use Config;
use Session;
use DB;
use Schema;
use mysqli;

class Store extends Model
{
    protected $table = 'stores';
    const SUCCESS = 'Send Data successfully';
    const UIDMESSAGE = 'Send UID In URL';

    protected $visible = array(
        "id",
        "name",
        "description",
        "phone",
        "address",
        "country",
        "state",
        "city",
        "zip",
        "user",
        "SID"
    );
    protected $appends = array('SID');
    public static function Validate($data) {
        $rules = array(
            'name' => 'required|min:3|max:255',
            'phone' => 'required|min:10|numeric',
            'zip' => 'required|numeric',
            'state' => 'required',
            'address' => 'required',
            'city' => 'required',
        );
        return Validator::make($data, $rules);
    }
   
    public function getSIDAttribute(){
        return $this->id;
    }
    public function user()
    {
        return $this->belongsToMany('pos2020\User', 'user_stores', 'store_id', 'user_id');
    }
    public function salesUsers()
    {
        return $this->belongsToMany('pos2020\User', 'sales_stores', 'store_id', 'user_id');
    }
    public function userStores()
    {
        return $this->hasMany(UserStores::class)->with('user');
    }
     public function storeComputer()
    {
        return $this->hasMany(storeComputer::class);
    }
    public function product()
    {
        return $this->hasMany('pos2020\Item');
    }

    public function scopeSalesStore($query){
        $user = Auth::user();
        $role  = $user->roles()->first();
      
        if($role->id == 3){ // sales Executive
            $store_ids = array();
            $store_ids = USer::join('sales_stores', 'users.id','=','sales_stores.user_id')
                        ->where('sales_stores.user_id', $user->id)
                        ->pluck('store_id','store_id')
                        ->toArray();
            $query->whereIn( 'id', $store_ids)->where('store_view_permission','!=',1);
           
        }
        if($role->id == 4 ){ // sales manager
            $store_ids = array();
            $store_ids = USer::join('sales_stores', 'users.id','=','sales_stores.user_id')
                        ->where('agent_office_id', $user->agent_office_id)->pluck('store_id','store_id')
                        ->toArray();
           return  $query->whereIn('id', $store_ids)->where('store_view_permission','!=',1);
        }
        else if($role->id == 5 ){ // sales admin
            $store_ids = array();
            $store_ids = USer::join('sales_stores', 'users.id','=','sales_stores.user_id')
                       // ->where('sales_stores.user_id', $user->id)
                        ->pluck('store_id','store_id')
                        ->toArray();
           return  $query->whereIn('id', $store_ids)->where('store_view_permission','!=',1);
        } 
        else if($role->id == 6 ){ // sales agent
            $store_ids = array();
            $store_ids = USer::join('sales_stores', 'users.id','=','sales_stores.user_id')
                       // ->where('sales_stores.user_id', $user->id)
                        ->where('agent_office_id', $user->agent_office_id)
                        ->pluck('store_id','store_id')
                        ->toArray();
           return $query->whereIn( 'id', $store_ids)->where('store_view_permission','!=',1);
        } 
         else if($role->id == 8 ){ // store manager
           /* $store_ids = array();
            $store_ids = USer::join('sales_stores', 'users.id','=','sales_stores.user_id')
                        ->where('sales_stores.user_id', $user->id)
                        ->pluck('store_id','store_id')
                
                ->toArray();*/
            return Auth::User()->store();
            //$query->whereIn( 'id', $store_ids);
        } 
    }
    public function createStoreDB($multi_store = false ){


        // $db_host = systemOption::pluck('value')->first(); //http://pos2020.net/cp.php
       // dd($db_host);
        $d_data = systemOption::all();
        //dd($d_data);
        $db_host = $d_data[0]->value;
        $cpaneluser = $d_data[1]->value;
        $cpanelpass = $d_data[2]->value; 
       
        $array = array_merge(range(0,9),range('A','Z'),range('a','z'));
        shuffle($array);
        $databasepass = implode('',array_slice($array,0,10));

        $databasepass = $databasepass . "P0s";


        $databasename = 'u'.$this->id;
        $databaseuser = $databasename; // Warning: in most of cases this can't be longer than 8 characters

        if($multi_store  == true) {

            if($this->primary_storeId > 0 ) {

                $p_store = Store::find($this->primary_storeId);
                if($p_store) {
                    $this->db_name = $databasename;
                    $this->db_username = $databaseuser;
                    $this->db_password = $databasepass;
                    $this->db_hostname = $db_host ;
                    $this->save();
                    
                    $databasename = $databasename;
                    $xmlapi = new xmlapi($db_host);  
                    $xmlapi->password_auth("".$cpaneluser."","".$cpanelpass."");  
                    $xmlapi->set_debug(1);//this setting will put output into the error log in the directory that you are calling script from 
                    $xmlapi->set_output('array');//set this for browser output
                    $xmlapi->set_port(2083);

                    $usr = $xmlapi->api1_query($cpaneluser, "Mysql", "adduser", array($databaseuser, $databasepass));  
          
                    $usr = json_decode(json_encode($usr),true);
                    if (isset($usr['event']['result']) && $usr['event']['result'] == 1)
                    {
                        $addusr = $xmlapi->api1_query($cpaneluser, "Mysql", "adduserdb", array($databasename, $databaseuser, 'all'));  
                    }
                }
            }
            
            /*if($this->primary_storeId > 0 ) {

                $p_store = Store::find($this->primary_storeId);

                $d_name = $p_store->db_name;
                $d_user = $p_store->db_username;
                $d_pass = $p_store->db_password;
                $d_host = $p_store->db_hostname;
                
                if($p_store) {
                    $this->db_name = $d_name;
                    $this->db_username = $d_user;
                    $this->db_password = $d_pass;
                    $this->db_hostname = $d_host ;
                    $this->save();
                }
            }*/
            
            return '';
        }

        $this->db_name = $databasename;
        $this->db_username = $databaseuser;
        $this->db_password = $databasepass;
        $this->db_hostname = $db_host; 
        $this->save();
        
         // Create connection
        $conn = new mysqli($db_host, $cpaneluser, $cpanelpass);
        
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 
        
        // Create database
        $sql = "CREATE DATABASE ".$databasename;
        if ($conn->query($sql) === TRUE) {
            
            //echo "Database created successfully.<br>";
            if ($conn->query("CREATE USER '".$databaseuser."'@'".$db_host."' IDENTIFIED BY '".$databasepass."';") === TRUE) {
                
                //echo "User created successfully.<br/>";
                // if ($conn->query("GRANT ALL PRIVILEGES ON ".$databasename.".* TO '".$databaseuser."'@'".$db_host."'") === TRUE) {
                if ($conn->query("GRANT ALL PRIVILEGES ON ".$databasename.".* TO '".$databaseuser."'@'%' IDENTIFIED BY '".$databasepass."';") === TRUE) {
                    
                    $conn->query("FLUSH PRIVILEGES;");
                    
                    //echo "Granted all permissions successfully.<br/>";
                    
                    // dd("mysql -u" . $databaseuser . " -p" . $databasepass . " -h" . $db_host . " -D". $databasename . " < ". storage_path('golden_blank.sql'));
                    
                    exec("mysql -u" . $databaseuser . " -p" . $databasepass . " -h" . $db_host . " -D". $databasename . " < ". storage_path('golden_blank.sql'));
                    
                    /*exec("mysql -u" . $databaseuser . " -p" . $databasepass . " " . 
                                $databasename . " < ". storage_path('golden_blank.sql') );*/
                } else {
                    echo "Error granting permissions: " . $conn->error."<br/>";die;
                }
                
            } else {
                
                echo "CREATE USER '".$databaseuser."'@'".$db_host."' IDENTIFIED BY '".$databasepass."';"."<br>";
                echo "Error creating user: " . $conn->error."<br/>"; die;
            }
            
        } else {
            echo "Error creating database: " . $conn->error."<br/>";die;
        }        
        
        
        //Original code to create database and user: DISABLED because it is unable to do so.
        // $xmlapi = new xmlapi($db_host);  
        // $xmlapi->password_auth("".$cpaneluser."","".$cpanelpass."");  
        // $xmlapi->set_port(2083);
        
        // $xmlapi->set_debug(1);//this setting will put output into the error log in the directory that you are calling script from 
        // $xmlapi->set_output('array');//set this for browser output
        //create database  
        // $createdb =  $xmlapi->api1_query($cpaneluser, "Mysql", "adddb", array($databasename)); 
        // //dd($createdb);
        // $createdb = json_decode(json_encode($createdb),true);
        // if (isset($createdb['event']['result']) && $createdb['event']['result'] == 1)
        // {
        //     //create user  
        //     $usr = $xmlapi->api1_query($cpaneluser, "Mysql", "adduser", array($databaseuser, $databasepass));  
          
        //     $usr = json_decode(json_encode($usr),true);
        //     if (isset($usr['event']['result']) && $usr['event']['result'] == 1)
        //     {
        //         $addusr = $xmlapi->api1_query($cpaneluser, "Mysql", "adduserdb", array($databasename, $databaseuser, 'all'));  

        //         exec("mysql -u" . $databaseuser . " -p" . $databasepass . " " . 
        //         $databasename . " < ". storage_path('golden_blank.sql') );
        //     }
        // }

    }
    public function setdb( )
    {
        User::changeStore($this->id);
        Config::set('database.connections.mysql2', array(
                
            'driver' => 'mysql',
            'host' =>  Session::get('s_db_host'),
            'port' => env('DB_PORT', '3306'),
            'database' => Session::get('s_db_name'),
            'username' => Session::get('s_db_username'),
            'password' => Session::get('s_db_password'),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        
        ));
        return true;
    }

    public static function getSelectedStore()
    {
        $store = Self::where('id', Session::get('selected_store_id'))->first();
        return $store;
    }

    public function plcbsetdb($store)
    {
        Config::set('database.connections.mysql2', array(
                
            'driver' => 'mysql',
            'host' =>  $store->db_hostname,
            'port' => env('DB_PORT', '3306'),
            'database' => $store->db_name,
            'username' => $store->db_username,
            'password' => $store->db_password,
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        
        ));
        return true;
    }

    public function setDefaultSID()
    {
        $new_store_id = $this->id;
        $new_db_name = $this->db_name;
        $tables = DB::connection('mysql2')->select('SHOW TABLES');
        foreach($tables as $table){
            $tab_ojbect = 'Tables_in_'.$new_db_name;
            $table_name = $table->$tab_ojbect;

            if(Schema::connection('mysql2')->hasColumn($table_name, 'SID')) {
                DB::connection('mysql2')->statement("ALTER TABLE $table_name CHANGE COLUMN `SID` `SID` int(11) NOT NULL DEFAULT $new_store_id;");
            }
        }

        $databaseuser = $this->db_username;
        $databasepass = $this->db_password;
        $databasename = $this->db_name;
        $db_host = $this->db_hostname;


        exec("mysql -u" . $databaseuser . " -p" . $databasepass . " -h" . $db_host . " -D". $databasename . " < ". storage_path('web_DefaultPosData.sql') );
        
        $insert_query = "INSERT INTO `u".$new_store_id."`.`mst_version` (`ver_id`, `ver_no`, `update_dt`, `update_type`, `ftp_folder_name`, `create_dt`, `LastUpdate`, `SID`) VALUES ('300', '3.0.0', current_timestamp(), 'Manual', 'update_script_300', '".date('Y-m-d H:i:s', strtotime('now'))."', '".date('Y-m-d H:i:s', strtotime('now'))."', '".$new_store_id."')";
        
        DB::connection('mysql')->statement($insert_query);
        
        return true;
    }
}
