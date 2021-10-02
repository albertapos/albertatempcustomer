<?php

namespace pos2020\Http\Controllers\Admin;

// use Request;
use Illuminate\Http\Request;
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
use DB;

use pos2020\NewSku;
use Config;
use Schema;

use pos2020\Department;
use pos2020\Category;
use pos2020\Subcategory;
use pos2020\Unit;
use pos2020\Manufacturer;
use pos2020\Size;

class NPLController extends Controller
{
      public function index()
    {
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 300);
        
        echo memory_get_usage();
        
        $nplitems = Nplitem::paginate(15);
        
        // $nplitems = Nplitem::all();
        
        $stores = Store::all();
        $store_array = array();
        foreach ($stores as $storesData) {
           $store_array[$storesData->id] = $storesData->name;
        }
        
        
         return view('admin.npl.index',compact('nplitems','store_array'));
    }
    
    
    public function paginated_result($page=1){
        return $page;
        $limit = 15;  
        
        // if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };
        
        $start_from = ($page-1) * $limit;  
          
        // $sql = "SELECT * FROM posts ORDER BY item_name ASC LIMIT $start_from, $limit";
        
        $result = DB::select( DB::raw("SELECT barcode,item_name,item_type,department,category,selling_price,cost FROM npl_items ORDER BY item_name ASC LIMIT :start_from, :limit"), array('start_from' => $start_from, 'limit' => $limit));
        
        return response()->json($result);
    }
    
    
      public function create(Request $request)
    {
        ini_set('memory_limit', '1G');
        ini_set('max_execution_time', 300);
        
        // $departments = MST_DEPARTMENT::all();
        // $category = MST_CATEGORY::all();
        // $items = Item::all();
        // $aisles = Aisle::all();
        // $suppliers = MST_SUPPLIER::all();
        // $shelfs = MstShelf::all();
        // $groups = ITEMGROUP::all();
        // $shelvings = Shelving::all();
        // $units = MST_ITEM_UNIT::all();
        // $sizes = MST_ITEM_SIZE::all();
        // return $stations = mst_station::all();
        
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

        
        $departments = Department::all();
        $categories = Category::all();
        $subcategories = Subcategory::all();
        $units = Unit::all();
        $manufacturers = Manufacturer::all();
        $sizes = Size::all();
        
        return view('admin.npl.add',compact('store_array','departments','categories','subcategories','manufacturers','units','sizes'));
    }
    
    public function store(Request $request){
        ini_set('memory_limit', '-1');
        
        
        $input = $request->all();
        
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
           $input['sellingunit'] = 1;
        }
        if(!isset($input['qtyonhand']) || $input['qtyonhand'] === '')
        {
           $input['qtyonhand'] = 0;
        }
        
        // return  "167";
        // return gettype($input);
        
        // $npl_item = [];
        
        $npl_item = new Nplitem;
        
        $npl_item->barcode = $input['barcode'];
        $npl_item->item_type = $input['itemtype'];
        $npl_item->item_name = $input['itemname'];
        $npl_item->description = $input['description'];
        $npl_item->unit = $input['unit'];
        $npl_item->department = $input['dept'];
        $npl_item->category = $input['category'];
        $npl_item->sub_category = $input['subcategory'];
        
        
        // $npl_item->supplier = $input['supplier'];
        // $npl_item->group = $input['group'];
        $npl_item->supplier = $input['manufacturer'];
        $npl_item->size = $input['size'];
        $npl_item->cost = $input['cost'];
        $npl_item->selling_price = $input['sellingprice'];
        $npl_item->qty_on_hand = $input['qtyonhand'];
        $npl_item->tax1 = $input['vtax1'];
        $npl_item->tax2 = $input['vtax2'];
        $npl_item->selling_unit = $input['sellingunit'];
        $npl_item->food_stamp = $input['foodstamp'];
        $npl_item->WIC_item = $input['wicitem'];
        $npl_item->age_verification = $input['ageverification'];
        
        $npl_item->done_editing = isset($input['Save'])?'1':'0';
        // return 197;
        
        $npl_item->save();
        // dd($npl_item->save());
        
        // return 200;
        
        // return $npl_item;
        
        // return $inserted_npl_items = Nplitem::create($npl_item);
        
        // return $this->sendResponse($inserted_npl_items, 'NPL Item saved successfully.');
        return redirect('/admin/npl-list');
    }
    
    
    public function upload_csv(Request $request){
        
        // return 158;
        
        $file_path = storage_path()."/logs/npl_import_error_log.txt";

    	$myfile = fopen( $file_path, "a");
    	
        
        if ($request->hasFile('import_item_file')) {
            
            $import_item_file = $request->file('import_item_file');
            
            //$input = $request::all();        
            $input = $request->all();

            
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
						if(count($values) != 19){
						  //  echo 143;
							$return['code'] = 0;
							$return['error'] = count($values)." Your csv file is not valid.".json_encode($values);
							//$this->response->addHeader('Content-Type: application/json');
						    //echo json_encode($return);
							//exit;
						}else{
						  //  echo 150;
						    $itemtype = str_replace('"', '', $values[0]);
						    $itemcode = str_replace('"', '', $values[1]);
						    $itemname = str_replace('"', '', $values[2]);
						    $itemdescription = str_replace('"', '', $values[3]);
						    $unit = str_replace('"', '', $values[4]);
						    $depname = str_replace('"', '', $values[5]);
						    $catname = str_replace('"', '', $values[6]);
						    $sub_category = str_replace('"', '', $values[7]);
						    $manufacturer = str_replace('"', '', $values[8]);
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

							if(strlen($itemcode) > 0 && strlen($itemname) > 0){
								// $checkItemCode = Nplitem::where('barcode', '=', $itemcode)->get();
								
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
                                $npl_item['sub_category'] = $sub_category;
                                $npl_item['manufacturer'] = $manufacturer;
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
                                // print_r($npl_item); die;

								$checkItemCode = Nplitem::find($itemcode);
								
								if(count($checkItemCode) == 0){
                                    $inserted_npl_items = Nplitem::create($npl_item);
	                                $msg_exist = 'Item: '.$itemcode.' inserted.'.PHP_EOL;
								}else{
								    $checkItemCode->update($npl_item);
									$msg_exist = 'Item: '.$itemcode.' replaced with new values.'.PHP_EOL;
								}
									
                        // 		$error = 'Error: '.json_encode($e).PHP_EOL;
                        		
                                fwrite($myfile, $msg_exist);
							} else {
							    
							    $error = 'Error: Cannot consider the itemcode: '.$itemcode.' because either the barcode or the item is empty'.PHP_EOL;
                        		
                                fwrite($myfile, $error);
							}
						}	
					}
					$line_row_index++;
				}
				
				fclose($handle); fclose($myfile);
				unset($msg_exist); unset($error); unset($strline);
				
				$return['code'] = 1;
				$return['success'] = "Imported successfully!";
				//$return['mssg'] = $msg_exist;
				//$this->response->addHeader('Content-Type: application/json');
	    		//echo json_encode($return);
				//exit;
				return $return;
			}else{
			    
			    fclose($handle); fclose($myfile);
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

        
        $departments = Department::all();
        $categories = Category::all();
        $subcategories = Subcategory::all();
        $units = Unit::all();
        $manufacturers = Manufacturer::all();
        $sizes = Size::all();
        
        return view('admin.npl.edit',compact('nplitems','store_array','departments','categories','subcategories','manufacturers','units','sizes'));        
        
        
        //  return view('admin.npl.edit',compact('nplitems','store_array'));
    }
    
    public function update(Request $request, $id)
    {
        ini_set('memory_limit', '-1');
        
        $input = $request->all();
        
        //$npl_item = [];
        
        $tax1 = $tax2 = "N";
        if(array_key_exists('vtax1', $input) && !empty(trim($input['vtax1'])) && $input['vtax1'] == 'Y'){
            $tax1 = "Y";
        }
        
        if(array_key_exists('vtax2', $input) && !empty(trim($input['vtax2'])) && $input['vtax2'] == 'Y'){
            $tax2 = "Y";
        }
        
        // return $tax1;
        $npl_item = Nplitem::find($id);
        
        $npl_item->barcode = $input['barcode'];
        $npl_item->item_type = $input['itemtype'];
        $npl_item->item_name = $input['itemname'];
        $npl_item->description = $input['description'];
        $npl_item->unit = $input['unit'];
        $npl_item->department = $input['dept'];
        $npl_item->category = $input['category'];
        $npl_item->sub_category = $input['subcategory'];
        $npl_item->supplier = $input['manufacturer'];
        // $npl_item->group = $input['group'];
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
        $npl_item->done_editing = isset($input['Save'])?'1':'0';
        

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
        
        return redirect('admin/npl-list')->withSuccess('NPL Item Deleted Successfully');

    }
    
    public function delete_multiple_nplitems(Request $request) {

        ini_set('memory_limit', '-1');
        $input = $request->barcode;     
        
        foreach ($input as $key => $barcode) {
            
            $npl_item = Nplitem::find($barcode);
            $npl_item->delete();
        }

        $return['success'] = 'Items Deleted Successfully';
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
       
        // return $request::all();
        ini_set('memory_limit', '-1');
        
        // echo memory_get_usage();
        
        
        $input = $request->all();
        
        
        if(array_key_exists('done_editing', $input) && $input['done_editing'] != -1){
            if($input['done_editing'] == 1){
                $concatenate_query = " done_editing = 1";
            } elseif($input['done_editing'] == 0){
                $concatenate_query = " done_editing = 0";
            }
        } else {
           $concatenate_query = ""; 
        }
        
        
        
        
        
        
        // return $input['search']['value'];
        
        // return isset($input["search[value]"])?$input["search[value]"]:"Not set";
        
        if(isset($input['search']['value']) && !empty(trim($input['search']['value']))){
            
            // $data = Nplitem::where('item_name','LIKE','%'.$input['search']['value'].'%')->orWhere('barcode','LIKE','%'.$input['search']['value'].'%')->select('barcode','item_name','item_type','department','category','selling_price','cost')->get();
            
            $limit = 20;
            
            $start_from = ($input['start']);
            
            $offset = $input['start']+$input['length'];
            
            $concatenate_query = empty(trim($concatenate_query))?"":" AND".$concatenate_query;

            $query = "SELECT barcode,item_name,item_type,department,category,selling_price,cost FROM npl_items WHERE item_name LIKE '%".$input['search']['value']."%' OR barcode LIKE '%".$input['search']['value']."%'" . $concatenate_query . " ORDER BY item_name ASC LIMIT ".$start_from.",".$limit;
          
            $data = DB::select( DB::raw($query));
            
            
            $count_records = count($data);
            
            $count_total = count($data);
            
        } else {
            
            $limit = 20;
            
            // $page = 
            
            $start_from = ($input['start']);
            
            $offset = $input['start']+$input['length'];
            
            $concatenate_query = empty(trim($concatenate_query))?"":" WHERE".$concatenate_query;
            
            $count = DB::select("SELECT count(barcode) as count FROM inslocdb.npl_items" . $concatenate_query);

          
            $data = DB::select( DB::raw("SELECT barcode,item_name,item_type,department,category,selling_price,cost FROM npl_items" . $concatenate_query . " ORDER BY item_name ASC LIMIT {$start_from}, {$limit}"));
            
            $count_records = $count[0]->count;
            
            $count_total = $count[0]->count;
            
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
   
   
    public function new_skus_list() {
        ini_set('memory_limit', '1G');
        ini_set('max_execution_time', 300);
        
        $new_skus = NewSku::paginate(15);
        
        // $nplitems = Nplitem::all();
        
        $stores = Store::all();
        $store_array = array();
        foreach ($stores as $storesData) {
           $store_array[$storesData->id] = $storesData->name;
        }
        
        
        return view('admin.new_sku.index',compact('new_skus','store_array'));
    }
    
    public function newSkuToNpl()
    {
        
        $newSkus = NewSku::where(['added_to_npl'=>0])->get()->toArray();
        if(!empty($newSkus))
        {
            foreach($newSkus as $value)
            {
               $id = $value['id'];
                $barcode = $value['barcode'];
                $user = $value['SID'];
                $table = $user. "." ."mst_item";
                $checkNPL = Nplitem::where(['barcode'=>$barcode])->get()->toArray();
                
                if(!empty($checkNPL))
                {
                    $query = "UPDATE new_sku_stores SET added_to_npl = 1  WHERE id = '$id'";
                    $update = DB::select( DB::raw($query));
                    continue;
                }
                
                // $query = "SELECT *,vitemname,vdescription,nsellunit FROM $table WHERE vbarcode = '$barcode'";
                $query = "SELECT mi.vbarcode,mi.vitemtype,mi.vitemname,mi.vdescription,mi.nsellunit,mi.vsize,mi.nunitcost,mi.nsaleprice,mi.iqtyonhand,mi.vtax1,mi.vtax2,mi.wicitem,mi.vageverify,md.vdepartmentname,mc.vcategoryname FROM $table as mi LEFT JOIN $user.mst_department as md ON md.vdepcode = mi.vdepcode  LEFT JOIN $user.mst_category as mc ON mc.vcategorycode = mi.vcategorycode  WHERE vbarcode = '$barcode'";
                // echo $query;exit;
                $data = DB::select( DB::raw($query));
                if(empty($data))
                {
                    continue;
                }
                $data = json_decode(json_encode($data[0]), true);
                $npl_item = [];
        
                $npl_item['barcode'] = $data['vbarcode'];
                $npl_item['item_type'] = $data['vitemtype'];
                $npl_item['item_name'] = $data['vitemname'];
                $npl_item['description'] = $data['vdescription'];
                $npl_item['unit'] = $data['nsellunit'];
                $npl_item['department'] = $data['vdepartmentname'];
                $npl_item['category'] = $data['vcategoryname'];
                $npl_item['supplier'] = '';
                $npl_item['group'] = '';
                $npl_item['size'] = $data['vsize'];
                $npl_item['cost'] = $data['nunitcost'];
                $npl_item['selling_price'] = $data['nsaleprice'];
                $npl_item['qty_on_hand'] = $data['iqtyonhand'];
                $npl_item['tax1'] = $data['vtax1'];
                $npl_item['tax2'] = $data['vtax2'];
                $npl_item['selling_unit'] = $data['nsellunit'];
                $npl_item['food_stamp'] = '';
                $npl_item['WIC_item'] = $data['wicitem'];
                $npl_item['age_verification'] = $data['vageverify'];
                
                $inserted_npl_items = Nplitem::create($npl_item);
        
                if($inserted_npl_items)
                {
                    $query = "UPDATE new_sku_stores SET added_to_npl = 1  WHERE id = '$id'";
                    $update = DB::select( DB::raw($query));
                }
            }
        }
        return redirect('admin/newskus')->withSuccess('New items added to NPL Successfully');
        
    }
    
    
    
    public function new_sku_list_search(Request $request){
        
        $input = $request->all();

        
        if(array_key_exists('added_to_npl', $input) && $input['added_to_npl'] != -1){
            if($input['added_to_npl'] == 1){
                $concatenate_query = " added_to_npl = 1";
            } elseif($input['added_to_npl'] == 0){
                $concatenate_query = " added_to_npl = 0";
            }
        } else {
           $concatenate_query = ""; 
        }

        if(isset($input['search']['value']) && !empty(trim($input['search']['value']))){
            
            // $data = Nplitem::where('item_name','LIKE','%'.$input['search']['value'].'%')->orWhere('barcode','LIKE','%'.$input['search']['value'].'%')->select('barcode','item_name','item_type','department','category','selling_price','cost')->get();
            
            $limit = 20;
            
            $start_from = ($input['start']);
            
            $offset = $input['start']+$input['length'];
            
            $concatenate_query = empty(trim($concatenate_query))?"":" AND".$concatenate_query;
          
            $query = "SELECT barcode,itemname,itemtype,SID,item_create_dt FROM inslocdb.new_sku_stores WHERE itemname LIKE '%".$input['search']['value']."%' OR barcode LIKE '%".$input['search']['value']."%'" . $concatenate_query ." ORDER BY itemname ASC LIMIT ".$start_from.",".$limit;
          
// echo $query; die;

            $data = DB::select( DB::raw($query));
            
            
            $count_records = count($data);
            
            $count_total = count($data);
            
        } else {
            
            $limit = 20;
            
            // $page = 
            
            $start_from = ($input['start']);
            
            $offset = $input['start']+$input['length'];
            
            $concatenate_query = empty(trim($concatenate_query))?"":" WHERE".$concatenate_query;
            
            $count = DB::select("SELECT count(barcode) as count FROM inslocdb.new_sku_stores" . $concatenate_query);
            
            // echo json_encode($count); die;

            $select_query = "SELECT barcode,itemname,itemtype,SID,item_create_dt FROM inslocdb.new_sku_stores" . $concatenate_query . " ORDER BY itemname ASC LIMIT :start_from, :limit";
            
            // echo $select_query; die;
            
            $data = DB::select( DB::raw($select_query), array('start_from' => $start_from, 'limit' => $limit));
            
            // echo json_encode($data); die;
            
            // $count_records = count(NewSku::all());
            
            // $count_total = count(NewSku::all());
            
            $count_records = $count[0]->count;
            
            $count_total = $count[0]->count;
            
        }
    
        // $data = Nplitem::where('item_name','LIKE','%'.$input["search[value]"].'%')->orWhere('barcode','LIKE','%'.$input["search[value]"].'%')->take(10)->select('barcode','item_name','item_type','department','category','selling_price','cost')->get();
      //var_dump($data);
      
        
        
              
        $return = [];
        $return['draw'] = (int)$input['draw'];
        $return['recordsTotal'] = $count_total;
        $return['recordsFiltered'] = $count_records;
        $return['data'] = $data;

        return response()->json($return);
    }
    
    
    
    public function edit_newly_added_item($barcode){
        
        $stores = Store::all();
        $store_array = array();
        foreach ($stores as $storesData) {
           $store_array[$storesData->id] = $storesData->name;
        }
        
        $new_sku_item = NewSku::where('barcode', '=', $barcode)->first();
        
        if($new_sku_item->added_to_npl == 1){
            
            $new_item = Nplitem::where('barcode', '=', $barcode)->first();
            
            $new_item->added_to_npl = 1;
            
// return json_encode($new_item);
            return view('admin.new_sku.edit',compact('new_item', 'store_array'));
        }
        
        $db = $new_sku_item->SID;
        
        $query_db = 'USE DATABASE '.$db;
        
        DB::raw($query_db);
        
        $db_select = DB::select(DB::raw("SELECT * FROM ".$db.".mst_item WHERE vbarcode = :barcode"), array('barcode' => $barcode));
        
        // print_r($db_select); die;
        
        $selected_item = $db_select[0];
        
                // return json_encode($selected_item);

        
        $department = DB::select(DB::raw("SELECT vdepartmentname FROM ".$db.".mst_department WHERE vdepcode = :dept_code"), array('dept_code' => $selected_item->vdepcode));
        $department = array_key_exists(0, $department)?$department[0]->vdepartmentname:"General";
        
        $category = DB::select(DB::raw("SELECT vcategoryname FROM ".$db.".mst_category WHERE vcategorycode = :category_code"), array('category_code' => $selected_item->vcategorycode));
        $category = array_key_exists(0, $category)?$category[0]->vcategoryname:"General";

        
        $supplier = DB::select(DB::raw("SELECT vcompanyname FROM ".$db.".mst_supplier WHERE vsuppliercode = :supplier_code"), array('supplier_code' => $selected_item->vsuppliercode));
        $supplier = array_key_exists(0, $supplier)?$supplier[0]->vcompanyname:"General";
        
        
        $group = DB::select(DB::raw("SELECT ig.vitemgroupname FROM ".$db.".itemgroupdetail igd RIGHT JOIN " . $db . ".itemgroup ig ON igd.iitemgroupid = ig.iitemgroupid WHERE vsku = :barcode"), array('barcode' => $barcode));
        $group = array_key_exists(0, $group)?$group[0]:(object)['vitemgroupname' => ""];
        
        // return json_encode($group);
        
        //create array to display details
        $new_item = [];
        $npl_item['barcode'] = $selected_item->vbarcode;
        $npl_item['item_type'] = $selected_item->vitemtype;
        $npl_item['item_name'] = $selected_item->vitemname;
        $npl_item['description'] = $selected_item->vdescription;
        $npl_item['unit'] = $selected_item->nsellunit;
        
        $npl_item['department'] = $department;
        $npl_item['category'] = $category;
        $npl_item['supplier'] = $supplier;
        $npl_item['group'] = $group->vitemgroupname;
        
        $npl_item['size'] = $selected_item->vsize;
        $npl_item['cost'] = $selected_item->dcostprice;
        $npl_item['selling_price'] = $selected_item->dunitprice;
        $npl_item['qty_on_hand'] = $selected_item->iqtyonhand;
        $npl_item['tax1'] = $selected_item->vtax1;
        $npl_item['tax2'] = $selected_item->vtax2;
        $npl_item['selling_unit'] = $selected_item->nsellunit;
        $npl_item['food_stamp'] = $selected_item->vfooditem;
        $npl_item['WIC_item'] = $selected_item->wicitem;
        $npl_item['age_verification'] = $selected_item->vageverify;
        
        
        
        $new_item = (object)$npl_item;
        // return json_encode($new_item);
        
        
        return view('admin.new_sku.edit',compact('new_item', 'store_array'));
    }
    
    
    public function send_to_npl(Request $request){
        
        $input = $request->all();
        
        //check if the item is present in NPL
        $check_npl = Nplitem::where('barcode', '=', $input['barcode'])->first();
        
        if(gettype($check_npl) !== 'object'){
            
            //insert the item into NPL
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
            $npl_item['tax1'] = array_key_exists('vtax1', $input)?"Y":"N";
            $npl_item['tax2'] = array_key_exists('vtax2', $input)?"Y":"N";
            $npl_item['selling_unit'] = $input['sellingunit'];
            $npl_item['food_stamp'] = $input['foodstamp'];
            $npl_item['WIC_item'] = $input['wicitem'];
            $npl_item['age_verification'] = $input['ageverification'];
            
            $inserted_npl_items = Nplitem::create($npl_item);
            
            if($inserted_npl_items) {
                $new_sku = NewSku::where('barcode', '=', $input['barcode'])->first();
                $new_sku->added_to_npl = 1;
                $new_sku->save();
                
                return redirect('admin/newskus')->withSuccess('Item added to NPL Successfully');
            } else {
                return redirect('admin/newskus')->withErrors('The item could not be added to NPL');
            }
            
        } else {
           
           return redirect('admin/newskus')->withErrors('The item already exists in NPL');
        }
        
    }
    
    
    public function snapshot_mst_item(){
        
        ini_set('display_errors', '1');
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 0);
        
        // echo getcwd(); die;
        
        $file_name = 'inventory_snaphot.txt';

        $file_path = public_path()."/".$file_name;

        $myfile = fopen( $file_path, "a");
        
        $data_row = "========================================= Logged on:".date("Y-m-d H:i:s")." UTC========================================".PHP_EOL;

        
        
        // return "Done";
        
        $stores = Store::all();
        
        foreach ($stores as $store) {
            //skip NPL  || ($store->db_name != "u100506")
            if(($store->db_name == "u100552")){
                continue;
            }
            
            $db_host = 'devalberta.cfixtkqw8bai.us-east-2.rds.amazonaws.com';
            
            /*Config::set('database.connections.mysql4', array(
                    
                'driver' => 'mysql',
                'host' =>  $db_host,
                'port' => env('DB_PORT', '3306'),
                'database' => $store->db_name,
                'username' => $store->db_username,
                'password' => $store->db_password,
                'charset' => 'utf8',
                'collation' => 'utf8_unicode_ci',
                'prefix' => '',
                'strict' => true,
                'engine' => null,
            
            ));*/
            
            
            //Check if the table exists
            $check_table_query = "SELECT * FROM information_schema.tables WHERE table_schema = '".$store->db_name."' AND table_name = 'inventory_history' LIMIT 1";
            
            $check_table = DB::connection('mysql')->select($check_table_query);
            
            
            // create the table if it does NOT exist
            if (count($check_table) === 0) {
                
                // echo "mysql -u" . $store->db_username . " -p" . $store->db_password . " -h" . $db_host . " -D". $store->db_name . " < ". storage_path('create_inventory_history.sql');
                // die;
                
                $master_username = "alberta";
                $master_password = "Jalaram123$";
                
                // Code to create table
                exec("mysql -u" . $master_username . " -p" . $master_password . " -h" . $db_host . " -D". $store->db_name . " < ". storage_path('create_inventory_history.sql'));
                
                $data_row .= "Created 'inventory_history' table in ".$store->db_name.PHP_EOL;
            }
            
            
            
            // Get the list of items in from the mst_item table
            $data_row .= "INSERT COMMANDS IN ".$store->db_name.PHP_EOL;

            $select_query = 'SELECT vbarcode,vitemname,iqtyonhand,SID FROM '.$store->db_name.'.mst_item';
            $items_list = DB::connection('mysql')->select($select_query);
            
            // $data_row .= json_encode($items_list[0]).PHP_EOL;  continue;
            
            foreach($items_list as $item){
                
                $today = date("Y-m-d");
                
                //Check if item exists
                $check_item_snapshot_query = "select * from " . $store->db_name . ".inventory_history where date(inv_dt)=date('".$today."') and barcode='".$item->vbarcode."'";
                $check_item_snapshot_today = DB::connection('mysql')->select($check_item_snapshot_query);
                
                
                //Insert only if the record does NOT EXIST
                if(count($check_item_snapshot_today) === 0){
                    
                    $yesterday = date("Y-m-d",strtotime("-1 days"));
                    
                    $check_item_snapshot_yesterday_query = "select qoh from ".$store->db_name.".inventory_history where date(inv_dt)=date('".$yesterday."') and barcode='".$item->vbarcode."'";
                    $check_item_snapshot_yesterday = DB::connection('mysql')->select($check_item_snapshot_yesterday_query);
                    
                    // if(isset($check_item_snapshot_yesterday[0]) && gettype($check_item_snapshot_yesterday[0]) === "object"){
                    
                    if(count($check_item_snapshot_today) !== 0){
                        $qoh_yesterday = $check_item_snapshot_yesterday[0]->qoh;
                    } else {
                        $qoh_yesterday = 0;
                    }
                    
                    /*if(isset($check_item_snapshot_today[0]) && gettype($check_item_snapshot_today[0]) === "object"){
                        $qoh_today = $check_item_snapshot_today[0]->qoh;
                    } else {
                        $qoh_today = 0;
                    }*/ 
                    
                    // print_r($item); die;
                    
                    
                    // get the difference between yesterday's qoh and today's qoh
                    $qoh_today = $item->iqtyonhand;
                    $inv_consumed = $qoh_yesterday - $qoh_today;
                    
                    
                    $insert_statement = "INSERT INTO ".$store->db_name.".inventory_history (`barcode`, `item_name`, `qoh`, `inv_dt`, `inv_consumed`) VALUES('".$item->vbarcode."','".$item->vitemname."','".$item->iqtyonhand."','".$today."','".$inv_consumed."')";
                    DB::connection('mysql')->statement($insert_statement);
                    
                    
                    $data_row .= PHP_EOL;
                    $data_row .= $insert_statement.PHP_EOL;
                    
                }
                
                
            }
            
        }
        
        $data_row .= "========================================= CRON JOB ENDED ON ".date("Y-m-d H:i:s")." UTC========================================".PHP_EOL;
        
        $data_row .= PHP_EOL;
        
        fwrite($myfile,$data_row);
        fclose($myfile);
        
        DB::disconnect('mysql');
        
        return "Items snapshot taken.";
    }
    
    public function data_transfer(){
        
        $stores = Store::all();
        $departments = Department::all();
        $categories = Category::all();
        $subcategories = Subcategory::all();
        
        $store_array = array();
        foreach ($stores as $storesData) {
           $store_array[$storesData->id] = $storesData->name;
        }
        
        return view('admin.npl.transfer',compact('store_array', 'departments', 'categories', 'subcategories'));
    }
    
    public function get_department_items(Request $request){
        
        $input = $request->all();
        
        $dept_code = $input['dep_code'];
        
        // return "SELECT mi.ireorderpoint, mi.iitemid,mi.vitemcode,mi.vitemname,mi.vbarcode,mi.vsize,mi.iqtyonhand,mi.dcostprice,mi.dunitprice,mi.npack,CASE WHEN mi.npack = 1 or (mi.npack is null) then mi.iqtyonhand else (Concat(cast(((mi.iqtyonhand div mi.npack )) as signed), '  (', Mod(mi.iqtyonhand,mi.npack) ,')') ) end as QOH FROM inslocdb.mst_item as mi  LEFT JOIN inslocdb.mst_itemalias as mia ON(mi.vitemcode=mia.vitemcode) WHERE mi.vdepcode IN (".implode(',', $dept_code).") AND mi.estatus='Active'";
        
        $dept_item_query = "SELECT * FROM inslocdb.npl_items WHERE department IN(SELECT vdepartmentname FROM inslocdb.mst_department WHERE vdepcode IN('".implode("','", $dept_code)."'))";
        
        return $items = DB::select($dept_item_query);
    
        $items = $this->model_administration_promotion->getDepartmentItems($this->request->post['dep_code']);
        $count = count($items);
        
        $json = [];
        foreach($items as $value){
            if(isset($value['iitemid'])){
                $json[] = ['id'=>$value['iitemid'], 'text'=>$value['vitemname']." [".$value['vbarcode']."]", 'cost'=>$value['dcostprice'], 'unit'=>$value['dunitprice'],'total_count'=>$count];
            } 
        }
        
        return response()->json($json);
    }
    
    public function get_department_categories(Request $request){
        
        $input = $request->all();
        
        $dept_code = $input['dep_code'];
        
        $dept_cat_query = "SELECT * FROM inslocdb.mst_category where dept_code IN ('".implode("','", $dept_code)."') ORDER BY vcategoryname";
        
        $categories = DB::select($dept_cat_query);
        
        // $cat_list = "<option value='all'>All</option>";
        
        $cat_list = "";
        
        foreach($categories as $category){
            if(isset($category->vcategorycode)){
                $cat_code = $category->vcategorycode;
                $cat_name = $category->vcategoryname;
                $cat_list .= "<option value=".$cat_code.">".$cat_name."</option>";
            } 
        }
        
        return $cat_list;
        
    }
    

    public function get_category_items(Request $request){
        
        $input = $request->all();
        
        $dept_code = $input['dep_code'];
        
        $cat_code  = $input['cat_code'];
        
        // return "SELECT mi.ireorderpoint, mi.iitemid,mi.vitemcode,mi.vitemname,mi.vbarcode,mi.vsize,mi.iqtyonhand,mi.dcostprice,mi.dunitprice,mi.npack,CASE WHEN mi.npack = 1 or (mi.npack is null) then mi.iqtyonhand else (Concat(cast(((mi.iqtyonhand div mi.npack )) as signed), '  (', Mod(mi.iqtyonhand,mi.npack) ,')') ) end as QOH FROM inslocdb.mst_item as mi  LEFT JOIN inslocdb.mst_itemalias as mia ON(mi.vitemcode=mia.vitemcode) WHERE mi.vdepcode IN (".implode(',', $dept_code).") AND mi.estatus='Active'";
        
        $dept_item_query = "SELECT * FROM inslocdb.npl_items WHERE department IN(SELECT vdepartmentname FROM inslocdb.mst_department WHERE vdepcode IN('".implode("','", $dept_code)."')) AND category IN(SELECT vcategoryname FROM inslocdb.mst_category WHERE vcategorycode IN('".implode("','", $cat_code)."'))";
        
        return $items = DB::select($dept_item_query);
    
        $items = $this->model_administration_promotion->getDepartmentItems($this->request->post['dep_code']);
        $count = count($items);
        
        $json = [];
        foreach($items as $value){
            if(isset($value['iitemid'])){
                $json[] = ['id'=>$value['iitemid'], 'text'=>$value['vitemname']." [".$value['vbarcode']."]", 'cost'=>$value['dcostprice'], 'unit'=>$value['dunitprice'],'total_count'=>$count];
            } 
        }
        
        return response()->json($json);
    }
    
    
    public function get_category_sub_categories(Request $request){
        
        $input = $request->all();
        
        $cat_code = $input['cat_code'];
        
        $cat_subcat_query = "SELECT * FROM inslocdb.mst_subcategory where cat_id IN ('".implode("','", $cat_code)."') ORDER BY subcat_name";
        
        $subcategories = DB::select($cat_subcat_query);
        
        // $subcat_list = "<option value='all'>All</option>";
        
        $subcat_list = "";
        
            foreach($subcategories as $subcategory){
                if(isset($subcategory->subcat_name)){
                    $sub_cat_id = $subcategory->subcat_id;
                    $sub_cat_name = $subcategory->subcat_name;
                    $subcat_list .= "<option value=".$sub_cat_id.">".$sub_cat_name."</option>";
                } 
            }
            echo $subcat_list;
        
    }
    
    
    public function data_transfer_to_store(Request $request){
        
        $data = $request->all();
      //
        
        ini_set('memory_limit',-1);
        
        $targetStoreId = "u".$data['store'];
        
        if(isset($data['department_id']) && count($data['department_id']) > 0){
            
            $string_department_id = implode(',', $data['department_id']);
            
            // print_r($string_department_id); die;
            
            // $query = "SELECT * FROM inslocdb.mst_item mi LEFT JOIN inslocdb.mst_department md ON mi.vdepcode = md.vdepcode LEFT JOIN inslocdb.mst_category mc ON mi.vcategorycode=mc.vcategorycode LEFT JOIN inslocdb.mst_subcategory msc ON mi.subcat_id=msc.subcat_id WHERE mi.vdepcode IN(".$string_department_id.")";
            
            $query = "SELECT * FROM inslocdb.npl_items WHERE department IN(SELECT vdepartmentname FROM inslocdb.mst_department WHERE vdepcode IN(".$string_department_id."))";
            
            if(isset($data['category_id']) && count($data['category_id']) > 0){
            
                $string_category_id = implode(',', $data['category_id']);
                
                // print_r($string_department_id); die;
                
                $query .= " AND category IN(SELECT vcategoryname FROM inslocdb.mst_category WHERE vcategorycode IN(".$string_category_id."))";
            }
           
            if(isset($data['subcategory_id']) && count($data['subcategory_id']) > 0){
            
                $string_subcategory_id = implode(',', $data['subcategory_id']);
                
                // print_r($string_department_id); die;
                
                // $query .= " AND mi.subcat_id IN(".$string_subcategory_id.")";
                
                $query .= " AND subcategory IN(SELECT subcat_name FROM inslocdb.mst_subcategory WHERE subcat_id IN(".$string_subcategory_id."))";
            }
            

        } else {
            $query = "SELECT * FROM inslocdb.mst_item";
        }
        
        // return $query;
        
        
        
        $response =  DB::select($query);
       // print_r($response);die;
        $file_path = storage_path()."/logs/transfer_from_npl.txt";
        
        if(is_file($file_path)) {
            unlink($file_path);
        }
        
        $myfile = fopen($file_path, "a");
        

        // return $response;
        if(!empty($response)) {
            
            $added = $skipped = 0;
            foreach($response as $r) {
                
                
                
                // Check if the barcode exists
                $is_exist = DB::select("SELECT * FROM $targetStoreId.mst_item WHERE vbarcode = '".$r->barcode."'");
                
                // echo json_encode($is_exist); die;
                
                if(empty($is_exist)) {
                    
                    // Check if the department exists
                    $department_id = $this->check_department($r->department, $targetStoreId);
                    
                    // Check if the category exists
                    $category_id = $this->check_category($r->category, $department_id, $targetStoreId);
                    
                    // Check if the subcategory exists
                    $subcategory_id = $this->check_category($r->subcategory, $category_id, $targetStoreId);
                    
                    // Check if the unit exists
                    $unit_code = $this->check_unit($r->unit, $targetStoreId);
                    
                    // Check if the manufacturer exists
                    $manufacturer_id = $this->check_manufacturer($r->manufacturer, $targetStoreId);
                    

                    try{
                        
                        $insert_query = "INSERT INTO $targetStoreId.mst_item SET  `vitemtype` = '" . $r->item_type . "', vitemcode = '" . $r->barcode . "',`vitemname` = '" . $r->item_name . "',`vunitcode` = '" . $unit_code . "', vbarcode = '" . $r->barcode . "', vcategorycode = '" . $category_id . "', vdepcode = '" . $department_id . "', iqtyonhand = '" . (int)$r->qty_on_hand . "', dcostprice = '" . $r->cost . "', dunitprice = '" . $r->selling_price . "', vtax1 = '" . $r->tax1 . "', vtax2 = '" . $r->tax2 . "', vfooditem = '" . $r->food_stamp . "', visinventory = 'Yes', estatus = 'Active', vageverify = '" . $r->age_verification . "',  dcreated = NULL, dlastupdated = NULL , dlastreceived = NULL, dlastordered = NULL, vsize = '" . $r->size . "', nsellunit = '" . (int)$r->selling_unit . "', SID = '" . (int)($data['store']) . "', wicitem = '" . (int)$r->WIC_item . "'";
                        
                        DB::statement($insert_query);
                        
                        $text = $r->barcode.' inserted.'.PHP_EOL;
                        
                        ++$added;
                        
                    }
                    catch(Exception $e) {
                        continue;
                    }
                } else {
                    
                    $text = $r->barcode.' already exists.'.PHP_EOL;
                    
                    ++$skipped;
                }
                
                fwrite($myfile,$text);
            }
            
            $text = PHP_EOL.'Note: '.$added.' added and '.$skipped.' skipped.';
            
            fwrite($myfile,$text);
        } else {
            
            $text = PHP_EOL.'No items fall under the selected criteria.';
            
            fwrite($myfile,$text);
        }
        
        
        
        fclose($myfile);
        
        $headers = [
            'Content-type' => 'text/plain', 
        ];

        return response()->download($file_path, 'Items downloaded from NPL.txt', $headers);
    }
    
    
    public function check_department($department_name, $store_db){
        
        // check if the relevant record exists
        $query = "SELECT * FROM ".$store_db.".mst_department WHERE vdepartmentname='".$department_name."'";
        
        $check_record = DB::select($query);
        
        if(count($check_record) > 0){
            
            $dept_code = $check_record[0]->idepartmentid;
        } else {
            
            $insert_query = "INSERT INTO `".$store_db."`.`mst_department`(`vdepartmentname`, `vdescription`, `isequence`, `estatus`, `LastUpdate`, `SID`) VALUES('".$department_name."','".$department_name."', '0', 'Active', '".date('Y-m-d H:i:s')."', '0')";
            
            $run_query = DB::statement($insert_query);
            
            $dept_code  = DB::getPdo()->lastInsertId();
            
            
            $update_query = "UPDATE ".$store_db.".mst_department SET `vdepcode`='".$dept_code."' WHERE idepartmentid=".$dept_code;
            
            $update = DB::statement($update_query);
        }
        
        return $dept_code;
    }
    
    
    public function check_category($category_name, $department_id, $store_db){
        
        // check if the relevant record exists
        $query = "SELECT * FROM ".$store_db.".mst_category WHERE vcategoryname='".$category_name."'";
        
        $check_record = DB::select($query);
        
        if(count($check_record) > 0){
            
            $cat_id = $check_record[0]->icategoryid;
        } else {
            
            $insert_query = "INSERT INTO `".$store_db."`.`mst_category`(`vcategoryname`, `vdescription`, `isequence`, `estatus`, `LastUpdate`, `SID`, `dept_code`) VALUES('".$category_name."','".$category_name."', '0', 'Active', '".date('Y-m-d H:i:s')."', '0','".$department_id."')";
            
            $run_query = DB::statement($insert_query);
            
            $cat_id  = DB::getPdo()->lastInsertId();
            
            
            $update_query = "UPDATE ".$store_db.".mst_category SET `vcategorycode`='".$cat_id."' WHERE icategoryid=".$cat_id;
            
            $update = DB::statement($update_query);
        }
        
        return $cat_id;
    }
    
    
    public function check_subcategory($subcategory_name, $category_id, $store_db){
        
        // check if the relevant record exists
        $query = "SELECT * FROM ".$store_db.".mst_subcategory WHERE subcat_name='".$subcategory_name."'";
        
        $check_record = DB::select($query);
        
        if(count($check_record) > 0){
            
            $subcat_id = $check_record[0]->subcat_id;
        } else {
            
            $insert_query = "INSERT INTO `".$store_db."`.`mst_subcategory`(`subcat_name`, `status`, `created_at`, `LastUpdate`, `SID`, `cat_id`) VALUES('".$subcategory_name.", 'Active', '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."', '0','".$category_id."')";
            
            $run_query = DB::statement($insert_query);
            
            $subcat_id  = DB::getPdo()->lastInsertId();
        }
        
        return $subcat_id;
    }
    
    
    public function check_unit($unit_name, $store_db){
        
        // check if the relevant record exists
        $query = "SELECT * FROM ".$store_db.".mst_unit WHERE vunitname='".$unit_name."'";
        
        $check_record = DB::select($query);
        
        if(count($check_record) > 0){
            
            $unit_id = $check_record[0]->iunitid;
        } else {
            
            $insert_query = "INSERT INTO `".$store_db."`.`mst_unit`(`vunitname`, `vunitcode`, `vunitdesc`, `estatus`, `LastUpdate`, `SID`) VALUES('".$unit_name."', '', '', 'Active', '".date('Y-m-d H:i:s')."', '0')";
            
            $run_query = DB::statement($insert_query);
            
            $unit_id  = DB::getPdo()->lastInsertId();
            
            $unit_code = 'UNT00'.$unit_id;
            
            $update_query = "UPDATE ".$store_db.".mst_unit SET `vunitcode`='".$unit_code."' WHERE iunitid=".$unit_id;
            
            $update = DB::statement($update_query);
        }
        
        return $unit_id;
    }
    
    
    public function check_manufacturer($manufacturer_name, $store_db){
        
        // check if the relevant record exists
        $query = "SELECT * FROM ".$store_db.".mst_manufacturer WHERE mfr_name='".$manufacturer_name."'";
        
        $check_record = DB::select($query);
        
        if(count($check_record) > 0){
            
            $mfr_id = $check_record[0]->mfr_id;
        } else {
            
            $insert_query = "INSERT INTO `".$store_db."`.`mst_manufacturer`(`mfr_name`, `status`, `created_at`, `LastUpdate`, `SID`) VALUES('".$manufacturer_name."', 'Active', '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."', '0')";
            
            $run_query = DB::statement($insert_query);
            
            $mfr_id  = DB::getPdo()->lastInsertId();
            
            $update_query = "UPDATE ".$store_db.".mst_manufacturer SET `mfr_code`='".$mfr_id."' WHERE mfr_id=".$mfr_id;
            
            $update = DB::statement($update_query);
        }
        
        return $mfr_id;
    }
    
    public function __destruct(){
        $this->cleanup();
    }
    
    public function cleanup() {
        //cleanup everything from attributes
        foreach (get_class_vars(__CLASS__) as $clsVar => $_) {
            unset($this->$clsVar);
        }
    
        //cleanup all objects inside data array
        if (is_array($this->_data)) {
            foreach ($this->_data as $value) {
                if (is_object($value) && method_exists($value, 'cleanUp')) {
                    $value->cleanUp();
                }
            }
        }
    }
    
    
    public function transfer_newskus_to_npl(){
        
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 0);
        
        //get the list of items to be transferred
        $new_sku_details = NewSku::where('added_to_npl', '!=', '1')->get()->toArray();
        
        $file_path = storage_path()."/logs/transfer_to_npl.txt";
        
        $myfile = fopen($file_path, "a");
        
        $data = PHP_EOL."===============================================".date('Y-m-d')."=========================================================".PHP_EOL;
        
        fwrite($myfile, $data);
        
        foreach($new_sku_details as $new_sku){
            
            // print_r($new_sku); die;
            
            // form the query to get the relevant details from the mst_item
            $db = $new_sku['SID'];
        
            $query_db = 'USE DATABASE '.$db;
        
            DB::raw($query_db);
        
            $db_select = DB::select(DB::raw("SELECT * FROM ".$db.".mst_item WHERE vbarcode = :barcode"), array('barcode' => $new_sku['barcode']));
        
        
            // echo "<pre>";print_r($db_select[0]);echo "</pre>"; die;
            
            if(!isset($db_select[0])){
                continue;
            }
        
            $selected_item = $db_select[0];
            
            // return gettype($selected_item);

            $department = DB::select(DB::raw("SELECT vdepartmentname FROM ".$db.".mst_department WHERE vdepcode = :dept_code"), array('dept_code' => $selected_item->vdepcode));
            $department = array_key_exists(0, $department)?$department[0]->vdepartmentname:"General";
            
            $category = DB::select(DB::raw("SELECT vcategoryname FROM ".$db.".mst_category WHERE vcategorycode = :category_code"), array('category_code' => $selected_item->vcategorycode));
            $category = array_key_exists(0, $category)?$category[0]->vcategoryname:"General";
    
            
            $supplier = DB::select(DB::raw("SELECT vcompanyname FROM ".$db.".mst_supplier WHERE vsuppliercode = :supplier_code"), array('supplier_code' => $selected_item->vsuppliercode));
            $supplier = array_key_exists(0, $supplier)?$supplier[0]->vcompanyname:"General";
            
            if(isset($selected_item->subcat_id)){
                $subcat = DB::select(DB::raw("SELECT msc.subcat_name FROM ".$db.".mst_subcategory msc WHERE subcat_id = :subcat_id"), array('subcat_id' => $selected_item->subcat_id));
                $subcat = array_key_exists(0, $subcat)?$subcat[0]->subcat_name:"General";  
            } else {
                $subcat = "General";
            }
            
            //create array to display details
            $npl_item = [];
            $npl_item['barcode'] = $selected_item->vbarcode;
            $npl_item['item_type'] = $selected_item->vitemtype;
            $npl_item['item_name'] = $selected_item->vitemname;
            $npl_item['description'] = $selected_item->vdescription;
            $npl_item['unit'] = $selected_item->nsellunit;
            
            $npl_item['department'] = $department;
            $npl_item['category'] = $category;
            $npl_item['supplier'] = $supplier;
            $npl_item['sub_category'] = $subcat;
            
            // $npl_item['group'] = $group->vitemgroupname;
            
            $npl_item['size'] = $selected_item->vsize;
            $npl_item['cost'] = $selected_item->dcostprice;
            $npl_item['selling_price'] = $selected_item->dunitprice;
            $npl_item['qty_on_hand'] = $selected_item->iqtyonhand;
            $npl_item['tax1'] = $selected_item->vtax1;
            $npl_item['tax2'] = $selected_item->vtax2;
            $npl_item['selling_unit'] = $selected_item->nsellunit;
            $npl_item['food_stamp'] = $selected_item->vfooditem;
            $npl_item['WIC_item'] = $selected_item->wicitem;
            
            if(isset($selected_item->vageverify) && $selected_item->vageverify != 0){
                $npl_item['age_verification'] = $selected_item->vageverify;
            }
           
        //   echo "1605"." ";
           
        //   echo $selected_item->vbarcode;
           
            $selected_npl_item = Nplitem::find($selected_item->vbarcode);
            
            // dd(isset($selected_npl_item));die;
            
            if(!isset($selected_npl_item)){
                $data = 'Create: Item with barcode ' . $selected_item->vbarcode;
                fwrite($myfile, $data);

                try {
                    $migrate_to_npl_items = Nplitem::create($npl_item);
                }catch (Exception $e) {
                    $data = 'Error: Item with barcode ' . $selected_item->vbarcode .json_encode($e).PHP_EOL;
                    fwrite($myfile, $data);
                    continue;
                }
            } else {
                $data = 'Update: Item with barcode ' . $selected_item->vbarcode;
                fwrite($myfile, $data);
                
                // $migrate_to_npl_items = $selected_npl_item->update($npl_item);
                
                try {
                    $migrate_to_npl_items = $selected_npl_item->update($npl_item);
                }catch (Exception $e) {
                    $data = 'Error: Item with barcode ' . $selected_item->vbarcode .json_encode($e).PHP_EOL;
                    fwrite($myfile, $data);
                    continue;
                }
            }
            
            
            if($migrate_to_npl_items) {
                $new_sku = NewSku::where('barcode', '=', $selected_item->vbarcode)->first();
                $new_sku->added_to_npl = 1;
                $new_sku->save();
                
                // $data .= 'Item with barcode ' . $selected_item->vbarcode .  ' added to NPL Successfully'.PHP_EOL;
                $data = ' added to NPL Successfully'.PHP_EOL;
                
            } else {
                // $data .= 'Item with barcode ' . $selected_item->vbarcode .' could not be added to NPL'.PHP_EOL;
                $data = ' could not be added to NPL'.PHP_EOL;
                
            }
            
            // print_r($npl_item); die;

            fwrite($myfile, $data);
        }
        
        $done = "Done transferring New SKUs to NPL";
        fwrite($myfile, $done);
        
        fclose($myfile);
        unset($data); 
        unset($new_sku_details);
        
        return $done;
    }
    
    
    public function transfer_items_to_npl_from_npl_store(Request $request){
        
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 0);
        
        $file_path = storage_path()."/logs/transfer_to_npl_from_NPL_store.txt";
        
        $myfile = fopen($file_path, "a");
        
        $data = PHP_EOL."===============================================".date('Y-m-d')."=========================================================".PHP_EOL;
        
        fwrite($myfile, $data);

        $items_from_nplstore = DB::connection('development')->select(DB::raw('SELECT * FROM u100552.mst_item'));

        $db = 'u100552'; // db relevant to NPL_store

        foreach($items_from_nplstore as $selected_item){
            
/*            $department = $this->check_table('development', 'vdepartmentname', 'u100552', 'mst_department', 'vdepcode', $selected_item->vdepcode);
            
            $category = $this->check_table('development', 'vcategoryname', 'u100552', 'mst_category', 'vcategorycode', $selected_item->vcategorycode);
            
            $subcat = $this->check_table('development', 'subcat_name', 'u100552', 'mst_subcategory', 'subcat_id', $selected_item->subcat_id);
            
            $supplier = $this->check_table('development', 'vcompanyname', 'u100552', 'mst_supplier', 'vsuppliercode', $selected_item->vsuppliercode);
*/            
            /*if(isset($selected_item->subcat_id)){
                $subcat = DB::connection('development')->select(DB::raw("SELECT msc.subcat_name FROM ".$db.".mst_subcategory msc WHERE subcat_id = :subcat_id"), array('subcat_id' => $selected_item->subcat_id));
                $subcat = array_key_exists(0, $subcat)?$subcat[0]->subcat_name:"General";  
            } else {
                $subcat = "General";
            }*/
            
            $department = $category = $subcat = $supplier = 'General';
            
            $size = $unit = 'Each';
            
            //create array to display details
            $npl_item = [];
            $npl_item['barcode'] = $selected_item->vbarcode;
            $npl_item['item_type'] = $selected_item->vitemtype;
            $npl_item['item_name'] = $selected_item->vitemname;
            $npl_item['description'] = $selected_item->vdescription;
            $npl_item['unit'] = $unit;
            
            $npl_item['department'] = $department;
            $npl_item['category'] = $category;
            $npl_item['supplier'] = $supplier;
            $npl_item['sub_category'] = $subcat;
            
            // $npl_item['group'] = $group->vitemgroupname;
            
            $npl_item['size'] = $size;
            $npl_item['cost'] = $selected_item->dcostprice;
            $npl_item['selling_price'] = $selected_item->dunitprice;
            $npl_item['qty_on_hand'] = $selected_item->iqtyonhand;
            $npl_item['tax1'] = $selected_item->vtax1;
            $npl_item['tax2'] = $selected_item->vtax2;
            $npl_item['selling_unit'] = $selected_item->nsellunit;
            $npl_item['food_stamp'] = $selected_item->vfooditem;
            $npl_item['WIC_item'] = $selected_item->wicitem;
            
            if(isset($selected_item->vageverify) && $selected_item->vageverify != 0){
                $npl_item['age_verification'] = $selected_item->vageverify;
            }
           
            // echo '<pre>';print_r($npl_item);echo '</pre>';die;
           
            $selected_npl_item = Nplitem::find($selected_item->vbarcode);
            
            // dd(isset($selected_npl_item));die;
            
            if(!isset($selected_npl_item)){
                $data = 'Create: Item with barcode ' . $selected_item->vbarcode.PHP_EOL;
                fwrite($myfile, $data);

                try {
                    $migrate_to_npl_items = Nplitem::create($npl_item);
                }catch (\Exception $e) {
                    $data = 'Error: Item with barcode ' . $selected_item->vbarcode .json_encode($e).PHP_EOL;
                    fwrite($myfile, $data);
                    continue;
                }
            } else {
                $data = 'Update: Item with barcode ' . $selected_item->vbarcode.PHP_EOL;
                fwrite($myfile, $data);
                
                // $migrate_to_npl_items = $selected_npl_item->update($npl_item);
                
                try {
                    $migrate_to_npl_items = $selected_npl_item->update($npl_item);
                }catch (\Exception $e) {
                    $data = 'Error: Item with barcode ' . $selected_item->vbarcode .json_encode($e).PHP_EOL;
                    fwrite($myfile, $data);
                    continue;
                }
            }
            
        }

        fclose($myfile);
        unset($data); unset($items_from_nplstore);
        
        return "Done transferring items From NPL Store (development) to NPL";

    }
    
    public function check_table($connection, $column_name, $db, $table, $field, $value){
        
        $query = 'SELECT `'.$column_name.'` FROM '.$db.'.'.$table.' WHERE '.$field.'="'.$value.'"';
        
        $run_query = DB::connection($connection)->select(DB::raw($query));
        
        $result = array_key_exists(0, $run_query)?$run_query[0]->$column_name:"General";
        
        return $result;
    }
    
    public function add_new_sku_to_npl(){
        
        ini_set('memory_limit', '-1');
        
        ini_set('max_execution_time', 600);
        
        $newly_added_items = NewSku::where('SID', '!=', 'u100630')->where('added_to_npl', '=', '0')->get();
        
        $already_exists = $inserted_items = $not_inserted = $total = $not_exist_store = 0;

        
        foreach($newly_added_items as $item){
            
            $barcode = $item->barcode;
            
            //check if the item is present in NPL
            $check_npl = Nplitem::where('barcode', '=', $item->barcode)->first();
        
            if(gettype($check_npl) === 'object'){
                $already_exists++;
                continue;
            }
            
            /*if($item->added_to_npl == 1){
                
                $new_item = Nplitem::where('barcode', '=', $barcode)->first();
                
                $new_item->added_to_npl = 1;
                
                // return json_encode($new_item);
                return view('admin.new_sku.edit',compact('new_item', 'store_array'));
            }*/
            
            $db = $item->SID;
            
            $query_db = 'USE DATABASE '.$db;
            
            DB::raw($query_db);
            
            $db_select = DB::select(DB::raw("SELECT * FROM ".$db.".mst_item WHERE vbarcode = :barcode"), array('barcode' => $barcode));
            
            if(count($db_select) === 0){
                // echo 'SID: '.$db.' Barcode: '.$barcode.'<br>';
                // print_r($db_select);
                $not_exist_store++;
                continue;
            }
            
            //die;
            
            $selected_item = $db_select[0];
            
                    // return json_encode($selected_item);
    
            
            $department = DB::select(DB::raw("SELECT vdepartmentname FROM ".$db.".mst_department WHERE vdepcode = :dept_code"), array('dept_code' => $selected_item->vdepcode));
            $department = array_key_exists(0, $department)?$department[0]->vdepartmentname:"General";
            
            $category = DB::select(DB::raw("SELECT vcategoryname FROM ".$db.".mst_category WHERE vcategorycode = :category_code"), array('category_code' => $selected_item->vcategorycode));
            $category = array_key_exists(0, $category)?$category[0]->vcategoryname:"General";
    
            
            $supplier = DB::select(DB::raw("SELECT vcompanyname FROM ".$db.".mst_supplier WHERE vsuppliercode = :supplier_code"), array('supplier_code' => $selected_item->vsuppliercode));
            $supplier = array_key_exists(0, $supplier)?$supplier[0]->vcompanyname:"General";
            
            
            $group = DB::select(DB::raw("SELECT ig.vitemgroupname FROM ".$db.".itemgroupdetail igd RIGHT JOIN " . $db . ".itemgroup ig ON igd.iitemgroupid = ig.iitemgroupid WHERE vsku = :barcode"), array('barcode' => $barcode));
            $group = array_key_exists(0, $group)?$group[0]:(object)['vitemgroupname' => ""];
            
            // return json_encode($group);
            
            //create array to display details
            $npl_item = [];
            $npl_item['barcode'] = $selected_item->vbarcode;
            $npl_item['item_type'] = $selected_item->vitemtype;
            $npl_item['item_name'] = $selected_item->vitemname;
            $npl_item['description'] = $selected_item->vdescription;
            $npl_item['unit'] = $selected_item->nsellunit;
            
            $npl_item['department'] = $department;
            $npl_item['category'] = $category;
            $npl_item['supplier'] = $supplier;
            $npl_item['group'] = $group->vitemgroupname;
            
            $npl_item['size'] = $selected_item->vsize;
            $npl_item['cost'] = $selected_item->dcostprice;
            $npl_item['selling_price'] = $selected_item->dunitprice;
            $npl_item['qty_on_hand'] = $selected_item->iqtyonhand;
            $npl_item['tax1'] = $selected_item->vtax1;
            $npl_item['tax2'] = $selected_item->vtax2;
            $npl_item['selling_unit'] = $selected_item->nsellunit;
            $npl_item['food_stamp'] = $selected_item->vfooditem;
            $npl_item['WIC_item'] = $selected_item->wicitem;
            $npl_item['age_verification'] = $selected_item->vageverify;
            
            // print_r($npl_item); die;
            
            // $new_item = (object)$npl_item; 
            
             $inserted_npl_items = Nplitem::create($npl_item);
            
            if($inserted_npl_items) {
                $new_sku = NewSku::where('barcode', '=', $barcode)->first();
                $new_sku->added_to_npl = 1;
                $new_sku->save();
                
                $inserted_items++;
            } else {
                $not_inserted++;
            }
            
            $total++;
        } 
        
        $response = 'Total: '.$total.'. Already exists in NPL: '.$already_exists.'. Inserted items: '.$inserted_items.'. Not inserted items: '.$not_inserted.'. Does not exist in Store: '.$not_exist_store; 
        
        return $response;
    }
}
?>