<?php

namespace pos2020\Http\Controllers;

//use Illuminate\Http\Request;
use Request;
use pos2020\Http\Requests;
use pos2020\Http\Controllers\Controller;
use pos2020\storeComputer;
use pos2020\Store;
use pos2020\Item;
use DB;

class StoreController extends Controller
{
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
    public function getUidStore(Request $request){

      $randomnum = str_random(8);
      $uId = Request::get('uid');

      if($uId){
        $storeComputer =  storeComputer::where('uid', 'Like', "%".$uId."%")->first();
        $storeId = $storeComputer->store_id;
        if($storeId){
            $products = Item::where('sid','=',$storeId)
                        ->where('vitemtype','Kiosk')
                        ->get();
      
            return $products->toJson(); 
        }
        
      }
      else{
        return Store::UIDMESSAGE;
      }
    }
    public function getProductDetail(Request $request){
        $products = Item::join('kiosk_default_ingredients','kiosk_default_ingredients.itemid','=','mst_item.iitemid')
                    ->get(array('mst_item.*'));
                    dd($products);
    }

    public function getLaravelDb(){

        //current time
        echo 'Time stamp before connecting to DB: '.date("H:i:s").'<br><br>';

        // Test database connection
        $setConn = new Store;

        $setConn->setConnection('mysql');

        echo 'Time stamp after connecting to DB: '.date("H:i:s").'<br><br>';

        $stores = Store::get();

        echo 'Time stamp after select query in Global DB to get list of all stores: '.date("H:i:s").'<br><br>';
        $stores = $stores->toArray();

        echo "<pre>";
        print_r($stores);
       
        echo "<br>";
        echo 'Time stamp after list of all stores: '.date("H:i:s").'<br><br>';
    }

    public function getSimpleDb(){

        $servername = "64.64.3.10";
        $username = "inslocuser";
        $password = "n@rayan!23";
        $database = "inslocdb";

        //current time
        echo 'Time stamp before connecting to DB: '.date("H:i:s").'<br><br>';

        $conn = new \mysqli($servername, $username, $password,$database);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 

        echo 'Time stamp after connecting to DB: '.date("H:i:s").'<br><br>';

        $sql = "SELECT * FROM stores";
        $result = $conn->query($sql);

        echo 'Time stamp after select query in Global DB to get list of all stores
        : '.date("H:i:s").'<br><br>';

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "id: " . $row["id"]. " - Name: " . $row["name"]. "<br>";
            }
        } else {
            echo "0 store";
        }
        echo "<br>";
        echo 'Time stamp after list of all stores
        : '.date("H:i:s").'<br><br>';
    }
}
