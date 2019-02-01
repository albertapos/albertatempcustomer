<?php

namespace pos2020\Http\Controllers\Admin;

use Request;
// use Illuminate\Http\Request;
use pos2020\Http\Requests;
use pos2020\Http\Controllers\Controller;
use pos2020\MST_DEPARTMENT;
use pos2020\MST_CATEGORY;
use pos2020\MST_SUPPLIER;
use pos2020\MstShelf;
use pos2020\ITEMGROUP;
use pos2020\Shelving;
use pos2020\Item;
use pos2020\MST_ITEM_UNIT;
use pos2020\MST_ITEM_SIZE;
use pos2020\mst_station;
use pos2020\Aisle;
use pos2020\Nplitem;
use Session;
use PDF;
use Mail;
use pos2020\Store;

class NPLController extends Controller
{
      public function index()
    {
        ini_set('memory_limit', '1G');
        ini_set('max_execution_time', 300);
        
        $nplitems = Nplitem::paginate(15);
        
        $stores = Store::all();
        $store_array = array();
        foreach ($stores as $storesData) {
           $store_array[$storesData->id] = $storesData->name;
        }
        
        
         return view('admin.npl.index',compact('nplitems','store_array'));
    }
    
      public function create(Request $request)
    {
        ini_set('memory_limit', '1G');
        ini_set('max_execution_time', 300);
        
        $departments = MST_DEPARTMENT::all();
        $category = MST_CATEGORY::all();
        $items = Item::all();
        $aisles = Aisle::all();
        $suppliers = MST_SUPPLIER::all();
        $shelfs = MstShelf::all();
        $groups = ITEMGROUP::all();
        $shelvings = Shelving::all();
        $units = MST_ITEM_UNIT::all();
        $sizes = MST_ITEM_SIZE::all();
        $stations = mst_station::all();
        
        $stores = Store::all();
        $store_array = array();
        foreach ($stores as $storesData) {
           $store_array[$storesData->id] = $storesData->name;
        }

        // $department_array = array('0' => 'Select Department');
        // foreach ($departments as $department) {
        //     $department_array[$department->idepartmentid] = $department->vdepartmentname;
        // }

        // $category_array = array('0' => 'Select Category');
        // foreach ($category as $categoryData) {
        //     $category_array[$categoryData->vcategorycode] = $categoryData->vcategoryname;
        // }

        
         return view('admin.npl.add',compact('departments', 'category', 'items', 'aisles','suppliers','shelfs','groups','shelvings','units','sizes','stations','store_array'));
    }
    
    public function store(Request $request){
        $input = $request::all();
        
        // if($input['vtax1'] == 'Y')
        // {
        //     $input['vtax2'] = 'N';
        // }
        // if($input['vtax2'] == 'Y')
        // {
        //     $input['vtax1'] = 'N';
        // }
        
        if(!isset($input['vtax1']) || $input['vtax1'] === '')
        {
           $input['vtax1'] = 'N';
        }
        if(!isset($input['vtax2']) || $input['vtax2'] === '')
        {
           $input['vtax2'] = 'N';
        }
        
        if(!isset($input['unit']) || $input['unit'] === '')
        {
           $input['unit'] = 0;
        }
        if(!isset($input['cost']) || $input['cost'] === '')
        {
           $input['cost'] = 0.00;
        }
        if(!isset($input['sellingprice']) || $input['sellingprice'] === '')
        {
           $input['sellingprice'] = 0.00;
        }
        if(!isset($input['sellingunit']) || $input['sellingunit'] === '')
        {
           $input['sellingunit'] = 0;
        }
        if(!isset($input['qtyonhand']) || $input['qtyonhand'] === '')
        {
           $input['qtyonhand'] = 0;
        }
        
        
        // // return $input;
        
        $npl_item = [];
        
        $npl_item['barcode'] = $input['barcode'];
        $npl_item['item_type'] = $input['itemtype'];
        $npl_item['item_name'] = $input['itemname'];
        $npl_item['description'] = $input['description'];
        $npl_item['unit'] = $input['unit'];
        $npl_item['department'] = $input['dept'];
        $npl_item['category'] = $input['category'];
        $npl_item['supplier'] = $input['supplier'];
        $npl_item['group'] = $input['group'];
        $npl_item['size'] = $input['size'];
        $npl_item['cost'] = $input['cost'];
        $npl_item['selling_price'] = $input['sellingprice'];
        $npl_item['qty_on_hand'] = $input['qtyonhand'];
        $npl_item['tax1'] = $input['vtax1'];
        $npl_item['tax2'] = $input['vtax2'];
        $npl_item['selling_unit'] = $input['sellingunit'];
        $npl_item['food_stamp'] = $input['foodstamp'];
        $npl_item['WIC_item'] = $input['wicitem'];
        $npl_item['age_verification'] = $input['ageverification'];
        
        $inserted_npl_items = Nplitem::create($npl_item);
        
        // return $this->sendResponse($inserted_npl_items, 'NPL Item saved successfully.');
         return redirect('admin/npl-list')->withSuccess('NPL Item Saved Successfully');
    }
    
    
    public function upload_csv(Request $request){
        
        // return 158;
        
        if ($request::hasFile('import_item_file')) {
            
            $import_item_file = $request::file('import_item_file');
            
            //$input = $request::all();        
            $input = $request::all();

            
            if($input['separated_by'] == 'pipe'){
				$seperatBy = "|";
			}else{
				$seperatBy = ",";
			}
			
			//$import_item_file = $this->request->files['import_item_file']['tmp_name'];
			$handle = fopen($import_item_file, "r");
			$msg_exist = '';
			$line_row_index=1;
			
			if ($handle) {
			 //   echo 134;
				while (($strline = fgets($handle)) !== false) {
				    // echo 136;
					$values = explode($seperatBy,$strline);
				// 	echo 138;

					if($line_row_index >= 1){
					   // echo 141;
						if(count($values) != 20 && count($values) != 3){
						  //  echo 143;
							$return['code'] = 0;
							$return['error'] = count($values)." Your csv file is not valid.".json_encode($values);
							//$this->response->addHeader('Content-Type: application/json');
						    //echo json_encode($return);
							//exit;
						}else{
						  //  echo 150;
						  
						  if(count($values) == 20){

						    $itemtype = str_replace('"', '', $values[0]);
						    $itemcode = str_replace('"', '', $values[1]);
						    $itemname = str_replace('"', '', $values[2]);
						    $itemdescription = str_replace('"', '', $values[3]);
						    $unit = str_replace('"', '', $values[4]);
						    $depname = str_replace('"', '', $values[5]);
						    $catname = str_replace('"', '', $values[6]);
						    $supplier = str_replace('"', '', $values[7]);
						    $groupname = str_replace('"', '', $values[8]);
						    $size = str_replace('"', '', $values[9]); 
						    $costprice = str_replace('"', '', $values[10]);
						    $price = str_replace('"', '', $values[11]);
						    $iqoh = str_replace('"', '', $values[12]);
						    $tax1 = str_replace('"', '', $values[13]);
						    $tax2 = str_replace('"', '', $values[14]);
						    $sellingunit = str_replace('"', '', $values[15]);
						    $foodstamp = str_replace('"', '', $values[16]);
						    $wicitem = str_replace('"', '', $values[17]);
						    $ageverification = str_replace('"', '', $values[18]);
						    $itemimage = '';

							if(strlen($itemcode) > 0 && strlen($itemname)){
								$checkItemCode = Nplitem::where('barcode', '=', $itemcode)->get();
								
								if(count($checkItemCode) == 0){

	                                $vcatcode = $catname;
	                                $vdepcode = $depname;

	                                $price = str_replace('$','',$price);

	                                $dunitprice = $price;
	                                if($price == ''){
	                                	$dunitprice = '0.00';
	                                }

	                                $costprice = str_replace('$','',$costprice);

	                                $dcostPrice = $costprice;
	                                if($costprice == ''){
	                                	$dcostPrice = '0.00';
	                                }
	                                
	 
	                                $vtax1 = 'N';
	                                if($tax1 == 'Y'){
	                                	$vtax1 = 'Y';
	                                }
	                                
	                                $vtax2 = 'N';
	                                if($tax2 == 'Y'){
	                                	$vtax2 = 'Y';
	                                }
	                                
	                                //Food stamp
	                                $foodstamp = 'N';
	                                if($foodstamp == 'Y'){
	                                	$foodstamp = 'Y';
	                                }
	                                
	                                //WIC Item
	                                $wicitem = 'N';
	                                if($wicitem == 'Y'){
	                                	$wicitem = 'Y';
	                                }

	                                if(strlen($iqoh) == 0){
	                                	$iqoh = "0";
	                                }

	                                /*if(strlen($npack) == '0' || $npack == '0'){
	                                	$npack = 1;
	                                }else{
	                                	$npack = $npack;
	                                }*/

	                                if($dcostPrice == '0.00' || $dcostPrice == '0.0000'){
	                                	$nunitcost = sprintf("%.4f", $dcostPrice);
	                                }

	                                /*if(($dcostPrice != '0.00' || $dcostPrice != '0.0000') && $npack != '0'){
	                                	$nunitcost = $dcostPrice / $npack;
	                                	$nunitcost = sprintf("%.4f", $nunitcost);
	                                }else{
	                                	$nunitcost = '0.0000';
	                                }*/
                            
	                                
	                                //Selling Unit
	                                $sellunit = $sellingunit == ''?1:(int)$sellingunit;

                                    $unit = empty(trim($unit))?0:trim($unit);
	                                $data = array();

                                    $npl_item['barcode'] = $itemcode;
                                    $npl_item['item_type'] = $itemtype;
                                    $npl_item['item_name'] = $itemname;
                                    $npl_item['description'] = $itemdescription;
                                    $npl_item['unit'] = $unit;
                                    $npl_item['department'] = $depname;
                                    $npl_item['category'] = $catname;
                                    $npl_item['supplier'] = $supplier;
                                    $npl_item['group'] = $groupname;
                                    $npl_item['size'] = $size;
                                    $npl_item['cost'] = $dcostPrice;
                                    $npl_item['selling_price'] = $dunitprice;
                                    $npl_item['qty_on_hand'] = $iqoh;
                                    $npl_item['tax1'] = $vtax1;
                                    $npl_item['tax2'] = $vtax2;
                                    $npl_item['selling_unit'] = $sellunit;
                                    $npl_item['food_stamp'] = $foodstamp;
                                    $npl_item['WIC_item'] = $wicitem;
                                    $npl_item['age_verification'] = $ageverification;
                                    // die(json_encode($npl_item));
                                    $inserted_npl_items = Nplitem::create($npl_item);
	                                
	                                $msg_exist .= 'Item: '.$itemcode.' inserted.'.PHP_EOL;
								}else{
									$msg_exist .= 'Item: '.$itemcode.' already exist.'.PHP_EOL;
									
								}
							}
						      
						  } else {
						      
						    $itemcode = str_replace('"', '', $values[0]);
						    $itemname = str_replace('"', '', $values[1]);
						    $size = str_replace('"', '', $values[2]);
						    
						  //  $delete = Nplitem::find($itemcode)->delete();

						      
						    if(strlen($itemcode) > 0 && strlen($itemname)){
						        
						        $checkItemCode = Nplitem::where('barcode', '=', $itemcode)->get();
								
								if(count($checkItemCode) == 0){
								    
                                    $npl_item['barcode'] = $itemcode;
                                    $npl_item['item_type'] = "";
                                    $npl_item['item_name'] = $itemname;
                                    $npl_item['description'] = "";
                                    $npl_item['unit'] = 0;
                                    $npl_item['department'] = "";
                                    $npl_item['category'] = "";
                                    $npl_item['supplier'] = "";
                                    $npl_item['group'] = "";
                                    $npl_item['size'] = $size;
                                    $npl_item['cost'] = 0.00;
                                    $npl_item['selling_price'] = 0.00;
                                    $npl_item['qty_on_hand'] = 0;
                                    $npl_item['tax1'] = "N";
                                    $npl_item['tax2'] = "N";
                                    $npl_item['selling_unit'] = 0;
                                    $npl_item['food_stamp'] = "N";
                                    $npl_item['WIC_item'] = "N";
                                    $npl_item['age_verification'] = "";
                                    // die(json_encode($npl_item));
                                    $inserted_npl_items = Nplitem::create($npl_item);
	                                
	                                $msg_exist .= 'Item: '.$itemcode.' inserted.'.PHP_EOL;								    
								    
								} else {
									$msg_exist .= 'Item: '.$itemcode.' already exist.'.PHP_EOL;
									
								}
						        
						    }  
						      
						      
						  }
						  
						  

						}	
					}
					$line_row_index++;
				}
				
				
				$return['code'] = 1;
				$return['success'] = "Imported successfully!";
				//$return['mssg'] = $msg_exist;
				//$this->response->addHeader('Content-Type: application/json');
	    		//echo json_encode($return);
				//exit;
				return $return;
			}else{
				$return['code'] = 0;
				$return['error'] = "file not found!";
				return $return;

			}
        } else {
            $return['code'] = 0;
			$return['error'] = "file not found!";
			return $return;
        }
        
        return "128: Nothing";
        
        
        /*if ($this->request->server['REQUEST_METHOD'] == 'POST' && isset($this->request->files['import_item_file']) && $this->request->files['import_item_file']['name'] != '') {
            echo "inside upload";
        } else {
            echo "else";
        }*/
    }
    
    public function edit(Request $request, $id)
    {
        // return $id;
        $nplitems = Nplitem::find($id);
        
        $stores = Store::all();
        $store_array = array();
        foreach ($stores as $storesData) {
           $store_array[$storesData->id] = $storesData->name;
        }

        // $department_array = array('0' => 'Select Department');
        // foreach ($departments as $department) {
        //     $department_array[$department->idepartmentid] = $department->vdepartmentname;
        // }

        // $category_array = array('0' => 'Select Category');
        // foreach ($category as $categoryData) {
        //     $category_array[$categoryData->vcategorycode] = $categoryData->vcategoryname;
        // }

        
         return view('admin.npl.edit',compact('nplitems','store_array'));
    }
    
     public function update(Request $request, $id)
    {
        // return $id;
        $input = $request::all();
        
        //$npl_item = [];
        
        $tax1 = $tax2 = "N";
        if(array_key_exists('vtax1', $input) && !empty(trim($input['vtax1'])) && $input['vtax1'] == 'Y'){
            $tax1 = "Y";
        }
        
        if(array_key_exists('vtax2', $input) && !empty(trim($input['vtax2'])) && $input['vtax2'] == 'Y'){
            $tax2 = "Y";
        }
        
        // return $tax1;
        $npl_item = Nplitem::find($input['barcode']);
        
        $npl_item->barcode = $input['barcode'];
        $npl_item->item_type = $input['itemtype'];
        $npl_item->item_name = $input['itemname'];
        $npl_item->description = $input['description'];
        $npl_item->unit = $input['unit'];
        $npl_item->department = $input['dept'];
        $npl_item->category = $input['category'];
        $npl_item->supplier = $input['supplier'];
        $npl_item->group = $input['group'];
        $npl_item->size = $input['size'];
        $npl_item->cost = $input['cost'];
        $npl_item->selling_price = $input['sellingprice'];
        $npl_item->qty_on_hand = $input['qtyonhand'];
        $npl_item->tax1 = $tax1;
        $npl_item->tax2 = $tax2;
        $npl_item->selling_unit = $input['sellingunit'];
        $npl_item->food_stamp = $input['foodstamp'];
        $npl_item->WIC_item = $input['wicitem'];
        $npl_item->age_verification = $input['ageverification'];
        

        $npl_item->save();
        
        
        $stores = Store::all();
        $store_array = array();
        foreach ($stores as $storesData) {
           $store_array[$storesData->id] = $storesData->name;
        }

        // $department_array = array('0' => 'Select Department');
        // foreach ($departments as $department) {
        //     $department_array[$department->idepartmentid] = $department->vdepartmentname;
        // }

        // $category_array = array('0' => 'Select Category');
        // foreach ($category as $categoryData) {
        //     $category_array[$categoryData->vcategorycode] = $categoryData->vcategoryname;
        // }

        
          return redirect('admin/npl-list')->withSuccess('NPL Item Updated Successfully');
    }
    
     public function delete($id) {
                
        // return $id;
        
        $npl_items = Nplitem::find($value->barcode);
        
        $npl_items->delete();
        
        $return['success'] = 'Item Deleted Successfully';

        return $return;
        
        // return redirect('admin/npl-list')->withSuccess('NPL Item Deleted Successfully');

    }
    
     public function delete_multiple_nplitems(Request $request) {
        // $return = array();

        $input = $request::all();     

        foreach ($input as $key => $barcode) {
            
            $npl_item = Nplitem::find($barcode);
            
            // $npl_item->delete();
            
            
        }

        

        $return['success'] = 'Item Deleted Successfully';

        return $return;

    }
    
    public function getNplItems()
    {
        if(!empty(Request::get('term'))){
            $productObj = Nplitem::where('npl_items.item_name','like','%'.Request::get('term') .'%')->get();
            return response()->json($productObj);
        }else{
            return 'Something Went Wrong!!!';
        }
    }
    
   
   public function search(Request $request){
       
    //   return $request::all();
        
        $data = Nplitem::where('item_name','LIKE','%'.$request::get('term').'%')->orWhere('barcode','LIKE','%'.$request::get('term').'%')->take(10)->select('barcode','item_name')->get();
      //var_dump($data);

        return response()->json($data);
        $results=array();


      /*foreach ($data as $key => $v) {

          $results[]=['id'=>$v->id,'value'=>$v->invoice_number." Project Name: ".$v->project_name." Amount: ".$v->amount];

      }

      return response()->json($results);*/
    
    
    
   } 
    
}
?>