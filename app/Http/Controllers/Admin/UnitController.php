<?php

// namespace pos2020\Http\Controllers\Admin;

// use Illuminate\Http\Request;

// use pos2020\Http\Requests;
// use pos2020\Http\Controllers\Controller;
// use pos2020\Unit;


// class UnitController extends Controller
// {
//     /**
//      * Display a listing of the resource.
//      *
//      * @return \Illuminate\Http\Response
//      */
//     public function index()
//     {
//         $unit = new Unit;

//         $unit->setConnection('mysql2');

//       // $u = $users2->table('sc_items')->get();
// //print_r($u);

//         $something = Unit::all();

//         dd($something);

//         return $something;
//     }

//     /**
//      * Show the form for creating a new resource.
//      *
//      * @return \Illuminate\Http\Response
//      */
//     public function create()
//     {
//         //
//     }

//     /**
//      * Store a newly created resource in storage.
//      *
//      * @param  \Illuminate\Http\Request  $request
//      * @return \Illuminate\Http\Response
//      */
//     public function store(Request $request)
//     {
//         //
//     }

//     /**
//      * Display the specified resource.
//      *
//      * @param  int  $id
//      * @return \Illuminate\Http\Response
//      */
//     public function show($id)
//     {
//         //
//     }

//     /**
//      * Show the form for editing the specified resource.
//      *
//      * @param  int  $id
//      * @return \Illuminate\Http\Response
//      */
//     public function edit($id)
//     {
//         //
//     }

//     /**
//      * Update the specified resource in storage.
//      *
//      * @param  \Illuminate\Http\Request  $request
//      * @param  int  $id
//      * @return \Illuminate\Http\Response
//      */
//     public function update(Request $request, $id)
//     {
//         //
//     }

//     /**
//      * Remove the specified resource from storage.
//      *
//      * @param  int  $id
//      * @return \Illuminate\Http\Response
//      */
//     public function destroy($id)
//     {
//         //
//     }
// }


namespace pos2020\Http\Controllers\Admin;

use Illuminate\Http\Request;
// use Request;
use DB;

use pos2020\Http\Requests;
use pos2020\Http\Controllers\Controller;
use pos2020\Unit;
use pos2020\Store;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         
        $unit = Unit::all();
        
        $stores = Store::all();
        $store_array = array();
        foreach ($stores as $storesData) {
           $store_array[$storesData->id] = $storesData->name;
        }
        
        return view('admin.npl.unit',compact('units','store_array'));
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
        $input = $request->all();
        
        $dept = new Unit();
        
        
        $dept->vunitname = $input['vunitname'];
        $dept->vunitcode = '';
        $dept->vunitdesc = 0;
        $dept->estatus = 'Active';
        $dept->SID = 0;
        //$dept->created_at=date('Y-m-d H:i:s');
        $dept->LastUpdate = date('Y-m-d H:i:s');
        
        $dept->save();
        
        $id = $dept->iunitid;
        
        $dept = Unit::find($id);
        
        $dept->vunitcode = $id;
        $dept->save();
        
        $unit = Unit::all();
        
        $stores = Store::all();
        $store_array = array();
        foreach ($stores as $storesData) {
           $store_array[$storesData->id] = $storesData->name;
        }
        
        return redirect('/admin/npl/units')
            ->with('unit', $unit)
            ->with('store_array', $store_array);
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
        $dept = Unit::find($id);
        
        return response()->json($dept);
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
        
        $input = $request->all();
        
        $dept = Unit::find($id);
        
        // $dept->vunitcode = $input['vunitcode'];
        $dept->vunitname = $input['vunitname'];
        //$dept->vunitdesc = $input['vunitdesc'];
        $dept->estatus = 'Active';
        $dept->SID = 0;
        //$dept->created_at=date('Y-m-d H:i:s');
        $dept->LastUpdate = date('Y-m-d H:i:s');
        
        
        $dept->save();
        
        $unit = Unit::all();
        
        $stores = Store::all();
        $store_array = array();
        foreach ($stores as $storesData) {
           $store_array[$storesData->id] = $storesData->name;
        }
        
        
        return redirect('/admin/npl/units')
            ->with('unit', $unit)
            ->with('store_array', $store_array);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        //
        $input = $request->all();
        
        $department_ids = explode(",", $input['delete_departments'][0]);
        
        foreach($department_ids as $id){
            if($id == 1){continue;}
            $dept = Unit::find($id);
            $dept->delete();
        }
        
        $unit = Unit::all();
        
        $stores = Store::all();
        $store_array = array();
        foreach ($stores as $storesData) {
           $store_array[$storesData->id] = $storesData->name;
        }
        
        
        return redirect('/admin/npl/units')
            ->with('unit', $unit)
            ->with('store_array', $store_array);
    }
    
    
   public function search(\Request $request){
       
        // return $request::all();
    
        $input = $request::all();
        
        // return $input['search']['value'];
        
        // return isset($input["search[value]"])?$input["search[value]"]:"Not set";
        
        if(isset($input['search']['value']) && !empty(trim($input['search']['value']))){
            
            $limit = 20;
            
            $start_from = ($input['start']);
            
            $offset = $input['start']+$input['length'];
          
            $query = "SELECT iunitid,vunitcode,vunitname FROM `inslocdb`.`mst_unit` WHERE vunitname LIKE '%".$input['search']['value']."%' OR vunitcode LIKE '%".$input['search']['value']."%' ORDER BY vunitname ASC LIMIT ".$start_from.",".$limit;
          
            $data = DB::select( DB::raw($query));
            
            
            $count_records = count($data);
            
            $count_total = count($data);
            
        } else {
            
            $limit = 20;
            
            // $page = 
            
            $start_from = ($input['start']);
            
            $offset = $input['start']+$input['length'];
          
            $data = DB::select( DB::raw("SELECT iunitid,vunitcode,vunitname FROM `inslocdb`.`mst_unit`  ORDER BY vunitname ASC LIMIT :start_from, :limit"), array('start_from' => $start_from, 'limit' => $limit));
            
            $count_records = count(Unit::all());
            
            $count_total = count(Unit::all());
            
        }
    
        // $data = Nplitem::where('item_name','LIKE','%'.$input["search[value]"].'%')->orWhere('barcode','LIKE','%'.$input["search[value]"].'%')->take(10)->select('barcode','item_name','item_type','department','category','selling_price','cost')->get();
      //var_dump($data);
      
        
        
              
        $return = [];
        $return['draw'] = (int)$input['draw'];
        $return['recordsTotal'] = $count_total;
        $return['recordsFiltered'] = $count_records;
        $return['data'] = $data;

        return response()->json($return);
        
        
        
        
        
        
        $results=array();


      /*foreach ($data as $key => $v) {

          $results[]=['id'=>$v->id,'value'=>$v->invoice_number." Project Name: ".$v->project_name." Amount: ".$v->amount];

      }

      return response()->json($results);*/
    
    
    
   }

    
}

