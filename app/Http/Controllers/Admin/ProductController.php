<?php

namespace pos2020\Http\Controllers\Admin;

//use Illuminate\Http\Request;
use Request;
use pos2020\Http\Controllers\Controller;
use pos2020\Http\Requests;
use pos2020\Unit;
use pos2020\Item;
use pos2020\MST_DEPARTMENT;
use pos2020\MST_SIZE;
use pos2020\MST_SUPPLIER;
use pos2020\MST_CATEGORY;
use pos2020\ITEMGROUP;
use pos2020\MST_AGEVERIFICATION;
use pos2020\MST_DISCOUNT;
use pos2020\PRODUCTS;
use pos2020\Http\Requests\createProductRequest;
use pos2020\ITEMGROUPDETAIL;
use pos2020\Store;
use pos2020\kioskCategory;
use pos2020\kioskMenuItem;
use pos2020\kioskPageFlowHeader;
use pos2020\kioskPageFlowDetail;
use pos2020\tmp_priceupdate;
use Validator;
use Session;
use File;
use pos2020\WEB_MST_ITEM;
use pos2020\MST_TAX;
use pos2020\Nplitem;
use DB;
use DateTime;
use Response;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stores = Store::all();
        $store_array = array();
        foreach ($stores as $storesData) {
           $store_array[$storesData->id] = $storesData->name;
        }

        $departments = MST_DEPARTMENT::all();
        $category = MST_CATEGORY::all();

        $department_array = array('0' => 'Select Department');
        foreach ($departments as $department) {
            $department_array[$department->vdepcode] = $department->vdepartmentname;
        }

        $category_array = array('0' => 'Select Category');
        foreach ($category as $categoryData) {
            $category_array[$categoryData->vcategorycode] = $categoryData->vcategoryname;
        }

        $stores = Store::all();
        $store_array = array();
        foreach ($stores as $storesData) {
           $store_array[$storesData->id] = $storesData->name;
        }

        // .............................   Search Filter ---------------------------------------

        $department = Request::get('vdepcode');
        $category = Request::get('vcategorycode');
        $itemName = Request::get('vitemname');
        $sku = Request::get('vbarcode');
        $appends = array();
        $productObj = Item::orderBy('mst_item.LastUpdate','desc')->currentStore();

        if(Request::get('vdepcode')){
            $productObj->where('mst_item.vdepcode','=',Request::get('vdepcode'));
            $appends['vdepcode'] = Request::get('vdepcode');

        }
        if(Request::get('vcategorycode')){
            $productObj->where('mst_item.vcategorycode','=',Request::get('vcategorycode'));
            $appends['vcategorycode'] = Request::get('vcategorycode');
        }
        if(Request::get('vitemname')){
            $productObj->where('mst_item.vitemname','like','%'.Request::get('vitemname') .'%');
            $appends['vitemname'] = Request::get('vitemname');

        }
        if(Request::get('vbarcode')){
            $productObj->where('mst_item.vbarcode','=',Request::get('vbarcode'));
            $appends['vbarcode'] = Request::get('vbarcode');
        }

        $products = $productObj->paginate(20);
        $products->appends($appends);

        // ...........................................................................................

        if (Request::isJson()){
            return $products->toJson();
        }else{
           return view('admin.product.index',compact('products','store_array','department_array','category_array'));
        }   
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        ini_set('memory_limit', '500M');
        $unit = new Unit;
        $units = Unit::all();
   //     $item = Item::all();
        $departments = MST_DEPARTMENT::all();
        $size = MST_SIZE::all();
        $supplier = MST_SUPPLIER::all();
        $category = MST_CATEGORY::all();
        $group = ITEMGROUP::all();
        $ageVerification = MST_AGEVERIFICATION::all();
        $discount = MST_DISCOUNT::all();

        $unit_array = array();
        $item_type_array = array();
        $department_array = array();
        $size_array = array();
        $supplier_array = array();
        $category_array = array();
        $group_array = array();
        $color_array = array('None');
        $ageVerification_array = array();
        $item_name_array = array();
        $barcode_type_array = array();
        $discount_array = array();
        $chk_array = array();
        $bottle_deposit_array = array();
        $inventoryItem_array = array();

        foreach ($units as $unit) {
            $unit_array[$unit->vunitcode] = $unit->vunitname;
        }
        /*
        foreach ($item as $type) {
            $item_type_array[$type->iitemid] = $type->vitemtype;
        }
        */
         
        foreach ($departments as $department) {
          $department_array[$department->vdepcode] = $department->vdepartmentname;
        }
        foreach ($size as $sizeData) {
            $size_array[$sizeData->isizeid] = $sizeData->vsize;
        }
        foreach ($supplier as $supplierData) {
            $supplier_array[$supplierData->vsuppliercode] = $supplierData->vcompanyname;
        }
        foreach ($category as $categoryData) {
            $category_array[$categoryData->vcategorycode] = $categoryData->vcategoryname;
        }
        foreach ($group as $groupData) {
            $group_array[$groupData->iitemgroupid] = $groupData->vitemgroupname;
        }
        /*
        foreach ($item as $colorCode) {
            $color_array[$colorCode->iitemid] = $colorCode->vcolorcode;
        }
        */
        foreach ($ageVerification as $ageVerificationData) {
            $ageVerification_array[$ageVerificationData->vvalue] = $ageVerificationData->vname;
        }
        /*
        foreach ($item as $itemName) {
            $item_name_array[$itemName->vitemname] = $itemName->vitemname;
        }
        */
        foreach ($discount as $discountData) {
            $discount_array[$discountData->idiscountid] = $discountData->vdescription;
        }
        /*
        foreach ($item as $barCodeType) {
            $barcode_type_array[$barCodeType->iitemid] = $barCodeType->vbarcodetype;
        }
        
        foreach ($item  as $bottleData) {
            $bottle_deposit_array[$bottleData->iitemid] = $bottleData->ebottledeposit;
        }
        foreach ($item  as $inventoryData) {
            $inventoryItem_array[$inventoryData->iitemid] = $inventoryData->visinventory;
        }
        */
        $stores = Store::all();
        $store_array = array();
        foreach ($stores as $storesData) {
           $store_array[$storesData->id] = $storesData->name;
        }
        return view('admin.product.create',compact('unit_array','item_type_array','department_array','size_array','supplier_array','category_array'
            ,'group_array','color_array','ageVerification_array','item_name_array','barcode_type_array','discount_array','bottle_deposit_array','inventoryItem_array','itemType','yesNo','foodItem','store_array'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
        $validation = Item::Validate(Request::all());
        $checked = Request::get('checkStore') ;
      
        if($validation->fails() === false)
        {
            if($checked == 'Y')
            {
                $storeData = Store::where('id','=',SESSION::get('selected_store_id'))->get();
                $storeId = array();

                foreach ($storeData as $store) {
                    $storeId[] = $store->id;
                }

                $product = Item::whereIn('SID',$storeId)->first();
            }

            $products = new Item;
            $products->SID = SESSION::get('selected_store_id');
            $products->estatus = Item::STATUS_ACTIVE;
            $products->vitemtype = Request::get('vitemtype');
            $products->vitemname = Request::get('vitemname');
            $products->vunitcode = Request::get('vunitcode');
            $products->vdepcode = Request::get('vdepcode');
            $products->vsize = Request::get('vsize');
            $products->npack = Request::get('npack');
            $products->dcostprice = Request::get('dcostprice');
            $products->nunitcost = Request::get('nunitcost');
            $products->vbarcode = Request::get('vbarcode');
            $products->vdescription = Request::get('vdescription');
            $products->vsuppliercode = Request::get('vsuppliercode');
            $products->vcategorycode = Request::get('vcategorycode');
            $products->itemimage = Request::file('file');

            if (Request::hasFile('file')) {
                $file = Request::file('file');
                $destination_path = Item::PRODUCT_IMAGEPATH;
                $filename = str_random(6).'_'.$file[0]->getClientOriginalName();
                $file[0]->move($destination_path, $filename);
                $products->itemimage = $destination_path . $filename;
            }

            if(Request::get('groupName')){
              $group = new ITEMGROUPDETAIL;
              $group->iitemgroupid = Request::get('groupName');
              $group->vsku = Request::get('sku');
              $group->save();
            }
            $products->nsellunit = Request::get('nsellunit');
            $products->nsaleprice = Request::get('nsaleprice');
            $products->vsequence = Request::get('vsequence');
            $products->vcolorcode = Request::get('vcolorcode');
            $products->vshowsalesinzreport = Request::get('vshowsalesinzreport');
            $products->iqtyonhand = Request::get('iqtyonhand');
            $products->nlevel2 = Request::get('nlevel2');
            $products->nlevel4 = Request::get('nlevel4');
            $products->visinventory = Request::get('visinventory');
            $products->VAGEVERIFY = Request::get('VAGEVERIFY');
            $products->ebottledeposit = Request::get('ebottledeposit');
            $products->ireorderpoint = Request::get('ireorderpoint');
            $products->nlevel3 = Request::get('nlevel3');
            $products->ndiscountper = Request::get('ndiscountper');
            $products->vfooditem = Request::get('vfooditem');
            $products->vtax1 = (Request::get('vtax1') ? Request::get('vtax1') : 'N');
            $products->vtax2 = (Request::get('vtax2') ? Request::get('vtax2') : 'N');
            $products->vbarcodetype = Request::get('vbarcodetype');
            $products->vdiscount = Request::get('vdiscount');
            $products->norderqtyupto = Request::get('norderqtyupto');
            $products->save();

             if (Request::isJson()){
                 return config('app.RETURN_MSG.SUCCESS');
             }

            
            return redirect('admin/products')->withSuccess('Product Created Successfully');
        }
        else
        {
          if (Request::isJson()){
             return  $validation->errors()->all();
        }
          return redirect('/admin/products/create')->withInput()
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
        ini_set('memory_limit', '500M');   
        $products = Item::where('iitemid',$id)->first();
        $units = Unit::all();
        $item = Item::all();
        $departments = MST_DEPARTMENT::all();
        $size = MST_SIZE::all();
        $supplier = MST_SUPPLIER::all();
        $category = MST_CATEGORY::all();
        $group = ITEMGROUP::all();
        $ageVerification = MST_AGEVERIFICATION::all();
        $discount = MST_DISCOUNT::all();

        $unit_array = array();
        $item_type_array = array();
        $department_array = array();
        $size_array = array();
        $supplier_array = array();
        $category_array = array();
        $group_array = array();
        $color_array = array();
        $ageVerification_array = array();
        $item_name_array = array();
        $barcode_type_array = array();
        $discount_array = array();
        $chk_array = array();
        $bottle_deposit_array = array();
        $inventoryItem_array = array();

        foreach ($units as $unit) {
            $unit_array[$unit->vunitcode] = $unit->vunitname;
        }
        foreach ($item as $type) {
            $item_type_array[$type->iitemid] = $type->vitemtype;
        }
        foreach ($departments as $department) {
            $department_array[$department->vdepcode] = $department->vdepartmentname;
        }
        foreach ($size as $sizeData) {
            $size_array[$sizeData->isizeid] = $sizeData->vsize;
        }
        foreach ($supplier as $supplierData) {
            $supplier_array[$supplierData->vsuppliercode] = $supplierData->vcompanyname;
        }
        foreach ($category as $categoryData) {
            $category_array[$categoryData->vcategorycode] = $categoryData->vcategoryname;
        }
        foreach ($group as $groupData) {
            $group_array[$groupData->iitemgroupid] = $groupData->vitemgroupname;
        }
        foreach ($item as $colorCode) {
            $color_array[$colorCode->iitemid] = $colorCode->vcolorcode;
        }
        foreach ($ageVerification as $ageVerificationData) {
            $ageVerification_array[$ageVerificationData->vvalue] = $ageVerificationData->vname;
        }
        foreach ($item as $itemName) {
            $item_name_array[$itemName->vitemname] = $itemName->vitemname;
        }
        foreach ($item as $barCodeType) {
            $barcode_type_array[$barCodeType->iitemid] = $barCodeType->vbarcodetype;
        }
        foreach ($discount as $discountData) {
            $discount_array[$discountData->idiscountid] = $discountData->vdescription;
        }
        foreach ($item  as $bottleData) {
            $bottle_deposit_array[$bottleData->iitemid] = $bottleData->ebottledeposit;
        }
        foreach ($item  as $inventoryData) {
            $inventoryItem_array[$inventoryData->iitemid] = $inventoryData->visinventory;
        }
        $stores = Store::all();
        $store_array = array();
        foreach ($stores as $storesData) {
           $store_array[$storesData->id] = $storesData->name;
        }

        if (Request::isJson()){
            return $products->toJson();
        }else{
          return view('admin.product.edit', compact('products','unit_array','item_type_array','department_array','size_array','supplier_array','category_array'
            ,'group_array','color_array','ageVerification_array','item_name_array','barcode_type_array','discount_array','bottle_deposit_array','inventoryItem_array','store_array'));
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
        $validation = WEB_MST_ITEM::Validate(Request::all());

        $products = WEB_MST_ITEM::where('mstid',$id)->first();
        
        $checked = Request::get('checkStore') ;

        if($validation->fails() === false)
        {

            if(count($products) > 0){
                if($checked == 'Y')
                    {
                       
                        $storeData = Store::where('id','=',SESSION::get('selected_store_id'))->get();
                        $storeId = array();

                        foreach ($storeData as $store) {
                            $storeId[] = $store->id;
                        }

                        $products = WEB_MST_ITEM::whereIn('SID',$storeId)->first();

                        $products->estatus = WEB_MST_ITEM::STATUS_ACTIVE;
                        $products->vitemtype = Request::get('vitemtype');
                        $products->vitemname = Request::get('vitemname');
                        $products->vunitcode = Request::get('vunitcode');
                        $products->vdepcode = Request::get('vdepcode');
                        $products->vsize = Request::get('vsize');
                        $products->npack = Request::get('npack');
                        $products->dcostprice = Request::get('dcostprice');
                        $products->nunitcost = Request::get('nunitcost');
                        $products->vbarcode = Request::get('vbarcode');
                        $products->vdescription = Request::get('vdescription');
                        $products->vsuppliercode = Request::get('vsuppliercode');
                        $products->vcategorycode = Request::get('vcategorycode');
                        $products->dunitprice = Request::get('dunitprice');

                        if (Request::hasFile('file')) {
                            $file = addslashes($_FILES['file']['tmp_name']);
                            $file = file_get_contents($file);
                                        
                            $products->itemimage = $file;    
                        }

                        if(Request::get('groupName')){
                          $group = new ITEMGROUPDETAIL;
                          $group->iitemgroupid = Request::get('groupName');
                          $group->vsku = Request::get('sku');
                          $group->save();
                        }

                        $products->nsellunit = Request::get('nsellunit');
                        $products->nsaleprice = Request::get('nsaleprice');
                        $products->vsequence = Request::get('vsequence');
                        $products->vcolorcode = Request::get('vcolorcode');
                        $products->vshowsalesinzreport = Request::get('vshowsalesinzreport');
                        $products->iqtyonhand = Request::get('iqtyonhand');
                        $products->nlevel2 = Request::get('nlevel2');
                        $products->nlevel4 = Request::get('nlevel4');
                        $products->visinventory = Request::get('visinventory');
                        $products->VAGEVERIFY = Request::get('VAGEVERIFY');
                        $products->ebottledeposit = Request::get('ebottledeposit');
                        $products->ireorderpoint = Request::get('ireorderpoint');
                        $products->nlevel3 = Request::get('nlevel3');
                        $products->ndiscountper = Request::get('ndiscountper');
                        $products->vfooditem = Request::get('vfooditem');
                        $products->vtax1 = (Request::get('vtax1') ? Request::get('vtax1') : 'N');
                        $products->vtax2 = (Request::get('vtax2') ? Request::get('vtax2') : 'N');
                        $products->vbarcodetype = Request::get('vbarcodetype');
                        $products->vdiscount = Request::get('vdiscount');
                        $products->norderqtyupto = Request::get('norderqtyupto');
                        $products->SID = SESSION::get('selected_store_id');
                        $products->updatetype = 'Open';
                        $products->save();

                        $message = 'Product is updated';
                        return redirect('admin/products')->withMessage($message);
                    }

                    $products->estatus = WEB_MST_ITEM::STATUS_ACTIVE;
                    $products->vitemtype = Request::get('vitemtype');
                    $products->vitemname = Request::get('vitemname');
                    $products->vunitcode = Request::get('vunitcode');
                    $products->vdepcode = Request::get('vdepcode');
                    $products->vsize = Request::get('vsize');
                    $products->npack = Request::get('npack');
                    $products->dcostprice = Request::get('dcostprice');
                    $products->nunitcost = Request::get('nunitcost');
                    $products->vbarcode = Request::get('vbarcode');
                    $products->vdescription = Request::get('vdescription');
                    $products->vsuppliercode = Request::get('vsuppliercode');
                    $products->vcategorycode = Request::get('vcategorycode');
                    $products->dunitprice = Request::get('dunitprice');


                    if (Request::hasFile('file')) {
                        $file = addslashes($_FILES['file']['tmp_name']);
                        $file = file_get_contents($file);
                                      
                        $products->itemimage = $file;    
                    }

                    if(Request::get('groupName')){
                      $group = new ITEMGROUPDETAIL;
                      $group->iitemgroupid = Request::get('groupName');
                      $group->vsku = Request::get('sku');
                      $group->save();
                    }

                    $products->nsellunit = Request::get('nsellunit');
                    $products->nsaleprice = Request::get('nsaleprice');
                    $products->vsequence = Request::get('vsequence');
                    $products->vcolorcode = Request::get('vcolorcode');
                    $products->vshowsalesinzreport = Request::get('vshowsalesinzreport');
                    $products->iqtyonhand = Request::get('iqtyonhand');
                    $products->nlevel2 = Request::get('nlevel2');
                    $products->nlevel4 = Request::get('nlevel4');
                    $products->visinventory = Request::get('visinventory');
                    $products->VAGEVERIFY = Request::get('VAGEVERIFY');
                    $products->ebottledeposit = Request::get('ebottledeposit');
                    $products->ireorderpoint = Request::get('ireorderpoint');
                    $products->nlevel3 = Request::get('nlevel3');
                    $products->ndiscountper = Request::get('ndiscountper');
                    $products->vfooditem = Request::get('vfooditem');
                    $products->vtax1 = (Request::get('vtax1') ? Request::get('vtax1') : 'N');
                    $products->vtax2 = (Request::get('vtax2') ? Request::get('vtax2') : 'N');
                    $products->vbarcodetype = Request::get('vbarcodetype');
                    $products->vdiscount = Request::get('vdiscount');
                    $products->norderqtyupto = Request::get('norderqtyupto');
                    $products->SID = SESSION::get('selected_store_id');
                    $products->updatetype = 'Open';
                    $products->save();
            }else{
                if($checked == 'Y')
                {
                    $storeData = Store::where('id','=',SESSION::get('selected_store_id'))->get();
                    $storeId = array();

                    foreach ($storeData as $store) {
                        $storeId[] = $store->id;
                    }

                    $product = WEB_MST_ITEM::whereIn('SID',$storeId)->first();
                }

                $products1 = new WEB_MST_ITEM;
                $products1->SID = SESSION::get('selected_store_id');
                $products1->estatus = WEB_MST_ITEM::STATUS_ACTIVE;
                $products1->vitemtype = Request::get('vitemtype');
                $products1->vitemname = Request::get('vitemname');
                $products1->vunitcode = Request::get('vunitcode');
                $products1->vdepcode = Request::get('vdepcode');
                $products1->vsize = Request::get('vsize');
                $products1->npack = Request::get('npack');
                $products1->dcostprice = Request::get('dcostprice');
                $products1->nunitcost = Request::get('nunitcost');
                $products1->vbarcode = Request::get('vbarcode');
                $products1->vdescription = Request::get('vdescription');
                $products1->vsuppliercode = Request::get('vsuppliercode');
                $products1->vcategorycode = Request::get('vcategorycode');
                $products1->itemimage = Request::file('file');

                if (Request::hasFile('file')) {
                    $file = addslashes($_FILES['file']['tmp_name']);
                    $file = file_get_contents($file);
                    
                    $products1->itemimage = $file;
                }

                if(Request::get('groupName')){
                  $group = new ITEMGROUPDETAIL;
                  $group->iitemgroupid = Request::get('groupName');
                  $group->vsku = Request::get('sku');
                  $group->save();
                }
                $products1->nsellunit = Request::get('nsellunit');
                $products1->nsaleprice = Request::get('nsaleprice');
                $products1->vsequence = Request::get('vsequence');
                $products1->vcolorcode = Request::get('vcolorcode');
                $products1->vshowsalesinzreport = Request::get('vshowsalesinzreport');
                $products1->iqtyonhand = Request::get('iqtyonhand');
                $products1->nlevel2 = Request::get('nlevel2');
                $products1->nlevel4 = Request::get('nlevel4');
                $products1->visinventory = Request::get('visinventory');
                $products1->VAGEVERIFY = Request::get('VAGEVERIFY');
                $products1->ebottledeposit = Request::get('ebottledeposit');
                $products1->ireorderpoint = Request::get('ireorderpoint');
                $products1->nlevel3 = Request::get('nlevel3');
                $products1->ndiscountper = Request::get('ndiscountper');
                $products1->vfooditem = Request::get('vfooditem');
                $products1->vtax1 = (Request::get('vtax1') ? Request::get('vtax1') : 'N');
                $products1->vtax2 = (Request::get('vtax2') ? Request::get('vtax2') : 'N');
                $products1->vbarcodetype = Request::get('vbarcodetype');
                $products1->vdiscount = Request::get('vdiscount');
                $products1->norderqtyupto = Request::get('norderqtyupto');
                $products1->updatetype = 'Open';
                $products1->mstid = $id;
                $products1->save();
            }
            

            return redirect('admin/products')->withSuccess('Product is updated');
        }
        else
        {
            if (Request::isJson()){
                if($validation->fails() === false)
                {
                   return config('app.RETURN_MSG.SUCCESS');
                }
                else{
                  return redirect('admin/products/'.$products->iitemid.'/edit')->withInput()
                        ->withErrors($validation);
                }
            }
            return redirect('admin/products/'.$products->iitemid.'/edit')->withInput()
                        ->withErrors($validation);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,Request $request)
    {
        $products = Item::where('iitemid',$id)->first();
        $file[] = $products->itemimage;
        File::delete($file);
        $products->delete();
    
        if (Request::isJson()){
           return config('app.RETURN_MSG.SUCCESS');
        }else{
          return redirect('admin/products')->withSuccess('Product Deleted!');
        }

    }
    public function postEdit(Request $request,$id){
        $products = Item::where('iitemid',$id)->first();
        $validation = Item::Validate(Request::all());
        $checked = Request::get('checkStore') ;
    
        if($validation->fails() === false)
        {
            if($checked == 'Y')
            {
                $storeData = Store::where('id','=',SESSION::get('selected_store_id'))->get();
                $storeId = array();

                foreach ($storeData as $store) {
                    $storeId[] = $store->id;
                }

                $product = Item::whereIn('SID',$storeId)->first();

                $product->estatus = Item::STATUS_ACTIVE;
                $product->vitemtype = Request::get('vitemtype');
                $product->vitemname = Request::get('vitemname');
                $product->vunitcode = Request::get('vunitcode');
                $product->vdepcode = Request::get('vdepcode');
                $product->vsize = Request::get('vsize');
                $product->npack = Request::get('npack');
                $product->dcostprice = Request::get('dcostprice');
                $product->nunitcost = Request::get('nunitcost');
                $product->vbarcode = Request::get('vbarcode');
                $product->vdescription = Request::get('vdescription');
                $product->vsuppliercode = Request::get('vsuppliercode');
                $product->vcategorycode = Request::get('vcategorycode');

                if(Request::get('groupName')){
                  $group = new ITEMGROUPDETAIL;
                  $group->iitemgroupid = Request::get('groupName');
                  $group->vsku = Request::get('sku');
                  $group->save();
                }

                $product->nsellunit = Request::get('nsellunit');
                $product->nsaleprice = Request::get('nsaleprice');
                $product->vsequence = Request::get('vsequence');
                $product->vcolorcode = Request::get('vcolorcode');
                $product->vshowsalesinzreport = Request::get('vshowsalesinzreport');
                $product->iqtyonhand = Request::get('iqtyonhand');
                $product->nlevel2 = Request::get('nlevel2');
                $product->nlevel4 = Request::get('nlevel4');
                $product->visinventory = Request::get('visinventory');
                $product->VAGEVERIFY = Request::get('VAGEVERIFY');
                $product->ebottledeposit = Request::get('ebottledeposit');
                $product->ireorderpoint = Request::get('ireorderpoint');
                $product->nlevel3 = Request::get('nlevel3');
                $product->ndiscountper = Request::get('ndiscountper');
                $product->vfooditem = Request::get('vfooditem');
                $product->vtax1 = (Request::get('vtax1') ? Request::get('vtax1') : 'N');
                $product->vtax2 = (Request::get('vtax2') ? Request::get('vtax2') : 'N');
                $product->vbarcodetype = Request::get('vbarcodetype');
                $product->vdiscount = Request::get('vdiscount');
                $product->norderqtyupto = Request::get('norderqtyupto');
                $product->save();

                $message = 'Product is updated';
                return redirect('admin/products')->withMessage($message);
            }

            $products->estatus = Item::STATUS_ACTIVE;
            $products->vitemtype = Request::get('vitemtype');
            $products->vitemname = Request::get('vitemname');
            $products->vunitcode = Request::get('vunitcode');
            $products->vdepcode = Request::get('vdepcode');
            $products->vsize = Request::get('vsize');
            $products->npack = Request::get('npack');
            $products->dcostprice = Request::get('dcostprice');
            $products->nunitcost = Request::get('nunitcost');
            $products->vbarcode = Request::get('vbarcode');
            $products->vdescription = Request::get('vdescription');
            $products->vsuppliercode = Request::get('vsuppliercode');
            $products->vcategorycode = Request::get('vcategorycode');

            if(Request::get('groupName')){
              $group = new ITEMGROUPDETAIL;
              $group->iitemgroupid = Request::get('groupName');
              $group->vsku = Request::get('sku');
              $group->save();
            }

            $products->nsellunit = Request::get('nsellunit');
            $products->nsaleprice = Request::get('nsaleprice');
            $products->vsequence = Request::get('vsequence');
            $products->vcolorcode = Request::get('vcolorcode');
            $products->vshowsalesinzreport = Request::get('vshowsalesinzreport');
            $products->iqtyonhand = Request::get('iqtyonhand');
            $products->nlevel2 = Request::get('nlevel2');
            $products->nlevel4 = Request::get('nlevel4');
            $products->visinventory = Request::get('visinventory');
            $products->VAGEVERIFY = Request::get('VAGEVERIFY');
            $products->ebottledeposit = Request::get('ebottledeposit');
            $products->ireorderpoint = Request::get('ireorderpoint');
            $products->nlevel3 = Request::get('nlevel3');
            $products->ndiscountper = Request::get('ndiscountper');
            $products->vfooditem = Request::get('vfooditem');
            $products->vtax1 = (Request::get('vtax1') ? Request::get('vtax1') : 'N');
            $products->vtax2 = (Request::get('vtax2') ? Request::get('vtax2') : 'N');
            $products->vbarcodetype = Request::get('vbarcodetype');
            $products->vdiscount = Request::get('vdiscount');
            $products->norderqtyupto = Request::get('norderqtyupto');
            $products->save();

            if (Request::isJson()){
                return config('app.RETURN_MSG.SUCCESS');
            }

            return redirect('admin/products')->withSuccess('Product is updated');
        }
        else
        {
            if (Request::isJson()){
             return  $validation->errors()->all();
            }
            
            return redirect('admin/products/'.$products->iitemid.'/edit')->withInput()
                        ->withErrors($validation);
        }
    }
    public function getProductView(Request $request , $id){
        $product = Item::where('iitemid',$id)->first();
        $stores = Store::all();
        $store_array = array();
        foreach ($stores as $storesData) {
           $store_array[$storesData->id] = $storesData->name;
        }

        return view('admin.product.productView',compact('product','store_array'));
    }  
    public function checkPriceBySKU(Request $request) {
        $sku = Request::get('sku');
        $sid=Request::get('sid');
        $db = "u".$sid;
        $query_db = 'USE DATABASE '.$db;
        
        DB::raw($query_db);
        $exist="SELECT * FROM information_schema.tables WHERE table_schema = '".$db."' AND table_name = 'mst_version' LIMIT 1";
        
        $exist_records = DB::select($exist);
        
        if(count($exist_records) > 0)
        {
            $query_select = "SELECT mi.vbarcode vbarcode, mi.vitemname vitemname,mi.vitemtype vitemtype ,mi.npack npack,mi.dunitprice dunitprice,
            CAST((mi.dcostprice) as decimal(10,2)) dcostprice,
            mi.iqtyonhand iqtyonhand,CAST((mi.nsaleprice) as decimal(10,2))nsaleprice,mi.vunitcode vunitcode,mi.vcategorycode vcategorycode,mi.vdepcode vdepcode,
            mi.vsuppliercode vsuppliercode,mi.vtax1 vtax1,mi.vtax2 vtax2,mi.vfooditem vfooditem,mi.vdescription vdescription,mi.vageverify vageverify,
            mi.vsize vsize,mi.nsellunit nsellunit,mi.wicitem wicitem,mi.visinventory visinventory,mi.SID SID,ms.vcompanyname vcompanyname,mc.vcategoryname vcategoryname,ifnull((md.vdepartmentname),'') vdepartmentname,
            ifnull(concat('',sc.subcat_id),'') as subcat_id,ifnull((sc.subcat_name),'') subcat_name
            
            FROM ".$db.".mst_item mi LEFT JOIN ".$db.".mst_itemalias mia on mi.vitemcode = mia.vitemcode 
            LEFT JOIN  ".$db.".mst_supplier ms on mi.vsuppliercode = ms.vsuppliercode
             LEFT JOIN  ".$db.".mst_department md on mi.vdepcode  =md.vdepcode
             LEFT JOIN  ".$db.".mst_category mc on mi.vcategorycode=mc.vcategorycode
             LEFT JOIN  ".$db.".mst_subcategory sc on sc.cat_id = mc.vcategorycode
            WHERE mia.valiassku = '".$sku."' OR mi.vbarcode='".$sku."'";
           
             //echo   $query_select;die;     
            $matching_records = DB::select($query_select);
            
            
            if(count($matching_records) > 0){
                $matching_records[0]->iqtyonhand = (string)$matching_records[0]->iqtyonhand;
                
                $data = [];
                
                $data_array = $matching_records;
                $data['data'] = $data_array;
                $data['status'] = "success";
                return response()->json($data, 200);
                
            } else {
                return response()->json(['error'=>'No Barcode Found'],401);
                
            }
        }
        else{
            $query_select = "SELECT mi.vbarcode vbarcode, mi.vitemname vitemname,mi.vitemtype vitemtype ,mi.npack npack,mi.dunitprice dunitprice,CAST((mi.dcostprice) as decimal(10,2)) dcostprice,
            mi.iqtyonhand iqtyonhand,CAST((mi.nsaleprice) as decimal(10,2))  nsaleprice,mi.vunitcode vunitcode,mi.vcategorycode vcategorycode,mi.vdepcode vdepcode,
            mi.vsuppliercode vsuppliercode,mi.vtax1 vtax1,mi.vtax2 vtax2,mi.vfooditem vfooditem,mi.vdescription vdescription,mi.vageverify vageverify,
            mi.vsize vsize,mi.nsellunit nsellunit,mi.wicitem wicitem,mi.visinventory visinventory,mi.SID SID,ms.vcompanyname vcompanyname,mc.vcategoryname vcategoryname,ifnull((md.vdepartmentname),'') vdepartmentname
           
            
            FROM ".$db.".mst_item mi LEFT JOIN ".$db.".mst_itemalias mia on mi.vitemcode = mia.vitemcode 
            LEFT JOIN  ".$db.".mst_supplier ms on mi.vsuppliercode = ms.vsuppliercode
             LEFT JOIN  ".$db.".mst_department md on mi.vdepcode  =md.vdepcode
             LEFT JOIN  ".$db.".mst_category mc on mi.vcategorycode=mc.vcategorycode
             
            WHERE mia.valiassku = '".$sku."' OR mi.vbarcode='".$sku."'";
    //   echo $query_select; die;
                
            $matching_records = DB::select($query_select);
            
            
            if(count($matching_records) > 0){
                $matching_records[0]->iqtyonhand = (string)$matching_records[0]->iqtyonhand;
                $data = [];
                
                $data_array = $matching_records;
                $data['data'] = $data_array;
                $data['status'] = "success";
                return response()->json($data, 200);
                
            } else {
                return response()->json(['error'=>'No Barcode Found'],401);
                
            }
        }
    }
//     public function checkPriceBySKU(Request $request) {
//         $sku = Request::get('sku');
//         $sid=Request::get('sid');
//         $db = "u".$sid;
//         $query_db = 'USE DATABASE '.$db;
        
//         DB::raw($query_db);
//         $exist="SELECT * FROM information_schema.tables WHERE table_schema = '".$db."' AND table_name = 'mst_version' LIMIT 1";
        
//         $exist_records = DB::select($exist);
        
//         if(count($exist_records) > 0)
//         {
//         $query_select = "SELECT mi.vbarcode vbarcode, mi.vitemname vitemname,mi.vitemtype vitemtype ,mi.npack npack,mi.dunitprice dunitprice,
//         CAST((mi.dcostprice) as decimal(10,2)) dcostprice,
//         mi.iqtyonhand iqtyonhand,CAST((mi.nsaleprice) as decimal(10,2))nsaleprice,mi.vunitcode vunitcode,mi.vcategorycode vcategorycode,mi.vdepcode vdepcode,
//         mi.vsuppliercode vsuppliercode,mi.vtax1 vtax1,mi.vtax2 vtax2,mi.vfooditem vfooditem,mi.vdescription vdescription,mi.vageverify vageverify,
//         mi.vsize vsize,mi.nsellunit nsellunit,mi.wicitem wicitem,mi.visinventory visinventory,mi.SID SID,ms.vcompanyname vcompanyname,mc.vcategoryname vcategoryname,ifnull((md.vdepartmentname),'') vdepartmentname,
//         ifnull(concat('',sc.subcat_id),'') as subcat_id,ifnull((sc.subcat_name),'') subcat_name
        
//         FROM ".$db.".mst_item mi LEFT JOIN ".$db.".mst_itemalias mia on mi.vitemcode = mia.vitemcode 
//         LEFT JOIN  ".$db.".mst_supplier ms on mi.vsuppliercode = ms.vsuppliercode
//          LEFT JOIN  ".$db.".mst_department md on mi.vdepcode  =md.vdepcode
//          LEFT JOIN  ".$db.".mst_category mc on mi.vcategorycode=mc.vcategorycode
//          LEFT JOIN  ".$db.".mst_subcategory sc on sc.cat_id = mc.vcategorycode
//         WHERE mia.valiassku = '".$sku."' OR mi.vbarcode='".$sku."'";
       
//         //  echo   $query_select;die;     
//         $matching_records = DB::select($query_select);
        
        
//         if(count($matching_records) > 0){
//             $matching_records[0]->iqtyonhand = (string)$matching_records[0]->iqtyonhand;
//             $data = [];
            
//             $data_array = $matching_records;
//             $data['data'] = $data_array;
//             $data['status'] = "success";
//             return response()->json($data, 200);
            
//         } else {
//             return response()->json(['error'=>'No Barcode Found'],401);
            
//         }
//         }
//         else{
//             $query_select = "SELECT mi.vbarcode vbarcode, mi.vitemname vitemname,mi.vitemtype vitemtype ,mi.npack npack,mi.dunitprice dunitprice,CAST((mi.dcostprice) as decimal(10,2)) dcostprice,
//         mi.iqtyonhand iqtyonhand,CAST((mi.nsaleprice) as decimal(10,2))  nsaleprice,mi.vunitcode vunitcode,mi.vcategorycode vcategorycode,mi.vdepcode vdepcode,
//         mi.vsuppliercode vsuppliercode,mi.vtax1 vtax1,mi.vtax2 vtax2,mi.vfooditem vfooditem,mi.vdescription vdescription,mi.vageverify vageverify,
//         mi.vsize vsize,mi.nsellunit nsellunit,mi.wicitem wicitem,mi.visinventory visinventory,mi.SID SID,ms.vcompanyname vcompanyname,mc.vcategoryname vcategoryname,ifnull((md.vdepartmentname),'') vdepartmentname
       
        
//         FROM ".$db.".mst_item mi LEFT JOIN ".$db.".mst_itemalias mia on mi.vitemcode = mia.vitemcode 
//         LEFT JOIN  ".$db.".mst_supplier ms on mi.vsuppliercode = ms.vsuppliercode
//          LEFT JOIN  ".$db.".mst_department md on mi.vdepcode  =md.vdepcode
//          LEFT JOIN  ".$db.".mst_category mc on mi.vcategorycode=mc.vcategorycode
         
//         WHERE mia.valiassku = '".$sku."' OR mi.vbarcode='".$sku."'";
//     //   echo $query_select; die;
                
//         $matching_records = DB::select($query_select);
        
        
//         if(count($matching_records) > 0){
//             $matching_records[0]->iqtyonhand = (string)$matching_records[0]->iqtyonhand;
//             $data = [];
            
//             $data_array = $matching_records;
//             $data['data'] = $data_array;
//             $data['status'] = "success";
//             return response()->json($data, 200);
            
//         } else {
//             return response()->json(['error'=>'No Barcode Found'],401);
            
//         }
//         }

//         // if($sku) { 
//         //     $obj = Item::where('vbarcode',$sku);
//         //     if(Request::get('sid')) {
//         //         $obj->where('SID',Request::get('sid'));
//         //     }
//              /*$obj = Item::where('vbarcode',$sku)->orWhere('');
//             if(Request::get('sid')) {
//                 $obj->where('SID',Request::get('sid'));
//             }*/

//     //         /*'subcat_id', 'int(11)', 'YES', '', NULL, ''
//     //         'manufacturer_id', 'int(11)', 'YES', '', NULL, ''*/
//     //         $data = $obj->get(array('vbarcode','vitemname','vitemtype','npack','dunitprice','dcostprice','iqtyonhand','nsaleprice','vunitcode','vcategorycode','vdepcode','vsuppliercode','vtax1','vtax2','vfooditem','vdescription','vageverify','vsize','nsellunit','wicitem','visinventory','SID'));
//     //         $data_array = $data->toArray();
            
            
//     //         if(count($data_array) == 0){
//     //             return response()->json(['error'=>'No barcode found'],401);
//     //         }
            
//     //         $data_array[0]['iqtyonhand'] = (string)$data_array[0]['iqtyonhand'];
            
            
//     //         $data = [];
//     //         $data['data'] = $data_array;
//     //         $data['status'] = "success";
//     //         return response()->json($data, 200);
//     //         // return $data_array;
//     //     }
//     //     else
//     //     {
//     //         return response()->json(['error'=>'SKU is  missing '],401);
//     //     }
       
//     // }
// }
    
    
    //Adarsh: Function to get the item detail from SKU
    public function get_item_by_sku(Request $request) {
        $sku = Request::get('sku');
        if($sku) {
            
            // 'barcode','item_name','cost','selling_price','qty_on_hand','tax1','tax2','item_type','description','unit','department','category','supplier','group','size','selling_unit','food_stamp','WIC_item','age_verification'
            $obj = Nplitem::find($sku, ['barcode','item_name','cost','selling_price','qty_on_hand','tax1','tax2','item_type','description','unit','department','category','supplier','group','size','selling_unit','food_stamp','WIC_item','age_verification']);
            
            if($obj == null){
                //Changed the request code from 401 to 405 on Manish's request: Because 401 was not allowing the session to sustain
                return response()->json(['message'=>'Item not found in NPL'],405);
            }
            $data = [];
            
            // return $obj[0]['iqtyonhand'] = (string)$obj[0]['iqtyonhand'];
            
            $data['data'] = $obj;
            $data['status'] = "success";
            return response()->json($data, 200);
        } else {
            return response()->json(['message'=>'SKU is  missing '],405);
        }
       
    }
    
    //Returns the list of the list of a DEPARTMENT according to the SID
    public function get_department_list($sid){
        
        $store = Store::where('id','=',$sid)->first();
        
        if(!isset($store->id)){
            
            return response()->json(['error'=>"That store does not exist."],200);
        }

        
        $data = [];
        
        $db = "u".$sid;
        
        $query_db = 'USE DATABASE '.$db;
        
        DB::raw($query_db);
        
        $query_select = "SELECT vdepcode, vdepartmentname FROM ".$db.".mst_department ORDER BY vdepartmentname";
        
        $matching_records = DB::select($query_select);
        
        
        
        foreach($matching_records as $v){
            
            $temp = [];
            // $temp['key'] = $v->vdepcode;
            // $temp['value'] = $v->vdepartmentname;
            
            $temp['value'] = $v->vdepcode;
            $temp['label'] = $v->vdepartmentname;
            
            $data[] = $temp;
            
            // $data[$v->vdepcode] = $v->vdepartmentname;
        }
        
        return response()->json(['data'=>$data],200);
    }
    
    
    public function get_unit_list($sid){
        // echo "asdfasdf";die;
        $store = Store::where('id','=',$sid)->first();
        
        // print_r($store);die;
        
        if(!isset($store->id)){
            
            return response()->json(['error'=>"That store does not exist."],200);
        }

        
        $data = [];
        
        $db = "u".$sid;
        
        $query_db = 'USE DATABASE '.$db;
        
        DB::raw($query_db);
        
        $query_select = "SELECT vunitcode, vunitname FROM ".$db.".mst_unit ORDER BY vunitname";
        
        $matching_records = DB::select($query_select);
        
        
        
        foreach($matching_records as $v){
            
            $temp = [];
            // $temp['key'] = $v->vdepcode;
            // $temp['value'] = $v->vdepartmentname;
            
            $temp['value'] = $v->vunitcode;
            $temp['label'] = $v->vunitname;
            
            $data[] = $temp;
            
            // $data[$v->vdepcode] = $v->vdepartmentname;
        }
        
        return response()->json(['data'=>$data],200);
    }
    
    public function get_manufacture_list($sid){
        
        $store = Store::where('id','=',$sid)->first();
        
        if(!isset($store->id)){
            
            return response()->json(['error'=>"That store does not exist."],200);
        }

        
        $data = [];
        
        $db = "u".$sid;
        
        $query_db = 'USE DATABASE '.$db;
        
        DB::raw($query_db);
        
        $query_select = "SELECT mfr_code, mfr_id, mfr_name FROM ".$db.".mst_manufacturer ORDER BY mfr_name";
        
        $matching_records = DB::select($query_select);
        
        
        
        foreach($matching_records as $v){
            
            $temp = [];
            // $temp['key'] = $v->vdepcode;
            // $temp['value'] = $v->vdepartmentname;
            
            $temp['value'] = "$v->mfr_id";
            $temp['label'] = $v->mfr_name;
            // $temp['mfr_id'] = $v->mfr_id;
            
            $data[] = $temp;
            
            // $data[$v->vdepcode] = $v->vdepartmentname;
        }
        
        return response()->json(['data'=>$data],200);
    }
    
    public function get_size_list($sid){
        
        $store = Store::where('id','=',$sid)->first();
        
        if(!isset($store->id)){
            
            return response()->json(['error'=>"That store does not exist."],200);
        }

        
        $data = [];
        
        $db = "u".$sid;
        
        $query_db = 'USE DATABASE '.$db;
        
        DB::raw($query_db);
        
        $query_select = "SELECT isizeid, vsize FROM ".$db.".mst_size ORDER BY vsize";
        
        $matching_records = DB::select($query_select);
        
        
        
        foreach($matching_records as $v){
            
            $temp = [];
            // $temp['key'] = $v->vdepcode;
            // $temp['value'] = $v->vdepartmentname;
            
            $temp['value'] = "$v->isizeid";
            $temp['label'] = $v->vsize;
            
            $data[] = $temp;
            
            // $data[$v->vdepcode] = $v->vdepartmentname;
        }
        
        return response()->json(['data'=>$data],200);
    }
    
    //Returns the list of the list of a CATEGORY according to the SID and department_code
    public function get_category_list($sid, $department_code){
        
        $data = [];
        
        $db = "u".$sid;
        
        $query_db = 'USE DATABASE '.$db;
        
        DB::raw($query_db);
        
        $query_select = "SELECT vcategorycode, vcategoryname FROM ".$db.".mst_category WHERE dept_code =".$department_code;
        
        $matching_records = DB::select($query_select);
        
        foreach($matching_records as $v){
            
            $temp = [];
            // $temp['key'] = $v->vcategorycode;
            // $temp['value'] = $v->vcategoryname;
            
            $temp['value'] = $v->vcategorycode;
            $temp['label'] = $v->vcategoryname;
            
            $data[] = $temp;
            
            // $data[$v->vcategorycode] = $v->vcategoryname;
        }
        
        return response()->json(['data'=>$data],200);
    }
    
    
    
    //Returns the list of Sub Categories according to the SID and category id
    public function get_subcategory_list($sid, $category_id){
        
        $data = [];
        
        $db = "u".$sid;
        
        $query_db = 'USE DATABASE '.$db;
        
        DB::raw($query_db);
        
        // SELECT subcat_id, subcat_name FROM u1097.mst_subcategory;
        $query_select = "SELECT subcat_id, subcat_name FROM ".$db.".mst_subcategory WHERE cat_id =".$category_id;
        
        $matching_records = DB::select($query_select);
        
        foreach($matching_records as $v){
            
            $temp = [];
            $temp['key'] = $v->subcat_id;
            $temp['value'] = $v->subcat_name;
            
            $data[] = $temp;
            
            // $data[$v->vcategorycode] = $v->vcategoryname;
        }
        
        return response()->json(['data'=>$data],200);
    }
    
    
    
    //Returns the list of the list of age verification according to the SID
    // public function get_age_verification_list($sid){
        
    //     $data = [];
        
    //     $db = "u".$sid;
        
    //     $query_db = 'USE DATABASE '.$db;
        
    //     DB::raw($query_db);
        
    //     $query_select = "SELECT vvalue, vname FROM ".$db.".mst_ageverification";
        
    //     $matching_records = DB::select($query_select);
        
    //     foreach($matching_records as $v){
            
    //         $temp = [];
    //         $temp['key'] = $v->vvalue;
    //         $temp['value'] = $v->vname;
            
    //         $data[] = $temp;
    //     }
        
    //     return response()->json(['data'=>$data],200);
    // }
    public function get_age_verification_list($sid){
        
        $data = [];
        
        $db = "u".$sid;
        
        $query_db = 'USE DATABASE '.$db;
        
        DB::raw($query_db);
        
        $query_select = "SELECT vvalue, vname FROM ".$db.".mst_ageverification";
        
        $matching_records = DB::select($query_select);
        
        foreach($matching_records as $v){
            
            $temp = [];
            $temp['value'] = $v->vvalue;
            $temp['label'] = $v->vname;
            
            $data[] = $temp;
        }
        
        return response()->json(['data'=>$data],200);
    }
    

    //Returns the list of the list of a VENDOR according to the SID
    public function get_vendor_list($sid){
        
        $data = [];
        
        $db = "u".$sid;
        
        $query_db = 'USE DATABASE '.$db;
        
        DB::raw($query_db);
        
        $query_select = "SELECT vsuppliercode, vcompanyname FROM ".$db.".mst_supplier";
        
        $matching_records = DB::select($query_select);
        
        /*foreach($matching_records as $v){
            $data[$v->vsuppliercode] = $v->vcompanyname;
        }*/
        
        foreach($matching_records as $v){
            $temp = [];
            // $temp['key'] = $v->vsuppliercode;
            // $temp['value'] = $v->vcompanyname;
            
            $temp['value'] = $v->vsuppliercode;
            $temp['label'] = $v->vcompanyname;
            
            $data[] = $temp;
            
            // $data[$v->vdepcode] = $v->vdepartmentname;
        }
        
        return response()->json(['data'=>$data],200);
    }
    
    
    public function make_password($password){
        
        
        return $response = Hash::make($password);
    }
    
    //Adarsh: Function to insert an item:All Values taken from user
    public function insert_item_from_npl(Request $request){
        
        $input = Request::all();
        
        $validator = Validator::make($input, [
           'sid' => 'required',
           'barcode' => 'required',
           'item_name' => 'required',
           'cost' => 'required',
           'selling_price' => 'required',
           'qty_on_hand' => 'required',
           'tax1' => 'required|in:Y,N',
           'tax2' => 'required|in:Y,N'
       ]);
        
        if ($validator->fails()) {
            return response()->json(['message' => $validator->messages()->first()],200);
        }
        
        // Check if the item already exists in the store db
        $store = Store::where('id','=',Request::get('sid'))->first();
        
        $db = "u".$store->id;
        
        $query_db = 'USE DATABASE '.$db;
        
        DB::raw($query_db);
        

        $barcode = (string)$input['barcode'];
        
        $query_select = "SELECT vbarcode FROM ".$db.".mst_item WHERE vbarcode=?";
        
        $matching_records = DB::select($query_select, array($barcode));
        
        if(count($matching_records) > 0){
            return response()->json(['message' => 'That item already exists in the store database ('.$db.')'],200);
        }
        
        
        //========= Check if the item exist in the NPL =========================
        $npl = NPLItem::where('barcode', '=', $input['barcode'])->first();
        
        if(empty($npl)){
            
            return response()->json(['message' => 'The data for this item does NOT exist in NPL'],200);
        }
        
           /*'is_inventory'
           'selling_unit'
           'tax1'
           'tax2'
           'food_item'
           'age_verification'*/ 
            
            // $npl->description."','".$npl->vunitcode."','".$npl->size."','".$npl->sellingunit."','".$npl->food_stamp."','".$npl->WIC_item."','".."'
        

        $itemname = addslashes(trim($input['item_name']));
        $itemtype = isset($npl->item_type)?$npl->item_type:'Standard';
        
        
        // ========================= Department ================================
        if(isset($npl->department)){
            $query_check_dept = "SELECT vdepcode FROM ".$db.".mst_department WHERE vdepartmentname=?";
            
            // check if the department exists in the store
            $department = DB::select($query_check_dept, array($npl->department));
            if(empty($department)){
                //Insert if it does not exist
                $sequence_query = "SELECT isequence FROM ".$db.".mst_department ORDER BY isequence DESC LIMIT 1";
                
                $get_sequence = DB::select($sequence_query);
                
                $query_insert = "INSERT INTO ".$db.".mst_department (vdepartmentname,SID,estatus) VALUES('".$npl->department."','".$store->id."','Active')";
        
                $insert_dept = DB::insert($query_insert);
                
                $query_last_id = "SELECT LAST_INSERT_ID()";
                
                $dept_id = DB::select($query_last_id);
                
                
                echo json_encode($dept_id);
                
                die;
                
                
                
                $dept_code = $last_id = $dept_id['LAST_INSERT_ID()'];
                
                $query_update = "UPDATE mst_department SET vdepcode = '" . (int)$last_id . "' WHERE idepartmentid = '" . (int)$last_id . "'";
                
                DB::statement($query_update);
                
            } else {
                // return json_encode($department);
                $dept_code = $department[0]->vdepcode;
            }
        } else {
            
            $dept_code = 1;
        }
        
        // ============================== Category =============================
        if(isset($npl->category)){
            $query_check_cat = "SELECT vcategorycode FROM ".$db.".mst_category WHERE vcategoryname=?";
            
            // check if the category exists in the store
            $category = DB::select($query_check_cat, array($npl->category));
            if(empty($category)){
                
                //Insert if it does not exist
                $query_insert = "INSERT INTO ".$db.".mst_category (vcategoryname,SID,estatus) VALUES('".$npl->category."','".$store->id."','Active')";
        
                $insert_dept = DB::insert($query_insert);
                
                $query_cat_id = "SELECT LAST_INSERT_ID()";
                
                $cat_id = DB::select($query_cat_id);
                
                $category_code = $last_id = $cat_id['LAST_INSERT_ID()'];
                
                $query_update = "UPDATE mst_category SET vcategorycode = '" . (int)$last_id . "' WHERE icategoryid = '" . (int)$last_id . "'";
                
                DB::statement($query_update);
                
            } else {
                $category_code = $category[0]->vcategorycode;
            }
        } else {
            
            $category_code = 1;
        }
        
        
        // ============================== Supplier =============================
        if(isset($npl->supplier)){
            $query_check_supp = "SELECT vsuppliercode FROM ".$db.".mst_supplier WHERE vcompanyname=?";
            
            // check if the category exists in the store
            $supplier = DB::select($query_check_supp, array($npl->supplier));
            if(empty($supplier)){
                
                //Insert if it does not exist
                $query_insert = "INSERT INTO ".$db.".mst_supplier (vcompanyname,SID,estatus) VALUES('".$npl->supplier."','".$store->id."','Active')";
        
                $insert_dept = DB::insert($query_insert);
                
                $query_supp_id = "SELECT LAST_INSERT_ID()";
                
                $supp_id = DB::select($query_supp_id);
                
                $supplier_code = $last_id = $supp_id['LAST_INSERT_ID()'];
                
                $query_update = "UPDATE mst_supplier SET vsuppliercode = '" . (int)$last_id . "' WHERE isupplierid = '" . (int)$last_id . "'";
                
                DB::statement($query_update);
                
            } else {
                $supplier_code = $supplier[0]->vsuppliercode;
            }
        } else {
            
            $supplier_code = 1;
        }


        $estatus = "Active";
        
        $cost = $input['cost'];
        
        $selling_price = $input['selling_price'];
        
        $qty_on_hand = $input['qty_on_hand'];

        $tax1 = array_key_exists('tax1', $input)?$input['tax1']:"N";
        
        $tax2 = array_key_exists('tax2', $input)?$input['tax2']:"N";
        
        $is_inventory = "Yes";
        
        $description = isset($npl->description)?$npl->description:"";
        
        $unitcode = isset($npl->vunitcode)?$npl->vunitcode:"UNT001";
        
        $size = isset($npl->size)?$npl->size:"";
        
        $sellingunit = isset($npl->sellingunit)?$npl->sellingunit:1;
        
        $food_stamp = isset($npl->food_stamp)?$npl->food_stamp:"N";
        
        if(!isset($npl->WIC_item) || $npl->WIC_item == 'N'){
            $wic_item = 0;
        } else {
            $wic_item = 1;
        }
        // $wic_item = isset($npl->WIC_item)?$npl->WIC_item:0;
        
        $age_verification = isset($input['age_verification'])?$input['age_verification']:0;
        
        $liability = "N";
        
        /*$category_code
        $supplier_code
        $store->id
        $estatus
        $cost
        $selling_price
        $qty_on_hand
        $tax1
        $tax2
        $is_inventory
        $description
        $unitcode
        $size
        $sellingunit
        $food_stamp
        $wic_item
        $age_verification*/
        
        /*$dept_code = array_key_exists('department_code', $input)?$input['department_code']:1;
        
        $supplier_code = array_key_exists('supplier_code', $input)?$input['supplier_code']:1;
        
        
        
        $category_code = array_key_exists('category_code', $input)?$input['category_code']:1;
        
        
        
        $tax1 = array_key_exists('tax1', $input)?$input['tax1']:"N";
        
        $tax2 = array_key_exists('tax2', $input)?$input['tax2']:"N";
        */
        //Set Status to Active and inventory to Yes (if not entered), default
        
        
        
        
        
        /*'barcode', 'item_type', 'item_name', 'description', 'unit', 'department', 'category', 'supplier', 'group', 'size', 'cost', 'selling_price', 'qty_on_hand', 'tax1', 'tax2', 'selling_unit', 'food_stamp', 'WIC_item', 'age_verification'

        
        $query_insert = "INSERT INTO ".$db.".mst_item (vbarcode,vitemcode,vitemname,vitemtype,vcategorycode,SID,estatus,dcostprice,dunitprice,iqtyonhand,vtax1,vtax2,visinventory) VALUES('".$barcode."','".$barcode."','".$itemname."','".$itemtype."',".$category_code.",".$store->id.",'".$estatus."',".$cost.",".$selling_price.",".$qty_on_hand.",'".$tax1."','".$tax2."','".$is_inventory."')";*/


        $query_insert = "INSERT INTO ".$db.".mst_item (vbarcode,vitemcode,vitemname,vitemtype,vdepcode,vcategorycode,vsuppliercode,SID,estatus,dcostprice,dunitprice,iqtyonhand,vtax1,vtax2,visinventory,vdescription,vunitcode,vsize,nsellunit,vfooditem,wicitem,vageverify,liability) VALUES('".$barcode."','".$barcode."','".$itemname."','".$itemtype."','".$dept_code."','".$category_code."','".$supplier_code."','".$store->id."','".$estatus."','".$cost."','".$selling_price."','".$qty_on_hand."','".$tax1."','".$tax2."','".$is_inventory."','".$description."','".$unitcode."','".$size."','".$sellingunit."','".$food_stamp."',".$wic_item.",'".$age_verification."','".$liability."')";


        

        //return $query_insert = "INSERT INTO ".$db.".mst_item ('iitemid','vitemname','SID') VALUES(20001,'".$input['itemname']."',".$input['sid'].")";
        
        
        $insert = DB::insert($query_insert);
        
        $success_message = "Item inserted successfully in ".$db;
        
        if($insert){
            return response()->json(['message' => $success_message], 200);
        } else {
           return response()->json(['message' => 'Item could not be inserted.'],200); 
        }
    }
    
    //Adarsh: Function to insert an item: Values for 6 fields to be taken from user rest from NPL (inslocdb->npl_items) to customer (database(u*****)->mst_item)
    // public function insert_item_customer(Request $request){
        
    //     $input = Request::all();
        
    //     $validator = Validator::make($input, [
    //       'sid' => 'required',
    //       'barcode' => 'required',
    //       'item_name' => 'required',
    //       'cost' => 'required',
    //       'selling_price' => 'required',
    //       'qty_on_hand' => 'required',
    //       'category_code' => 'required',
    //       'department_code' => 'required',
    //       'supplier_code' => 'required'
           
    //   ]);
        
    //     if ($validator->fails()) {
    //         return response()->json(['message' => $validator->messages()->first()],200);
    //     }
       
    //     // $npl = NPLItem::where('barcode', '=', $input['barcode'])->first();
       
        
            
            
        
    //     $store = Store::where('id','=',Request::get('sid'))->first();
    //     $sidphone=$store->id;//Sid for Item_moment
    
    //     $db = "u".$store->id;
        
    //     $query_db = 'USE DATABASE '.$db;
        
    //     DB::raw($query_db);
        

    //     $barcode = (string)$input['barcode'];
        
    //     $query_select = "SELECT vbarcode, iitemid FROM ".$db.".mst_item WHERE vbarcode=?";
        
    //     $matching_records = DB::select($query_select, array($barcode));
        
        
        
    //     $itemname = addslashes($input['item_name']);
        
    //     $itemtype = array_key_exists('itemtype', $input)?$input['itemtype']:'Standard';
        
    //     // $dept_code = array_key_exists('department_code', $input)?$input['department_code']:1;
        
    //     //======================================================== Department ==================================================================================
    //     if(array_key_exists('department_code', $input)){
            
    //         // check if the department exists with the entered department id
    //         $dept_code_query_run = DB::connection('mysql')->select("SELECT * FROM ".$db.".mst_department WHERE idepartmentid='" .(int)$input['department_code']. "'");

    //         if(count($dept_code_query_run) > 0) {
                
    //             //return the vdepcode
    //             $dept_code = $dept_code_query_run[0]->vdepcode;
                
    //         } else {
                
    //           // check if the department exists with the name
    //             $department_query_run = DB::connection('mysql')->select("SELECT * FROM ".$db.".mst_department WHERE vdepartmentname='" .$input['department_code']. "'");
    
    //             if(count($department_query_run) > 0){
                    
    //                 $dept_code = $department_query_run[0]->vdepcode;
                    
    //             } else {
                    
    //                 //create a record;
    //                 try {
    //                     $sql = "INSERT INTO ".$db.".mst_department SET vdepartmentname = '" . html_entity_decode($input['department_code']) . "',isequence =0 ,estatus = 'Active',SID = '" . (int)$input['sid']."'";
            
    //                     DB::connection('mysql')->select($sql);
                        
                        
                        
    //                     $last_id_query = DB::connection('mysql')->select("SELECT max(idepartmentid) last_id from ".$db.".mst_department");
                        
    //                     $last_id = $last_id_query[0]->last_id;
    //                     DB::connection('mysql')->select("UPDATE ".$db.".mst_department SET vdepcode = '" . (int)$last_id . "' WHERE idepartmentid = '" . (int)$last_id . "'");
    //                 }
    //                 catch (MySQLDuplicateKeyException $e) {
    //                     // duplicate entry exception
    //                   $error['error'] = $e->getMessage(); 
    //                     return $error; 
    //                 }
    //                 catch (MySQLException $e) {
    //                     // other mysql exception (not duplicate key entry)
                        
    //                     $error['error'] = $e->getMessage(); 
    //                     return $error; 
    //                 }
    //                 catch (Exception $e) {
    //                     // not a MySQL exception
                       
    //                     $error['error'] = $e->getMessage(); 
    //                     return $error; 
    //                 }
            
    //                 $dept_code = $last_id;
    //             } 
    //         }
            
    //     } else {
    //         $dept_code=1;
    //     }
        

    //     // $category_code = array_key_exists('category_code', $input)?$input['category_code']:1;

    //     //======================================================== Category ==================================================================================
    //     if(array_key_exists('category_code', $input)){

    //         // check if the category exists with the entered cateogry id
    //         $cat_code_query_run = DB::connection('mysql')->select("SELECT * FROM ".$db.".mst_category WHERE icategoryid='" .(int)$input['category_code']. "'");

    //         if(count($cat_code_query_run) > 0) {
                
    //             //return the vdepcode
    //             $category_code = $cat_code_query_run[0]->vcategorycode;
                
    //         } else {
                
    //           // check if the category exists with the name
    //             $category_query_run = DB::connection('mysql')->select("SELECT * FROM ".$db.".mst_category WHERE vcategoryname='" .$input['category_code']. "'");
    
    //             if(count($category_query_run) > 0){
                    
    //                 $category_code = $category_query_run[0]->vcategorycode;
                    
    //             } else {
                    
    //                 //create a record;
    //                 try {
    //                     $sql = "INSERT INTO ".$db.".mst_category SET `vcategoryname` = '" . html_entity_decode($input['category_code']) . "',`vdescription` = '" . html_entity_decode($input['category_code']) . "', vcategorttype = '',`isequence` = '0',`dept_code` ='". (int)$dept_code ."',`estatus` = 'Active',SID = '" . (int)$input['sid']."'";
            
    //                     DB::connection('mysql')->select($sql);
            
    //                     $last_id_query = DB::connection('mysql')->select("SELECT max(icategoryid) last_id from ".$db.".mst_category");
                        
    //                     $last_id = $last_id_query[0]->last_id;
                        
                        
    //                     DB::connection('mysql')->select("UPDATE ".$db.".mst_category SET vcategorycode = '" . (int)$last_id . "' WHERE icategoryid = '" . (int)$last_id . "'");
    //                 }
    //                 catch (MySQLDuplicateKeyException $e) {
    //                     // duplicate entry exception
    //                   $error['error'] = $e->getMessage(); 
    //                     return $error; 
    //                 }
    //                 catch (MySQLException $e) {
    //                     // other mysql exception (not duplicate key entry)
                        
    //                     $error['error'] = $e->getMessage(); 
    //                     return $error; 
    //                 }
    //                 catch (Exception $e) {
    //                     // not a MySQL exception
                       
    //                     $error['error'] = $e->getMessage(); 
    //                     return $error; 
    //                 }
            
    //                 $category_code = $last_id;
    //             } 
    //         }

    //     } else {
    //         $category_code=1;
    //     }
        
        
    //     // $supplier_code = array_key_exists('supplier_code', $input)?$input['supplier_code']:1;
    //     //======================================================== Supplier ==================================================================================
    //     if(array_key_exists('supplier_code', $input)){

    //         // check if the supplier exists with the entered supplier id
    //         $sup_code_query_run = DB::connection('mysql')->select("SELECT * FROM ".$db.".mst_supplier WHERE isupplierid='" .(int)$input['supplier_code']. "'");

    //         if(count($sup_code_query_run) > 0) {
                
    //             //return the vsuppliercode
    //             $supplier_code = $sup_code_query_run[0]->vsuppliercode;
                
    //         } else {
                
    //           // check if the supplier exists with the name
    //             $supplier_query_run = DB::connection('mysql')->select("SELECT * FROM ".$db.".mst_supplier WHERE vcompanyname =  '" .$input['supplier_code']. "'");
    
    //             if(count($supplier_query_run) > 0){
                    
    //                 $supplier_code = $supplier_query_run[0]->vsuppliercode;
                    
    //             } else {
                    
    //                 //create a record;
    //                 try {
    //                     $sql = "INSERT INTO ".$db.".mst_supplier SET  vcompanyname = '" . $input['supplier_code'] . "',`vvendortype` = 'Vendor', vfnmae = '',`vlname` = '',`vcode` = '', vaddress1 = '', vcity = '', vstate = '', vphone = '', vzip = '', vcountry = '', vemail = '', plcbtype = '', estatus = 'Active',SID = '" . (int)$input['sid']."'";
            
    //                     DB::connection('mysql')->select($sql);
            
    //                     $last_id_query = DB::connection('mysql')->select("SELECT max(isupplierid) last_id from ".$db.".mst_supplier");
                        
    //                     $last_id = $last_id_query[0]->last_id;
                        
    //                     DB::connection('mysql')->select("UPDATE ".$db.".mst_supplier SET vsuppliercode = '" . (int)$last_id . "' WHERE isupplierid = '" . (int)$isupplierid . "'");
    //                 }
    //                 catch (MySQLDuplicateKeyException $e) {
    //                     // duplicate entry exception
    //                   $error['error'] = $e->getMessage(); 
    //                     return $error; 
    //                 }
    //                 catch (MySQLException $e) {
    //                     // other mysql exception (not duplicate key entry)
                        
    //                     $error['error'] = $e->getMessage(); 
    //                     return $error; 
    //                 }
    //                 catch (Exception $e) {
    //                     // not a MySQL exception
                       
    //                     $error['error'] = $e->getMessage(); 
    //                     return $error; 
    //                 }
            
    //                 $supplier_code = $last_id;
    //             } 
    //         }

    //     } else {
    //         $supplier_code=101;
    //     }        
        
    //     $age_verification = isset($input['age_verification'])?$input['age_verification']:0;
        
        
    //     $cost = $input['cost'];
        
    //     $selling_price = $input['selling_price'];
        
    //     $qty_on_hand = $input['qty_on_hand'];
        
    //     $tax1 = array_key_exists('tax1', $input)?$input['tax1']:"N";
        
    //     $tax2 = array_key_exists('tax2', $input)?$input['tax2']:"N";
        
    //     //Set Status to Active and inventory to Yes (if not entered), default
        
    //     $estatus = "Active";
        
    //     $is_inventory = isset($input['is_inventory'])?$input['is_inventory']:"Yes";
        
    //     $description = isset($input['description'])?$input['description']:"";
    //     $unitcode = isset($input['vunitcode'])?$input['vunitcode']:"UNT001";
    //     $size = isset($input['size'])?$input['size']:"";
    //     $sellingunit = isset($input['sellingunit'])?$input['sellingunit']:1;
    //     $food_stamp = isset($input['food_stamp'])?$input['food_stamp']:"N";
    //     $wic_item = isset($input['WIC_item'])?$input['WIC_item']:0;
        
    //     $liability = "N";
        
    //     /*'barcode', 'item_type', 'item_name', 'description', 'unit', 'department', 'category', 'supplier', 'group', 'size', 'cost', 'selling_price', 'qty_on_hand', 'tax1', 'tax2', 'selling_unit', 'food_stamp', 'WIC_item', 'age_verification'

        
    //     $query_insert = "INSERT INTO ".$db.".mst_item (vbarcode,vitemcode,vitemname,vitemtype,vcategorycode,SID,estatus,dcostprice,dunitprice,iqtyonhand,vtax1,vtax2,visinventory) VALUES('".$barcode."','".$barcode."','".$itemname."','".$itemtype."',".$category_code.",".$store->id.",'".$estatus."',".$cost.",".$selling_price.",".$qty_on_hand.",'".$tax1."','".$tax2."','".$is_inventory."')";*/


    //     if(count($matching_records) > 0){
            
    //         // ('".$itemname."','".$itemtype."','".$dept_code."','".$category_code."','".$supplier_code."','".$store->id."','".$estatus."','".$cost."','".$selling_price."','".$qty_on_hand."','".$tax1."','".$tax2."','".$is_inventory."','".$description."','".$unitcode."','".$size."','".$sellingunit."','".$food_stamp."','".$wic_item."','".$age_verification."','".$liability."')
            
    //         $update_query = "UPDATE ".$db.".mst_item SET vitemname='".$itemname."',vitemtype='".$itemtype."',vdepcode='".$dept_code."',vcategorycode='".$category_code."',vsuppliercode='".$supplier_code."',estatus='Active',dcostprice='".$cost."',nsaleprice='".$selling_price."',iqtyonhand='".$qty_on_hand."',vtax1='".$tax1."',vtax2='".$tax2."',visinventory='".$is_inventory."',vdescription='".$description."',vunitcode='".$unitcode."',vsize='".$size."',nsellunit='".$sellingunit."',vfooditem='".$food_stamp."',wicitem='".$wic_item."',vageverify='".$age_verification."',liability='".$liability."' WHERE iitemid='".$matching_records[0]->iitemid."'";
    //         DB::connection('mysql')->select($update_query);
            
    //         // return response()->json(['message' => 'Item edited successfully in the store database ('.$db.')'],200);
    //         return response()->json(['success' => 'Item edited successfully in the store database ('.$db.')'],200);

    //     }




    //     $query_insert = "INSERT INTO ".$db.".mst_item (vbarcode,vitemcode,vitemname,vitemtype,vdepcode,vcategorycode,vsuppliercode,SID,estatus,dcostprice,nsaleprice,iqtyonhand,vtax1,vtax2,visinventory,vdescription,vunitcode,vsize,nsellunit,vfooditem,wicitem,vageverify,liability) VALUES('".$barcode."','".$barcode."','".$itemname."','".$itemtype."','".$dept_code."','".$category_code."','".$supplier_code."','".$store->id."','".$estatus."','".$cost."','".$selling_price."','".$qty_on_hand."','".$tax1."','".$tax2."','".$is_inventory."','".$description."','".$unitcode."','".$size."','".$sellingunit."','".$food_stamp."','".$wic_item."','".$age_verification."','".$liability."')";
        
        

    //     //return $query_insert = "INSERT INTO ".$db.".mst_item ('iitemid','vitemname','SID') VALUES(20001,'".$input['itemname']."',".$input['sid'].")";
        
    //     $insert = DB::insert($query_insert);
        
    //     //Akshya-opening Qoh for Item moment 
    //         $vitemid = DB::getPdo()->lastInsertId(); 
           
    //         $query = DB::select("SELECT ipiid FROM ".$db.".trn_physicalinventory ORDER BY ipiid DESC LIMIT 1");
    //         $ipid = $query[0]->ipiid;
            
    //         $vrefnumber = str_pad($ipid+1,9,"0",STR_PAD_LEFT);
            
    // 		DB::statement("INSERT INTO ".$db.".trn_physicalinventory SET  vrefnumber= $vrefnumber, vtype ='OQohbyphone',SID = '" .$sidphone ."'");
    //         $ipiid = DB::getPdo()->lastInsertId(); 
            
            
    //         DB::statement("INSERT INTO ".$db.".trn_physicalinventorydetail SET  ipiid = '" . (int)$ipiid . "',
    //                      vitemid = '" .$vitemid. "',
    //                      vitemname = '" .$itemname. "',
    //                      ndebitqty= '" . $qty_on_hand. "', 
    //                      vbarcode = '" .$barcode. "', 
    //                      SID = '" .$sidphone."'
    //                      ");
    //     //opening qoh end
        
        
        
    //     $success_message = "Item inserted successfully in ".$db;
        
    //     if($insert){
    //         // return response()->json(['message' => $success_message], 200);
    //         return response()->json(['success' => $success_message], 200);

    //     } else {
    //       return response()->json(['message' => 'Item could not be inserted.'],200); 
    //     }
    // }

    public function updatePriceBySKU(Request $request) {
        $sku = Request::get('sku');
        $price = Request::get('price');
        $sid = Request::get('sid');

        if($sku && $price) { 
            /*$obj = Item::where('vbarcode',$sku);
            if(Request::get('sid')) {
                $obj->where('SID',Request::get('sid'));
            }
            $data = $obj->get();
            if(count($data) > 0 ) {
                foreach($data as $row) {
                    //$row->dunitprice = $price;
                    //$row->save();
                    $tmp = new tmp_priceupdate;
                    $tmp->SID = $row->SID;
                    $tmp->sku = $row->vbarcode;
                    $tmp->noldprice =  $row->dunitprice;
                    $tmp->nnewprice = $price;
                    $tmp->modifydate = date('Y-m-d H:i:s');
                    $tmp->tus = 0;
                    $tmp->save();
                }
            }*/
            
            $item = DB::select("SELECT count(*) count FROM u".$sid.".mst_item WHERE vbarcode=".$sku);
            
            // return $item[0]->count;
            
            if($item[0]->count == 0){
                
                return response()->json(["error" => 'Item does not exist in the db.'],401);
            }
            
            $formatted_price = number_format((float)$price, 2, '.', '');
            
            
            //$update_query = "UPDATE u".$sid.".mst_item SET `dunitprice`=".$formatted_price." WHERE vbarcode='".$sku."'";
            $update_query = "UPDATE u".$sid.".mst_item SET `nsaleprice`=".$formatted_price." WHERE vbarcode='".$sku."'";
            
            // $obj->dunitprice = $formatted_price;
            
            // $obj->save();
            
            DB::connection('mysql')->select($update_query);

            return response()->json(["message" => 'Price Updated Successfully '],200);
        } else {
            
            return response()->json(["error" => 'Both SKU and Price are  mandatory  '],401);
        }
    }
    
   //Hemant chnaged code for Item movement 10-oct-2020  
    public function updateQuantityBySKU(Request $request) {
    //   echo "sdafsd";die;
        $sku = Request::get('sku');
        $qty = Request::get('qty');
        $sid=Request::get('sid');
        $db = "u".$sid;
        
        
        $query_update = "UPDATE ".$db.".mst_item SET iqtyonhand = '" .$qty. "' WHERE vbarcode = '" .$sku. "'";
        DB::statement($query_update);
        //Adjustment detail start
        if($sku && $qty){
            $current_item = DB::select("SELECT * FROM ".$db.".mst_item WHERE vbarcode='".$sku ."'");
            
            $query = DB::select("SELECT ipiid FROM ".$db.".trn_physicalinventory ORDER BY ipiid DESC LIMIT 1");
            
            $ipid = $query[0]->ipiid;
            $vrefnumber = str_pad($ipid+1,9,"0",STR_PAD_LEFT);
            // echo "INSERT INTO ".$db.".trn_physicalinventory SET  vrefnumber= $vrefnumber, vtype = 'Update By Phone',SID = '" .$sid ."'";die;
    		DB::statement("INSERT INTO ".$db.".trn_physicalinventory SET  vrefnumber= $vrefnumber, vtype = 'Update By Phone',SID = '" .$sid ."'");
            $ipiid = DB::getPdo()->lastInsertId();
            $quickvalue=$qty-$current_item[0]->iqtyonhand;
       
            DB::statement("INSERT INTO ".$db.".trn_physicalinventorydetail SET  ipiid = '" . (int)$ipiid . "',
                         vitemid = '" .$current_item[0]->iitemid. "',
                         vitemname = '" .$current_item[0]->vitemname. "',
                         vunitcode = '" . $current_item[0]->vunitcode . "',
                         ndebitqty= '" . $quickvalue. "', 
                         
                         vbarcode = '" . $current_item[0]->vbarcode. "', 
                         SID = '" . $sid."'
                         ");
        
        }
        //adjustment detail end
    //   print_r($obj);die;
        if($sku && $qty) { 
            $obj = DB::select("SELECT * FROM ".$db.".mst_item WHERE vbarcode='".$sku ."'");
            //   print_r($obj);die;
            // echo Request::get('sid');die;
            // $obj = Item::where('vbarcode',$sku);
            if(Request::get('sid')) {
                $obj[0]->SID == Request::get('sid');
            }
            $data = $obj;
            //   print_r($data);die;
            if(count($data) > 0 ) {
                foreach($data as $row) {
                    // print_r($row);die;
                    //$row->dunitprice = $price;
                    //$row->save();
                    $row->iqtyonhand = $qty;
                    // $data->save();
                    
                
                }
            }

            return response()->json(['message' => 'Quantity Updated Successfully '],200);
        } else {
            return response()->json(['error' => 'SKU and Quantity is  missing  '],401);

        }
    }
    // public function updateQuantityBySKU(Request $request) {
    // //   echo "sdafsd";die;
    //     $sku = Request::get('sku');
    //     $qty = Request::get('qty');
    //     $sid=Request::get('sid');
    //     $db = "u".$sid;
        
    //     //Adjustment detail start
    //     if($sku && $qty){
    //         $current_item = DB::select("SELECT * FROM ".$db.".mst_item WHERE vbarcode='".$sku ."'");
            
    //         // echo "<pre>";
    //         // print_r($current_item);
    //         // die;
            
    //         $query = DB::select("SELECT ipiid FROM ".$db.".trn_physicalinventory ORDER BY ipiid DESC LIMIT 1");
            
    //         $ipid = $query[0]->ipiid;
    //         $vrefnumber = str_pad($ipid+1,9,"0",STR_PAD_LEFT);
            
    // 		DB::statement("INSERT INTO ".$db.".trn_physicalinventory SET  vrefnumber= $vrefnumber, vtype = 'Update By Phone',SID = '" .$sid ."'");
    //         $ipiid = DB::getPdo()->lastInsertId();
    //         $quickvalue=$qty-$current_item[0]->iqtyonhand;
            
            
            
    //         DB::statement("INSERT INTO ".$db.".trn_physicalinventorydetail SET  ipiid = '" . (int)$ipiid . "',
    //                      vitemid = '" .$current_item[0]->iitemid. "',
    //                      vitemname = '" .$current_item[0]->vitemname. "',
    //                      vunitcode = '" . $current_item[0]->vunitcode . "',
    //                      ndebitqty= '" . $quickvalue. "', 
    //                      vbarcode = '" . $current_item[0]->vbarcode. "', 
    //                      beforeQOH = '" . $current_item[0]->iqtyonhand . "', 
    //                      afterQOH = '" . $qty . "',
    //                      SID = '" . $sid."'
    //                      ");
        
    //     }
    //     //adjustment detail end
    // //   print_r($obj);die;
    //     if($sku && $qty) { 
    //         $obj = DB::select("SELECT * FROM ".$db.".mst_item WHERE vbarcode='".$sku ."'");
    //         //   print_r($obj);die;
    //         // echo Request::get('sid');die;
    //         // $obj = Item::where('vbarcode',$sku);
    //         if(Request::get('sid')) {
    //             $obj[0]->SID == Request::get('sid');
    //         }
    //         $data = $obj;
    //         //   print_r($data);die;
    //         if(count($data) > 0 ) {
    //             foreach($data as $row) {
    //                 // print_r($row);die;
    //                 //$row->dunitprice = $price;
    //                 //$row->save();
    //                 $row->iqtyonhand = $qty;
    //                 // $data->save();
    //             //===========Written by venkat for updating iqtyonhand from mobile================//
    //             $queryForUpdate = DB::select("UPDATE ".$db.".mst_item set iqtyonhand = '".$qty."'WHERE vbarcode='".$sku ."'  ");
    //             }
    //         }

    //         return response()->json(['message' => 'Quantity Updated Successfully '],200);
    //     } else {
    //         return response()->json(['error' => 'SKU and Quantity is  missing  '],401);

    //     }
    // }
    
    public function getProductDetail(Request $request){
        ini_set('memory_limit','1G');
        $sid = Request::get('sid',null);
        if(!is_null($sid)){ 

            $mst_tax = MST_TAX::where('Id',1)->first();

            $menuItem = kioskMenuItem::join('mst_item','mst_item.iitemid','=','kiosk_menu_item.iitemid')->where('mst_item.SID',$sid)->orderBy('mst_item.iitemid','asc');
            $data = array();
            $menuItem = $menuItem->get(array('kiosk_menu_item.*', 'mst_item.vitemname as title','mst_item.vbarcode as sku','mst_item.vsequence as product_sequence','mst_item.iqtyonhand as quantity','mst_item.itemimage as itemimage','mst_item.iitemid as itemid','mst_item.estatus as estatus','mst_item.vtax1 as vtax1'));
            foreach ($menuItem as $key => $item) {
                $product = array();
                $product['id'] =  $item->iitemid;
                $product['title'] = $item->title;
                $product['price'] = $item->Price;
                $product['sku'] =  $item->sku;
                $product['product_sequence'] =  $item->product_sequence;
                $product['estatus'] =  $item->estatus;
                $product['vtax1'] =  $item->vtax1;
                $product['vtax1_rate'] =  $mst_tax->ntaxrate;

                if($item->itemimage){
                     $product['image'] = $item->product_image;
                }
               
                $product['quantity'] = $item->quantity;
              
                if($item->category) {
                    $product['category'] = $item->category->Category;
                    $product['menu_id'] = $item->MenuId;
                    $product['category_id'] = $item->CategoryId;
                    $product['category_sequence'] = $item->category->Sequence;
                    if($item->category->ImageLoc){
                        $product['category_image'] = url('/api/admin/categories/image/'.$item->CategoryId);
                    }
                }
                $product['pages'] = array();
                if($item->pages){
                    foreach ($item->pages as $page) {
                        foreach ($item->menus as $menu) {
                        $new_page = array('id'=>$page->PageId,'title'=>$page->pageTitle['DisplayTitle'], 'Action' => $page->Action,'options'=>array());
                        foreach($page->options as $option) {
                            if($option->item) { 
                               $image = base64_encode($option->item->itemimage);   
                                $new_page['options'][] =  array( 'id'=>$option->item->iitemid, 'title'=>$option->item->vitemname,'vtax1'=>$option->item->vtax1,
                                                                   'price' => $option->Price,'image' => $option->item->product_image,
                                                                   'sku' => $option->item->vbarcode,'quantity' => $option->item->iqtyonhand,
                                                                   'DisplaySeq'=> $option->DisplaySeq );
                                
                                sort($new_page['options']);
                            }
                        }
                        
                        $product['pages'][] = $new_page;
                    }
                       
                    }
                }
                sort($product['pages']);
                $data[] = $product;
            }
        }
        else {
            return response()->json(['error'=>'sid is  missing'],401);
        }
        
        return $data;
       
    }
    public function editPrice(Request $request,$id)
    {
        $products = Item::where('iitemid',$id)->first();
        if($products) {
        $tmp = new tmp_priceupdate;
                    $tmp->SID = $products->SID;
                    $tmp->sku = $products->vbarcode;
                    $tmp->noldprice =  $products->dunitprice;
                    $tmp->nnewprice = Request::get('editval');
                    $tmp->modifydate = date('Y-m-d H:i:s');
                    $tmp->status = 0;
                    $tmp->save();
        }
        $products->save();
    }
    public function getImage($id){
        $product = Item::where('iitemid',$id)->first();
        if($product && $product->itemimage){
            $result = base64_encode($product->itemimage);
            return view('admin.product.product_image',compact('result'));
        }
    }

    public function getCategoryImage($id){
        $category = kioskCategory::where('CategoryId',$id)->first();
        
        if($category && $category->ImageLoc){
            $result = base64_encode($category->ImageLoc);
            return view('admin.product.product_image',compact('result'));
        }
    }
    
    
    //close the end of day with the relevant shifts
    public function end_of_day(Request $request){
        
        $input = Request::all();
        
        $file_path = storage_path('/logs/eod_pos.log');
        $handle = fopen($file_path, 'a');
        $content = date('m-d-Y H:i:s').': '.json_encode($input['data']).PHP_EOL;
        fwrite($handle, $content);
        fclose($handle);
        
        $data = $input['data'];
        
        $success =array();
        $error =array();

        $start_date = $data['start_date'];
        $dstartdatetime = DateTime::createFromFormat("m-d-Y" , $start_date);
        $dstartdatetime = $dstartdatetime->format('Y-m-d');
        
        
        // return $dstartdatetime;

        $denddatetime = DateTime::createFromFormat('m-d-Y', $data['start_date']);
        $denddatetime = $denddatetime->format('Y-m-d');
        
        $dstartdatetime = $dstartdatetime.' '.date('H:i:s');
        $denddatetime = $denddatetime.' '.date('H:i:s');
        
        $year = DateTime::createFromFormat('m-d-Y', $data['start_date']);
        $year = $year->format('y');

        $month = DateTime::createFromFormat('m-d-Y', $data['start_date']);
        $month = $month->format('m');

        $day = DateTime::createFromFormat('m-d-Y', $data['start_date']);
        $day = $day->format('d');

        $auto_inc_id = $year.''.$month.''.$day.'101';
        
        
        
        
        //Select the store database
        
        $store = Store::where('id','=',$data['sid'])->first();
        
        if(empty($store)){
            
            $response['message'] = "That store does not exist";
            $response['status'] = 'error';
            return response()->json($response);
        }
        
        $db = "u".$store->id;
        
        $check=''; $counter=0; $count_batches = count($data['batch']);
        foreach($data['batch'] as $batch){
            $counter++;
            $query_trn_batch = "SELECT ibatchid FROM ".$db.".trn_batch Where ibatchid = '".$batch."' AND (estatus = 'Open' OR endofday = '1') ";
            $result = DB::select($query_trn_batch);
            
            if($result){
                $check .= $batch;
            }
            
            if($counter != $count_batches){ $check .= ', '; }
            
        }
        if(isset($check) && !empty(trim($check))){
            $response['data'] = $check;
            $response['message'] = "End of Day of Batch {$check} is already done or the batch is open.";
            $response['status'] = 'error';
            return response()->json($response);
        }
        // die;
        
        
        $query_db = 'USE DATABASE '.$db;
        
        DB::raw($query_db);
        
        
        $check_query = "SELECT * FROM ".$db.".trn_endofday WHERE date_format(dstartdatetime,'%m-%d-%Y')='". $start_date ."'";
        
        $check_exist = DB::select($check_query);
        

        $batches = array_values(array_filter($data['batch'], function($value) { return trim($value) !== ''; }));
        
        $batch_ids = implode(',', $batches);
        
        

        
        
        if(count($check_exist) > 0){
            
            $check_exist_id = $check_exist[0]->id;

            $exist_batch_ids = DB::select("SELECT batchid FROM ".$db.".trn_endofdaydetail WHERE eodid='". $check_exist_id ."'");

            $old_batch_ids = array();

            if(count($exist_batch_ids) > 0){
                foreach ($exist_batch_ids as $k => $v) {
                    $old_batch_ids[] = $v->batchid;
                }
            }


            $new_batch_ids = array();

            foreach ($batches as $new_v) {
                if(!in_array($new_v, $old_batch_ids)){
                    $new_batch_ids[]= $new_v;
                } 
            }
            


            if(count($new_batch_ids) > 0){
                $batch_ids_new = implode(',', $new_batch_ids);

                $batch_data = DB::select("SELECT ifnull(SUM(nnetsales),0.00) as nnetsales, ifnull(SUM(nnetpaidout),0.00) as nnetpaidout, ifnull(SUM(nnetcashpickup),0.00) as nnetcashpickup, ifnull(SUM(nopeningbalance),0.00) as nopeningbalance, ifnull(SUM(nclosingbalance),0.00) as nclosingbalance, ifnull(SUM(nuserclosingbalance),0.00) as nuserclosingbalance, ifnull(SUM(nnetaddcash),0.00) as nnetaddcash, ifnull(SUM(ntotalnontaxable),0.00) as ntotalnontaxable, ifnull(SUM(ntotaltaxable),0.00) as ntotaltaxable, ifnull(SUM(ntotalsales),0.00) as ntotalsales, ifnull(SUM(ntotaltax),0.00) as ntotaltax, ifnull(SUM(ntotalcreditsales),0.00) as ntotalcreditsales, ifnull(SUM(ntotalcashsales),0.00) as ntotalcashsales, ifnull(SUM(ntotalgiftsales),0.00) as ntotalgiftsales, ifnull(SUM(ntotalchecksales),0.00) as ntotalchecksales, ifnull(SUM(ntotalreturns),0.00) as ntotalreturns, ifnull(SUM(ntotaldiscount),0.00) as ntotaldiscount, ifnull(SUM(ntotaldebitsales),0.00) as ntotaldebitsales, ifnull(SUM(ntotalebtsales),0.00) as ntotalebtsales FROM " . $db . ".trn_batch WHERE ibatchid IN($batch_ids_new)");
                
                
                // return $batch_data;
                
                // $this->db2->query();
                
                DB::statement("UPDATE " . $db . ".trn_endofday SET nnetsales =nnetsales+ '" . $batch_data[0]->nnetsales . "', nnetpaidout =nnetpaidout+ '" . $batch_data[0]->nnetpaidout . "', nnetcashpickup =nnetcashpickup+ '" . $batch_data[0]->nnetcashpickup . "', dstartdatetime = '" . $dstartdatetime . "', denddatetime = '" . $denddatetime . "', nopeningbalance =nopeningbalance+ '" . $batch_data[0]->nopeningbalance . "', nclosingbalance =nclosingbalance+ '" . $batch_data[0]->nclosingbalance . "', nuserclosingbalance =nuserclosingbalance+ '" . $batch_data[0]->nuserclosingbalance . "', nnetaddcash =nnetaddcash+ '" . $batch_data[0]->nnetaddcash . "',  ntotalnontaxable =ntotalnontaxable+ '" . $batch_data[0]->ntotalnontaxable . "', ntotaltaxable =ntotaltaxable+ '" . $batch_data[0]->ntotaltaxable . "', ntotalsales =ntotalsales+ '" . $batch_data[0]->ntotalsales . "', ntotaltax =ntotaltax+ '" . $batch_data[0]->ntotaltax . "', ntotalcreditsales =ntotalcreditsales+ '" . $batch_data[0]->ntotalcreditsales . "', ntotalcashsales =ntotalcashsales+ '" . $batch_data[0]->ntotalcashsales . "', ntotalgiftsales =ntotalgiftsales+ '" . $batch_data[0]->ntotalgiftsales . "', ntotalchecksales =ntotalchecksales+ '" . $batch_data[0]->ntotalchecksales . "', ntotalreturns =ntotalreturns+ '" . $batch_data[0]->ntotalreturns . "', ntotaldiscount =ntotaldiscount+ '" . $batch_data[0]->ntotaldiscount . "', ntotaldebitsales =ntotaldebitsales+ '" . $batch_data[0]->ntotaldebitsales . "', ntotalebtsales =ntotalebtsales+ '" . $batch_data[0]->ntotalebtsales . "' WHERE id='". $check_exist_id ."'");

                foreach ($new_batch_ids as $key_id => $new_batch_ids_value) {
                    DB::statement("INSERT INTO " . $db . ".trn_endofdaydetail SET eodid = '" . $check_exist_id . "', batchid = '" . $new_batch_ids_value . "',SID = '" . (int)$data['sid']."'");

                    DB::statement("UPDATE " . $db . ".trn_batch SET endofday = '1' WHERE ibatchid='". $new_batch_ids_value ."'");

                }

            }
 
        }else{
            
            $batch_data_query = "SELECT ifnull(SUM(nnetsales),0.00) as nnetsales, ifnull(SUM(nnetpaidout),0.00) as nnetpaidout, ifnull(SUM(nnetcashpickup),0.00) as nnetcashpickup, ifnull(SUM(nopeningbalance),0.00) as nopeningbalance, ifnull(SUM(nclosingbalance),0.00) as nclosingbalance, ifnull(SUM(nuserclosingbalance),0.00) as nuserclosingbalance, ifnull(SUM(nnetaddcash),0.00) as nnetaddcash, ifnull(SUM(ntotalnontaxable),0.00) as ntotalnontaxable, ifnull(SUM(ntotaltaxable),0.00) as ntotaltaxable, ifnull(SUM(ntotalsales),0.00) as ntotalsales, ifnull(SUM(ntotaltax),0.00) as ntotaltax, ifnull(SUM(ntotalcreditsales),0.00) as ntotalcreditsales, ifnull(SUM(ntotalcashsales),0.00) as ntotalcashsales, ifnull(SUM(ntotalgiftsales),0.00) as ntotalgiftsales, ifnull(SUM(ntotalchecksales),0.00) as ntotalchecksales, ifnull(SUM(ntotalreturns),0.00) as ntotalreturns, ifnull(SUM(ntotaldiscount),0.00) as ntotaldiscount, ifnull(SUM(ntotaldebitsales),0.00) as ntotaldebitsales, ifnull(SUM(ntotalebtsales),0.00) as ntotalebtsales FROM " . $db . ".trn_batch WHERE ibatchid IN($batch_ids)";

            $batch_data = DB::select($batch_data_query);

            $insert_query = "INSERT INTO " . $db . ".trn_endofday SET id='". $auto_inc_id ."', nnetsales = '" . $batch_data[0]->nnetsales . "', nnetpaidout = '" . $batch_data[0]->nnetpaidout . "', nnetcashpickup = '" . $batch_data[0]->nnetcashpickup . "', dstartdatetime = '" . $dstartdatetime . "', denddatetime = '" . $denddatetime . "', nopeningbalance = '" . $batch_data[0]->nopeningbalance . "', nclosingbalance = '" . $batch_data[0]->nclosingbalance . "', nuserclosingbalance = '" . $batch_data[0]->nuserclosingbalance . "', nnetaddcash = '" . $batch_data[0]->nnetaddcash . "',  ntotalnontaxable = '" . $batch_data[0]->ntotalnontaxable . "', ntotaltaxable = '" . $batch_data[0]->ntotaltaxable . "', ntotalsales = '" . $batch_data[0]->ntotalsales . "', ntotaltax = '" . $batch_data[0]->ntotaltax . "', ntotalcreditsales = '" . $batch_data[0]->ntotalcreditsales . "', ntotalcashsales = '" . $batch_data[0]->ntotalcashsales . "', ntotalgiftsales = '" . $batch_data[0]->ntotalgiftsales . "', ntotalchecksales = '" . $batch_data[0]->ntotalchecksales . "', ntotalreturns = '" . $batch_data[0]->ntotalreturns . "', ntotaldiscount = '" . $batch_data[0]->ntotaldiscount . "', ntotaldebitsales = '" . $batch_data[0]->ntotaldebitsales . "', ntotalebtsales = '" . $batch_data[0]->ntotalebtsales . "' ,SID = '" . (int)$data['sid']."'";
            
            DB::statement($insert_query);

            // $last_id = $this->db2->getLastId();

            foreach ($batches as $key => $value) {
                DB::statement("INSERT INTO " . $db . ".trn_endofdaydetail SET eodid = '" . $auto_inc_id . "', batchid = '" . $value . "',SID = '" . (int)$data['sid'] . "'");

                DB::statement("UPDATE " . $db . ".trn_batch SET endofday = '1' WHERE ibatchid='". $value ."'");
            }

        }
        
        $response['message'] = 'Successfully Updated End of Day Shift';
        $response['status'] = 'success';
        return response()->json($response, 200);
    }
    
    //===================  insert into new_sku_stores =========================================
    public function track_new_skus(){
        
        // $date = date('Y-m-d');
        
        $date = '2019-06-10';
        
        /*$exclude_query = "select barcode from inslocdb.npl_items union select barcode from inslocdb.new_sku_stores";
        
        return $run_exclude_query = DB::select($exclude_query);*/
        
        
        //create the select query
        $concatenate_select_query = "select concat('select vbarcode,vitemname,SID,dcreated FROM ',table_schema ,'.mst_item where date_format(dcreated,','''%Y-%m-%d''',')>''','" . $date . "''and vbarcode not in (select barcode from inslocdb.npl_items union select barcode from inslocdb.new_sku_stores);') as script from information_schema.TABLES where Table_Name='mst_item' and table_schema like 'u%'"; 

        $run_select_query = DB::select($concatenate_select_query);
// echo "<br><br>";        
        $concatenate_insert_query = "select concat('insert into inslocdb.new_sku_stores (barcode,itemtype,itemname,SID,item_create_dt) select vbarcode,vitemtype, vitemname,''', table_schema, ''' , dcreated  FROM ',table_schema ,'.mst_item where date_format(dcreated,','''%Y-%m-%d''',')>''','" . $date . "''and vbarcode not in (select barcode from inslocdb.npl_items union select barcode from inslocdb.new_sku_stores);') as script from information_schema.TABLES where Table_Name='mst_item' and table_schema like 'u%'"; 
// die;        
        $run_insert_query = DB::select($concatenate_insert_query);
        
        
        $data_row = "========================".$date."========================".PHP_EOL;

        $file_path = public_path()."/track_new_skus.txt";

		$myfile = fopen( $file_path, "a");

        foreach($run_insert_query as $k => $query){
            
            $run_select_query[$k]->script;
            
            try{
                $data_row = json_encode(DB::select($run_select_query[$k]->script));
                
                $data_row .= PHP_EOL;
                
                DB::statement($query->script);                
                
            } catch(\Exception $e) {
                
                fwrite($myfile,json_encode($e));
                
                continue;
                
            }
            
            fwrite($myfile,$data_row);
            
            // echo $query->script."<br/>";
        }
        
        // return "Done";
		
		fclose($myfile);
        
        return "New SKU";
    }
    
    
    public function getDownload()
    {
        //PDF file is stored under project/public/download/info.pdf
        $file= public_path(). "/robots.txt";
    
        // header('Content-Description: File Transfer');
        // header('Content-Type: application/octet-stream');
        // header('Content-Disposition: attachment; filename='.basename($file));
        // header('Content-Transfer-Encoding: binary');
        // header('Expires: 0');
        // header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        // header('Pragma: public');
        // header('Content-Length: ' . filesize($file));
    
        /*$headers = array(
                    'Content-Description: File Transfer',
                    'Content-Type: application/octet-stream',
                    'Content-Disposition: attachment; filename='.basename($file),
                    'Content-Transfer-Encoding: binary',
                    'Expires: 0',
                    'Cache-Control: must-revalidate, post-check=0, pre-check=0',
                    'Pragma: public',
                    'Content-Length: ' . filesize($file)
                );*/
                
                
        
    
        return Response::download($file, 'filename.txt', $headers);
    }
    
    public function convert_barcode(){
        
        $input = Request::all();
        
        if(!array_key_exists('upc', $input) || $input['upc'] == ''){
            
            $return['message'] = "You did not send the barcode.";
            $return['status'] = "error";
            
            return response()->json($return, 400);
        }

        $upc = $input['upc'];
        
        $option = strlen($upc);
        
        
        
        /*option 
        8. upce to upca 
        12. upca to upce*/
        
        if($option === 8 || $option === 7){

            // UPC-E
            
            $response = $this->convert_upce_to_upca($upc);
            
            if($response === false){
                
                $return['message'] = "Invalid barcode.";
                $return['status'] = "error";
            
                return response()->json($return, 400);
            }
            
            $return['data'] = $response;
            $return['status'] = "success";
            
            return response()->json($return, 200);
            
        } elseif($option === 12 || $option === 11){
            
            // UPC-A
            
            $response = $this->convert_upca_to_upce($upc);
            
            if($response === false){
                
                $return['message'] = "Invalid barcode.";
                $return['status'] = "error";
            
                return response()->json($return, 400);
            }
            
            $return['data'] = $response;
            $return['status'] = "success";
            
            return response()->json($return, 200);
            
        } else {
            
            //neither UPC A nor UPC E
            
            $return['message'] = "Invalid barcode.";
            $return['status'] = "error";
            
            return response()->json($return, 400);
        }
        
        
    }
    
    
    public function convert_upca_2_upce(){
        
        $input = Request::all();
        
        if(!array_key_exists('upc', $input) || $input['upc'] == ''){
            
            $return['message'] = "You did not send the barcode.";
            $return['status'] = "error";
            
            return response()->json($return, 400);
        }

        $upc = $input['upc'];
        
        $option = strlen($upc);
        if($option === 13)
        {
            //  $option = substr($option, 1);
             $upc = substr($upc, 1);

        }
        $option = strlen($upc);
        
        if($option === 12 || $option === 11){
            
            // UPC-A
            
            $response = $this->convert_upca_to_upce($upc);
            
            if($response === false){
                
                $return['message'] = "Invalid barcode.";
                $return['status'] = "error";
            
                return response()->json($return, 400);
            }
            
            $return['data'] = $response;
            $return['status'] = "success";
            
            return response()->json($return, 200);
            
        } else {
            
            //neither UPC A nor UPC E
            
            $return['message'] = "Invalid barcode.";
            $return['status'] = "error";
            
            return response()->json($return, 400);
        }
    }
    
    
    public function convert_upce_2_upca(){
        
        $input = Request::all();
        
        if(!array_key_exists('upc', $input) || $input['upc'] == ''){
            
            $return['message'] = "You did not send the barcode.";
            $return['status'] = "error";
            
            return response()->json($return, 400);
        }

        $upc = $input['upc'];
        
        $option = strlen($upc);
        
        if($option === 8 || $option === 7){

            // UPC-E
            
            $response = $this->convert_upce_to_upca($upc);
            
            if($response === false){
                
                $return['message'] = "Invalid barcode.";
                $return['status'] = "error";
            
                return response()->json($return, 400);
            }
            
            $return['data'] = $response;
            $return['status'] = "success";
            
            return response()->json($return, 200);
            
        } else {
            
            //neither UPC A nor UPC E
            
            $return['message'] = "Invalid barcode.";
            $return['status'] = "error";
            
            return response()->json($return, 400);
        }
    }
    
    
    
    public function convert_upce_to_upca($upc) {
	    
		if(!isset($upc)||!is_numeric($upc)) { return false; }
		if(strlen($upc)==7) { $upc = $upc.$this->validate_upce($upc,true); }
		if(strlen($upc)>8||strlen($upc)<8) { return false; }
		if(!preg_match("/^0/", $upc)) { return false; }
		if($this->validate_upce($upc)===false) { return false; }
		if(preg_match("/0(\d{5})([0-3])(\d{1})/", $upc, $upc_matches)) {
		$upce_test = preg_match("/0(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})/", $upc, $upc_matches);
		if($upce_test==false) { return false; }
		if($upc_matches[6]==0) {
		$upce = "0".$upc_matches[1].$upc_matches[2].$upc_matches[6]."0000".$upc_matches[3].$upc_matches[4].$upc_matches[5].$upc_matches[7]; }
		if($upc_matches[6]==1) {
		$upce = "0".$upc_matches[1].$upc_matches[2].$upc_matches[6]."0000".$upc_matches[3].$upc_matches[4].$upc_matches[5].$upc_matches[7]; }
		if($upc_matches[6]==2) {
		$upce = "0".$upc_matches[1].$upc_matches[2].$upc_matches[6]."0000".$upc_matches[3].$upc_matches[4].$upc_matches[5].$upc_matches[7]; }
		if($upc_matches[6]==3) {
		$upce = "0".$upc_matches[1].$upc_matches[2].$upc_matches[3]."00000".$upc_matches[4].$upc_matches[5].$upc_matches[7]; } }
		if(preg_match("/0(\d{5})([4-9])(\d{1})/", $upc, $upc_matches)) {
		preg_match("/0(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})/", $upc, $upc_matches);
		if($upc_matches[6]==4) {
		$upce = "0".$upc_matches[1].$upc_matches[2].$upc_matches[3].$upc_matches[4]."00000".$upc_matches[5].$upc_matches[7]; }
		if($upc_matches[6]==5) {
		$upce = "0".$upc_matches[1].$upc_matches[2].$upc_matches[3].$upc_matches[4].$upc_matches[5]."0000".$upc_matches[6].$upc_matches[7]; }
		if($upc_matches[6]==6) {
		$upce = "0".$upc_matches[1].$upc_matches[2].$upc_matches[3].$upc_matches[4].$upc_matches[5]."0000".$upc_matches[6].$upc_matches[7]; }
		if($upc_matches[6]==7) {
		$upce = "0".$upc_matches[1].$upc_matches[2].$upc_matches[3].$upc_matches[4].$upc_matches[5]."0000".$upc_matches[6].$upc_matches[7]; }
		if($upc_matches[6]==8) {
		$upce = "0".$upc_matches[1].$upc_matches[2].$upc_matches[3].$upc_matches[4].$upc_matches[5]."0000".$upc_matches[6].$upc_matches[7]; }
		if($upc_matches[6]==9) {
		$upce = "0".$upc_matches[1].$upc_matches[2].$upc_matches[3].$upc_matches[4].$upc_matches[5]."0000".$upc_matches[6].$upc_matches[7]; } }
		return $upce; 
	}
	
	public function convert_upca_to_upce($upc) {
		if(!isset($upc)||!is_numeric($upc)) { return false; }
		if(strlen($upc)==11) { $upc = $upc.$this->validate_upca($upc,true); }
		if(strlen($upc)>12||strlen($upc)<12) { return false; }
		if($this->validate_upca($upc)===false) { return false; }
		if(!preg_match("/0(\d{11})/", $upc)) { return false; }
		$upce = null;
		if(preg_match("/0(\d{2})00000(\d{3})(\d{1})/", $upc, $upc_matches)) {
		$upce = "0".$upc_matches[1].$upc_matches[2]."0";
		$upce = $upce.$upc_matches[3]; return $upce; }
		if(preg_match("/0(\d{2})10000(\d{3})(\d{1})/", $upc, $upc_matches)) {
		$upce = "0".$upc_matches[1].$upc_matches[2]."1";
		$upce = $upce.$upc_matches[3]; return $upce; }
		if(preg_match("/0(\d{2})20000(\d{3})(\d{1})/", $upc, $upc_matches)) {
		$upce = "0".$upc_matches[1].$upc_matches[2]."2";
		$upce = $upce.$upc_matches[3]; return $upce; }
		if(preg_match("/0(\d{3})00000(\d{2})(\d{1})/", $upc, $upc_matches)) {
		$upce = "0".$upc_matches[1].$upc_matches[2]."3";
		$upce = $upce.$upc_matches[3]; return $upce; }
		if(preg_match("/0(\d{4})00000(\d{1})(\d{1})/", $upc, $upc_matches)) {
		$upce = "0".$upc_matches[1].$upc_matches[2]."4";
		$upce = $upce.$upc_matches[3]; return $upce; }
		if(preg_match("/0(\d{5})00005(\d{1})/", $upc, $upc_matches)) {
		$upce = "0".$upc_matches[1]."5";
		$upce = $upce.$upc_matches[2]; return $upce; }
		if(preg_match("/0(\d{5})00006(\d{1})/", $upc, $upc_matches)) {
		$upce = "0".$upc_matches[1]."6";
		$upce = $upce.$upc_matches[2]; return $upce; }
		if(preg_match("/0(\d{5})00007(\d{1})/", $upc, $upc_matches)) {
		$upce = "0".$upc_matches[1]."7";
		$upce = $upce.$upc_matches[2]; return $upce; }
		if(preg_match("/0(\d{5})00008(\d{1})/", $upc, $upc_matches)) {
		$upce = "0".$upc_matches[1]."8";
		$upce = $upce.$upc_matches[2]; return $upce; }
		if(preg_match("/0(\d{5})00009(\d{1})/", $upc, $upc_matches)) {
		$upce = "0".$upc_matches[1]."9";
		$upce = $upce.$upc_matches[2]; return $upce; }
		if($upce==null) { return false; }
	}

	public function validate_upce($upc,$return_check=false) 
	{
		if(!isset($upc)||!is_numeric($upc)) { return false; }
		if(strlen($upc)>8) { preg_match("/^(\d{8})/", $upc, $fix_matches); $upc = $fix_matches[1]; }
		if(strlen($upc)>8||strlen($upc)<7) { return false; }
		if(!preg_match("/^0/", $upc)) { return false; }
		$CheckDigit = null;
		if(strlen($upc)==8&&preg_match("/^(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})/", $upc, $upc_matches)) {
		preg_match("/^(\d{7})(\d{1})/", $upc, $upc_matches);
		$CheckDigit = $upc_matches[2]; }
		if(preg_match("/^(\d{1})(\d{5})([0-3])/", $upc, $upc_matches)) {
		preg_match("/^(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})/", $upc, $upc_matches);
		if($upc_matches[7]==0) {
		$OddSum = (0 + $upc_matches[3] + 0 + 0 + $upc_matches[4] + $upc_matches[6]) * 3;
		$EvenSum = $upc_matches[2] + 0 + 0 + 0 + $upc_matches[5]; }
		if($upc_matches[7]==1) {
		$OddSum = (0 + $upc_matches[3] + 0 + 0 + $upc_matches[4] + $upc_matches[6]) * 3;
		$EvenSum = $upc_matches[2] + 1 + 0 + 0 + $upc_matches[5]; }
		if($upc_matches[7]==2) {
		$OddSum = (0 + $upc_matches[3] + 0 + 0 + $upc_matches[4] + $upc_matches[6]) * 3;
		$EvenSum = $upc_matches[2] + 2 + 0 + 0 + $upc_matches[5]; }
		if($upc_matches[7]==3) {
		$OddSum = (0 + $upc_matches[3] + 0 + 0 + 0 + $upc_matches[6]) * 3;
		$EvenSum = $upc_matches[2] + $upc_matches[4] + 0 + 0 + $upc_matches[5]; } }
		if(preg_match("/^(\d{1})(\d{5})([4-9])/", $upc, $upc_matches)) {
		preg_match("/^(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})/", $upc, $upc_matches);
		if($upc_matches[7]==4) {
		$OddSum = (0 + $upc_matches[3] + $upc_matches[5] + 0 + 0 + $upc_matches[6]) * 3;
		$EvenSum = $upc_matches[2] + $upc_matches[4] + 0 + 0 + 0; }
		if($upc_matches[7]==5) {
		$OddSum = (0 + $upc_matches[3] + $upc_matches[5] + 0 + 0 + $upc_matches[7]) * 3;
		$EvenSum = $upc_matches[2] + $upc_matches[4] + $upc_matches[6] + 0 + 0; }
		if($upc_matches[7]==6) {
		$OddSum = (0 + $upc_matches[3] + $upc_matches[5] + 0 + 0 + $upc_matches[7]) * 3;
		$EvenSum = $upc_matches[2] + $upc_matches[4] + $upc_matches[6] + 0 + 0; }
		if($upc_matches[7]==7) {
		$OddSum = (0 + $upc_matches[3] + $upc_matches[5] + 0 + 0 + $upc_matches[7]) * 3;
		$EvenSum = $upc_matches[2] + $upc_matches[4] + $upc_matches[6] + 0 + 0; }
		if($upc_matches[7]==8) {
		$OddSum = (0 + $upc_matches[3] + $upc_matches[5] + 0 + 0 + $upc_matches[7]) * 3;
		$EvenSum = $upc_matches[2] + $upc_matches[4] + $upc_matches[6] + 0 + 0; }
		if($upc_matches[7]==9) {
		$OddSum = (0 + $upc_matches[3] + $upc_matches[5] + 0 + 0 + $upc_matches[7]) * 3;
		$EvenSum = $upc_matches[2] + $upc_matches[4] + $upc_matches[6] + 0 + 0; } }
		$AllSum = $OddSum + $EvenSum;
		$CheckSum = $AllSum % 10;
		if($CheckSum>0) {
		$CheckSum = 10 - $CheckSum; }
		if($return_check==false&&strlen($upc)==8) {
		if($CheckSum!=$CheckDigit) {  false; }
		if($CheckSum==$CheckDigit) { return true; } }
		if($return_check==true) { return $CheckSum; } 
		if(strlen($upc)==7) { return $CheckSum; } 
	}
	
	
	public function validate_upca($upc,$return_check=false) 
	{
		if(!isset($upc)||!is_numeric($upc)) { return false; }
		if(strlen($upc)>12) { preg_match("/^(\d{12})/", $upc, $fix_matches); $upc = $fix_matches[1]; }
		if(strlen($upc)>12||strlen($upc)<11) { return false; }
		if(strlen($upc)==11) {
		preg_match("/^(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})/", $upc, $upc_matches); }
		if(strlen($upc)==12) {
		preg_match("/^(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})/", $upc, $upc_matches); }
		$OddSum = ($upc_matches[1] + $upc_matches[3] + $upc_matches[5] + $upc_matches[7] + $upc_matches[9] + $upc_matches[11]) * 3;
		$EvenSum = $upc_matches[2] + $upc_matches[4] + $upc_matches[6] + $upc_matches[8] + $upc_matches[10];
		$AllSum = $OddSum + $EvenSum;
		$CheckSum = $AllSum % 10;
		if($CheckSum>0) {
		$CheckSum = 10 - $CheckSum; }
		if($return_check==false&&strlen($upc)==12) {
		if($CheckSum!=$upc_matches[12]) { return false; }
		if($CheckSum==$upc_matches[12]) { return true; } }
		if($return_check==true) { return $CheckSum; } 
		if(strlen($upc)==11) { return $CheckSum; } 
	}	

 public function Zreport(Request $request) {
     //return json_encode(Request::all());
         $input = Request::all();
        
        $db = "u".$input['sid'];
        
        $batch_id = $input['batchid'];
        
      
        $query_db = 'USE DATABASE '.$db;
        
        DB::raw($query_db);
        
        $query_select ="SELECT Case  when sum(nnettotal) is null then 0.00 ELSE sum(nnettotal) end As NNETTOAL,Case  when sum(NNONTAXABLETOTAL) 
        is null then 0.00 ELSE sum(NNONTAXABLETOTAL) end as NNONTAXABLETOTAL,Case  when sum(NTAXABLETOTAL) is null then 0.00 ELSE sum(NTAXABLETOTAL) 
        end As NTAXABLETOTAL, Case  when sum(NTAXTOTAL) is null then 0 ELSE sum(NTAXTOTAL) end As NTAXTOTAL , Case  when sum(NSUBTOTAL) is null 
        then 0.00 ELSE sum(NSUBTOTAL) end As NSUBTOTAL,case when sum(NTOTALLOTTERY) is null then 0.00 else SUM(NTOTALLOTTERY) 
        end as NTOTALLOTTERY FROM ".$db.".trn_sales WHERE iOnAccount != 1 and 
        vtrntype='Transaction' and ibatchid = $batch_id";
        
            
        $queary_tender="SELECT (case when (b.vtendername = 'ReturnItem') THEN 'Return Item' ELSE b.vtendername END) as vtendername,ifnull(sum(b.namount),0) as Amount  FROM ".$db.".trn_sales a,".$db.".trn_salestender b,
         ".$db.".mst_tentertype c WHERE a.vtrntype='Transaction' and a.isalesid = b.isalesid
         and b.itenerid != 121   and b.itenerid = c.itenderid   
         and a.ibatchid=$batch_id
        group by  b.itenerid,b.vtendername,c.vtendertag";
        //echo $queary_tender;die;
        
        
       $NoofTransaction= "SELECT case when count(isalesID) is null then 0 else  count(isalesID) end as Tot 
        FROM ".$db.".trn_sales where vtrntype='Transaction' and  ibatchid=$batch_id";
        
        
      
       $AVG_TRAN="SELECT Case  when sum(nnettotal) is null then 0 ELSE sum(nnettotal) end As NNETTOAL FROM ".$db.".trn_sales WHERE iOnAccount != 1 and 
        vtrntype='Transaction' and ibatchid =$batch_id";
        
        $openingcash="SELECT ifnull(sum(NOpeningBalance),0) as NOpeningBalance FROM ".$db.".trn_batch WHERE  ibatchid=$batch_id";
        
        $onlycashsale="SELECT ifnull(sum(b.namount),0) as Amount FROM ".$db.".trn_sales a,".$db.".trn_salestender b, ".$db.".mst_tentertype c WHERE a.vtrntype='Transaction' and a.isalesid = b.isalesid and b.itenerid != 121  and b.vtendername = 'cash'
         and b.itenerid = c.itenderid  
         and a.ibatchid=$batch_id   group by  b.itenerid,b.vtendername,c.vtendertag";
         
         
         $cash_paidout="select ifnull(sum(ifnull(b.namount,0.00)),0.00) as nAmount from ".$db.".trn_paidout a,".$db.".trn_paidoutdetail b 
         where a.ipaidouttrnid = b.ipaidouttrnid and a.ibatchid =$batch_id";
         
        $cash_pichup="SELECT ifnull(sum(NNETTOTAL) ,0) as NAMOUNT FROM ".$db.".trn_sales WHERE vtrntype='Cash pickup' and ibatchid =$batch_id ";
        $actualCash="SELECT ifnull(sum(nuserclosingbalance),0) as nuserclosingbalance FROM ".$db.".trn_batch where ibatchid =$batch_id";
         
        $addcash="SELECT case when sum(NNETTOTAL) is null then 0 else sum(NNETTOTAL) end as NAMOUNT FROM ".$db.".trn_sales 
        WHERE vtrntype='Add Cash' and ibatchid  =$batch_id";
        
        $coupon_q="select sum(Abs(ndebitamt)) as CouponAmount  from ".$db.".trn_sales a,".$db.".trn_salesdetail b 
       where a.isalesid = b.isalesid and a.ibatchid = $batch_id and b.vitemcode = '18' group by ibatchid";
        $coupon_que=DB::select($coupon_q);
        $ca=isset($coupon_que[0]->CouponAmount)?$coupon_que[0]->CouponAmount:"0.00";
        
        $queary_tender_records= DB::select($queary_tender);
        $Tran_records= DB::select($AVG_TRAN);
        $avg=DB::select($NoofTransaction);
        
        
        
        
        
        $Open_Cash=DB::select($openingcash);
        //print_r($Open_Cash);die;
        $value_op=0?0:$Open_Cash[0]->NOpeningBalance;
        
        
        
        $Open_Cash_sale=DB::select($onlycashsale);
        
       $value_csale=isset($Open_Cash_sale[0]->Amount)?$Open_Cash_sale[0]->Amount:0.00;
        
        $addcashvalue=DB::select($addcash);
        $value_add_cash=$addcashvalue[0]->NAMOUNT;
        
         
        $Open_Cash_paidout=DB::select($cash_paidout);
        $value_paidout=$Open_Cash_paidout[0]->nAmount;
       
        $Open_Cash_pickup=DB::select($cash_pichup);
        $value_cash_picup=$Open_Cash_pickup[0]->NAMOUNT;
        
        $Open_Cash_actual=DB::select($actualCash);
        //print_r($Open_Cash_actual);die;
        $actual_value=$Open_Cash_actual[0]->nuserclosingbalance;
        
        
        $total =  $avg[0]->Tot == 0?0:$Tran_records[0]->NNETTOAL/$avg[0]->Tot;
        
        
        
        $matching_records = DB::select($query_select);
        //print_r($matching_records); die;
        $expected_cash_value=($value_op+$value_csale+$value_add_cash-($value_paidout+$value_cash_picup));
        $cashover=$expected_cash_value-$actual_value;
         If($expected_cash_value>$actual_value)
         {
             $cashover1="Cash Short";
         }
         else{
             $cashover1="Cash Over";
         }
          if(count($matching_records) > 0){
            
            $data = [];
            
            $data_array1=$queary_tender_records ;
            // print_r($data_array1);exit;
            $data_array = $matching_records;
           // $data ['title']="Total Sales";
            $data['SalesTotal'] = $data_array;
            $data['TenderTotal']=$data_array1;
            $data['Coupon']=$ca;
            $data['OfTransaction']=$avg;
            $data['AvgTranscation']=number_format($total, 2, '.', '');
           $data['OpeningCash']= $Open_Cash;
           $data['CashSale']=$value_csale;
           
            $data['addcash']=$value_add_cash;   
           
           
           
           $data['Cashpaidout']=$Open_Cash_paidout;
           $data['Cashpickup']=$Open_Cash_pickup;
           $data['Cashactual']=$actual_value;
           $data['ExpectedCash']=number_format($expected_cash_value, 2, '.', '');
           
           $data['CashDetail']=$cashover1;
           if($cashover<0){
           $data['CashDetailValue']=number_format(abs($cashover), 2, '.', '');
           }
          else{
              $value=number_format(abs($cashover), 2, '.', '');
              $data['CashDetailValue']='('.$value.')';
          }
        //   $data[$cashover1]=number_format($cashover, 2, '.', '');
            $data['status'] = "success";
            return response()->json($data, 200);
            //return response()->json($data1 200);
        } else {
            return response()->json(['error'=>'No BatchID Found'],401);
            
        }
}
// public function checkPriceBySKU(Request $request) {
//         $sku = Request::get('sku');
//         if($sku) { 
//             $obj = Item::where('vbarcode',$sku);
//             if(Request::get('sid')) {
//                 $obj->where('SID',Request::get('sid'));
//             }

//             /*'subcat_id', 'int(11)', 'YES', '', NULL, ''
//             'manufacturer_id', 'int(11)', 'YES', '', NULL, ''*/
//             $data = $obj->get(array('vbarcode','vitemname','vitemtype','npack','dunitprice','dcostprice','iqtyonhand','nsaleprice','vunitcode','vcategorycode','vdepcode','vsuppliercode','vtax1','vtax2','vfooditem','vdescription','vageverify','vsize','nsellunit','wicitem','visinventory','SID'));
//             $data_array = $data->toArray();
            
            
//             if(count($data_array) == 0){
//                 return response()->json(['error'=>'No barcode found'],401);
//             }
            
//             $data_array[0]['iqtyonhand'] = (string)$data_array[0]['iqtyonhand'];
            
            
//             $data = [];
//             $data['data'] = $data_array;
//             $data['status'] = "success";
//             return response()->json($data, 200);
//             // return $data_array;
//         }
//         else
//         {
//             return response()->json(['error'=>'SKU is  missing '],401);
//         }
       
//     }

public function end_of_report(Request $request) {
     //return json_encode(Request::all());
    
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
            join trn_batch b on d.batchid=b.ibatchid and ibatchid in (SELECT ed.batchid FROM ".$db.".trn_endofday e join ".$db.".trn_endofdaydetail 
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
             from ".$db.".trn_sales ts join trn_batch tb on ts.ibatchid=tb.ibatchid where ts.ibatchid in (SELECT ed.batchid FROM ".$db.".trn_endofday e join ".$db.".trn_endofdaydetail ed 
             on e.id=ed.eodid where date_format(e.dstartdatetime,'%m-%d-%Y' ) = '". $date ."')) GROUP BY trn_mps.vcardtype";
             
             $ebt="SELECT count(trn_mps.nauthamount) as transaction_number, ifnull(SUM(trn_mps.nauthamount),0) 
             as nauthamount, trn_mps.vcardtype as vcardtype FROM ".$db.".trn_mpstender trn_mps WHERE 
             trn_mps.vcardtype ='EBT' AND trn_mps.nauthamount !=0 AND trn_mps.itranid in (select vuniquetranid 
             from ".$db.".trn_sales ts join trn_batch tb on ts.ibatchid=tb.ibatchid where ts.ibatchid in (SELECT ed.batchid FROM ".$db.".trn_endofday e join ".$db.".trn_endofdaydetail ed 
             on e.id=ed.eodid where date_format(e.dstartdatetime,'%m-%d-%Y' ) = '". $date ."')) GROUP BY trn_mps.vcardtype";
             
              $visa="SELECT count(trn_mps.nauthamount) as transaction_number, ifnull(SUM(trn_mps.nauthamount),0) 
             as nauthamount, trn_mps.vcardtype as vcardtype FROM ".$db.".trn_mpstender trn_mps WHERE 
             trn_mps.vcardtype ='visa' AND trn_mps.nauthamount !=0 AND trn_mps.itranid in (select vuniquetranid 
             from ".$db.".trn_sales ts join trn_batch tb on ts.ibatchid=tb.ibatchid where ts.ibatchid in (SELECT ed.batchid FROM ".$db.".trn_endofday e join ".$db.".trn_endofdaydetail ed 
             on e.id=ed.eodid where date_format(e.dstartdatetime,'%m-%d-%Y' ) = '". $date ."')) GROUP BY trn_mps.vcardtype";
                         
            $disc="SELECT count(trn_mps.nauthamount) as transaction_number, ifnull(SUM(trn_mps.nauthamount),0) 
             as nauthamount, trn_mps.vcardtype as vcardtype FROM ".$db.".trn_mpstender trn_mps WHERE 
             trn_mps.vcardtype ='discover' AND trn_mps.nauthamount !=0 AND trn_mps.itranid in (select vuniquetranid 
             from ".$db.".trn_sales ts join trn_batch tb on ts.ibatchid=tb.ibatchid where ts.ibatchid in (SELECT ed.batchid FROM ".$db.".trn_endofday e join ".$db.".trn_endofdaydetail ed 
             on e.id=ed.eodid where date_format(e.dstartdatetime,'%m-%d-%Y' ) = '". $date ."')) GROUP BY trn_mps.vcardtype";
             
            $vendor="SELECT ifnull(vpaidoutname,' ') Vendor_Name, sum(namount) Amount FROM 
            ".$db.".trn_paidoutdetail tpd join ".$db.".trn_paidout tp on tpd.ipaidouttrnid=tp.ipaidouttrnid 
            where date_format(ddate,'%m-%d-%Y') = '". $date ."' 
            GROUP BY vpaidoutname WITH ROLLUP";
            
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
          $queary_mastercard= DB::select($mastercard);
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
          if(count($queary_tax) > 0){
            
            $data = [];
            //$data['Store_Sales_with_Tax']=number_format($queary_tax[0]->Sales_With_Tax-$queary_liabilitySales[0]->Liability_Amount, 2, '.', '');
            //return $queary_tax;
            //return $queary_liabilitySales;
           // return $queary_deleteitem;
           //return $queary_voidamount;
           //return $queary_housecharge;
           //return $queary_saletotal;
           //return $queary_startcash;
           //return $queary_Hours;
            $data0=$queary_tax[0];
            $data1=$queary_liabilitySales[0];
            $data2=$queary_deleteitem[0];
            $data3=$queary_voidamount[0];
            $data4=$queary_housecharge[0];
            $data5=$queary_saletotal[0];
            $data6=$queary_startcash[0];
            
            $eos_report_data = [
                                ['Store_Sales_with_Tax',number_format($queary_tax[0]->Sales_With_Tax-$queary_liabilitySales[0]->Liability_Amount, 2, '.', '')],
                                ['Sales_With_Tax',$data0->Sales_With_Tax],
                                ['Non_Taxable_Sales',$data0->Non_Taxable_Sales],
                                ['Taxable_Total',$data0->Taxable_Total],
                                ['House_Charged',$data0->House_Charged],
                                ['Total_Tax',$data0->Total_Tax],
                                ['EBT_Cash_Payments',$data0->EBT_Cash_Payments],
                                ['Check_Payments',$data0->Check_Payments],
                                ['Credit_Card_Payments',$data0->Credit_Card_Payments],
                                ['Debit_Card_Payments',$data0->Debit_Card_Payments],
                                ['Discount_Amount',$data0->Discount_Amount],
                                
                                ['Liability_Amount',$data1->Liability_Amount],
                                ['Tax1_Total',$data1->Tax1_Total],
                                ['Tax2_Total',$data1->Tax2_Total],
                                ['Lot_Sales',$data1->Lot_Sales],
                                ['Lot_Redeem',$data1->Lot_Redeem],
                                ['Inst_Sales',$data1->Inst_Sales],
                                ['Inst_Redeem',$data1->Inst_Redeem],
                                ['Bottle_Deposit',$data1->Bottle_Deposit],
                                ['Bottle_Deposit_Redeem',$data1->Bottle_Deposit_Redeem],
                                ['Coupon_Redeem',$data1->Coupon_Redeem],
                                ['Gross_Sales',$data1->Gross_Sales],
                                ['Gross_Cost',$data1->Gross_Cost],
                                ['Return_Amount',$data1->Return_Amount],
                                
                                ['Deleted_Items_Amount',$data2->Deleted_Items_Amount],
                                ['No_of_Trn_Items_Deleted',$data2->No_of_Trn_Items_Deleted],
                                
                                ['Void_Amount',$data3->Void_Amount],
                                
                                ['housecharge_payments',$data4->housecharge_payments],
                                
                                ['No_of_Sales',$data5->No_of_Sales],
                                ['Sales_amount',$data5->Sales_amount],
                                ['No_of_Void',$data5->No_of_Void],
                                ['Void_Amoun',$data5->Void_Amount],
                                ['No_Sales',$data5->No_Sales],
                                
                                ['start_cash',$data6->start_cash],
                                ['cash_pickup',$data6->cash_pickup],
                                ['add_cash',$data6->add_cash],
                                ['Lotto_sales',number_format($Lotto_Sales, 2, '.', '')],
                                ['Total_sales_tax',number_format($Total_Sales_Tax, 2, '.', '')],
                                ['Fuel_Sales',number_format(0.00, 2, '.', '')],
                                ['No_of_sale',number_format($Number_of_Sales, 2, '.', '')],
                                ['GrossProfit',number_format($Grossprofit, 2, '.', '')],
                                ['Average_Sales',number_format($avgsale, 2, '.', '')],
                                ['Gross_Profit_(%)',number_format($grosprofitpercentage, 2, '.', '')],
                                ['Amex',isset($queary_amex[0]->nauthamount) ? $queary_amex[0]->nauthamount:"0.00"],
                                ['MasterCard',isset($queary_mastercard[0]->nauthamount) ? $queary_mastercard[0]->nauthamount:"0.00"],
                                ['EBT',isset($queary_ebt[0]->nauthamount) ? $queary_ebt[0]->nauthamount:"0.00"],
                                ['Visa', isset($queary_visa[0]->nauthamount) ? $queary_visa[0]->nauthamount:"0.00"],
                               ['Discover',isset($queary_disc[0]->nauthamount) ? $queary_disc[0]->nauthamount:"0.00"]
                                
                            ];
            $eos_report_title = ['Title','Value'];    
             
            $data[]=$eos_report_data; 
            
            $hours_data = [];
            // print_r($queary_Hours);exit;
            foreach($queary_Hours as $value)
            {
                $hours_data[] = [$value->Hours,$value->Amount];
            }
            
            $eos_report_hours_title = ['Hourly Sales','Amount'];
            
            $hourly_sales_data = $hours_data;
            $vendor_data = [];
            // print_r($queary_Hours);exit;
            $count=1;
            foreach($queary_vendor as $value)
            {
                $vendor_data[] = [$count++,$value->Vendor_Name,$value->Amount];
            }
            
            $eos_report_vendor_title = ['No.','Vendor Name','Amount'];
            $vendor_data = $vendor_data;
            $department_data = [];
            foreach($queary_department as $value)
            {
                $department_data[] = [$value->Dept,$value->Qty,$value->Amount];
            }
            
            $eos_report_department_title = ['Department','Quantity','Price'];
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
            return response()->json(['error'=>'No BatchID Found'],401);
            
           }
      
     }
     
     
     public function get_subcategory_sid(Request $request) {
        
         $input = Request::all();
         $db = "u".$input['sid'];
         $category_id= $input['category_id'];
        
         $data = [];
        
        
      
        $query_db = 'USE DATABASE '.$db;
        
        DB::raw($query_db);
        $exist="SELECT * FROM information_schema.tables WHERE table_schema = '".$db."' AND table_name = 'mst_version' LIMIT 1";
        
        $exist_records = DB::select($exist);
        
        if(count($exist_records) > 0)
        {
        // SELECT subcat_id, subcat_name FROM u1097.mst_subcategory;
        $query_select = "SELECT subcat_id, subcat_name FROM ".$db.".mst_subcategory WHERE cat_id =".$category_id;
        
        $matching_records = DB::select($query_select);
        
        foreach($matching_records as $v){
            
            $temp = [];
            $temp['key'] = $v->subcat_id;
            $temp['value'] = $v->subcat_name;
            
            $data[] = $temp;
            
            
        }
        
        return response()->json(['data'=>$data],200);
        }
        else{
            return response()->json(['error'=>'No Subcategories Found'],401);
        }
    }
    
    public function get_item_by_sku_new(Request $request) {
        $sku = Request::get('sku');
        if(isset($sku)) {
            
            // 'barcode','item_name','cost','selling_price','qty_on_hand','tax1','tax2','item_type','description','unit','department','category','supplier','group','size','selling_unit','food_stamp','WIC_item','age_verification'
            $nplitem_array = Nplitem::find($sku, ['barcode','item_name','cost','selling_price','qty_on_hand','tax1','tax2','item_type','description','unit','department','category','supplier','group','size','selling_unit','food_stamp','WIC_item','age_verification']);
            
            if($nplitem_array == null){
                //Changed the request code from 401 to 405 on Manish's request: Because 401 was not allowing the session to sustain
                return response()->json(['message'=>'Item not found in NPL'],405);
            }
            
            $data = [];

            $nplitem_array = $nplitem_array->toArray();
            
            $response_data = [];
            
            array_walk($nplitem_array, function($v, $k) use (&$response_data) {
                if($k === 'selling_price'){
                    $response_data['dunitprice'] = (isset($v) && $v !== null)?trim($v):'';
                } else {
                    $response_data[$k] = (isset($v) && $v !== null)?trim($v):'';
                }
            });
            
            $data['data'] = $response_data;
            $data['status'] = "success";
            
            return response()->json($data, 200);
        } else {
            return response()->json(['message'=>'SKU is  missing '],405);
        }
       
    }
    
    
    //for tax 3 Modified API
    //for tax 3 Modified API
    public function check_price_by_sku_new(Request $request) {
        $sku = Request::get('sku');
        $sid=Request::get('sid');
        $db = "u".$sid;
        $query_db = 'USE DATABASE '.$db;
        
        DB::raw($query_db);
        
        
        $query_delete_id =  "select * FROM  ".$db.".mst_item mi LEFT JOIN ".$db.".mst_itemalias mia on mi.vitemcode = mia.vitemcode
                             WHERE mia.valiassku = '".$sku."' OR mi.vbarcode='".$sku."'";
        
        $item = DB::select($query_delete_id);

        if(!$item){
            return response()->json(['error' => 'That Barcode / Alias Code Does not exist in the store database ('.$db.')'],200);
        }
        
        $exist="SELECT * FROM information_schema.tables WHERE table_schema = '".$db."' AND table_name = 'mst_version' LIMIT 1";
        
        $exist_records = DB::select($exist);
        
        if(count($exist_records) > 0)
        {
            
             $sql="SHOW COLUMNS FROM ".$db.".mst_item LIKE 'vtax3'";
             $tax3_exist=DB::select($sql);
            
             if(count($tax3_exist)==1){
                 $query_select = "SELECT mi.vbarcode vbarcode, mi.manufacturer_id, mi.nbottledepositamt, mi.vitemname vitemname,mi.vitemtype vitemtype ,mi.npack npack,mi.dunitprice dunitprice,
                CAST((mi.new_costprice) as decimal(10,2)) dcostprice,
                mi.iqtyonhand iqtyonhand,CAST((mi.nsaleprice) as decimal(10,2))nsaleprice,mi.vunitcode vunitcode,mi.vcategorycode vcategorycode,mi.vdepcode vdepcode,
                mi.vsuppliercode vsuppliercode,mi.vtax1 vtax1,mi.vtax2 vtax2,
                ifnull((mi.vtax3),'') vtax3,
                mi.vfooditem vfooditem,mi.vdescription vdescription,mi.vageverify vageverify,
                mi.vsize vsize,mi.nsellunit nsellunit,mi.wicitem wicitem,mi.visinventory visinventory,mi.SID SID,ms.vcompanyname vcompanyname,mc.vcategoryname vcategoryname,ifnull((md.vdepartmentname),'') vdepartmentname,
                ifnull(concat('',sc.subcat_id),'') as subcat_id,ifnull((sc.subcat_name),'') subcat_name
                
                FROM ".$db.".mst_item mi LEFT JOIN ".$db.".mst_itemalias mia on mi.vitemcode = mia.vitemcode 
                LEFT JOIN  ".$db.".mst_supplier ms on mi.vsuppliercode = ms.vsuppliercode
                 LEFT JOIN  ".$db.".mst_department md on mi.vdepcode  =md.vdepcode
                 LEFT JOIN  ".$db.".mst_category mc on mi.vcategorycode=mc.vcategorycode
                 LEFT JOIN ".$db.".mst_subcategory sc on mi.subcat_id = sc.subcat_id
                WHERE mia.valiassku = '".$sku."' OR mi.vbarcode='".$sku."'";
                
             }
             else{
                $query_select = "SELECT mi.vbarcode vbarcode,mi.manufacturer_id, mi.vitemname vitemname,mi.vitemtype vitemtype ,mi.npack npack,mi.dunitprice dunitprice,
                CAST((mi.new_costprice) as decimal(10,2)) dcostprice,
                mi.iqtyonhand iqtyonhand,CAST((mi.nsaleprice) as decimal(10,2))nsaleprice,mi.vunitcode vunitcode,mi.vcategorycode vcategorycode,mi.vdepcode vdepcode,
                mi.vsuppliercode vsuppliercode,mi.vtax1 vtax1,mi.vtax2 vtax2,mi.vfooditem vfooditem,mi.vdescription vdescription,mi.vageverify vageverify,
                mi.vsize vsize,mi.nsellunit nsellunit,mi.wicitem wicitem,mi.visinventory visinventory,mi.SID SID,ms.vcompanyname vcompanyname,mc.vcategoryname vcategoryname,ifnull((md.vdepartmentname),'') vdepartmentname,
                ifnull(concat('',sc.subcat_id),'') as subcat_id,ifnull((sc.subcat_name),'') subcat_name
                
                FROM ".$db.".mst_item mi LEFT JOIN ".$db.".mst_itemalias mia on mi.vitemcode = mia.vitemcode 
                LEFT JOIN  ".$db.".mst_supplier ms on mi.vsuppliercode = ms.vsuppliercode
                 LEFT JOIN  ".$db.".mst_department md on mi.vdepcode  =md.vdepcode
                 LEFT JOIN  ".$db.".mst_category mc on mi.vcategorycode=mc.vcategorycode
                
                 LEFT JOIN ".$db.".mst_subcategory sc on mi.subcat_id = sc.subcat_id
                WHERE mia.valiassku = '".$sku."' OR mi.vbarcode='".$sku."'";
             }
        //echo   $query_select;die;     
        $matching_records = DB::select($query_select);
        
        if($matching_records[0]->manufacturer_id == 0){
            // echo "came here";die;
            $manufacturer_id = "";
            $matching_records[0]->manufacturer_id = $manufacturer_id;
            // echo $sku;
            // echo "UPDATE ".$db.".mst_item SET manufacturer_id = '" . $manufacturer_id . "' WHERE vbarcode = '" . $sku . "'";die;
        }
        
        

        if(count($matching_records) > 0){
            $matching_records[0]->iqtyonhand = (string)$matching_records[0]->iqtyonhand;
            $matching_records[0]->manufacturer_id = (string)$matching_records[0]->manufacturer_id;
            $matching_records[0]->vsize = $size = (isset($matching_records[0]->vsize) && $matching_records[0]->vsize !== NULL && $matching_records[0]->vsize !== 'NULL' && !empty(trim($matching_records[0]->vsize)))?$matching_records[0]->vsize:"";

            
            if(!isset($matching_records[0]->vcompanyname) || $matching_records[0]->vcompanyname === null){
                $matching_records[0]->vcompanyname = '';
            }
            $data = [];
            
            
            // var_dump($size);die;
            
            $data_array = $matching_records;
            $data['data'] = $data_array;
            $data['status'] = "success";
            return response()->json($data, 200);
            
        } else {
            return response()->json(['error'=>'No Barcode Found'],401);
            
        }
        }
        else{
            $sql="SHOW COLUMNS FROM ".$db.".mst_item LIKE 'vtax3'";
             $tax3_exist=DB::select($sql);
            
             if(count($tax3_exist)==1){
                    $query_select = "SELECT mi.vbarcode vbarcode, mi.manufacturer_id, mi.vitemname vitemname,mi.vitemtype vitemtype ,mi.npack npack,mi.dunitprice dunitprice,CAST((mi.new_costprice) as decimal(10,2)) dcostprice,
                mi.iqtyonhand iqtyonhand,CAST((mi.nsaleprice) as decimal(10,2))  nsaleprice,mi.vunitcode vunitcode,mi.vcategorycode vcategorycode,mi.vdepcode vdepcode,
                mi.vsuppliercode vsuppliercode,mi.vtax1 vtax1,mi.vtax2 vtax2,mi.vtax3 vtax3,mi.vfooditem vfooditem,mi.vdescription vdescription,mi.vageverify vageverify,
                mi.vsize vsize,mi.nsellunit nsellunit,mi.wicitem wicitem,mi.visinventory visinventory,mi.SID SID,ms.vcompanyname vcompanyname,mc.vcategoryname vcategoryname,ifnull((md.vdepartmentname),'') vdepartmentname
               
                
                FROM ".$db.".mst_item mi LEFT JOIN ".$db.".mst_itemalias mia on mi.vitemcode = mia.vitemcode 
                LEFT JOIN  ".$db.".mst_supplier ms on mi.vsuppliercode = ms.vsuppliercode
                 LEFT JOIN  ".$db.".mst_department md on mi.vdepcode  =md.vdepcode
                 LEFT JOIN  ".$db.".mst_category mc on mi.vcategorycode=mc.vcategorycode
                 
                WHERE mia.valiassku = '".$sku."' OR mi.vbarcode='".$sku."'";
             }
             else{
                   $query_select = "SELECT mi.vbarcode vbarcode, mi.manufacturer_id, mi.vitemname vitemname,mi.vitemtype vitemtype ,mi.npack npack,mi.dunitprice dunitprice,CAST((mi.new_costprice) as decimal(10,2)) dcostprice,
                mi.iqtyonhand iqtyonhand,CAST((mi.nsaleprice) as decimal(10,2))  nsaleprice,mi.vunitcode vunitcode,mi.vcategorycode vcategorycode,mi.vdepcode vdepcode,
                mi.vsuppliercode vsuppliercode,mi.vtax1 vtax1,mi.vtax2 vtax2,mi.vfooditem vfooditem,mi.vdescription vdescription,mi.vageverify vageverify,
                mi.vsize vsize,mi.nsellunit nsellunit,mi.wicitem wicitem,mi.visinventory visinventory,mi.SID SID,ms.vcompanyname vcompanyname,mc.vcategoryname vcategoryname,ifnull((md.vdepartmentname),'') vdepartmentname
               
                
                FROM ".$db.".mst_item mi LEFT JOIN ".$db.".mst_itemalias mia on mi.vitemcode = mia.vitemcode 
                LEFT JOIN  ".$db.".mst_supplier ms on mi.vsuppliercode = ms.vsuppliercode
                 LEFT JOIN  ".$db.".mst_department md on mi.vdepcode  =md.vdepcode
                 LEFT JOIN  ".$db.".mst_category mc on mi.vcategorycode=mc.vcategorycode
                 
                WHERE mia.valiassku = '".$sku."' OR mi.vbarcode='".$sku."'";
             }
    //   echo $query_select; die;
                
        $matching_records = DB::select($query_select);
        
        
                if(count($matching_records) > 0){
                    $matching_records[0]->iqtyonhand = (string)$matching_records[0]->iqtyonhand;
                    $data = [];
                    
                    $data_array = $matching_records;
                    $data['data'] = $data_array;
                    $data['status'] = "success";
                    return response()->json($data, 200);
                    
                } else {
                    return response()->json(['error'=>'No Barcode Found'],401);
                    
                }
        }
    }
    
    public function insert_item_customer(Request $request){
        
        $input = Request::all();
        
         
        $validator = Validator::make($input, [
           'sid' => 'required',
           'barcode' => 'required',
           'item_name' => 'required',
           'cost' => 'required',
           'selling_price' => 'required',
           'qty_on_hand' => 'integer',
           'category_code' => 'required',
           'department_code' => 'required',
           'supplier_code' => 'required',
         
           
       ]);
        
        if ($validator->fails()) {
            return response()->json(['message' => $validator->messages()->first()],200);
        }
        
        $input['qty_on_hand'] = (isset($input['qty_on_hand']) && !empty(trim($input['qty_on_hand'])))?$input['qty_on_hand']:0;

        // $npl = NPLItem::where('barcode', '=', $input['barcode'])->first();
       
        // return Request::get('sid');
        $store = Store::where('id','=',Request::get('sid'))->first();
        
        if($store === null){
            return response()->json(['message' => 'That store does not exist'],200);
        }
        
        // dd($store);
        
        $db = "u".$store->id;
        
        $query_db = 'USE DATABASE '.$db;
        
        DB::raw($query_db);
        

        $barcode = (string)$input['barcode'];
        
        $query_select = "SELECT vbarcode, iitemid, nbottledepositamt FROM ".$db.".mst_item WHERE vbarcode=?";
        //echo $query_select;die;
        $matching_records = DB::select($query_select, array($barcode));
        
        
        
        $itemname = addslashes($input['item_name']);
        
        $itemtype = array_key_exists('itemtype', $input)?$input['itemtype']:'Standard';
        
        // $dept_code = array_key_exists('department_code', $input)?$input['department_code']:1;
        
        //======================================================== Department ==================================================================================
        if(array_key_exists('department_code', $input)){
            
            // check if the department exists with the entered department id
            $dept_code_query_run = DB::connection('mysql')->select("SELECT * FROM ".$db.".mst_department WHERE idepartmentid='" .(int)$input['department_code']. "'");

            if(count($dept_code_query_run) > 0) {
                //return the vdepcode
                $dept_code = $dept_code_query_run[0]->vdepcode;
            } else {
                
               // check if the department exists with the name
                $department_query_run = DB::connection('mysql')->select("SELECT * FROM ".$db.".mst_department WHERE vdepartmentname='" .$input['department_code']. "'");
    
                if(count($department_query_run) > 0){
                    
                    $dept_code = $department_query_run[0]->vdepcode;
                    
                } else {
                    
                    //create a record;
                    try {
                        $sql = "INSERT INTO ".$db.".mst_department SET vdepartmentname = '" . html_entity_decode($input['department_code']) . "',isequence =0 ,estatus = 'Active',SID = '" . (int)$input['sid']."'";
            
                        DB::connection('mysql')->statement($sql);
                        
                        $last_id_query = DB::connection('mysql')->select("SELECT max(idepartmentid) last_id from ".$db.".mst_department");
                        
                        $last_id = $last_id_query[0]->last_id;
                        DB::connection('mysql')->statement("UPDATE ".$db.".mst_department SET vdepcode = '" . (int)$last_id . "' WHERE idepartmentid = '" . (int)$last_id . "'");
                    }
                    catch (MySQLDuplicateKeyException $e) {
                        // duplicate entry exception
                       $error['error'] = $e->getMessage(); 
                        return $error; 
                    }
                    catch (MySQLException $e) {
                        // other mysql exception (not duplicate key entry)
                        
                        $error['error'] = $e->getMessage(); 
                        return $error; 
                    }
                    catch (Exception $e) {
                        // not a MySQL exception
                       
                        $error['error'] = $e->getMessage(); 
                        return $error; 
                    }
            
                    $dept_code = $last_id;
                } 
            }
            
        } else {
            $dept_code=1;
        }
        

        // $category_code = array_key_exists('category_code', $input)?$input['category_code']:1;

        //======================================================== Category ==================================================================================
        if(array_key_exists('category_code', $input)){

            // check if the category exists with the entered cateogry id
            $cat_code_query_run = DB::connection('mysql')->select("SELECT * FROM ".$db.".mst_category WHERE icategoryid='" .(int)$input['category_code']. "'");

            if(count($cat_code_query_run) > 0) {
                
                //return the vdepcode
                $category_code = $cat_code_query_run[0]->vcategorycode;
                
            } else {
                
               // check if the category exists with the name
                $category_query_run = DB::connection('mysql')->select("SELECT * FROM ".$db.".mst_category WHERE vcategoryname='" .$input['category_code']. "'");
    
                if(count($category_query_run) > 0){
                    
                    $category_code = $category_query_run[0]->vcategorycode;
                    
                } else {
                    
                    //create a record;
                    try {
                        $sql = "INSERT INTO ".$db.".mst_category SET `vcategoryname` = '" . html_entity_decode($input['category_code']) . "',`vdescription` = '" . html_entity_decode($input['category_code']) . "', vcategorttype = '',`isequence` = '0',`dept_code` ='". (int)$dept_code ."',`estatus` = 'Active',SID = '" . (int)$input['sid']."'";
            
                        DB::connection('mysql')->statement($sql);
            
                        $last_id_query = DB::connection('mysql')->select("SELECT max(icategoryid) last_id from ".$db.".mst_category");
                        
                        $last_id = $last_id_query[0]->last_id;
                        
                        
                        DB::connection('mysql')->statement("UPDATE ".$db.".mst_category SET vcategorycode = '" . (int)$last_id . "' WHERE icategoryid = '" . (int)$last_id . "'");
                    }
                    catch (MySQLDuplicateKeyException $e) {
                        // duplicate entry exception
                       $error['error'] = $e->getMessage(); 
                        return $error; 
                    }
                    catch (MySQLException $e) {
                        // other mysql exception (not duplicate key entry)
                        
                        $error['error'] = $e->getMessage(); 
                        return $error; 
                    }
                    catch (Exception $e) {
                        // not a MySQL exception
                       
                        $error['error'] = $e->getMessage(); 
                        return $error; 
                    }
            
                    $category_code = $last_id;
                } 
            }

        } else {
            $category_code=1;
        }
        
        //======================================================= Sub Category Code =======================
        if((isset($input['subcat_id'])) && !empty(trim($input['subcat_id']))){
                if(array_key_exists('subcat_id', $input)){
        
                    // check if the sub category exists with the entered subcat_id
                    $subcat_code_query_run = DB::connection('mysql')->select("SELECT * FROM ".$db.".mst_subcategory WHERE subcat_id='" .(int)$input['subcat_id']. "'");
        
                    if(count($subcat_code_query_run) > 0) {
                        //return the subcat_id
                        $subcat_id = $subcat_code_query_run[0]->subcat_id;
                    } else {
                        
                      // check if the category exists with the name
                        $subcategory_query_run = DB::connection('mysql')->select("SELECT * FROM ".$db.".mst_subcategory WHERE subcat_name='" .$input['subcat_id']. "'");
            
                        if(count($subcategory_query_run) > 0){
                            
                            $subcat_id = $subcategory_query_run[0]->subcat_id;
                            
                        } else {
                            
                            //create a record;
                            try {
                                $sql = "INSERT INTO ".$db.".mst_subcategory SET `subcat_name` = '" . html_entity_decode($input['subcat_id']) . "',cat_id = '" . (int)$input['category_code']."', status= 'YES' ,SID = '" . (int)$input['sid']."' ";
                    
                                DB::connection('mysql')->select($sql);
                    
                                $last_id_query = DB::connection('mysql')->select("SELECT max(subcat_id) last_id from ".$db.".mst_subcategory");
                                
                                $last_id = $last_id_query[0]->last_id;
                                
                                
                            }
                            catch (MySQLDuplicateKeyException $e) {
                                // duplicate entry exception
                              $error['error'] = $e->getMessage(); 
                                return $error; 
                            }
                            catch (MySQLException $e) {
                                // other mysql exception (not duplicate key entry)
                                
                                $error['error'] = $e->getMessage(); 
                                return $error; 
                            }
                            catch (Exception $e) {
                                // not a MySQL exception
                               
                                $error['error'] = $e->getMessage(); 
                                return $error; 
                            }
                    
                            $subcat_id = $last_id;
                        } 
                    }
        
                } else {
                    $subcat_id =1;
                }
        }else {
            $subcat_id = null;
        }

        // $supplier_code = array_key_exists('supplier_code', $input)?$input['supplier_code']:1;
        //======================================================== Supplier ==================================================================================
        if(array_key_exists('supplier_code', $input)){

            // check if the supplier exists with the entered supplier id
            $sup_code_query_run = DB::connection('mysql')->select("SELECT * FROM ".$db.".mst_supplier WHERE isupplierid='" .(int)$input['supplier_code']. "'");

            if(count($sup_code_query_run) > 0) {
                
                //return the vsuppliercode
                $supplier_code = $sup_code_query_run[0]->vsuppliercode;
                
            } else {
                
               // check if the supplier exists with the name
                $supplier_query_run = DB::connection('mysql')->select("SELECT * FROM ".$db.".mst_supplier WHERE vcompanyname =  '" .$input['supplier_code']. "'");
    
                if(count($supplier_query_run) > 0){
                    
                    $supplier_code = $supplier_query_run[0]->vsuppliercode;
                    
                } else {
                    
                    //create a record;
                    try {
                        $sql = "INSERT INTO ".$db.".mst_supplier SET  vcompanyname = '" . $input['supplier_code'] . "',`vvendortype` = 'Vendor', vfnmae = '',`vlname` = '',`vcode` = '', vaddress1 = '', vcity = '', vstate = '', vphone = '', vzip = '', vcountry = '', vemail = '', plcbtype = '', estatus = 'Active',SID = '" . (int)$input['sid']."'";
            
                        DB::connection('mysql')->select($sql);
            
                        $last_id_query = DB::connection('mysql')->select("SELECT max(isupplierid) last_id from ".$db.".mst_supplier");
                        
                        $last_id = $last_id_query[0]->last_id;
                        
                        DB::connection('mysql')->select("UPDATE ".$db.".mst_supplier SET vsuppliercode = '" . (int)$last_id . "' WHERE isupplierid = '" . (int)$isupplierid . "'");
                    }
                    catch (MySQLDuplicateKeyException $e) {
                        // duplicate entry exception
                       $error['error'] = $e->getMessage(); 
                        return $error; 
                    }
                    catch (MySQLException $e) {
                        // other mysql exception (not duplicate key entry)
                        
                        $error['error'] = $e->getMessage(); 
                        return $error; 
                    }
                    catch (Exception $e) {
                        // not a MySQL exception
                       
                        $error['error'] = $e->getMessage(); 
                        return $error; 
                    }
            
                    $supplier_code = $last_id;
                } 
            }

        } else {
            $supplier_code=101;
        }        
        
        $age_verification = isset($input['age_verification'])?$input['age_verification']:0;
        
        
        $cost = $input['cost'];
        
        $selling_price = $input['selling_price'];
        
        $qty_on_hand = $input['qty_on_hand'];
        
        $tax1 = array_key_exists('tax1', $input)?$input['tax1']:"N";
        
        $tax2 = array_key_exists('tax2', $input)?$input['tax2']:"N";
        
        //$tax3 = array_key_exists('tax2', $input)?$input['tax3']:"N";
        
        //Set Status to Active and inventory to Yes (if not entered), default
        
        $estatus = "Active";
        
        $is_inventory = isset($input['is_inventory'])?$input['is_inventory']:"Yes";
        
        $description = isset($input['description'])?$input['description']:"";
        $unitcode = isset($input['vunitcode'])?$input['vunitcode']:"UNT001";
        $size = isset($input['size'])?$input['size']:"";
        $manufacturer_id = isset($input['manufacturer_id'])?$input['manufacturer_id']:"";
        $sellingunit = isset($input['sellingunit'])?$input['sellingunit']:1;
        $food_stamp = isset($input['food_stamp'])?$input['food_stamp']:"N";
        $wic_item = isset($input['WIC_item'])?$input['WIC_item']:0;
        
        if($manufacturer_id == ""){
            $manufacturer_id = 0;
        }
        
        
        // echo $manufacturer_id;die;
        $liability = "N";
        
        /*'barcode', 'item_type', 'item_name', 'description', 'unit', 'department', 'category', 'supplier', 'group', 'size', 'cost', 'selling_price', 'qty_on_hand', 'tax1', 'tax2', 'selling_unit', 'food_stamp', 'WIC_item', 'age_verification'

        
        $query_insert = "INSERT INTO ".$db.".mst_item (vbarcode,vitemcode,vitemname,vitemtype,vcategorycode,SID,estatus,dcostprice,dunitprice,iqtyonhand,vtax1,vtax2,visinventory) VALUES('".$barcode."','".$barcode."','".$itemname."','".$itemtype."',".$category_code.",".$store->id.",'".$estatus."',".$cost.",".$selling_price.",".$qty_on_hand.",'".$tax1."','".$tax2."','".$is_inventory."')";*/

        // echo count($matching_records);die;
    if(count($matching_records) > 0){
            
            
            // ('".$itemname."','".$itemtype."','".$dept_code."','".$category_code."','".$supplier_code."','".$store->id."','".$estatus."','".$cost."','".$selling_price."','".$qty_on_hand."','".$tax1."','".$tax2."','".$is_inventory."','".$description."','".$unitcode."','".$size."','".$sellingunit."','".$food_stamp."','".$wic_item."','".$age_verification."','".$liability."')
         $sqltax3exist="select * from ".$db.".mst_tax where vtaxcode='TAX3'";
         $tax3_exist_intax=DB::select($sqltax3exist);
        
         
       if(count($tax3_exist_intax)===1){

                if(isset($input['nbottledepositamt']) && ($input['nbottledepositamt'] == '0.00' || $input['nbottledepositamt'] == '')){
    				$nbottledepositamt = '0.00';
    				$ebottledeposit = 'No';
    			}else{
    				$nbottledepositamt = (float)$input['nbottledepositamt'];
    				$ebottledeposit = 'Yes';
    			}
    
                
                $tax3 = array_key_exists('tax3', $input)?$input['tax3']:"N";
                    
                $update_query = "UPDATE ".$db.".mst_item SET vitemname='".$itemname."',vitemtype='".$itemtype."',vdepcode='".$dept_code."',
                vcategorycode='".$category_code."',vsuppliercode='".$supplier_code."',estatus='Active',new_costprice='".$cost."',manufacturer_id='".$manufacturer_id."',
                dunitprice='".$selling_price."',iqtyonhand='".$qty_on_hand."',ebottledeposit='".$ebottledeposit."',nbottledepositamt='".$nbottledepositamt."',
                vtax1='".$tax1."',vtax2='".$tax2."',vtax3='".$tax3."',visinventory='".$is_inventory."',
                vdescription='".$description."',vunitcode='".$unitcode."',vsize='".$size."',
                nsellunit='".$sellingunit."',vfooditem='".$food_stamp."',wicitem='".$wic_item."',
                vageverify='".$age_verification."',liability='".$liability."', ";
                
                if(!isset($subcat_id) || $subcat_id === null){                
                    $update_query .= "subcat_id = null";
                } else {
                    $update_query .= "subcat_id = '".$subcat_id."'";
                } 
                
                $update_query .= " WHERE iitemid='".$matching_records[0]->iitemid."'";

                try{
                   
                    DB::connection('mysql')->update($update_query);
                 }
                 
                 
                 catch(\Illuminate\Database\QueryException $e) {
                        $addmsttax= "ALTER TABLE ".$db.".mst_item ADD vtax3 VARCHAR(2)";
                        $addcolumn = DB::insert($addmsttax);
                        
                        DB::connection('mysql')->update($update_query);
                        
                       
                }

            
       }     
           
       else
            {
                if(isset($input['nbottledepositamt']) && ($input['nbottledepositamt'] == '0.00' || $input['nbottledepositamt'] == '')){
    				$nbottledepositamt = '0.00';
    				$ebottledeposit = 'No';
    			}else{
    				$nbottledepositamt = (float)$input['nbottledepositamt'];
    				$ebottledeposit = 'Yes';
    			}
    
            $update_query = "UPDATE ".$db.".mst_item SET vitemname='".$itemname."',vitemtype='".$itemtype."',vdepcode='".$dept_code."',
            vcategorycode='".$category_code."',vsuppliercode='".$supplier_code."',estatus='Active',new_costprice='".$cost."',manufacturer_id='".$manufacturer_id."',
            dunitprice='".$selling_price."',iqtyonhand='".$qty_on_hand."',ebottledeposit='".$ebottledeposit."',nbottledepositamt='".$nbottledepositamt."',
            vtax1='".$tax1."',vtax2='".$tax2."',visinventory='".$is_inventory."',
            vdescription='".$description."',vunitcode='".$unitcode."',vsize='".$size."',
            nsellunit='".$sellingunit."',vfooditem='".$food_stamp."',wicitem='".$wic_item."',
            vageverify='".$age_verification."',liability='".$liability."', ";


            if(!isset($subcat_id) || $subcat_id === null){                
                $update_query .= "subcat_id = null";
            } else {
                $update_query .= "subcat_id = '".$subcat_id."'";
            } 
            
            $update_query .= " WHERE iitemid='".$matching_records[0]->iitemid."'";
            
                        
            
            DB::connection('mysql')->update($update_query);
            }
            
           
            
            // return response()->json(['message' => 'Item edited successfully in the store database ('.$db.')'],200);
            return response()->json(['success' => 'Item edited successfully in the store database ('.$db.')'],200);

        }
         
         
         
        $sqltax3exist="select * from ".$db.".mst_tax where vtaxcode='TAX3'";
        $tax3_exist_intax=DB::select($sqltax3exist);
        
        // Check if the tax3 column exists
        if(count($tax3_exist_intax)===1){
           
                if(isset($input['nbottledepositamt']) && ($input['nbottledepositamt'] == '0.00' || $input['nbottledepositamt'] == '')){
    				$nbottledepositamt = '0.00';
    				$ebottledeposit = 'No';
    			}else{
    				$nbottledepositamt = (float)$input['nbottledepositamt'];
    				$ebottledeposit = 'Yes';
    			}
    
           
            $tax3 = array_key_exists('tax3', $input)?$input['tax3']:"N";
            
                // ebottledeposit='".$ebottledeposit."',nbottledepositamt='".$nbottledepositamt."',
                
                
            if($subcat_id === null) {
                $query_insert = "INSERT INTO ".$db.".mst_item (vbarcode, vitemcode, vitemname, ebottledeposit, nbottledepositamt, vitemtype, vdepcode, 
                                vcategorycode, vsuppliercode, SID, estatus, new_costprice, dunitprice, iqtyonhand, vtax1, vtax2, vtax3, visinventory, 
                                vdescription,vunitcode,vsize, manufacturer_id, nsellunit,vfooditem,wicitem,vageverify,liability)
                                VALUES('".$barcode."','".$barcode."','".$itemname."','".$ebottledeposit."','".$nbottledepositamt."','".$itemtype."',
                                '".$dept_code."','".$category_code."','".$supplier_code."','".$store->id."', '".$estatus."','".$cost."','".$selling_price."',
                                '".$qty_on_hand."','".$tax1."','".$tax2."','".$tax3."', '".$is_inventory."','".$description."','".$unitcode."', '".$size."',
                                '".$manufacturer_id."','".$sellingunit."','".$food_stamp."','".$wic_item."','".$age_verification."','".$liability."')";
            }
            else
            {
                $query_insert = "INSERT INTO ".$db.".mst_item (vbarcode, vitemcode, vitemname, ebottledeposit, nbottledepositamt, vitemtype, vdepcode, 
                                vcategorycode, vsuppliercode, SID, estatus, new_costprice, dunitprice, iqtyonhand, vtax1, vtax2, vtax3, visinventory, 
                                vdescription,vunitcode,vsize, manufacturer_id, nsellunit,vfooditem,wicitem,vageverify,liability, subcat_id)
                                VALUES('".$barcode."','".$barcode."','".$itemname."','".$ebottledeposit."','".$nbottledepositamt."','".$itemtype."', '".$dept_code."', 
                                '".$category_code."','".$supplier_code."','".$store->id."', '".$estatus."','".$cost."','".$selling_price."','".$qty_on_hand."',
                                '".$tax1."','".$tax2."','".$tax3."', '".$is_inventory."', '".$description."','".$unitcode."', '".$size."','".$manufacturer_id."',
                                '".$sellingunit."','".$food_stamp."','".$wic_item."','".$age_verification."','".$liability."', '".$subcat_id."')";
            }
            try{
               
                $insert = DB::insert($query_insert);
             }
             
             
            catch(\Illuminate\Database\QueryException $e) {

                    $addmsttax= "ALTER TABLE ".$db.".mst_item ADD vtax3 VARCHAR(2)";
                    $addcolumn = DB::insert($addmsttax);
                    
                    $insert = DB::insert($query_insert);
            }

        } else {
                
                if(!isset($input['nbottledepositamt']) || ($input['nbottledepositamt'] == '0.00' || $input['nbottledepositamt'] == '')){
    				$nbottledepositamt = '0.00';
    				$ebottledeposit = 'No';
    			}else{
    				$nbottledepositamt = (float)$input['nbottledepositamt'];
    				$ebottledeposit = 'Yes';
    			}
    // 			echo "----------";
    
            
            if($subcat_id === null) {
                $query_insert = "INSERT INTO ".$db.".mst_item (vbarcode,vitemcode,vitemname,vitemtype,vdepcode,vcategorycode,vsuppliercode,SID,estatus,
                                 new_costprice,dunitprice,iqtyonhand,vtax1,vtax2,visinventory,vdescription,vunitcode,vsize,manufacturer_id,nsellunit,
                                 vfooditem,wicitem,vageverify,liability)
                                 VALUES('".$barcode."','".$barcode."','".$itemname."','".$itemtype."','".$dept_code."','".$category_code."','".$supplier_code."',
                                 '".$store->id."','".$estatus."','".$cost."','".$selling_price."','".$qty_on_hand."','".$tax1."','".$tax2."','".$is_inventory."',
                                 '".$description."','".$unitcode."','".$size."','".$manufacturer_id."','".$sellingunit."','".$food_stamp."','".$wic_item."',
                                 '".$age_verification."','".$liability."')";
            }
            else
            {
                $query_insert = "INSERT INTO ".$db.".mst_item (vbarcode,vitemcode,vitemname,vitemtype,vdepcode,vcategorycode,vsuppliercode,SID,estatus,
                                 new_costprice,dunitprice,iqtyonhand,vtax1,vtax2,visinventory,vdescription,vunitcode,vsize,manufacturer_id,nsellunit,
                                 vfooditem,wicitem,vageverify,liability,subcat_id)
                                 VALUES('".$barcode."','".$barcode."','".$itemname."','".$itemtype."','".$dept_code."','".$category_code."','".$supplier_code."',
                                 '".$store->id."','".$estatus."','".$cost."','".$selling_price."','".$qty_on_hand."','".$tax1."','".$tax2."','".$is_inventory."',
                                 '".$description."','".$unitcode."','".$size."','".$manufacturer_id."','".$sellingunit."','".$food_stamp."','".$wic_item."',
                                 '".$age_verification."','".$liability."', '".$subcat_id."')";
                
            }
            // die;
            $insert = DB::insert($query_insert);
        }
        //return $query_insert = "INSERT INTO ".$db.".mst_item ('iitemid','vitemname','SID') VALUES(20001,'".$input['itemname']."',".$input['sid'].")";
        
        
        
        $success_message = "Item inserted successfully in ".$db;
        
        if($insert){
            // return response()->json(['message' => $success_message], 200);
            return response()->json(['success' => $success_message], 200);

        } else {
           return response()->json(['message' => 'Item could not be inserted.'],200); 
        }
    }
    
    public function updatePriceBySKU_new(Request $request) {
        // echo "adsfdasf";die; 
        $sku = Request::get('sku');
        $price = Request::get('price');
        $sid = Request::get('sid');

        if($sku && $price) { 
            /*$obj = Item::where('vbarcode',$sku);
            if(Request::get('sid')) {
                $obj->where('SID',Request::get('sid'));
            }
            $data = $obj->get();
            if(count($data) > 0 ) {
                foreach($data as $row) {
                    //$row->dunitprice = $price;
                    //$row->save();
                    $tmp = new tmp_priceupdate;
                    $tmp->SID = $row->SID;
                    $tmp->sku = $row->vbarcode;
                    $tmp->noldprice =  $row->dunitprice;
                    $tmp->nnewprice = $price;
                    $tmp->modifydate = date('Y-m-d H:i:s');
                    $tmp->status = 0;
                    $tmp->save();
                }
            }*/
            
            $item = DB::select("SELECT count(*) count FROM u".$sid.".mst_item WHERE vbarcode=".$sku);
            
            // return $item[0]->count;
            
            if($item[0]->count == 0){
                
                return response()->json(["error" => 'Item does not exist in the db.'],401);
            }
            
            $formatted_price = number_format((float)$price, 2, '.', '');
            
            
            $update_query = "UPDATE u".$sid.".mst_item SET `dunitprice`=".$formatted_price." WHERE vbarcode='".$sku."'";
           // $update_query = "UPDATE u".$sid.".mst_item SET `nsaleprice`=".$formatted_price." WHERE vbarcode='".$sku."'";
            
            // $obj->dunitprice = $formatted_price;
            
            // $obj->save();
            
            // DB::connection('mysql')->select($update_query);
            DB::connection('mysql')->update($update_query);

            return response()->json(["message" => 'Price Updated Successfully '],200);
        } else {
            
            return response()->json(["error" => 'Both SKU and Price are  mandatory  '],401);
        }
    }
    //HEMANT NEW API TRANSFFERED PRODUCTION 13-OCTOBER-2020 ----------------START ---------------------------------------------- Line -start 4128-end 6994
    
    // public function hold_transaction(Request $request){
    //     $input = Request::all();
    //     $db = "u".$input['sid'];
    //     $sid = $input['sid'];
        
    //     $validator = Validator::make($input, [
    //       'isalesid' => 'required'
    //     ]);
        
    //     if ($validator->fails()) {
    //         return response()->json(['message' => $validator->messages()->first()],200);
    //     }
         
    //     $query_db = 'USE DATABASE '.$db;
    //     DB::raw($query_db);  
         
    //     $isalesid = $input['isalesid'];
    //     $query_update = "UPDATE ".$db.".trn_sales SET vtrntype = '" . 'Hold' . "' WHERE isalesid = '" . (int)$isalesid . "'";
    //     DB::statement($query_update);
    //     return response()->json(['data'=>'Successfully Updated To Hold!!!'],200);
    // }
    
    public function sms_process(Request $request){
        $input = Request::all();

        $db = "u".$input['sid'];
        $sid = $input['sid'];
        $sales_id = $input['sales_id'];
        // $message = $input['txt_mess'];
        
                
        $sql="SELECT ts.isalesid, ts.ntaxabletotal as tax_total, ts.nsubtotal as subtotal, ts.nnettotal as total, tsd.vitemcode as itemcode, tsd.vitemname as itemname, tsd.nunitprice as price FROM trn_sales ts INNER JOIN trn_salesdetail tsd ON ts.isalesid=tsd.vuniquetranid where ts.isalesid = $sales_id and tsd.vuniquetranid = $sales_id";
        $count_row = DB::connection('mysql')->select($sql);
        // dd($count_row);
        // echo "<pre>";
        // print_r($count_row);die;
        
        // $sms_array = array();
        // $sms_array['qty'];
        // $sms_array['item_name'];
        // $sms_array['amount'];
        // $sms_array['subtotal'];
        // $sms_array['tax'];
        // $sms_array['total'];
        
        
        
        $message = 'Hello How are you please reply me';
        $number = $input['mob_num'];
        
        
        $validator = Validator::make($input, [
        //   'txt_mess' => 'required',
           'mob_num' => 'required|numeric|digits:10'
        ]);
        
        if ($validator->fails()) {
            return response()->json(['message' => $validator->messages()->first()],200);
        }
         
        $query_db = 'USE DATABASE '.$db;
        DB::raw($query_db);     

        $fields = array(
            "sender_id" => "Alberta",
            "message" => $message,
            "language" => "english",
            "route" => "p",
            "numbers" => $number,
            "flash" => "1"
        );
        
        $curl = curl_init();
        
        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://www.fast2sms.com/dev/bulk",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => json_encode($fields),
          CURLOPT_HTTPHEADER => array(
            "authorization: OUwmX9CgY6Q8xKycSs2oZnAIJNvfjDidHezP7pV4Wbq1hBGtLT1XMAynIbqUmHPeE7fLWhwJ2KxR6OCi",
            "accept: */*",
            "cache-control: no-cache",
            "content-type: application/json"
          ),
        ));
        
        $response = curl_exec($curl);
        $err = curl_error($curl);
        
        curl_close($curl);
        
        if ($err) {
          echo "cURL Error #:" . $err;
        } else {
        //   echo $response;
        return response()->json(['success'=>'recipt sent successfully to NonDND numbers'],200);
        }
        
    }
    
    public function sms_process2(Request $request){
        $input = Request::all();

        $db = "u".$input['sid'];
        $sid = $input['sid'];
        $sales_id = $input['sales_id'];
        // $message = $input['txt_mess'];
        
                
        $sql="SELECT ts.isalesid, ts.ntaxabletotal as tax_total, ts.nsubtotal as subtotal, ts.nnettotal as total, tsd.vitemcode as itemcode, tsd.vitemname as itemname, tsd.nunitprice as price FROM ".$db.".trn_sales ts INNER JOIN ".$db.".trn_salesdetail tsd ON ts.isalesid=tsd.vuniquetranid where tsd.vuniquetranid = $sales_id";
        $count_row = DB::connection('mysql')->select($sql);
        
        // dd($count_row);
        // echo "<pre>";
        // print_r($count_row);die;
        
        $sms_array = array();
        // $sms_array['qty'];
        // $sms_array['item_name'];
        // $sms_array['amount'];
        $subtotal = $count_row[0]->subtotal;
        $tax = $count_row[0]->tax_total;
        $total = $count_row[0]->total;
        
        
        
        // $message = $sms_array;
        $message = "";
        $message .= "Please find the Bill"; ?> 
        <a href="https://devportal.albertapayments.com/api/admin/sms_format">
            <?php $message .= "Link Please click."; ?>
        </a><?php
        $number = $input['mob_num'];
        
        
        $validator = Validator::make($input, [
        //   'txt_mess' => 'required',
           'mob_num' => 'required|numeric|digits:10'
        ]);
        
        if ($validator->fails()) {
            return response()->json(['message' => $validator->messages()->first()],200);
        }
         
        $query_db = 'USE DATABASE '.$db;
        DB::raw($query_db);     

        $fields = array(
            "sender_id" => "Alberta",
            "message" => $message,
            "language" => "english",
            "route" => "p",
            "numbers" => $number,
            "flash" => "1"
        );
        
        $curl = curl_init();
        
        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://www.fast2sms.com/dev/bulk",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => json_encode($fields),
          CURLOPT_HTTPHEADER => array(
            "authorization: JOSe4Wh8wtITRMqsv6aXGCx5An7y2HPjYKcpzoU1FbDg3Nm09BnI6akUr7Yy32hsvDQxJRdZXBf8ltGw",
            "accept: */*",
            "cache-control: no-cache",
            "content-type: application/json"
          ),
        ));
        
        $response = curl_exec($curl);
        $err = curl_error($curl);
        
        curl_close($curl);
        
        if ($err) {
          echo "cURL Error #:" . $err;
        } else {
        //   echo $response;
        return response()->json(['success'=>'recipt sent successfully to NonDND numbers'],200);
        }
        
    }
    
    public function batch_in(Request $request){
        $input = Request::all();

        $db = "u".$input['sid'];
        $sid = $input['sid'];
        // $ibatchid = $input['ibatchid'];
        
        // $validator = Validator::make($input, [
        //   'ibatchid' => 'required',
        // ]);
        
        // if ($validator->fails()) {
        //     return response()->json(['message' => $validator->messages()->first()],200);
        // }
         
        $query_db = 'USE DATABASE '.$db;
        DB::raw($query_db);  
        
        $ibatchid = self::StrUniqueGetIDByTable();
        $batchname = 'Batch '.$ibatchid;
        $terminal_id = '101';
        
        $year = date("Y");
        $year = substr( $year, -2);
        $month = date("m");
        $date = date("d");
        $dmy = $year.$month.$date;
        
        $sql5="select ibatchid ,LastUpdate from ".$db.".trn_batch where date(dbatchstarttime)='$dmy' order by ibatchid desc limit 1";
        // $sql5="Select iholdid ,LastUpdate from ".$db.".mst_holditem where iholdid = $iholdid ORDER BY iholdid DESC";
        $count_row12 = DB::connection('mysql')->select($sql5);
        
        // echo "<pre>";
        // print_r($count_row12);die;
        
        
        if(!empty($count_row12)){
            // dd(1212);
            $ibatchid_inserteds = $count_row12[0]->ibatchid + 1;
            $sql = "INSERT INTO ".$db.".trn_batch SET 
            ibatchid = '" . $ibatchid_inserteds . "', 
            vbatchname = '" . $batchname . "', 
            nnetsales = '" . '0.00'. "', 
            nnetpaidout = '" . '0.00' . "', 
            nnetcashpickup = '" . '0.00' . "', 
            estatus = '" . 'Open' . "', 
            dbatchstarttime = '" .date("Y-m-d H:i:s"). "', 
            dbatchendtime = '" .date("Y-m-d H:i:s"). "', 
            vterminalid = '" . $terminal_id . "', 
            nopeningbalance = '" . '0.00' . "', 
            nclosingbalance = '" . '0.00' . "', 
            nuserclosingbalance = '" . '0.00' . "', 
            nnetaddcash = '" . '0.00' . "', 
            ntotalnontaxable = '" . '0.00' . "', 
            ntotaltaxable = '" . '0.00' . "', 
            ntotalsales = '" . '0.00' . "', 
            ntotaltax = '" . '0.00' . "', 
            tax1taxamount = '" . '0.00' . "', 
            tax2taxamount = '" . '0.00' . "', 
            tax3taxamount = '" . '0.00' . "', 
            ntotalcreditsales = '" . '0.00' . "', 
            ntotalcashsales = '" . '0.00' . "', 
            ntotalgiftsales = '" . '0.00' . "', 
            ntotalchecksales = '" . '0.00' . "', 
            ntotalreturns = '" . '0.00' . "', 
            numberofreturns = '" . '0' . "', 
            ntotalgasoline = '" . '0.00' . "', 
            ntotallottery = '" . '0.00' . "', 
            ntotallotteryredeem = '" . '0.00' . "', 
            ntotalbottledeposit = '" . '0.00' . "', 
            ntotalbottledepositredeem = '" . '0.00' . "', 
            ntotalbottledepositTax = '" . '0.00' . "', 
            ntotalbottledepositredeemTax = '" . '0.00' . "', 
            nhouseacctpayments = '" . '0.00' . "', 
            ntotaldiscount = '" . '0.00' . "', 
            ntotaldebitsales = '" . '0.00' . "', 
            ntotalebtsales = '" . '0.00' . "', 
            ionupload = '" . '0' . "', 
            vtransfer = '" . 'No' . "', 
            endofday = '" . '0' . "', 
            newrpt = '" . 'N' . "', 
            SID = '" .$sid . "'";
            
            DB::connection('mysql')->insert($sql);
                    
        }else{
            
            $ibatchid_inserteds = $ibatchid;
            $sql = "INSERT INTO ".$db.".trn_batch SET 
            ibatchid = '" . $ibatchid_inserteds . "', 
            vbatchname = '" . $batchname . "', 
            nnetsales = '" . '0.00'. "', 
            nnetpaidout = '" . '0.00' . "', 
            nnetcashpickup = '" . '0.00' . "', 
            estatus = '" . 'Open' . "', 
            dbatchstarttime = '" . date("Y-m-d H:i:s") . "', 
            dbatchendtime = '" . date("Y-m-d H:i:s") . "', 
            vterminalid = '" . $terminal_id . "', 
            nopeningbalance = '" . '0.00' . "', 
            nclosingbalance = '" . '0.00' . "', 
            nuserclosingbalance = '" . '0.00' . "', 
            nnetaddcash = '" . '0.00' . "', 
            ntotalnontaxable = '" . '0.00' . "', 
            ntotaltaxable = '" . '0.00' . "', 
            ntotalsales = '" . '0.00' . "', 
            ntotaltax = '" . '0.00' . "', 
            tax1taxamount = '" . '0.00' . "', 
            tax2taxamount = '" . '0.00' . "', 
            tax3taxamount = '" . '0.00' . "', 
            ntotalcreditsales = '" . '0.00' . "', 
            ntotalcashsales = '" . '0.00' . "', 
            ntotalgiftsales = '" . '0.00' . "', 
            ntotalchecksales = '" . '0.00' . "', 
            ntotalreturns = '" . '0.00' . "', 
            numberofreturns = '" . '0' . "', 
            ntotalgasoline = '" . '0.00' . "', 
            ntotallottery = '" . '0.00' . "', 
            ntotallotteryredeem = '" . '0.00' . "', 
            ntotalbottledeposit = '" . '0.00' . "', 
            ntotalbottledepositredeem = '" . '0.00' . "', 
            ntotalbottledepositTax = '" . '0.00' . "', 
            ntotalbottledepositredeemTax = '" . '0.00' . "', 
            nhouseacctpayments = '" . '0.00' . "', 
            ntotaldiscount = '" . '0.00' . "', 
            ntotaldebitsales = '" . '0.00' . "', 
            ntotalebtsales = '" . '0.00' . "', 
            ionupload = '" . '0' . "', 
            vtransfer = '" . 'No' . "', 
            endofday = '" . '0' . "', 
            newrpt = '" . 'N' . "', 
            SID = '" .$sid . "'";
                    
            DB::connection('mysql')->insert($sql);
        }
        
        $temp['batch_id'] = $ibatchid;
        
        return response()->json(['data'=>$temp],200);
    }
    
    public function batch_out(Request $request){
        // echo "asdfadsf";die;
        $input = Request::all();
        // print_r($input);die;

        $db = "u".$input['sid'];
        $sid = $input['sid'];
        $ibatchid = $input['ibatchid'];
        
        $validator = Validator::make($input, [
           'ibatchid' => 'required',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['message' => $validator->messages()->first()],200);
        }
         
        $query_db = 'USE DATABASE '.$db;
        DB::raw($query_db);    
        // call u1001.sp_BatchOut('1905241012');
        $sql=" Call ".$db.".sp_BatchOut('".$ibatchid."')";
        $result = DB::connection('mysql')->select($sql);
        
        return response()->json(['data'=>'Successfully Batch Outed!!'],200);
        
        // if($result){
            // return response()->json(['data'=>'Successfully Batch Outed!!'],200);
        // }else{
            // return response()->json(['data'=>'No Batch Found!!'],200);   
        // }
    }
    
    public function list_hold_items(Request $request){
         $input = Request::all();

         $db = "u".$input['sid'];
         $sid = $input['sid'];
         
        $query_db = 'USE DATABASE '.$db;
        DB::raw($query_db);       
        
        $sql5="select iholdid as id, vholdname, vterminalid as register, dorderdate as date from ".$db.".mst_holditem where vholdtrntype='Hold' ORDER BY iholdid DESC";
        // $sql5="select iholdid as id, vholdname, vterminalid as register, RIGHT(Convert(dorderdate,100),7) as ampm from ".$db.".mst_holditem where vholdtrntype='Hold'";
        $count_row12 = DB::connection('mysql')->select($sql5);
        $result = json_decode(json_encode($count_row12), true);
        // echo "<pre>";
        // print_r($result);die;
        // $data = array();
        // foreach($result as $values){
        //     // $date = $values['date'];
        //     // $result_array['conv_date'] = date('Y-m-d h:i:s a', strtotime($values['date']));
        //     array_push($result, date('Y-m-d h:i:s a', strtotime($values['date'])));
        //     // echo "<pre>";
        //     // print_r($date_value);
        // }
        //  echo "<pre>";
        // print_r($result);die;
        
        if(!empty($result)){
            return response()->json(['data'=>$count_row12],200);
        }else{
            return response()->json(['data'=>'No Hold Found!!'],200);   
        }
    }
    
    public function hold_transaction(Request $request){
         $input = Request::all();

        $db = "u".$input['sid'];
        $sid = $input['sid'];
        // $tax1 = $input['tax1'];
        // $tax2 = $input['tax2'];
        // $tax3 = $input['tax3'];
        //  $Totalitems = $input['Totalitems'];
        //  $SubTotal = $input['SubTotal'];
        //  $tax_total = $input['tax_total'];
         
         $query_db = 'USE DATABASE '.$db;
         DB::raw($query_db);       
         
            $data = array();
            
            try {
                $data['iholdid'] = self::StrUniqueGetIDByTable();
                $data['icustomerid'] = 0;
                $data['dorderdate'] = date("Y-m-d H:i:s");
                $data['vterminalid'] = 101;
                $data['isalesid'] = 0;
                $data['vholdname'] = $input['holdname'];
                $vholdname = $input['holdname'];
                $data['vtransfer'] = 'No';
                $data['vholdtrntype'] = 'Hold';
                $data['SID'] = $sid;
                $iholdid = $data['iholdid'];
                
                
                $sql51="Select iholdid, LastUpdate, vholdname from ".$db.".mst_holditem where vholdname = '$vholdname' AND vholdtrntype = 'Hold'";
                $count_row121 = DB::connection('mysql')->select($sql51);
                // print_r($count_row121);die;
                
                if(isset($count_row121[0]->vholdname)){
                    return response()->json(['error'=>'This Hold Already Exist'],401);
                }
                
                $year = date("Y");
                $year = substr( $year, -2);
                $month = date("m");
                $date = date("d");
                $dmy = $year.$month.$date;
                
                $sql5="select iholdid ,LastUpdate from ".$db.".mst_holditem where date(dorderdate)='$dmy' order by iholdid desc limit 1;";
                // $sql5="Select iholdid ,LastUpdate from ".$db.".mst_holditem where iholdid = $iholdid ORDER BY iholdid DESC";
                $count_row12 = DB::connection('mysql')->select($sql5);

                if(!empty($count_row12)){
                    $iholdid_inserteds = $count_row12[0]->iholdid + 1;
                    $sql = "INSERT INTO ".$db.".mst_holditem SET 
                    iholdid = '" . $iholdid_inserteds . "', 
                    icustomerid = '" . $data['icustomerid'] . "', 
                    dorderdate = '" . $data['dorderdate'] . "', 
                    vterminalid = '" . $data['vterminalid'] . "', 
                    isalesid = '" . $data['isalesid'] . "', 
                    vdiscountname = '" . '' . "', 
                    idiscountid = '" . '0.00' . "', 
                    vholdname = '" . $data['vholdname'] . "', 
                    vtransfer = '" . $data['vtransfer'] . "', 
                    vholdtrntype = '" . $data['vholdtrntype'] . "', 
                    `SID` = '" .$data['SID'] . "'";
                    
                    DB::connection('mysql')->insert($sql);
                    $sql="Select iholdid ,LastUpdate from ".$db.".mst_holditem order by LastUpdate desc limit 1";
                    $count_row = DB::connection('mysql')->select($sql);
                    $iholdid_inserted = $count_row[0]->iholdid;
                    
                }else{
                    $sql = "INSERT INTO ".$db.".mst_holditem SET 
                    iholdid = '" . $data['iholdid'] . "', 
                    icustomerid = '" . $data['icustomerid'] . "', 
                    dorderdate = '" . $data['dorderdate'] . "', 
                    vterminalid = '" . $data['vterminalid'] . "', 
                    isalesid = '" . $data['isalesid'] . "', 
                    vdiscountname = '" . '' . "', 
                    idiscountid = '" . '0.00' . "', 
                    vholdname = '" . $data['vholdname'] . "', 
                    vtransfer = '" . $data['vtransfer'] . "', 
                    vholdtrntype = '" . $data['vholdtrntype'] . "', 
                    `SID` = '" .$data['SID'] . "'";
                    
                    DB::connection('mysql')->insert($sql);
                    $sql="Select iholdid ,LastUpdate from ".$db.".mst_holditem order by LastUpdate desc limit 1";
                    $count_row = DB::connection('mysql')->select($sql);
                    $iholdid_inserted = $count_row[0]->iholdid;
                
                    $iholdid_inserted_incremented = $iholdid_inserted;

                }
                
                if($iholdid_inserted){
                    $iholdid_inserted_incremented = $iholdid_inserted;
                }
                
                $sku = $input['Items'];
                $main_array = array();
                //  echo "<pre>";
                // print_r($sku);die;
                
                foreach($sku as $loop_data){
                    $sku_loop = $loop_data['SKU'];
                    $qty_loop = $loop_data['qty'];
                    $price_loop = $loop_data['price'];
                    $priceValue_loop = $loop_data['priceValue'];
                    $tax_value1_loop = $loop_data['tax_value1'];
                    $tax_value2_loop = $loop_data['tax_value2'];
                    $tax_value3_loop = $loop_data['tax_value3'];
                    $tax_loop = $loop_data['tax'];
                    $vitemname_loop = $loop_data['vitemname'];
                    
                     $sql12 = "INSERT INTO ".$db.".trn_holditem SET 
                    iholdid = '" . $iholdid_inserted . "', 
                    vitemcode = '" . $sku_loop . "', 
                    vitemname = '" . $vitemname_loop . "', 
                    nsaleprice = $priceValue_loop,
                    nprice = '" . $price_loop . "', 
                    iqty = '" . $qty_loop . "', 
                    itemtaxrateone = '" . floatval($tax_value1_loop) . "', 
                    itemtaxratetwo = '" . floatval($tax_value2_loop) . "',
                    itemtaxratethree = '" . floatval($tax_value3_loop) . "',
                    vtax = '" . $tax_loop . "', 
                    `SID` = '" .$sid . "'";
                    DB::connection('mysql')->insert($sql12);
                    
                    // $sql = "SELECT vitemcode, nsaleprice, npack, nunitcost, vitemtype, vsize from ".$db.".mst_item where vitemcode = '$sku_loop'";
                    // $return_data = DB::connection('mysql')->select($sql);
                    // $result = json_decode(json_encode($return_data), true);
                    // $main_array[] = array_merge($loop_data, $result[0]);
                }
                
               
                
                // foreach($main_array as $value){
                //     $item_data['iholdid'] = $iholdid_inserted;
                //     $item_data['vitemcode'] = $value['vitemcode'];
                //     $item_data['SKU'] = $value['SKU'];
                //     $item_data['nsaleprice'] = $value['nsaleprice'];
                //     $item_data['npack'] = $value['npack'];
                //     $item_data['ncostprice'] = $value['nunitcost'];
                //     $item_data['vitemtype'] = $value['vitemtype'];
                //     $item_data['vsize'] = $value['vsize'];
                //     $item_data['vitemname'] = $value['vitemname'];
                //     $item_data['nprice'] = $value['price'];
                //     $item_data['iqty'] = $value['qty'];
                //     $item_data['vtax'] = $value['tax'];
                //     $item_data['SID'] = $sid;
                    
              
                //     $sql12 = "INSERT INTO ".$db.".trn_holditem SET 
                //     iholdid = '" . $item_data['iholdid'] . "', 
                //     vitemcode = '" . $item_data['vitemcode'] . "', 
                //     vitemname = '" . $item_data['vitemname'] . "', 
                //     nsaleprice = '" . $item_data['nsaleprice'] . "', 
                //     nprice = '" . $item_data['nprice'] . "', 
                //     iqty = '" . $item_data['iqty'] . "', 
                //     vtax = '" . $item_data['vtax'] . "', 
                //     npack = '" . $item_data['npack'] . "', 
                //     ncostprice = '" . $item_data['ncostprice'] . "', 
                //     vitemtype = '" . $item_data['vitemtype'] . "', 
                //     vsize = '" . $item_data['vsize'] . "',
                //     `SID` = '" .$item_data['SID'] . "'";
                    
                //     DB::connection('mysql')->insert($sql12);
                    
                //     $sku1 = $input['Items'];
                //     foreach($sku1 as $data_loop){
                //         $tax1 = $data_loop['tax_value1'];
                //         $tax2 = $data_loop['tax_value2'];
                //         $tax3 = $data_loop['tax_value3'];
                //         $qty = $data_loop['qty'];
                //         $price = $data_loop['price'];
                //         $total_calculated_price = $price * $qty;
                //         $sql13 = "UPDATE ".$db.".trn_holditem SET 
                //         itemtaxrateone = '" . floatval($tax1) . "', 
                //         itemtaxratetwo = '" . floatval($tax2) . "',
                //         itemtaxratethree = '" . floatval($tax3) . "'
                //         WHERE iholdid = '" . $item_data['iholdid'] . "' AND vitemcode = '" . $data_loop['SKU'] . "'";
                //         DB::connection('mysql')->update($sql13);
                        
                //         $sql13 = "UPDATE ".$db.".trn_holditem SET 
                //         iqty = '" . $qty . "'
                //         WHERE iholdid = '" . $item_data['iholdid'] . "'";
                //         DB::connection('mysql')->update($sql13);
                //     }

                // }
              return response()->json(['data'=>'Successfully hold items!!'],200);
              
            } catch (Exception $e) {
               
           } finally {
            //  Resetvalue();
           }
            
    }
    
    public function Unhold_transaction(Request $request){
        // dd(121);
        $input = Request::all();
        $db = "u".$input['sid'];
        $sid = $input['sid'];
        $vholdname = $input['holdname'];
        $hold_id = $input['hold_id'];
         
        $query_db = 'USE DATABASE '.$db;
        DB::raw($query_db);  
        
        $validator = Validator::make($input, [
           'holdname' => 'required'
        ]);
        
        if ($validator->fails()) {
            return response()->json(['message' => $validator->messages()->first()],200);
        }
        
        $query_update = "UPDATE ".$db.".mst_holditem SET vholdtrntype = '" . 'UnHold' . "', vholdname = '" . $vholdname . "' WHERE iholdid = '" . $hold_id . "'";
        DB::statement($query_update);
        
        $sql5="Select iholdid from ".$db.".mst_holditem where iholdid = $hold_id";
        $count_row12 = DB::connection('mysql')->select($sql5);
        $count_row1 = $count_row12[0];
        
        
//         SELECT Orders.OrderID, Customers.CustomerName, Orders.OrderDate
// FROM Orders
// INNER JOIN Customers ON Orders.CustomerID=Customers.CustomerID;
        
        $sql5="Select 
        ROUND(trnh.iqty, 1)*ROUND(trnh.itemtaxrateone + trnh.itemtaxratetwo + trnh.itemtaxratethree, 1/100) as taxableField,
        trnh.iholdid as hold_id, 
        trnh.vitemcode as barcode, 
        trnh.vitemname as itemName, 
        trnh.nprice as totalPriceField, 
        trnh.nsaleprice as priceValue,
        ROUND(trnh.iqty, 0) as qty, 
        trnh.vtax as taxable, 
        trnh.nfreeqty, 
        trnh.nbuyqty, 
        trnh.ndiscountqtyper, 
        trnh.npack, 
        trnh.ncostprice as SalesPriceData, 
        trnh.vitemtype, 
        trnh.vsize, 
        trnh.itemdiscountvalue, 
        trnh.itemdiscounttype, 
        trnh.itemtaxrateone, 
        trnh.itemtaxratetwo, 
        itemtaxratethree from ".$db.".trn_holditem as trnh
        INNER JOIN ".$db.".mst_item as msti ON trnh.vitemcode=msti.vitemcode
        where trnh.iholdid = '$count_row1->iholdid'";
        $count_row21 = DB::connection('mysql')->select($sql5);
        // $result = json_decode(json_encode($count_row21), true);
        
        // $tem_arry = array();
        // foreach($result as $value){
        //     // $tem_arry['qty_tax'] = floor($value['qty']);
        //     array_push($result, floor($value['qty']));
        //     // array_push($result, $tem_arry);
        // }
        
        // echo "<pre>";
        // print_r($result);
        // die;
        
        if(!empty($count_row21)){
            return response()->json($count_row21);
        } else {
            return response()->json(['error'=>'No Data Found'],401);
        }
        return response()->json(['data'=>'Successfully Updated To UnHold!!!'],200);
    }
    
    // public function transactions_products(Request $request){
    //     // echo "asdfadsf";die;
    //      $input = Request::all();
    //     //  echo "<pre>";
    //     //  print_r($input);
    //     //  die;
    //      $db = "u".$input['sid'];
    //      $sid = $input['sid'];
    //      $Totalitems = $input['Totalitems'];
    //      $SubTotal = $input['SubTotal'];
    //      $tax_total = $input['tax_total'];
    //     //  $is_tax = $input['is_tax'];
         
    //      $query_db = 'USE DATABASE '.$db;
    //      DB::raw($query_db);       
         
    //         $data = array();
    //         // $nTaxableTotal = 0.00;
    //         // $nNonTaxableAmount = 0.00;
    //         // $liablityAmount = 0.00;
    //         // $nreturntotal = 0.00;
    //         // $nreturntax = 0.00;
    //         // $cashtotal = 0.00;
    //         // $cashtax = 0.00;
    //         // $TranId = 0;
    //         // $nnettotal = 0.00;
    //         // // nnettotal = Convert.ToDouble(lblNetTotal.Text.Replace('$', ' '));
    //         // $nproductsale = 0.00;
    //         // $discountamt = 0.00;
    //         // // var ip = gblFunction.GETTerminaID();
    //         // $strTranID = "";
    //         // $strUniqueTranID = "";
    //         // // strUniqueTranID = gblFunction.StrUniqueTrnCode();
    //         // $updateqoh = 0;
            
    //         if (isset($input['vTranType']) == "Void"){
    //             $updateqoh = 1;
    //         }
            
    //         try {
    //             $data['isalesid'] = self::StrUniqueGetIDByTable();
    //             $data['istoreid'] = 101;
    //             $data['ilogid'] = 0;
    //             $data['icustomerid'] = 0;
    //             // $data['vcustomername'] = "";
    //             $data['vpaymenttype'] = 'TestCard';
    //             $data['dtrandate'] = date("Y-m-d H:i:s");
    //             // $data['dentdate'] = "";
                
    //             // if($is_tax == 'Y'){
    //             //       $data['ntaxabletotal'] = $tax_total;
    //             // }else{
    //             //       $data['nnontaxabletotal'] = $tax_total;    
    //             // }
                
                
    //             //   $data['ntaxtotal'] = $input['ntaxtotal'];
    //             //   $data['nsaletotalamt'] = $input['nsaletotalamt'];
    //             //   dd($data);
    //             // $data['tax1taxamount'] = "";
    //             // $data['tax2taxamount'] = "";
    //             // $data['tax3taxamount'] = "";
    //             // $data['nreturntotalamt'] = "";
    //             // $data['numberofreturns'] = "";
    //             //   $data['nsubtotal'] = $data['nnontaxabletotal'] + $data['ntaxabletotal'] + $data['ntaxtotal'];
    //             // $data['ndiscountamt'] = "";
    //             // $data['buydownamount'] = "";
    //             // $data['idiscountid'] = "";
    //             // $data['nchange'] = "";
    //             $data['vterminalid'] = 101;
    //             // $data['vdiscountname'] = "";
    //             $data['vtrntype'] = "Transaction";
    //             $data['itemplateid'] = 0;
    //             // $data['vdiscountname'] = "";
    //             // $data['vremark'] = "";
    //             $data['estatus'] = "Open";
    //             // $data['vzipcode'] = "";
    //             // $data['vcustphone'] = "";
    //             $data['vuniquetranid'] = self::StrUniqueGetIDByTable();
                  
    //             // $data['ttime'] = "";
    //             // $data['vtablename'] = "";
    //             $data['ibatchid'] = self::StrUniqueGetIDBatch();
    //             // $data['vinvoicenumber'] = "";
    //             // $data['vtransactionnumber'] = "";
    //             // $data['vmpstenderid'] = "";
    //             $data['ionaccount'] = 0;
    //             $data['vtendertype'] = "TestCard";
    //             $data['ionupload'] = 0;
    //             // $data['ntotalgasonline'] = "";
    //             // $data['ntotallottery'] = "";
    //             // $data['ntotallotteryredeem'] = "";
    //             //   $data['nnettotal'] = $data['nnontaxabletotal'] + $data['ntaxabletotal'] + $data['ntaxtotal'];
    //             // $data['ntotalbottledeposit'] = "";
    //             // $data['ntotalbottledepositredeem'] = "";
    //             // $data['ntotalbottledepositTax'] = "";
    //             // $data['ntotalbottledepositredeemTax'] = "";
    //             // $data['ntotalbottledepositredeemTax'] = "";
    //             $data['vtransfer'] = 'No';
    //             $data['SID'] = $input['sid'];
    //             // $data['kioskid'] = '';
    //             // $data['iswic'] = '';
    //             // $data['checkno'] = '';
    //             // $data['checksdate'] = '';
    //             // $data['checkedate'] = '';
    //             // $data['licnumber'] = '';
    //             // $data['liccustomername'] = '';
    //             // $data['licaddress'] = '';
    //             // $data['liccustomerbirthdate'] = '';
    //             // $data['licexpireddate'] = '';
                  
    //             $sql = "INSERT INTO ".$db.".trn_sales SET vtransfer = '" . $data['vtransfer'] . "', vtendertype = '" . $data['vtendertype'] . "', ionaccount = '" . $data['ionaccount'] . "', ibatchid = '" . $data['ibatchid'] . "', vuniquetranid = '" . $data['vuniquetranid'] . "', estatus = '" . $data['estatus'] . "', itemplateid = '" . $data['itemplateid'] . "', vtrntype = '" . $data['vtrntype'] . "', vterminalid = '" . $data['vterminalid'] . "', dtrandate = '" . $data['dtrandate'] . "', vpaymenttype = '" . $data['vpaymenttype'] . "', icustomerid = '" . $data['icustomerid'] . "', ilogid = '" . $data['ilogid'] . "', istoreid = '" . $data['istoreid'] . "', isalesid = '" . $data['isalesid'] . "', `SID` = '" .$data['SID'] . "'";
    //             DB::connection('mysql')->insert($sql);
    //             $sql="Select isalesid ,LastUpdate from ".$db.".trn_sales order by LastUpdate desc limit 1";
    //             $count_row = DB::connection('mysql')->select($sql);
    //             $isalesid_inserted = $count_row[0]->isalesid;
                
    //             $isalesid_inserted_incremented = $isalesid_inserted;
                
    //             $sku = $input['Items'];
    //             // $array1 = explode(",", $sku); 
    //             // $array =implode( ", ", $array1 ); 
    //             $main_array = array();
    //             foreach($sku as $loop_data){
    //                 $sku_loop = $loop_data['SKU'];
    //                 $sql = "SELECT *  from ".$db.".mst_item where vitemcode = '$sku_loop'";
    //                 $return_data = DB::connection('mysql')->select($sql);
    //                 $result = json_decode(json_encode($return_data), true);
    //                 $main_array[] = $result[0];
    //             }
                
    //             foreach($main_array as $value){
    //             //     echo "<pre>";
    //             // print_r($value);
    //                 $item_data['vitemname'] = $value['vitemname'];
    //                 $item_data['vitemcode'] = $value['vitemcode'];
    //                 $vcatcode = $value['vcategorycode'];
    //                 $item_data['vcatcode'] = $value['vcategorycode'];
    //                 $sql1 = "SELECT *  from ".$db.".mst_category where vcategorycode IN ($vcatcode)";
    //                 $return_data = DB::connection('mysql')->select($sql1);
    //                 $result1 = json_decode(json_encode($return_data), true);
                    
    //                 $item_data['vcatname'] = $result1[0]['vcategoryname'];
    //                 $item_data['vdepcode'] = $value['vdepcode'];
    //                 $vdepcode = $value['vdepcode'];
    //                 $sql2 = "SELECT *  from ".$db.".mst_department where vdepcode IN ($vdepcode)";
    //                 $return_data1 = DB::connection('mysql')->select($sql2);
    //                 $result2 = json_decode(json_encode($return_data1), true);
    //                 $item_data['vdepname'] = $result2[0]['vdepartmentname'];
    //                 //   $item_data['ndebitqty'] = $value['vitemname'];
    //                 //   $item_data['ncreditqty'] = $value['vitemname'];
    //                 $item_data['nunitprice'] = $value['dunitprice'];
    //                 $item_data['ncostprice'] = $value['nunitcost'];
    //                 //   $item_data['nextunitprice'] = $value['vitemname'];
    //                 //   $item_data['nextcostprice'] = $value['vitemname'];
    //                 //   $item_data['ndebitamt'] = $value['vitemname'];
    //                 //   $item_data['ncreditamt'] = $value['vitemname'];
    //                 $item_data['ndiscountamt'] = $value['ndiscountamt'];
    //                 //   $item_data['buydownamount'] = $value['vitemname'];
    //                 //   $item_data['nsaleamt'] = $value['vitemname'];
    //                 $item_data['nsaleprice'] = $value['nsaleprice'];
    //                 //   $item_data['vtax'] = $value['vitemname'];
    //                 $item_data['vunitcode'] = $value['vunitcode'];
    //                 $item_data['vunitname'] = 'Each';
    //                 // $item_data['vreason'] = '';
    //                 // $item_data['vadjtype'] = '';
    //                 $item_data['isalesid'] = $isalesid_inserted;
    //                 $item_data['vuniquetranid'] = $isalesid_inserted;
    //                 // $incremented_id = $item_data['vuniquetranid'];
    //                 $item_data['idettrnid'] = $isalesid_inserted_incremented;
    //                 $isalesid_inserted_incremented++;
    //                 $item_data['ereturnitem'] = 'No';
    //                 //   $item_data['nitemtax'] = $value['vitemname'];
    //                 //   $item_data['iunitqty'] = $value['vitemname'];
    //                 $item_data['npack'] = $value['npack'];
    //                 $item_data['vsize'] = $value['vsize'];
    //                 $item_data['vitemtype'] = $value['vitemtype'];
    //                 $item_data['SID'] = $sid;
    //                 //   $item_data['updateqoh'] = $value['vitemname'];
    //                 //   $item_data['itemdiscountvalue'] = $value['vitemname'];
    //                 //   $item_data['itemdiscounttype'] = $value['vitemname'];
    //                 //   $item_data['itemtaxrateone'] = $value['vitemname'];
    //                 //   $item_data['itemtaxratetwo'] = $value['vitemname'];
    //                 //   $item_data['itemtaxratethree'] = $value['vitemname'];
    //                 //   $item_data['liabilityamount'] = $value['vitemname'];
    //                 //   $item_data['preqoh'] = $value['vitemname'];
    //               $sql12 = "INSERT INTO ".$db.".trn_salesdetail SET vitemname = '" . $item_data['vitemname'] . "', isalesid = '" . $item_data['isalesid'] . "', vitemcode = '" . $item_data['vitemcode'] . "', vcatcode = '" . $item_data['vcatcode'] . "', vcatname = '" . $item_data['vcatname'] . "', vdepcode = '" . $item_data['vdepcode'] . "', vdepname = '" . $item_data['vdepname'] . "', nunitprice = '" . $item_data['nunitprice'] . "', ncostprice = '" . $item_data['ncostprice'] . "', ndiscountamt = '" . $item_data['ndiscountamt'] . "', nsaleprice = '" . $item_data['nsaleprice'] . "', vunitcode = '" . $item_data['vunitcode'] . "', vunitname = '" . $item_data['vunitname'] . "', vuniquetranid = '" . $item_data['vuniquetranid'] . "', idettrnid = '" . $item_data['idettrnid'] . "', ereturnitem = '" . $item_data['ereturnitem'] . "', npack = '" . $item_data['npack'] . "', vsize = '" . $item_data['vsize'] . "', vitemtype = '" . $item_data['vitemtype'] . "', `SID` = '" .$item_data['SID'] . "'";
    //               DB::connection('mysql')->insert($sql12);
                  
    //               $item_data['itenerid']= '101';
    //               $item_data['isalesid']= $isalesid_inserted;
    //               $item_data['vtendername']= 'TestCard';
    //             //   $item_data['namount']= '';
    //               $item_data['vuniquetranid']= $isalesid_inserted;
    //             //   $item_data['impstenderid']= '';
    //               $item_data['SID']= $sid;
                  
    //               $sql3 = "INSERT INTO ".$db.".trn_salestender SET isalesid = '" . $item_data['isalesid'] . "',itenerid = '" . $item_data['itenerid'] . "', vtendername = '" . $item_data['vtendername'] . "', vuniquetranid = '" . $item_data['vuniquetranid'] . "', `SID` = '" .$item_data['SID'] . "'";
    //               DB::connection('mysql')->insert($sql3);

    //             }
    //           return response()->json(['data'=>'Successfully Inserted Data!!!'],200);
              
    //         } catch (Exception $e) {
               
    //       } finally {
    //         //  Resetvalue();
    //       }
            
    //         if (isset($input['vTranType']) == "Transaction"){
                
    //         }
            
    // }
    
    // public function transactions_products(Request $request){
    //     // echo "asdfadsf";die;
    //      $input = Request::all();
    //     //  echo "<pre>";
    //     //  print_r($input);
    //     //  die;
    //      $db = "u".$input['sid'];
    //      $sid = $input['sid'];
    //      $Totalitems = $input['Totalitems'];
    //      $SubTotal = $input['SubTotal'];
    //      $tax_total = $input['tax_total'];
    //     //  $is_tax = $input['is_tax'];
         
    //      $query_db = 'USE DATABASE '.$db;
    //      DB::raw($query_db);       
         
    //         $data = array();
    //         // $nTaxableTotal = 0.00;
    //         // $nNonTaxableAmount = 0.00;
    //         // $liablityAmount = 0.00;
    //         // $nreturntotal = 0.00;
    //         // $nreturntax = 0.00;
    //         // $cashtotal = 0.00;
    //         // $cashtax = 0.00;
    //         // $TranId = 0;
    //         // $nnettotal = 0.00;
    //         // // nnettotal = Convert.ToDouble(lblNetTotal.Text.Replace('$', ' '));
    //         // $nproductsale = 0.00;
    //         // $discountamt = 0.00;
    //         // // var ip = gblFunction.GETTerminaID();
    //         // $strTranID = "";
    //         // $strUniqueTranID = "";
    //         // // strUniqueTranID = gblFunction.StrUniqueTrnCode();
    //         // $updateqoh = 0;
            
    //         if (isset($input['vTranType']) == "Void"){
    //             $updateqoh = 1;
    //         }
            
    //         try {
    //             $data['isalesid'] = self::StrUniqueGetIDByTable();
    //             $data['istoreid'] = 101;
    //             $data['ilogid'] = 0;
    //             $data['icustomerid'] = 0;
    //             // $data['vcustomername'] = "";
    //             $data['vpaymenttype'] = 'TestCard';
    //             $data['dtrandate'] = date("Y-m-d H:i:s");
    //             // $data['dentdate'] = "";
                
    //             // if($is_tax == 'Y'){
    //             //       $data['ntaxabletotal'] = $tax_total;
    //             // }else{
    //             //       $data['nnontaxabletotal'] = $tax_total;    
    //             // }
                
                
    //             //   $data['ntaxtotal'] = $input['ntaxtotal'];
    //             //   $data['nsaletotalamt'] = $input['nsaletotalamt'];
    //             //   dd($data);
    //             // $data['tax1taxamount'] = "";
    //             // $data['tax2taxamount'] = "";
    //             // $data['tax3taxamount'] = "";
    //             // $data['nreturntotalamt'] = "";
    //             // $data['numberofreturns'] = "";
    //             //   $data['nsubtotal'] = $data['nnontaxabletotal'] + $data['ntaxabletotal'] + $data['ntaxtotal'];
    //             // $data['ndiscountamt'] = "";
    //             // $data['buydownamount'] = "";
    //             // $data['idiscountid'] = "";
    //             // $data['nchange'] = "";
    //             $data['vterminalid'] = 101;
    //             // $data['vdiscountname'] = "";
    //             $data['vtrntype'] = "Transaction";
    //             $data['itemplateid'] = 0;
    //             // $data['vdiscountname'] = "";
    //             // $data['vremark'] = "";
    //             $data['estatus'] = "Open";
    //             // $data['vzipcode'] = "";
    //             // $data['vcustphone'] = "";
    //             $data['vuniquetranid'] = self::StrUniqueGetIDByTable();
                  
    //             // $data['ttime'] = "";
    //             // $data['vtablename'] = "";
    //             $data['ibatchid'] = self::StrUniqueGetIDBatch();
    //             // $data['vinvoicenumber'] = "";
    //             // $data['vtransactionnumber'] = "";
    //             // $data['vmpstenderid'] = "";
    //             $data['ionaccount'] = 0;
    //             $data['vtendertype'] = "TestCard";
    //             $data['ionupload'] = 0;
    //             // $data['ntotalgasonline'] = "";
    //             // $data['ntotallottery'] = "";
    //             // $data['ntotallotteryredeem'] = "";
    //             //   $data['nnettotal'] = $data['nnontaxabletotal'] + $data['ntaxabletotal'] + $data['ntaxtotal'];
    //             // $data['ntotalbottledeposit'] = "";
    //             // $data['ntotalbottledepositredeem'] = "";
    //             // $data['ntotalbottledepositTax'] = "";
    //             // $data['ntotalbottledepositredeemTax'] = "";
    //             // $data['ntotalbottledepositredeemTax'] = "";
    //             $data['vtransfer'] = 'No';
    //             $data['SID'] = $input['sid'];
    //             // $data['kioskid'] = '';
    //             // $data['iswic'] = '';
    //             // $data['checkno'] = '';
    //             // $data['checksdate'] = '';
    //             // $data['checkedate'] = '';
    //             // $data['licnumber'] = '';
    //             // $data['liccustomername'] = '';
    //             // $data['licaddress'] = '';
    //             // $data['liccustomerbirthdate'] = '';
    //             // $data['licexpireddate'] = '';
    //             $isalesid = $data['isalesid'];
                
    //             $sql5="Select isalesid ,LastUpdate from ".$db.".trn_sales where isalesid = '$isalesid'";
    //             $count_row12 = DB::connection('mysql')->select($sql5);

    //             if(empty($count_row12)){
    //                 $isalesid_inserted = $count_row12[0]->isalesid;
    //             }else{
    //                 $isalesid_inserted = 0;
    //             }
                
    //             if($isalesid_inserted == 0){
    //                 $sql = "INSERT INTO ".$db.".trn_sales SET vtransfer = '" . $data['vtransfer'] . "', vtendertype = '" . $data['vtendertype'] . "', ionaccount = '" . $data['ionaccount'] . "', ibatchid = '" . $data['ibatchid'] . "', vuniquetranid = '" . $data['vuniquetranid'] . "', estatus = '" . $data['estatus'] . "', itemplateid = '" . $data['itemplateid'] . "', vtrntype = '" . $data['vtrntype'] . "', vterminalid = '" . $data['vterminalid'] . "', dtrandate = '" . $data['dtrandate'] . "', vpaymenttype = '" . $data['vpaymenttype'] . "', icustomerid = '" . $data['icustomerid'] . "', ilogid = '" . $data['ilogid'] . "', istoreid = '" . $data['istoreid'] . "', isalesid = '" . $data['isalesid'] . "', `SID` = '" .$data['SID'] . "'";
    //                 DB::connection('mysql')->insert($sql);
    //                 $sql="Select isalesid ,LastUpdate from ".$db.".trn_sales order by LastUpdate desc limit 1";
    //                 $count_row = DB::connection('mysql')->select($sql);
    //             //       echo "<pre>";
    //             // print_r($count_row);
    //             // die;
    //                 $isalesid_inserted = $count_row[0]->isalesid;
                
    //                 $isalesid_inserted_incremented = $isalesid_inserted;
    //             }else{
    //                 $isalesid_inserted_incremented = $isalesid_inserted;
    //             }
                
    //             $sku = $input['Items'];
    //             // $array1 = explode(",", $sku); 
    //             // $array =implode( ", ", $array1 ); 
    //             $main_array = array();
    //             foreach($sku as $loop_data){
    //                 $sku_loop = $loop_data['SKU'];
    //                 $sql = "SELECT *  from ".$db.".mst_item where vitemcode = '$sku_loop'";
    //                 $return_data = DB::connection('mysql')->select($sql);
    //                 $result = json_decode(json_encode($return_data), true);
    //                 $main_array[] = $result[0];
    //             }
                
    //             foreach($main_array as $value){
    //             //     echo "<pre>";
    //             // print_r($value);
    //                 $item_data['vitemname'] = $value['vitemname'];
    //                 $item_data['vitemcode'] = $value['vitemcode'];
    //                 $vcatcode = $value['vcategorycode'];
    //                 $item_data['vcatcode'] = $value['vcategorycode'];
    //                 $sql1 = "SELECT *  from ".$db.".mst_category where vcategorycode IN ($vcatcode)";
    //                 $return_data = DB::connection('mysql')->select($sql1);
    //                 $result1 = json_decode(json_encode($return_data), true);
                    
    //                 $item_data['vcatname'] = $result1[0]['vcategoryname'];
    //                 $item_data['vdepcode'] = $value['vdepcode'];
    //                 $vdepcode = $value['vdepcode'];
    //                 $sql2 = "SELECT *  from ".$db.".mst_department where vdepcode IN ($vdepcode)";
    //                 $return_data1 = DB::connection('mysql')->select($sql2);
    //                 $result2 = json_decode(json_encode($return_data1), true);
    //                 $item_data['vdepname'] = $result2[0]['vdepartmentname'];
    //                 //   $item_data['ndebitqty'] = $value['vitemname'];
    //                 //   $item_data['ncreditqty'] = $value['vitemname'];
    //                 $item_data['nunitprice'] = $value['dunitprice'];
    //                 $item_data['ncostprice'] = $value['nunitcost'];
    //                 //   $item_data['nextunitprice'] = $value['vitemname'];
    //                 //   $item_data['nextcostprice'] = $value['vitemname'];
    //                 //   $item_data['ndebitamt'] = $value['vitemname'];
    //                 //   $item_data['ncreditamt'] = $value['vitemname'];
    //                 $item_data['ndiscountamt'] = $value['ndiscountamt'];
    //                 //   $item_data['buydownamount'] = $value['vitemname'];
    //                 //   $item_data['nsaleamt'] = $value['vitemname'];
    //                 $item_data['nsaleprice'] = $value['nsaleprice'];
    //                 //   $item_data['vtax'] = $value['vitemname'];
    //                 $item_data['vunitcode'] = $value['vunitcode'];
    //                 $item_data['vunitname'] = 'Each';
    //                 // $item_data['vreason'] = '';
    //                 // $item_data['vadjtype'] = '';
    //                 $item_data['isalesid'] = $isalesid_inserted;
    //                 $item_data['vuniquetranid'] = $isalesid_inserted;
    //                 // $incremented_id = $item_data['vuniquetranid'];
    //                 $item_data['idettrnid'] = $isalesid_inserted_incremented;
    //                 $isalesid_inserted_incremented++;
    //                 $item_data['ereturnitem'] = 'No';
    //                 //   $item_data['nitemtax'] = $value['vitemname'];
    //                 //   $item_data['iunitqty'] = $value['vitemname'];
    //                 $item_data['npack'] = $value['npack'];
    //                 $item_data['vsize'] = $value['vsize'];
    //                 $item_data['vitemtype'] = $value['vitemtype'];
    //                 $item_data['SID'] = $sid;
    //                 //   $item_data['updateqoh'] = $value['vitemname'];
    //                 //   $item_data['itemdiscountvalue'] = $value['vitemname'];
    //                 //   $item_data['itemdiscounttype'] = $value['vitemname'];
    //                 //   $item_data['itemtaxrateone'] = $value['vitemname'];
    //                 //   $item_data['itemtaxratetwo'] = $value['vitemname'];
    //                 //   $item_data['itemtaxratethree'] = $value['vitemname'];
    //                 //   $item_data['liabilityamount'] = $value['vitemname'];
    //                 //   $item_data['preqoh'] = $value['vitemname'];
                    
    //             $sql5="Select isalesid,idettrnid, LastUpdate from u1001.trn_salesdetail where isalesid = '$isalesid' order by idettrnid desc limit 1";
    //             $count_row12 = DB::connection('mysql')->select($sql5);
    //             $isalesid_inserted = $count_row12[0]->idettrnid;
                
    //             if($isalesid_inserted){
    //                 $isalesid_inserted_id = $isalesid_inserted+1;
    //               $sql12 = "INSERT INTO ".$db.".trn_salesdetail SET 
    //               vitemname = '" . $item_data['vitemname'] . "', 
    //               isalesid = '" . $isalesid . "', 
    //               vitemcode = '" . $item_data['vitemcode'] . "', 
    //               vcatcode = '" . $item_data['vcatcode'] . "',
    //               vcatname = '" . $item_data['vcatname'] . "', 
    //               vdepcode = '" . $item_data['vdepcode'] . "', 
    //               vdepname = '" . $item_data['vdepname'] . "', 
    //               nunitprice = '" . $item_data['nunitprice'] . "', 
    //               ncostprice = '" . $item_data['ncostprice'] . "', 
    //               ndiscountamt = '" . $item_data['ndiscountamt'] . "', 
    //               nsaleprice = '" . $item_data['nsaleprice'] . "', 
    //               vunitcode = '" . $item_data['vunitcode'] . "', 
    //               vunitname = '" . $item_data['vunitname'] . "', 
    //               vuniquetranid = '" . $isalesid . "', 
    //               idettrnid = '" . $isalesid_inserted_id . "', ereturnitem = '" . $item_data['ereturnitem'] . "', npack = '" . $item_data['npack'] . "', vsize = '" . $item_data['vsize'] . "', vitemtype = '" . $item_data['vitemtype'] . "', `SID` = '" .$item_data['SID'] . "'";
    //               DB::connection('mysql')->insert($sql12);
    //             }else{
    //                 $sql12 = "INSERT INTO ".$db.".trn_salesdetail SET vitemname = '" . $item_data['vitemname'] . "', isalesid = '" . $item_data['isalesid'] . "', vitemcode = '" . $item_data['vitemcode'] . "', vcatcode = '" . $item_data['vcatcode'] . "', vcatname = '" . $item_data['vcatname'] . "', vdepcode = '" . $item_data['vdepcode'] . "', vdepname = '" . $item_data['vdepname'] . "', nunitprice = '" . $item_data['nunitprice'] . "', ncostprice = '" . $item_data['ncostprice'] . "', ndiscountamt = '" . $item_data['ndiscountamt'] . "', nsaleprice = '" . $item_data['nsaleprice'] . "', vunitcode = '" . $item_data['vunitcode'] . "', vunitname = '" . $item_data['vunitname'] . "', vuniquetranid = '" . $item_data['vuniquetranid'] . "', idettrnid = '" . $item_data['idettrnid'] . "', ereturnitem = '" . $item_data['ereturnitem'] . "', npack = '" . $item_data['npack'] . "', vsize = '" . $item_data['vsize'] . "', vitemtype = '" . $item_data['vitemtype'] . "', `SID` = '" .$item_data['SID'] . "'";
    //                 DB::connection('mysql')->insert($sql12);
    //             }
                                
    //               $item_data['itenerid']= '101';
    //               $item_data['isalesid']= $isalesid_inserted;
    //               $item_data['vtendername']= 'TestCard';
    //             //   $item_data['namount']= '';
    //               $item_data['vuniquetranid']= $isalesid_inserted;
    //             //   $item_data['impstenderid']= '';
    //               $item_data['SID']= $sid;
                  
    //               $sql3 = "INSERT INTO ".$db.".trn_salestender SET isalesid = '" . $item_data['isalesid'] . "',itenerid = '" . $item_data['itenerid'] . "', vtendername = '" . $item_data['vtendername'] . "', vuniquetranid = '" . $item_data['vuniquetranid'] . "', `SID` = '" .$item_data['SID'] . "'";
    //               DB::connection('mysql')->insert($sql3);

    //             }
    //           return response()->json(['data'=>'Successfully Inserted Data!!!'],200);
              
    //         } catch (Exception $e) {
               
    //       } finally {
    //         //  Resetvalue();
    //       }
            
    //         if (isset($input['vTranType']) == "Transaction"){
                
    //         }
            
    // }
     
    public function transactions_products(Request $request){
        // echo "asdfadsf";die;
         $input = Request::all();
        //  echo "<pre>";
        //  print_r($input);
        //  die;
        
        
        // call to function
        // $this->wh_log($input);

         $db = "u".$input['sid'];
         $sid = $input['sid'];
         $Totalitems = $input['Totalitems'];
         $SubTotal = $input['SubTotal'];
         $tax_total = $input['tax_total'];
        //  $iuserid = 4;
         $iuserid = $input['iuserid'];
        //  $is_tax = $input['is_tax'];
        
        $sql_mst_store="Select * from ".$db.".mst_store where SID = '$sid'";
        $count_row_mst_store = DB::connection('mysql')->select($sql_mst_store);
        $istoreid = $count_row_mst_store[0]->istoreid;
        $vstorename = $count_row_mst_store[0]->vstorename;
        $login_id = 0;
        
        $sql_mst_user="Select * from inslocdb.store_mw_users where iuserid = '$iuserid'";
        $count_row_mst_user = DB::connection('mysql')->select($sql_mst_user);
        // print_r($count_row_mst_user);die;
        $vfname = $count_row_mst_user[0]->fname;
         
         $query_db = 'USE DATABASE '.$db;
         DB::raw($query_db);       
         
            $data = array();
            // $nTaxableTotal = 0.00;
            // $nNonTaxableAmount = 0.00;
            // $liablityAmount = 0.00;
            // $nreturntotal = 0.00;
            // $nreturntax = 0.00;
            // $cashtotal = 0.00;
            // $cashtax = 0.00;
            // $TranId = 0;
            // $nnettotal = 0.00;
            // // nnettotal = Convert.ToDouble(lblNetTotal.Text.Replace('$', ' '));
            // $nproductsale = 0.00;
            // $discountamt = 0.00;
            // // var ip = gblFunction.GETTerminaID();
            // $strTranID = "";
            // $strUniqueTranID = "";
            // // strUniqueTranID = gblFunction.StrUniqueTrnCode();
            // $updateqoh = 0;
            
            if (isset($input['vTranType']) == "Void"){
                $updateqoh = 1;
            }
            
            try {
                $data['isalesid'] = self::StrUniqueGetIDByTable();
                $data['istoreid'] = $istoreid;
                $data['icustomerid'] = $login_id;
                $data['vstorename'] = $vstorename;
                $data['iuserid'] = $iuserid;
                $data['vusername'] = $vfname;
                $data['ilogid'] = 0;
                $data['vpaymenttype'] = 'TestCard';
                $data['dtrandate'] = date("Y-m-d H:i:s");
                // $data['dentdate'] = "";
                
                // if($is_tax == 'Y'){
                //       $data['ntaxabletotal'] = $tax_total;
                // }else{
                //       $data['nnontaxabletotal'] = $tax_total;    
                // }
                
                
                //   $data['ntaxtotal'] = $input['tax_total'];
                //   $data['nsaletotalamt'] = $input['nsaletotalamt'];
                //   dd($data);
                //  $data['ntaxabletotal'] = $input['ntaxabletotal'];
                //  $data['nnontaxabletotal'] = $input['nnontaxabletotal'];
                // $data['tax1taxamount'] = "";
                // $data['tax2taxamount'] = "";
                // $data['tax3taxamount'] = "";
                // $data['nreturntotalamt'] = "";
                // $data['numberofreturns'] = "";
                //   $data['nsubtotal'] = $data['nnontaxabletotal'] + $data['ntaxabletotal'] + $data['ntaxtotal'];
                // $data['ndiscountamt'] = "";
                // $data['buydownamount'] = "";
                // $data['idiscountid'] = "";
                // $data['nchange'] = "";
                $data['vterminalid'] = 101;
                // $data['vdiscountname'] = "";
                $data['vtrntype'] = "Transaction";
                // $data['itemplateid'] = 0;
                // $data['vdiscountname'] = "";
                // $data['vremark'] = "";
                $data['estatus'] = "Open";
                // $data['vzipcode'] = "";
                // $data['vcustphone'] = "";
                $data['vuniquetranid'] = self::StrUniqueGetIDByTable();
                  
                // $data['ttime'] = "";
                // $data['vtablename'] = "";
                $data['ibatchid'] = self::StrUniqueGetIDBatch();
                // $data['vinvoicenumber'] = "";
                // $data['vtransactionnumber'] = "";
                // $data['vmpstenderid'] = "";
                // $data['ionaccount'] = 0;
                $data['vtendertype'] = "TestCard";
                // $data['ionupload'] = 0;
                // $data['ntotalgasonline'] = "";
                // $data['ntotallottery'] = "";
                // $data['ntotallotteryredeem'] = "";
                //   $data['nnettotal'] = $data['nnontaxabletotal'] + $data['ntaxabletotal'] + $data['ntaxtotal'];
                // $data['ntotalbottledeposit'] = "";
                // $data['ntotalbottledepositredeem'] = "";
                // $data['ntotalbottledepositTax'] = "";
                // $data['ntotalbottledepositredeemTax'] = "";
                // $data['ntotalbottledepositredeemTax'] = "";
                // $data['vtransfer'] = 'No';
                $data['SID'] = $input['sid'];
                // $data['kioskid'] = '';
                // $data['iswic'] = '';
                // $data['checkno'] = '';
                // $data['checksdate'] = '';
                // $data['checkedate'] = '';
                // $data['licnumber'] = '';
                // $data['liccustomername'] = '';
                // $data['licaddress'] = '';
                // $data['liccustomerbirthdate'] = '';
                // $data['licexpireddate'] = '';
                $isalesid = $data['isalesid'];
                
                // $sql5="Select isalesid ,LastUpdate from ".$db.".trn_sales where isalesid = '$isalesid'";
                // $count_row12 = DB::connection('mysql')->select($sql5);
                
                $year = date("Y");
                $year = substr( $year, -2);
                $month = date("m");
                $date = date("d");
                $dmy = $year.$month.$date;
                
                $sql5="select isalesid ,LastUpdate from ".$db.".trn_sales where date(dtrandate)='$dmy' order by isalesid desc limit 1;";
                $count_row12 = DB::connection('mysql')->select($sql5);
                // print_r($count_row12);die;
                
                
                if(!empty($count_row12)){
                    $incrementedisalesid = $count_row12[0]->isalesid + 1;
                    $sql = "INSERT INTO ".$db.".trn_sales SET 
                    iuserid = '" . $data['iuserid'] . "', 
                    vusername = '" . $data['vusername'] . "', 
                    vstorename = '" . $data['vstorename'] . "', 
                    vtendertype = '" . $data['vtendertype'] . "', 
                    ibatchid = '" . $data['ibatchid'] . "', 
                    vuniquetranid = '" . $data['vuniquetranid'] . "', 
                    estatus = '" . $data['estatus'] . "', 
                    vtrntype = '" . $data['vtrntype'] . "', 
                    vterminalid = '" . $data['vterminalid'] . "', 
                    dtrandate = '" . $data['dtrandate'] . "', 
                    vpaymenttype = '" . $data['vpaymenttype'] . "', 
                    icustomerid = '" . $data['icustomerid'] . "', 
                    ilogid = '" . $data['ilogid'] . "', 
                    istoreid = '" . $data['istoreid'] . "', 
                    isalesid = '" . $incrementedisalesid. "', 
                    `SID` = '" .$data['SID'] . "'";
                    DB::connection('mysql')->insert($sql);
                    
                    $sql="Select isalesid ,LastUpdate from ".$db.".trn_sales order by LastUpdate desc limit 1";
                    $count_row = DB::connection('mysql')->select($sql);
                    $isalesid_inserted = $count_row[0]->isalesid;
                
                    $isalesid_inserted_incremented = $isalesid_inserted;
                    
                    // $isalesid_inserteds = $count_row12[0]->isalesid + 1;
                    // $sql = "INSERT INTO ".$db.".mst_holditem SET 
                    // iholdid = '" . $isalesid_inserteds . "', 
                    // icustomerid = '" . $data['icustomerid'] . "', 
                    // dorderdate = '" . $data['dorderdate'] . "', 
                    // vterminalid = '" . $data['vterminalid'] . "', 
                    // isalesid = '" . $data['isalesid'] . "', 
                    // vdiscountname = '" . '' . "', 
                    // idiscountid = '" . '0.00' . "', 
                    // vholdname = '" . $data['vholdname'] . "', 
                    // vtransfer = '" . $data['vtransfer'] . "', 
                    // vholdtrntype = '" . $data['vholdtrntype'] . "', 
                    // `SID` = '" .$data['SID'] . "'";
                    
                    // DB::connection('mysql')->insert($sql);
                    // $sql="Select isalesid ,LastUpdate from ".$db.".trn_sales order by LastUpdate desc limit 1";
                    // $count_row = DB::connection('mysql')->select($sql);
                    // $isalesid_inserted = $count_row[0]->isalesid;
                    
                }else{
                    $sql = "INSERT INTO ".$db.".trn_sales SET 
                    iuserid = '" . $data['iuserid'] . "', 
                    vusername = '" . $data['vusername'] . "', 
                    vstorename = '" . $data['vstorename'] . "', 
                    vtendertype = '" . $data['vtendertype'] . "', 
                    ibatchid = '" . $data['ibatchid'] . "', 
                    vuniquetranid = '" . $data['vuniquetranid'] . "', 
                    estatus = '" . $data['estatus'] . "', 
                    vtrntype = '" . $data['vtrntype'] . "', 
                    vterminalid = '" . $data['vterminalid'] . "', 
                    dtrandate = '" . $data['dtrandate'] . "', 
                    vpaymenttype = '" . $data['vpaymenttype'] . "', 
                    icustomerid = '" . $data['icustomerid'] . "', 
                    ilogid = '" . $data['ilogid'] . "', 
                    istoreid = '" . $data['istoreid'] . "', 
                    isalesid = '" . $data['isalesid'] . "', 
                    `SID` = '" .$data['SID'] . "'";
                    DB::connection('mysql')->insert($sql);
                    $sql="Select isalesid ,LastUpdate from ".$db.".trn_sales order by LastUpdate desc limit 1";
                    $count_row = DB::connection('mysql')->select($sql);
                    $isalesid_inserted = $count_row[0]->isalesid;
                
                    $isalesid_inserted_incremented = $isalesid_inserted;

                }
                $isales_id = $isalesid_inserted;
                
                if($isalesid_inserted){
                    $isalesid_inserted_incremented = $isalesid_inserted;
                }
                
                $sku = $input['Items'];
                // $array1 = explode(",", $sku); 
                // $array =implode( ", ", $array1 ); 
                $main_array = array();
                // $taxable_cal = array();
                foreach($sku as $loop_data){
                    $sku_loop = $loop_data['SKU'];
                    $tax_loop = $loop_data['tax'];
                    $qty_loop = $loop_data['qty'];
                    $price_loop = $loop_data['price'];
                    
                    if($tax_loop == 'Y'){
                         $taxable_cal[] = $price_loop;
                        
                    }else{
                        $nontaxable_cal[] = $price_loop;
                    }
                    
                    if($sku_loop == '1'){
                        $bottle_deposit[] = $price_loop;
                    }else {
                        $bottle_deposit = 0.00;
                    }
                    
                    if($sku_loop == '10'){
                        $bottle_deposit_redeem[] = $price_loop;
                    }else{
                        $bottle_deposit_redeem = 0.00;
                    }
                    
                    if($sku_loop == '20'){
                        $ntotallottery[] = $price_loop;
                    }else{
                        $ntotallottery = 0.00;
                    }
                    
                    if($sku_loop == '6' && $sku_loop == '22'){
                        $ntotallotteryredeem[] = $price_loop;
                    }else{
                        $ntotallotteryredeem = 0.00;
                    }
                    
                    if($qty_loop < 0){
                        $nreturntotalamt[] = $price_loop;
                    }else{
                        $nreturntotalamt = 0.00;
                    }
                    
                    if($data['vtendertype'] == 'On Account'){
                        $ionaccount = 1;
                    }else{
                        $ionaccount = 0;
                    }
                    
                    if($data['vtendertype'] == 'On Account' && $data['vtendertype'] == 'Cash'){
                        $ionupload = 1;
                    }else{
                        $ionupload = 0;
                    }
                    
                     
                    
                    $price_add[] = $price_loop;
                    $qty_add[] = $qty_loop;
                    // print_r($price_add);die;
                    
                    
                    $sql = "SELECT *  from ".$db.".mst_item where vitemcode = '$sku_loop'";
                    $return_data = DB::connection('mysql')->select($sql);
                    $result = json_decode(json_encode($return_data), true);
                    // print_r($result);die;
                    $main_array[] = $result[0];
                }
                // dd($main_array);
                $sql="Select isalesid ,LastUpdate from ".$db.".trn_sales order by LastUpdate desc limit 1";
                $count_row = DB::connection('mysql')->select($sql);
                $isalesid_inserted = $count_row[0]->isalesid;
                
                // print_r($bottle_deposit_redeem); 
                $bottle_deposit_redeem = $bottle_deposit_redeem;
                $taxable_cal = $taxable_cal;
                $nontaxable_cal = $nontaxable_cal;
                $bottle_deposit = $bottle_deposit;
                $ntotallottery = $ntotallottery;
                $ntotallotteryredeem = $ntotallotteryredeem;
                $nreturntotalamt = $nreturntotalamt;
                $ionaccount = $ionaccount;
                $ionupload = $ionupload;
                $nsubtotal = array_sum($price_add);
                $nnettotal = array_sum($price_add);
                $numberofreturns = array_sum($qty_add);
                $ntaxabletotal = array_sum($taxable_cal);
                $nnontaxabletotal = array_sum($nontaxable_cal);
                $ntaxtotal = array_sum($price_add);;
                // $nsaletotalamt = '';
                // $ilogid = '';
                // $icustomerid = '';
                // $vcustomername = '';
                // $dentdate = '';
                $ntotalgasoline = 0.00;
                // $tax1taxamount = '';
                // $tax2taxamount = '';
                // $tax3taxamount = '';
                $buydownamount = 0.00;
                // $vdiscountname = '';
                // $itemplateid = ''; 
                // $vzipcode = '';
                // $vcustphone = '';
                // $ttime = '';
                // $vtablename = '';
                // $vinvoicenumber = '';
                // $vtransactionnumber = '';
                // $vmpstenderid = '';
                // $ndiscountamt = '';
                $ntotalbottledeposit = $bottle_deposit;
                $ntotalbottledepositredeem = $bottle_deposit_redeem;
                $ntotalbottledepositTax = '0.00';
                $ntotalbottledepositredeemTax = '0.00';
                // $vtransfer = '';
                // $kioskid = '';
                // $iswic = '';
                // $checkno = '';
                // $checksdate = '';
                // $licnumber = '';
                // $liccustomername = '';
                // $licaddress = '';
                // $liccustomerbirthdate = '';
                // $licexpireddate = '';
                // $new_cost = '';
                
                
                $sql28= "UPDATE ".$db.".trn_sales SET 
                ntotalbottledepositredeemTax = $ntotalbottledepositredeemTax, 
                ntotalbottledepositTax= $ntotalbottledepositTax,
                ntotalbottledepositredeem= $ntotalbottledepositredeem,
                ntotalbottledeposit= $ntotalbottledeposit,
                buydownamount= $buydownamount,
                ntotalgasoline= $ntotalgasoline,
                ntaxtotal= $ntaxtotal,
                ntaxabletotal= $ntaxabletotal,
                numberofreturns= $numberofreturns,
                nnettotal= $nnettotal,
                nsubtotal= $nsubtotal,
                ionupload= $ionupload,
                ionaccount= $ionaccount,
                nreturntotalamt= $nreturntotalamt,
                ntotallotteryredeem= $ntotallotteryredeem,
                ntotallottery= $ntotallottery
                WHERE isalesid = $isalesid_inserted";
                
                DB::connection('mysql')->update($sql28);
                
                $main_sales_id = $isalesid_inserted;
                
                foreach($main_array as $value){
                //     echo "<pre>";
                // print_r($value);
                    
                
                    $item_data['vitemname'] = $value['vitemname'];
                    $item_data['vitemcode'] = $value['vitemcode'];
                    $vcatcode = $value['vcategorycode'];
                    $item_data['vcatcode'] = $value['vcategorycode'];
                    $sql1 = "SELECT *  from ".$db.".mst_category where vcategorycode IN ($vcatcode)";
                    $return_data = DB::connection('mysql')->select($sql1);
                    $result1 = json_decode(json_encode($return_data), true);
                    
                    $item_data['vcatname'] = $result1[0]['vcategoryname'];
                    $item_data['vdepcode'] = $value['vdepcode'];
                    $vdepcode = $value['vdepcode'];
                    $sql2 = "SELECT *  from ".$db.".mst_department where vdepcode IN ($vdepcode)";
                    $return_data1 = DB::connection('mysql')->select($sql2);
                    $result2 = json_decode(json_encode($return_data1), true);
                    $item_data['vdepname'] = $result2[0]['vdepartmentname'];
                    //   $item_data['ndebitqty'] = $value['vitemname'];
                    //   $item_data['ncreditqty'] = $value['vitemname'];
                    $item_data['nunitprice'] = $value['dunitprice'];
                    $item_data['ncostprice'] = $value['nunitcost'];
                    //   $item_data['nextunitprice'] = $value['vitemname'];
                    //   $item_data['nextcostprice'] = $value['vitemname'];
                    //   $item_data['ndebitamt'] = $value['vitemname'];
                    //   $item_data['ncreditamt'] = $value['vitemname'];
                    $item_data['ndiscountamt'] = $value['ndiscountamt'];
                    //   $item_data['buydownamount'] = $value['vitemname'];
                    //   $item_data['nsaleamt'] = $value['vitemname'];
                    $item_data['nsaleprice'] = $value['nsaleprice'];
                    //   $item_data['vtax'] = $value['vitemname'];
                    $item_data['vunitcode'] = $value['vunitcode'];
                    $item_data['vunitname'] = 'Each';
                    // $item_data['vreason'] = '';
                    // $item_data['vadjtype'] = '';
                    $item_data['isalesid'] = $isalesid_inserted;
                    $item_data['vuniquetranid'] = $isalesid_inserted;
                    // $incremented_id = $item_data['vuniquetranid'];
                    $item_data['idettrnid'] = $isalesid_inserted_incremented;
                    $isalesid_inserted_incremented++;
                    $item_data['ereturnitem'] = 'No';
                    //   $item_data['nitemtax'] = $value['vitemname'];
                    //   $item_data['iunitqty'] = $value['vitemname'];
                    $item_data['npack'] = $value['npack'];
                    $item_data['vsize'] = $value['vsize'];
                    $item_data['vitemtype'] = $value['vitemtype'];
                    $item_data['SID'] = $sid;
                    //   $item_data['updateqoh'] = $value['vitemname'];
                    //   $item_data['itemdiscountvalue'] = $value['vitemname'];
                    //   $item_data['itemdiscounttype'] = $value['vitemname'];
                    //   $item_data['itemtaxrateone'] = $value['vitemname'];
                    //   $item_data['itemtaxratetwo'] = $value['vitemname'];
                    //   $item_data['itemtaxratethree'] = $value['vitemname'];
                    //   $item_data['liabilityamount'] = $value['vitemname'];
                    //   $item_data['preqoh'] = $value['vitemname'];
                    
                    $sql5="Select isalesid,idettrnid, LastUpdate from ".$db.".trn_salesdetail where isalesid = '$isalesid' order by idettrnid desc limit 1";
                    $count_row12 = DB::connection('mysql')->select($sql5);
                    
                    
                    if(!empty($count_row12)){
                        $isalesid_inserted = $count_row12[0]->idettrnid;
                    }
                    
                    if($isalesid_inserted){
                        $isalesid_inserted_incremented = $isalesid_inserted;
                    }
                
                
                    // $isalesid_inserted = $count_row12[0]->idettrnid;
                    
                    if($isalesid_inserted){
                        // dd(121);
                        $isalesid_inserted_id = $isalesid_inserted+1;
                      $sql12 = "INSERT INTO ".$db.".trn_salesdetail SET 
                      vitemname = '" . $item_data['vitemname'] . "', 
                      isalesid = '" . $isalesid . "', 
                      vitemcode = '" . $item_data['vitemcode'] . "', 
                      vcatcode = '" . $item_data['vcatcode'] . "',
                      vcatname = '" . $item_data['vcatname'] . "', 
                      vdepcode = '" . $item_data['vdepcode'] . "', 
                      vdepname = '" . $item_data['vdepname'] . "', 
                      nunitprice = '" . $item_data['nunitprice'] . "', 
                      ncostprice = '" . $item_data['ncostprice'] . "', 
                      ndiscountamt = '" . $item_data['ndiscountamt'] . "', 
                      nsaleprice = '" . $item_data['nsaleprice'] . "', 
                      vunitcode = '" . $item_data['vunitcode'] . "', 
                      vunitname = '" . $item_data['vunitname'] . "', 
                      vuniquetranid = '" . $main_sales_id . "', 
                      idettrnid = '" . $isalesid_inserted_id . "', ereturnitem = '" . $item_data['ereturnitem'] . "', npack = '" . $item_data['npack'] . "', vsize = '" . $item_data['vsize'] . "', vitemtype = '" . $item_data['vitemtype'] . "', `SID` = '" .$item_data['SID'] . "'";
                      DB::connection('mysql')->insert($sql12);
                    }else{
                        $sql12 = "INSERT INTO ".$db.".trn_salesdetail SET vitemname = '" . $item_data['vitemname'] . "', isalesid = '" . $item_data['isalesid'] . "', vitemcode = '" . $item_data['vitemcode'] . "', vcatcode = '" . $item_data['vcatcode'] . "', vcatname = '" . $item_data['vcatname'] . "', vdepcode = '" . $item_data['vdepcode'] . "', vdepname = '" . $item_data['vdepname'] . "', nunitprice = '" . $item_data['nunitprice'] . "', ncostprice = '" . $item_data['ncostprice'] . "', ndiscountamt = '" . $item_data['ndiscountamt'] . "', nsaleprice = '" . $item_data['nsaleprice'] . "', vunitcode = '" . $item_data['vunitcode'] . "', vunitname = '" . $item_data['vunitname'] . "', vuniquetranid = '" . $main_sales_id . "', idettrnid = '" . $item_data['idettrnid'] . "', ereturnitem = '" . $item_data['ereturnitem'] . "', npack = '" . $item_data['npack'] . "', vsize = '" . $item_data['vsize'] . "', vitemtype = '" . $item_data['vitemtype'] . "', `SID` = '" .$item_data['SID'] . "'";
                        DB::connection('mysql')->insert($sql12);
                    }
                                    
                    $item_data['itenerid']= '101';
                    $item_data['isalesid']= $isalesid_inserted;
                    $item_data['vtendername']= 'TestCard';
                    //   $item_data['namount']= '';
                    $item_data['vuniquetranid']= $isalesid_inserted;
                    //   $item_data['impstenderid']= '';
                    $item_data['SID']= $sid;
                      
                    $sql3 = "INSERT INTO ".$db.".trn_salestender SET isalesid = '" . $main_sales_id . "',itenerid = '" . $item_data['itenerid'] . "', vtendername = '" . $item_data['vtendername'] . "', vuniquetranid = '" . $item_data['vuniquetranid'] . "', `SID` = '" .$item_data['SID'] . "'";
                    DB::connection('mysql')->insert($sql3);

                }
                $temp = array();
                $temp['isales_id'] = $isales_id;
                $temp['success'] = 'Successfully Inserted Data!!!';
        
                // return response()->json(['data'=>$temp],200);
                
              return response()->json(['data'=>'Successfully Inserted Data!!!'],200);
              
            } catch (Exception $e) {
               
           } finally {
            //  Resetvalue();
           }
            
            if (isset($input['vTranType']) == "Transaction"){
                
            }
            
    }
    
    public function transactions_void(Request $request){
        // echo "asdfadsf";die;
         $input = Request::all();
        //  echo "<pre>";
        //  print_r($input);
        //  die;
         $db = "u".$input['sid'];
         $sid = $input['sid'];
         $Totalitems = $input['Totalitems'];
         $SubTotal = $input['SubTotal'];
         $tax_total = $input['tax_total'];
        //  $is_tax = $input['is_tax'];
         
         $query_db = 'USE DATABASE '.$db;
         DB::raw($query_db);       
         
            $data = array();
            // $nTaxableTotal = 0.00;
            // $nNonTaxableAmount = 0.00;
            // $liablityAmount = 0.00;
            // $nreturntotal = 0.00;
            // $nreturntax = 0.00;
            // $cashtotal = 0.00;
            // $cashtax = 0.00;
            // $TranId = 0;
            // $nnettotal = 0.00;
            // // nnettotal = Convert.ToDouble(lblNetTotal.Text.Replace('$', ' '));
            // $nproductsale = 0.00;
            // $discountamt = 0.00;
            // // var ip = gblFunction.GETTerminaID();
            // $strTranID = "";
            // $strUniqueTranID = "";
            // // strUniqueTranID = gblFunction.StrUniqueTrnCode();
            // $updateqoh = 0;
            
            if (isset($input['vTranType']) == "Void"){
                $updateqoh = 1;
            }
            
            try {
                $data['isalesid'] = self::StrUniqueGetIDByTable();
                $data['istoreid'] = 101;
                $data['ilogid'] = 0;
                $data['icustomerid'] = 0;
                // $data['vcustomername'] = "";
                $data['vpaymenttype'] = 'TestCard';
                $data['dtrandate'] = date("Y-m-d H:i:s");
                // $data['dentdate'] = "";
                
                // if($is_tax == 'Y'){
                //       $data['ntaxabletotal'] = $tax_total;
                // }else{
                //       $data['nnontaxabletotal'] = $tax_total;    
                // }
                
                
                //   $data['ntaxtotal'] = $input['ntaxtotal'];
                //   $data['nsaletotalamt'] = $input['nsaletotalamt'];
                //   dd($data);
                // $data['tax1taxamount'] = "";
                // $data['tax2taxamount'] = "";
                // $data['tax3taxamount'] = "";
                // $data['nreturntotalamt'] = "";
                // $data['numberofreturns'] = "";
                //   $data['nsubtotal'] = $data['nnontaxabletotal'] + $data['ntaxabletotal'] + $data['ntaxtotal'];
                // $data['ndiscountamt'] = "";
                // $data['buydownamount'] = "";
                // $data['idiscountid'] = "";
                // $data['nchange'] = "";
                $data['vterminalid'] = 101;
                // $data['vdiscountname'] = "";
                $data['vtrntype'] = "Void";
                $data['itemplateid'] = 0;
                // $data['vdiscountname'] = "";
                // $data['vremark'] = "";
                $data['estatus'] = "Open";
                // $data['vzipcode'] = "";
                // $data['vcustphone'] = "";
                $data['vuniquetranid'] = self::StrUniqueGetIDByTable();
                  
                // $data['ttime'] = "";
                // $data['vtablename'] = "";
                $data['ibatchid'] = self::StrUniqueGetIDBatch();
                // $data['vinvoicenumber'] = "";
                // $data['vtransactionnumber'] = "";
                // $data['vmpstenderid'] = "";
                $data['ionaccount'] = 0;
                $data['vtendertype'] = "TestCard";
                $data['ionupload'] = 0;
                // $data['ntotalgasonline'] = "";
                // $data['ntotallottery'] = "";
                // $data['ntotallotteryredeem'] = "";
                //   $data['nnettotal'] = $data['nnontaxabletotal'] + $data['ntaxabletotal'] + $data['ntaxtotal'];
                // $data['ntotalbottledeposit'] = "";
                // $data['ntotalbottledepositredeem'] = "";
                // $data['ntotalbottledepositTax'] = "";
                // $data['ntotalbottledepositredeemTax'] = "";
                // $data['ntotalbottledepositredeemTax'] = "";
                $data['vtransfer'] = 'No';
                $data['SID'] = $input['sid'];
                // $data['kioskid'] = '';
                // $data['iswic'] = '';
                // $data['checkno'] = '';
                // $data['checksdate'] = '';
                // $data['checkedate'] = '';
                // $data['licnumber'] = '';
                // $data['liccustomername'] = '';
                // $data['licaddress'] = '';
                // $data['liccustomerbirthdate'] = '';
                // $data['licexpireddate'] = '';
                $isalesid = $data['isalesid'];
                
                $sql5="Select isalesid ,LastUpdate from ".$db.".trn_sales where isalesid = '$isalesid'";
                $count_row12 = DB::connection('mysql')->select($sql5);
                
                if(!empty($count_row12)){
                    $isalesid_inserted = $count_row12[0]->isalesid;
                }else{
                    $sql = "INSERT INTO ".$db.".trn_sales SET vtransfer = '" . $data['vtransfer'] . "', vtendertype = '" . $data['vtendertype'] . "', ionaccount = '" . $data['ionaccount'] . "', ibatchid = '" . $data['ibatchid'] . "', vuniquetranid = '" . $data['vuniquetranid'] . "', estatus = '" . $data['estatus'] . "', itemplateid = '" . $data['itemplateid'] . "', vtrntype = '" . $data['vtrntype'] . "', vterminalid = '" . $data['vterminalid'] . "', dtrandate = '" . $data['dtrandate'] . "', vpaymenttype = '" . $data['vpaymenttype'] . "', icustomerid = '" . $data['icustomerid'] . "', ilogid = '" . $data['ilogid'] . "', istoreid = '" . $data['istoreid'] . "', isalesid = '" . $data['isalesid'] . "', `SID` = '" .$data['SID'] . "'";
                    DB::connection('mysql')->insert($sql);
                    $sql="Select isalesid ,LastUpdate from ".$db.".trn_sales order by LastUpdate desc limit 1";
                    $count_row = DB::connection('mysql')->select($sql);
                    $isalesid_inserted = $count_row[0]->isalesid;
                
                    $isalesid_inserted_incremented = $isalesid_inserted;

                }
                
                if($isalesid_inserted){
                    $isalesid_inserted_incremented = $isalesid_inserted;
                }
                
                $sku = $input['Items'];
                // $array1 = explode(",", $sku); 
                // $array =implode( ", ", $array1 ); 
                $main_array = array();
                foreach($sku as $loop_data){
                    $sku_loop = $loop_data['SKU'];
                    $sql = "SELECT *  from ".$db.".mst_item where vitemcode = '$sku_loop'";
                    $return_data = DB::connection('mysql')->select($sql);
                    $result = json_decode(json_encode($return_data), true);
                    $main_array[] = $result[0];
                }
                
                foreach($main_array as $value){
                //     echo "<pre>";
                // print_r($value);
                    $item_data['vitemname'] = $value['vitemname'];
                    $item_data['vitemcode'] = $value['vitemcode'];
                    $vcatcode = $value['vcategorycode'];
                    $item_data['vcatcode'] = $value['vcategorycode'];
                    $sql1 = "SELECT *  from ".$db.".mst_category where vcategorycode IN ($vcatcode)";
                    $return_data = DB::connection('mysql')->select($sql1);
                    $result1 = json_decode(json_encode($return_data), true);
                    
                    $item_data['vcatname'] = $result1[0]['vcategoryname'];
                    $item_data['vdepcode'] = $value['vdepcode'];
                    $vdepcode = $value['vdepcode'];
                    $sql2 = "SELECT *  from ".$db.".mst_department where vdepcode IN ($vdepcode)";
                    $return_data1 = DB::connection('mysql')->select($sql2);
                    $result2 = json_decode(json_encode($return_data1), true);
                    $item_data['vdepname'] = $result2[0]['vdepartmentname'];
                    //   $item_data['ndebitqty'] = $value['vitemname'];
                    //   $item_data['ncreditqty'] = $value['vitemname'];
                    $item_data['nunitprice'] = $value['dunitprice'];
                    $item_data['ncostprice'] = $value['nunitcost'];
                    //   $item_data['nextunitprice'] = $value['vitemname'];
                    //   $item_data['nextcostprice'] = $value['vitemname'];
                    //   $item_data['ndebitamt'] = $value['vitemname'];
                    //   $item_data['ncreditamt'] = $value['vitemname'];
                    $item_data['ndiscountamt'] = $value['ndiscountamt'];
                    //   $item_data['buydownamount'] = $value['vitemname'];
                    //   $item_data['nsaleamt'] = $value['vitemname'];
                    $item_data['nsaleprice'] = $value['nsaleprice'];
                    //   $item_data['vtax'] = $value['vitemname'];
                    $item_data['vunitcode'] = $value['vunitcode'];
                    $item_data['vunitname'] = 'Each';
                    // $item_data['vreason'] = '';
                    // $item_data['vadjtype'] = '';
                    $item_data['isalesid'] = $isalesid_inserted;
                    $item_data['vuniquetranid'] = $isalesid_inserted;
                    // $incremented_id = $item_data['vuniquetranid'];
                    $item_data['idettrnid'] = $isalesid_inserted_incremented;
                    $isalesid_inserted_incremented++;
                    $item_data['ereturnitem'] = 'No';
                    //   $item_data['nitemtax'] = $value['vitemname'];
                    //   $item_data['iunitqty'] = $value['vitemname'];
                    $item_data['npack'] = $value['npack'];
                    $item_data['vsize'] = $value['vsize'];
                    $item_data['vitemtype'] = $value['vitemtype'];
                    $item_data['SID'] = $sid;
                    //   $item_data['updateqoh'] = $value['vitemname'];
                    //   $item_data['itemdiscountvalue'] = $value['vitemname'];
                    //   $item_data['itemdiscounttype'] = $value['vitemname'];
                    //   $item_data['itemtaxrateone'] = $value['vitemname'];
                    //   $item_data['itemtaxratetwo'] = $value['vitemname'];
                    //   $item_data['itemtaxratethree'] = $value['vitemname'];
                    //   $item_data['liabilityamount'] = $value['vitemname'];
                    //   $item_data['preqoh'] = $value['vitemname'];
                    
                $sql5="Select isalesid,idettrnid, LastUpdate from u1001.trn_salesdetail where isalesid = '$isalesid' order by idettrnid desc limit 1";
                $count_row12 = DB::connection('mysql')->select($sql5);
                
                
                if(!empty($count_row12)){
                    $isalesid_inserted = $count_row12[0]->idettrnid;
                }
                
                if($isalesid_inserted){
                    $isalesid_inserted_incremented = $isalesid_inserted;
                }
                
                
                // $isalesid_inserted = $count_row12[0]->idettrnid;
                
                if($isalesid_inserted){
                    $isalesid_inserted_id = $isalesid_inserted+1;
                  $sql12 = "INSERT INTO ".$db.".trn_salesdetail SET 
                  vitemname = '" . $item_data['vitemname'] . "', 
                  isalesid = '" . $isalesid . "', 
                  vitemcode = '" . $item_data['vitemcode'] . "', 
                  vcatcode = '" . $item_data['vcatcode'] . "',
                  vcatname = '" . $item_data['vcatname'] . "', 
                  vdepcode = '" . $item_data['vdepcode'] . "', 
                  vdepname = '" . $item_data['vdepname'] . "', 
                  nunitprice = '" . $item_data['nunitprice'] . "', 
                  ncostprice = '" . $item_data['ncostprice'] . "', 
                  ndiscountamt = '" . $item_data['ndiscountamt'] . "', 
                  nsaleprice = '" . $item_data['nsaleprice'] . "', 
                  vunitcode = '" . $item_data['vunitcode'] . "', 
                  vunitname = '" . $item_data['vunitname'] . "', 
                  vuniquetranid = '" . $isalesid . "', 
                  idettrnid = '" . $isalesid_inserted_id . "', ereturnitem = '" . $item_data['ereturnitem'] . "', npack = '" . $item_data['npack'] . "', vsize = '" . $item_data['vsize'] . "', vitemtype = '" . $item_data['vitemtype'] . "', `SID` = '" .$item_data['SID'] . "'";
                  DB::connection('mysql')->insert($sql12);
                }else{
                    $sql12 = "INSERT INTO ".$db.".trn_salesdetail SET vitemname = '" . $item_data['vitemname'] . "', isalesid = '" . $item_data['isalesid'] . "', vitemcode = '" . $item_data['vitemcode'] . "', vcatcode = '" . $item_data['vcatcode'] . "', vcatname = '" . $item_data['vcatname'] . "', vdepcode = '" . $item_data['vdepcode'] . "', vdepname = '" . $item_data['vdepname'] . "', nunitprice = '" . $item_data['nunitprice'] . "', ncostprice = '" . $item_data['ncostprice'] . "', ndiscountamt = '" . $item_data['ndiscountamt'] . "', nsaleprice = '" . $item_data['nsaleprice'] . "', vunitcode = '" . $item_data['vunitcode'] . "', vunitname = '" . $item_data['vunitname'] . "', vuniquetranid = '" . $item_data['vuniquetranid'] . "', idettrnid = '" . $item_data['idettrnid'] . "', ereturnitem = '" . $item_data['ereturnitem'] . "', npack = '" . $item_data['npack'] . "', vsize = '" . $item_data['vsize'] . "', vitemtype = '" . $item_data['vitemtype'] . "', `SID` = '" .$item_data['SID'] . "'";
                    DB::connection('mysql')->insert($sql12);
                }
                                
                  $item_data['itenerid']= '101';
                  $item_data['isalesid']= $isalesid_inserted;
                  $item_data['vtendername']= 'TestCard';
                //   $item_data['namount']= '';
                  $item_data['vuniquetranid']= $isalesid_inserted;
                //   $item_data['impstenderid']= '';
                  $item_data['SID']= $sid;
                  
                  $sql3 = "INSERT INTO ".$db.".trn_salestender SET isalesid = '" . $item_data['isalesid'] . "',itenerid = '" . $item_data['itenerid'] . "', vtendername = '" . $item_data['vtendername'] . "', vuniquetranid = '" . $item_data['vuniquetranid'] . "', `SID` = '" .$item_data['SID'] . "'";
                  DB::connection('mysql')->insert($sql3);

                }
              return response()->json(['data'=>'Successfully Deleted Items!!!'],200);
              
            } catch (Exception $e) {
               
           } finally {
            //  Resetvalue();
           }
            
            if (isset($input['vTranType']) == "Transaction"){
                
            }
            
    }
    
    public function transactions_sales_id(Request $request){
        // echo "asdfadsf";die;
         $input = Request::all();
        //  echo "<pre>";
        //  print_r($input);
        //  die;
         $db = "u".$input['sid'];
         $sid = $input['sid'];
         $Totalitems = $input['Totalitems'];
         $SubTotal = $input['SubTotal'];
         $tax_total = $input['tax_total'];
        //  $is_tax = $input['is_tax'];
         
         $query_db = 'USE DATABASE '.$db;
         DB::raw($query_db);       
         
            $data = array();
            // $nTaxableTotal = 0.00;
            // $nNonTaxableAmount = 0.00;
            // $liablityAmount = 0.00;
            // $nreturntotal = 0.00;
            // $nreturntax = 0.00;
            // $cashtotal = 0.00;
            // $cashtax = 0.00;
            // $TranId = 0;
            // $nnettotal = 0.00;
            // // nnettotal = Convert.ToDouble(lblNetTotal.Text.Replace('$', ' '));
            // $nproductsale = 0.00;
            // $discountamt = 0.00;
            // // var ip = gblFunction.GETTerminaID();
            // $strTranID = "";
            // $strUniqueTranID = "";
            // // strUniqueTranID = gblFunction.StrUniqueTrnCode();
            // $updateqoh = 0;
            
            if (isset($input['vTranType']) == "Void"){
                $updateqoh = 1;
            }
            
            try {
                $data['isalesid'] = self::StrUniqueGetIDByTable();
                $data['istoreid'] = 101;
                $data['ilogid'] = 0;
                $data['icustomerid'] = 0;
                // $data['vcustomername'] = "";
                $data['vpaymenttype'] = 'TestCard';
                $data['dtrandate'] = date("Y-m-d H:i:s");
                // $data['dentdate'] = "";
                
                // if($is_tax == 'Y'){
                //       $data['ntaxabletotal'] = $tax_total;
                // }else{
                //       $data['nnontaxabletotal'] = $tax_total;    
                // }
                
                
                //   $data['ntaxtotal'] = $input['ntaxtotal'];
                //   $data['nsaletotalamt'] = $input['nsaletotalamt'];
                //   dd($data);
                // $data['tax1taxamount'] = "";
                // $data['tax2taxamount'] = "";
                // $data['tax3taxamount'] = "";
                // $data['nreturntotalamt'] = "";
                // $data['numberofreturns'] = "";
                //   $data['nsubtotal'] = $data['nnontaxabletotal'] + $data['ntaxabletotal'] + $data['ntaxtotal'];
                // $data['ndiscountamt'] = "";
                // $data['buydownamount'] = "";
                // $data['idiscountid'] = "";
                // $data['nchange'] = "";
                $data['vterminalid'] = 101;
                // $data['vdiscountname'] = "";
                $data['vtrntype'] = "Transaction";
                $data['itemplateid'] = 0;
                // $data['vdiscountname'] = "";
                // $data['vremark'] = "";
                $data['estatus'] = "Open";
                // $data['vzipcode'] = "";
                // $data['vcustphone'] = "";
                $data['vuniquetranid'] = self::StrUniqueGetIDByTable();
                  
                // $data['ttime'] = "";
                // $data['vtablename'] = "";
                $data['ibatchid'] = self::StrUniqueGetIDBatch();
                // $data['vinvoicenumber'] = "";
                // $data['vtransactionnumber'] = "";
                // $data['vmpstenderid'] = "";
                $data['ionaccount'] = 0;
                $data['vtendertype'] = "TestCard";
                $data['ionupload'] = 0;
                // $data['ntotalgasonline'] = "";
                // $data['ntotallottery'] = "";
                // $data['ntotallotteryredeem'] = "";
                //   $data['nnettotal'] = $data['nnontaxabletotal'] + $data['ntaxabletotal'] + $data['ntaxtotal'];
                // $data['ntotalbottledeposit'] = "";
                // $data['ntotalbottledepositredeem'] = "";
                // $data['ntotalbottledepositTax'] = "";
                // $data['ntotalbottledepositredeemTax'] = "";
                // $data['ntotalbottledepositredeemTax'] = "";
                $data['vtransfer'] = 'No';
                $data['SID'] = $input['sid'];
                // $data['kioskid'] = '';
                // $data['iswic'] = '';
                // $data['checkno'] = '';
                // $data['checksdate'] = '';
                // $data['checkedate'] = '';
                // $data['licnumber'] = '';
                // $data['liccustomername'] = '';
                // $data['licaddress'] = '';
                // $data['liccustomerbirthdate'] = '';
                // $data['licexpireddate'] = '';
                $isalesid = $data['isalesid'];
                
                $sql5="Select isalesid ,LastUpdate from ".$db.".trn_sales where isalesid = '$isalesid'";
                $count_row12 = DB::connection('mysql')->select($sql5);
                
                if(!empty($count_row12)){
                    $isalesid_inserted = $count_row12[0]->isalesid;
                }else{
                    $sql = "INSERT INTO ".$db.".trn_sales SET vtransfer = '" . $data['vtransfer'] . "', vtendertype = '" . $data['vtendertype'] . "', ionaccount = '" . $data['ionaccount'] . "', ibatchid = '" . $data['ibatchid'] . "', vuniquetranid = '" . $data['vuniquetranid'] . "', estatus = '" . $data['estatus'] . "', itemplateid = '" . $data['itemplateid'] . "', vtrntype = '" . $data['vtrntype'] . "', vterminalid = '" . $data['vterminalid'] . "', dtrandate = '" . $data['dtrandate'] . "', vpaymenttype = '" . $data['vpaymenttype'] . "', icustomerid = '" . $data['icustomerid'] . "', ilogid = '" . $data['ilogid'] . "', istoreid = '" . $data['istoreid'] . "', isalesid = '" . $data['isalesid'] . "', `SID` = '" .$data['SID'] . "'";
                    DB::connection('mysql')->insert($sql);
                    $sql="Select isalesid ,LastUpdate from ".$db.".trn_sales order by LastUpdate desc limit 1";
                    $count_row = DB::connection('mysql')->select($sql);
                    $isalesid_inserted = $count_row[0]->isalesid;
                
                    $isalesid_inserted_incremented = $isalesid_inserted;

                }
                
                if($isalesid_inserted){
                    $isalesid_inserted_incremented = $isalesid_inserted;
                }
                
                $sku = $input['Items'];
                // $array1 = explode(",", $sku); 
                // $array =implode( ", ", $array1 ); 
                $main_array = array();
                foreach($sku as $loop_data){
                    $sku_loop = $loop_data['SKU'];
                    $sql = "SELECT *  from ".$db.".mst_item where vitemcode = '$sku_loop'";
                    $return_data = DB::connection('mysql')->select($sql);
                    $result = json_decode(json_encode($return_data), true);
                    $main_array[] = $result[0];
                }
                
                foreach($main_array as $value){
                //     echo "<pre>";
                // print_r($value);
                    $item_data['vitemname'] = $value['vitemname'];
                    $item_data['vitemcode'] = $value['vitemcode'];
                    $vcatcode = $value['vcategorycode'];
                    $item_data['vcatcode'] = $value['vcategorycode'];
                    $sql1 = "SELECT *  from ".$db.".mst_category where vcategorycode IN ($vcatcode)";
                    $return_data = DB::connection('mysql')->select($sql1);
                    $result1 = json_decode(json_encode($return_data), true);
                    
                    $item_data['vcatname'] = $result1[0]['vcategoryname'];
                    $item_data['vdepcode'] = $value['vdepcode'];
                    $vdepcode = $value['vdepcode'];
                    $sql2 = "SELECT *  from ".$db.".mst_department where vdepcode IN ($vdepcode)";
                    $return_data1 = DB::connection('mysql')->select($sql2);
                    $result2 = json_decode(json_encode($return_data1), true);
                    $item_data['vdepname'] = $result2[0]['vdepartmentname'];
                    //   $item_data['ndebitqty'] = $value['vitemname'];
                    //   $item_data['ncreditqty'] = $value['vitemname'];
                    $item_data['nunitprice'] = $value['dunitprice'];
                    $item_data['ncostprice'] = $value['nunitcost'];
                    //   $item_data['nextunitprice'] = $value['vitemname'];
                    //   $item_data['nextcostprice'] = $value['vitemname'];
                    //   $item_data['ndebitamt'] = $value['vitemname'];
                    //   $item_data['ncreditamt'] = $value['vitemname'];
                    $item_data['ndiscountamt'] = $value['ndiscountamt'];
                    //   $item_data['buydownamount'] = $value['vitemname'];
                    //   $item_data['nsaleamt'] = $value['vitemname'];
                    $item_data['nsaleprice'] = $value['nsaleprice'];
                    //   $item_data['vtax'] = $value['vitemname'];
                    $item_data['vunitcode'] = $value['vunitcode'];
                    $item_data['vunitname'] = 'Each';
                    // $item_data['vreason'] = '';
                    // $item_data['vadjtype'] = '';
                    $item_data['isalesid'] = $isalesid_inserted;
                    $item_data['vuniquetranid'] = $isalesid_inserted;
                    // $incremented_id = $item_data['vuniquetranid'];
                    $item_data['idettrnid'] = $isalesid_inserted_incremented;
                    $isalesid_inserted_incremented++;
                    $item_data['ereturnitem'] = 'No';
                    //   $item_data['nitemtax'] = $value['vitemname'];
                    //   $item_data['iunitqty'] = $value['vitemname'];
                    $item_data['npack'] = $value['npack'];
                    $item_data['vsize'] = $value['vsize'];
                    $item_data['vitemtype'] = $value['vitemtype'];
                    $item_data['SID'] = $sid;
                    //   $item_data['updateqoh'] = $value['vitemname'];
                    //   $item_data['itemdiscountvalue'] = $value['vitemname'];
                    //   $item_data['itemdiscounttype'] = $value['vitemname'];
                    //   $item_data['itemtaxrateone'] = $value['vitemname'];
                    //   $item_data['itemtaxratetwo'] = $value['vitemname'];
                    //   $item_data['itemtaxratethree'] = $value['vitemname'];
                    //   $item_data['liabilityamount'] = $value['vitemname'];
                    //   $item_data['preqoh'] = $value['vitemname'];
                    
                $sql5="Select isalesid,idettrnid, LastUpdate from u1001.trn_salesdetail where isalesid = '$isalesid' order by idettrnid desc limit 1";
                $count_row12 = DB::connection('mysql')->select($sql5);
                
                
                if(!empty($count_row12)){
                    $isalesid_inserted = $count_row12[0]->idettrnid;
                }
                
                if($isalesid_inserted){
                    $isalesid_inserted_incremented = $isalesid_inserted;
                }
                
                
                // $isalesid_inserted = $count_row12[0]->idettrnid;
                
                if($isalesid_inserted){
                    $isalesid_inserted_id = $isalesid_inserted+1;
                  $sql12 = "INSERT INTO ".$db.".trn_salesdetail SET 
                  vitemname = '" . $item_data['vitemname'] . "', 
                  isalesid = '" . $isalesid . "', 
                  vitemcode = '" . $item_data['vitemcode'] . "', 
                  vcatcode = '" . $item_data['vcatcode'] . "',
                  vcatname = '" . $item_data['vcatname'] . "', 
                  vdepcode = '" . $item_data['vdepcode'] . "', 
                  vdepname = '" . $item_data['vdepname'] . "', 
                  nunitprice = '" . $item_data['nunitprice'] . "', 
                  ncostprice = '" . $item_data['ncostprice'] . "', 
                  ndiscountamt = '" . $item_data['ndiscountamt'] . "', 
                  nsaleprice = '" . $item_data['nsaleprice'] . "', 
                  vunitcode = '" . $item_data['vunitcode'] . "', 
                  vunitname = '" . $item_data['vunitname'] . "', 
                  vuniquetranid = '" . $isalesid . "', 
                  idettrnid = '" . $isalesid_inserted_id . "', ereturnitem = '" . $item_data['ereturnitem'] . "', npack = '" . $item_data['npack'] . "', vsize = '" . $item_data['vsize'] . "', vitemtype = '" . $item_data['vitemtype'] . "', `SID` = '" .$item_data['SID'] . "'";
                  DB::connection('mysql')->insert($sql12);
                }else{
                    $sql12 = "INSERT INTO ".$db.".trn_salesdetail SET vitemname = '" . $item_data['vitemname'] . "', isalesid = '" . $item_data['isalesid'] . "', vitemcode = '" . $item_data['vitemcode'] . "', vcatcode = '" . $item_data['vcatcode'] . "', vcatname = '" . $item_data['vcatname'] . "', vdepcode = '" . $item_data['vdepcode'] . "', vdepname = '" . $item_data['vdepname'] . "', nunitprice = '" . $item_data['nunitprice'] . "', ncostprice = '" . $item_data['ncostprice'] . "', ndiscountamt = '" . $item_data['ndiscountamt'] . "', nsaleprice = '" . $item_data['nsaleprice'] . "', vunitcode = '" . $item_data['vunitcode'] . "', vunitname = '" . $item_data['vunitname'] . "', vuniquetranid = '" . $item_data['vuniquetranid'] . "', idettrnid = '" . $item_data['idettrnid'] . "', ereturnitem = '" . $item_data['ereturnitem'] . "', npack = '" . $item_data['npack'] . "', vsize = '" . $item_data['vsize'] . "', vitemtype = '" . $item_data['vitemtype'] . "', `SID` = '" .$item_data['SID'] . "'";
                    DB::connection('mysql')->insert($sql12);
                }
                                
                  $item_data['itenerid']= '101';
                  $item_data['isalesid']= $isalesid_inserted;
                  $item_data['vtendername']= 'TestCard';
                //   $item_data['namount']= '';
                  $item_data['vuniquetranid']= $isalesid_inserted;
                //   $item_data['impstenderid']= '';
                  $item_data['SID']= $sid;
                  
                  $sql3 = "INSERT INTO ".$db.".trn_salestender SET isalesid = '" . $item_data['isalesid'] . "',itenerid = '" . $item_data['itenerid'] . "', vtendername = '" . $item_data['vtendername'] . "', vuniquetranid = '" . $item_data['vuniquetranid'] . "', `SID` = '" .$item_data['SID'] . "'";
                  DB::connection('mysql')->insert($sql3);

                }
              return response()->json(['data'=>'Successfully Deleted Items!!!'],200);
              
            } catch (Exception $e) {
               
           } finally {
            //  Resetvalue();
           }
            
            if (isset($input['vTranType']) == "Transaction"){
                
            }
            
    }
    
    public function transactions_sales_id1(Request $request){
        // echo "asdfadsf";die;
         $input = Request::all();
        //  echo "<pre>";
        //  print_r($input);
        //  die;
         $db = "u".$input['sid'];
         $sid = $input['sid'];
         $Totalitems = $input['Totalitems'];
         $SubTotal = $input['SubTotal'];
         $tax_total = $input['tax_total'];
        //  $is_tax = $input['is_tax'];
        $iuserid = $input['iuserid'];
         
        $sql_mst_store="Select * from ".$db.".mst_store where SID = '$sid'";
        $count_row_mst_store = DB::connection('mysql')->select($sql_mst_store);
        $istoreid = $count_row_mst_store[0]->istoreid;
        $vstorename = $count_row_mst_store[0]->vstorename;
        $login_id = 0;
        
        $sql_mst_user="Select * from inslocdb.store_mw_users where iuserid = '$iuserid'";
        $count_row_mst_user = DB::connection('mysql')->select($sql_mst_user);
        $vfname = $count_row_mst_user[0]->fname;
         
         $query_db = 'USE DATABASE '.$db;
         DB::raw($query_db);       
         
            $data = array();
            // $nTaxableTotal = 0.00;
            // $nNonTaxableAmount = 0.00;
            // $liablityAmount = 0.00;
            // $nreturntotal = 0.00;
            // $nreturntax = 0.00;
            // $cashtotal = 0.00;
            // $cashtax = 0.00;
            // $TranId = 0;
            // $nnettotal = 0.00;
            // // nnettotal = Convert.ToDouble(lblNetTotal.Text.Replace('$', ' '));
            // $nproductsale = 0.00;
            // $discountamt = 0.00;
            // // var ip = gblFunction.GETTerminaID();
            // $strTranID = "";
            // $strUniqueTranID = "";
            // // strUniqueTranID = gblFunction.StrUniqueTrnCode();
            // $updateqoh = 0;
            
            if (isset($input['vTranType']) == "Void"){
                $updateqoh = 1;
            }
            
            try {
                $data['isalesid'] = self::StrUniqueGetIDByTable();
                $data['istoreid'] = $istoreid;
                $data['icustomerid'] = $login_id;
                $data['vstorename'] = $vstorename;
                $data['iuserid'] = $iuserid;
                $data['vusername'] = $vfname;
                $data['ilogid'] = 0;
                $data['vpaymenttype'] = 'TestCard';
                $data['dtrandate'] = date("Y-m-d H:i:s");
                $data['vterminalid'] = 101;
                $data['vtrntype'] = "Transaction";
                $data['estatus'] = "Open";
                $data['vuniquetranid'] = self::StrUniqueGetIDByTable();
                $data['ibatchid'] = self::StrUniqueGetIDBatch();
                $data['vtendertype'] = "TestCard";
                $data['SID'] = $input['sid'];
                $isalesid = $data['isalesid'];
                $year = date("Y");
                $year = substr( $year, -2);
                $month = date("m");
                $date = date("d");
                $dmy = $year.$month.$date;
                
                $sql5="select isalesid ,LastUpdate from ".$db.".trn_sales where date(dtrandate)='$dmy' order by isalesid desc limit 1;";
                $count_row12 = DB::connection('mysql')->select($sql5);
                
                if(!empty($count_row12)){
                    $incrementedisalesid = $count_row12[0]->isalesid + 1;
                    $sql = "INSERT INTO ".$db.".trn_sales SET 
                    iuserid = '" . $data['iuserid'] . "', 
                    vusername = '" . $data['vusername'] . "', 
                    vstorename = '" . $data['vstorename'] . "', 
                    vtendertype = '" . $data['vtendertype'] . "', 
                    ibatchid = '" . $data['ibatchid'] . "', 
                    vuniquetranid = '" . $data['vuniquetranid'] . "', 
                    estatus = '" . $data['estatus'] . "', 
                    vtrntype = '" . $data['vtrntype'] . "', 
                    vterminalid = '" . $data['vterminalid'] . "', 
                    dtrandate = '" . $data['dtrandate'] . "', 
                    vpaymenttype = '" . $data['vpaymenttype'] . "', 
                    icustomerid = '" . $data['icustomerid'] . "', 
                    ilogid = '" . $data['ilogid'] . "', 
                    istoreid = '" . $data['istoreid'] . "', 
                    isalesid = '" . $incrementedisalesid. "', 
                    `SID` = '" .$data['SID'] . "'";
                    DB::connection('mysql')->insert($sql);
                    
                    $sql="Select isalesid ,LastUpdate from ".$db.".trn_sales order by LastUpdate desc limit 1";
                    $count_row = DB::connection('mysql')->select($sql);
                    $isalesid_inserted = $count_row[0]->isalesid;
                    $isalesid_inserted_incremented = $isalesid_inserted;
                }else{
                    $sql = "INSERT INTO ".$db.".trn_sales SET 
                    iuserid = '" . $data['iuserid'] . "', 
                    vusername = '" . $data['vusername'] . "', 
                    vstorename = '" . $data['vstorename'] . "', 
                    vtendertype = '" . $data['vtendertype'] . "', 
                    ibatchid = '" . $data['ibatchid'] . "', 
                    vuniquetranid = '" . $data['vuniquetranid'] . "', 
                    estatus = '" . $data['estatus'] . "', 
                    vtrntype = '" . $data['vtrntype'] . "', 
                    vterminalid = '" . $data['vterminalid'] . "', 
                    dtrandate = '" . $data['dtrandate'] . "', 
                    vpaymenttype = '" . $data['vpaymenttype'] . "', 
                    icustomerid = '" . $data['icustomerid'] . "', 
                    ilogid = '" . $data['ilogid'] . "', 
                    istoreid = '" . $data['istoreid'] . "', 
                    isalesid = '" . $data['isalesid'] . "', 
                    `SID` = '" .$data['SID'] . "'";
                    DB::connection('mysql')->insert($sql);
                    $sql="Select isalesid ,LastUpdate from ".$db.".trn_sales order by LastUpdate desc limit 1";
                    $count_row = DB::connection('mysql')->select($sql);
                    $isalesid_inserted = $count_row[0]->isalesid;
                
                    $isalesid_inserted_incremented = $isalesid_inserted;

                }
                
                $isales_id = $isalesid_inserted;
                $main_isales_id = $isalesid_inserted;
                
                if($isalesid_inserted){
                    $isalesid_inserted_incremented = $isalesid_inserted;
                }
                
                $sku = $input['Items'];
                // dd($sku);
                $main_array = array();
                
                for($i=0; $i<count($sku); $i++){
                    $sku_loop = $sku[$i]['SKU'];
                    
                    if($sku[$i]['tax'] == 'Y'){
                        $taxable[] = $sku[$i]['qty'] * $sku[$i]['price'];
                    }else{
                        $nontaxable[] = $sku[$i]['qty'] * $sku[$i]['price'];
                    }
                     $sql = "SELECT *  from ".$db.".mst_item where vitemcode = '$sku_loop'";
                    $return_data = DB::connection('mysql')->select($sql);
                    $result = json_decode(json_encode($return_data), true);
                    $main_array[] = $result[0];
                }
                
                $totaltaxable = array_sum($taxable);
                $nontotaltaxable = array_sum($nontaxable);
                
                // for($a=0; $a<count($taxable); $a++){
                //     // dd($taxable[$a]);    
                //     $totaltaxable = array_sum($taxable[$a]);
                // }
                
                // $ntaxabletotal = number_format($totaltaxable,2);
                // $nnontaxabletotal = number_format($nontotaltaxable,2);
                
                
                // $taxable_cal = array();
                // foreach($sku as $loop_data){
                //     $sku_loop = $loop_data['SKU'];
                //     $tax_loop = $loop_data['tax'];
                //     $qty_loop = $loop_data['qty'];
                //     $price_loop = $loop_data['price'];
                    
                    
                    
                    // if($tax_loop == 'Y'){
                    //      $taxable_cal[] = $price_loop;
                    //     $ntaxabletotal = array_sum($taxable_cal);
                    // }else{
                    //     $nontaxable_cal[] = $price_loop;
                    //     $nnontaxabletotal = array_sum($nontaxable_cal);
                    // }
                    
                //     if($sku_loop == '1'){
                //         $bottle_deposit[] = $price_loop;
                //     }else {
                //         $bottle_deposit = 0.00;
                //     }
                    
                //     if($sku_loop == '10'){
                //         $bottle_deposit_redeem[] = $price_loop;
                //     }else{
                //         $bottle_deposit_redeem = 0.00;
                //     }
                    
                //     if($sku_loop == '20'){
                //         $ntotallottery[] = $price_loop;
                //     }else{
                //         $ntotallottery = 0.00;
                //     }
                    
                //     if($sku_loop == '6' && $sku_loop == '22'){
                //         $ntotallotteryredeem[] = $price_loop;
                //     }else{
                //         $ntotallotteryredeem = 0.00;
                //     }
                    
                //     if($qty_loop < 0){
                //         $nreturntotalamt[] = $price_loop;
                //     }else{
                //         $nreturntotalamt = 0.00;
                //     }
                    
                //     if($data['vtendertype'] == 'On Account'){
                //         $ionaccount = 1;
                //     }else{
                //         $ionaccount = 0;
                //     }
                    
                //     if($data['vtendertype'] == 'On Account' && $data['vtendertype'] == 'Cash'){
                //         $ionupload = 1;
                //     }else{
                //         $ionupload = 0;
                //     }

                //     $price_add[] = $price_loop;
                //     $qty_add[] = $qty_loop;
                    
                    
                    // $sql = "SELECT *  from ".$db.".mst_item where vitemcode = '$sku_loop'";
                    // $return_data = DB::connection('mysql')->select($sql);
                    // $result = json_decode(json_encode($return_data), true);
                    // $main_array[] = $result[0];
                // }
                // die;
                
                $ntaxabletotal = 0.00;
                // echo "---------------------------";
                $nnontaxabletotal = 0.00;
                
                // print_r($nontaxable_cal);die;
                // dd($qty_add);
                $sql="Select isalesid ,LastUpdate from ".$db.".trn_sales order by LastUpdate desc limit 1";
                $count_row = DB::connection('mysql')->select($sql);
                $isalesid_inserted = $count_row[0]->isalesid;
                
                foreach($sku as $loop){
                    $sku_loop = $loop['SKU'];
                    $sql = "SELECT *  from ".$db.".mst_item where vitemcode = '$sku_loop'";
                    $return_data = DB::connection('mysql')->select($sql);
                    $result = json_decode(json_encode($return_data), true);
                    // print_r($result);die;
                    $main_array[] = $result[0];
                }
                    
                
                // $bottle_deposit_redeem = 0.00;
                // $taxable_cal = 0.00;
                // $nontaxable_cal = 0.00;
                // $bottle_deposit = 0.00;
                $ntotallottery = 0.00;
                $ntotallotteryredeem = 0.00;
                $nreturntotalamt = 0.00;
                $ionaccount = 0.00;
                $ionupload = 0.00;
                $nsubtotal = 0.00;
                $nnettotal = 0.00;
                $numberofreturns = 0.00;
                // $ntaxabletotal = 0.00;
                // $nnontaxabletotal = 0.00;
                $ntaxtotal = 0.00;
                $ntotalgasoline = 0.00;
                $buydownamount = 0.00;
                $ntotalbottledeposit = 0.00;
                $ntotalbottledepositredeem = 0.00;
                $ntotalbottledepositTax = 0.00;
                $ntotalbottledepositredeemTax = 0.00;
                

                // $bottle_deposit_redeem = $bottle_deposit_redeem;
                // $bottle_deposit = $bottle_deposit;
                // $ntotallottery = $ntotallottery;
                // $ntotallotteryredeem = $ntotallotteryredeem;
                // $nreturntotalamt = $nreturntotalamt;
                // $ionaccount = $ionaccount;
                // $ionupload = $ionupload;
                // $nsubtotal = array_sum($price_add);
                // $nnettotal = array_sum($price_add);
                // $numberofreturns = array_sum($qty_add);
                // $ntaxtotal = array_sum($price_add);;
                // // $nsaletotalamt = '';
                // // $ilogid = '';
                // // $icustomerid = '';
                // // $vcustomername = '';
                // // $dentdate = '';
                // $ntotalgasoline = 0.00;
                // // $tax1taxamount = '';
                // // $tax2taxamount = '';
                // // $tax3taxamount = '';
                // $buydownamount = 0.00;
                // // $vdiscountname = '';
                // // $itemplateid = ''; 
                // // $vzipcode = '';
                // // $vcustphone = '';
                // // $ttime = '';
                // // $vtablename = '';
                // // $vinvoicenumber = '';
                // // $vtransactionnumber = '';
                // // $vmpstenderid = '';
                // // $ndiscountamt = '';
                // $ntotalbottledeposit = $bottle_deposit;
                // $ntotalbottledepositredeem = $bottle_deposit_redeem;
                // $ntotalbottledepositTax = '0.00';
                // $ntotalbottledepositredeemTax = '0.00';
                // // $vtransfer = '';
                // // $kioskid = '';
                // // $iswic = '';
                // // $checkno = '';
                // // $checksdate = '';
                // // $licnumber = '';
                // // $liccustomername = '';
                // // $licaddress = '';
                // // $liccustomerbirthdate = '';
                // // $licexpireddate = '';
                // // $new_cost = '';
                
                
                $sql28= "UPDATE ".$db.".trn_sales SET 
                ntotalbottledepositredeemTax = $ntotalbottledepositredeemTax, 
                ntotalbottledepositTax= $ntotalbottledepositTax,
                ntotalbottledepositredeem= $ntotalbottledepositredeem,
                ntotalbottledeposit= $ntotalbottledeposit,
                buydownamount= $buydownamount,
                ntotalgasoline= $ntotalgasoline,
                ntaxtotal= $ntaxtotal,
                ntaxabletotal= $ntaxabletotal,
                numberofreturns= $numberofreturns,
                nnettotal= $nnettotal,
                nsubtotal= $nsubtotal,
                ionupload= $ionupload,
                ionaccount= $ionaccount,
                nreturntotalamt= $nreturntotalamt,
                ntotallotteryredeem= $ntotallotteryredeem,
                ntotallottery= $ntotallottery
                WHERE isalesid = $isalesid_inserted";
                
                DB::connection('mysql')->update($sql28);
                
                $main_sales_id = $isalesid_inserted;
                
                foreach($main_array as $value){
                    $item_data['vitemname'] = $value['vitemname'];
                    $item_data['vitemcode'] = $value['vitemcode'];
                    $vcatcode = $value['vcategorycode'];
                    $item_data['vcatcode'] = $value['vcategorycode'];
                    $sql1 = "SELECT *  from ".$db.".mst_category where vcategorycode IN ($vcatcode)";
                    $return_data = DB::connection('mysql')->select($sql1);
                    $result1 = json_decode(json_encode($return_data), true);
                    
                    $item_data['vcatname'] = $result1[0]['vcategoryname'];
                    $item_data['vdepcode'] = $value['vdepcode'];
                    $vdepcode = $value['vdepcode'];
                    $sql2 = "SELECT *  from ".$db.".mst_department where vdepcode IN ($vdepcode)";
                    $return_data1 = DB::connection('mysql')->select($sql2);
                    $result2 = json_decode(json_encode($return_data1), true);
                    $item_data['vdepname'] = $result2[0]['vdepartmentname'];
                    $item_data['nunitprice'] = $value['dunitprice'];
                    $item_data['ncostprice'] = $value['nunitcost'];
                    $item_data['ndiscountamt'] = $value['ndiscountamt'];
                    $item_data['nsaleprice'] = $value['nsaleprice'];
                    $item_data['vunitcode'] = $value['vunitcode'];
                    $item_data['vunitname'] = 'Each';
                    $item_data['isalesid'] = $main_isales_id;
                    $item_data['vuniquetranid'] = $isalesid_inserted;
                    $item_data['idettrnid'] = $isalesid_inserted_incremented;
                    $isalesid_inserted_incremented++;
                    $item_data['ereturnitem'] = 'No';
                    $item_data['npack'] = $value['npack'];
                    $item_data['vsize'] = $value['vsize'];
                    $item_data['vitemtype'] = $value['vitemtype'];
                    $item_data['SID'] = $sid;
                    
                $sql5="Select isalesid,idettrnid, LastUpdate from u1001.trn_salesdetail where isalesid = '$isalesid' order by idettrnid desc limit 1";
                $count_row12 = DB::connection('mysql')->select($sql5);
                
                if(!empty($count_row12)){
                    $isalesid_inserted = $count_row12[0]->idettrnid;
                }
                
                if($isalesid_inserted){
                    $isalesid_inserted_incremented = $isalesid_inserted;
                }
                
                if($isalesid_inserted){
                    $isalesid_inserted_id = $isalesid_inserted+1;
                  $sql12 = "INSERT INTO ".$db.".trn_salesdetail SET 
                  vitemname = '" . $item_data['vitemname'] . "', 
                  isalesid = '" . $isalesid . "', 
                  vitemcode = '" . $item_data['vitemcode'] . "', 
                  vcatcode = '" . $item_data['vcatcode'] . "',
                  vcatname = '" . $item_data['vcatname'] . "', 
                  vdepcode = '" . $item_data['vdepcode'] . "', 
                  vdepname = '" . $item_data['vdepname'] . "', 
                  nunitprice = '" . $item_data['nunitprice'] . "', 
                  ncostprice = '" . $item_data['ncostprice'] . "', 
                  ndiscountamt = '" . $item_data['ndiscountamt'] . "', 
                  nsaleprice = '" . $item_data['nsaleprice'] . "', 
                  vunitcode = '" . $item_data['vunitcode'] . "', 
                  vunitname = '" . $item_data['vunitname'] . "', 
                  vuniquetranid = '" . $main_isales_id . "', 
                  idettrnid = '" . $isalesid_inserted_id . "', ereturnitem = '" . $item_data['ereturnitem'] . "', npack = '" . $item_data['npack'] . "', vsize = '" . $item_data['vsize'] . "', vitemtype = '" . $item_data['vitemtype'] . "', `SID` = '" .$item_data['SID'] . "'";
                  DB::connection('mysql')->insert($sql12);
                }else{
                    $sql12 = "INSERT INTO ".$db.".trn_salesdetail SET vitemname = '" . $item_data['vitemname'] . "', isalesid = '" . $item_data['isalesid'] . "', vitemcode = '" . $item_data['vitemcode'] . "', vcatcode = '" . $item_data['vcatcode'] . "', vcatname = '" . $item_data['vcatname'] . "', vdepcode = '" . $item_data['vdepcode'] . "', vdepname = '" . $item_data['vdepname'] . "', nunitprice = '" . $item_data['nunitprice'] . "', ncostprice = '" . $item_data['ncostprice'] . "', ndiscountamt = '" . $item_data['ndiscountamt'] . "', nsaleprice = '" . $item_data['nsaleprice'] . "', vunitcode = '" . $item_data['vunitcode'] . "', vunitname = '" . $item_data['vunitname'] . "', vuniquetranid = '" . $main_isales_id . "', idettrnid = '" . $item_data['idettrnid'] . "', ereturnitem = '" . $item_data['ereturnitem'] . "', npack = '" . $item_data['npack'] . "', vsize = '" . $item_data['vsize'] . "', vitemtype = '" . $item_data['vitemtype'] . "', `SID` = '" .$item_data['SID'] . "'";
                    DB::connection('mysql')->insert($sql12);
                }
                                
                  $item_data['itenerid']= '101';
                  $item_data['isalesid']= $isalesid_inserted;
                  $item_data['vtendername']= 'TestCard';
                  $item_data['vuniquetranid']= $isalesid_inserted;
                  $item_data['SID']= $sid;
                  
                  $sql3 = "INSERT INTO ".$db.".trn_salestender SET isalesid = '" . $main_isales_id . "',itenerid = '" . $item_data['itenerid'] . "', vtendername = '" . $item_data['vtendername'] . "', vuniquetranid = '" . $item_data['vuniquetranid'] . "', `SID` = '" .$item_data['SID'] . "'";
                  DB::connection('mysql')->insert($sql3);

                }
                
                    // foreach($qty_add as $values_qty){
                    //     $qty = number_format($values_qty,2);
                    //     echo $sql28= "UPDATE ".$db.".trn_salesdetail SET 
                    //     ndebitqty =  $qty
                    //     WHERE vuniquetranid = $main_isales_id AND vitemname = '$item_name'";
                    //     DB::connection('mysql')->update($sql28);
                    // }
                
                
                // die;
                
                $success['isales_id'] =  (string)$main_isales_id;
                $success['Success'] =  'Successfully Generated Sales';
                return response()->json(['data' => $success], 200);
              
            } catch (Exception $e) {
               
            } finally {
               
            }
    }
    
    public function StrUniqueGetIDByTable(){
        $input = Request::all();
        $db = "u".$input['sid'];
        $query_db = 'USE DATABASE '.$db;
        DB::raw($query_db); 
        
         //HERE USER FOR pAYMENT tRANSACTION
            $year = date("Y");
            $year = substr( $year, -2);
            $month = date("m");
            $date = date("d");
            $dmy = $year.$month.$date.'101';
            
            $sql = "SELECT COUNT(isalesid) as isalesid  from ".$db.".trn_sales where isalesid like '".$dmy."'";
            $count_row = DB::connection('mysql')->select($sql);
        
            $reccount = $count_row[0]->isalesid;
            $transaction_id = $dmy.($reccount + 1);
            return $transaction_id;
    }
    
    public function StrUniqueIncrementedId(){
        $input = Request::all();
        $db = "u".$input['sid'];
        $query_db = 'USE DATABASE '.$db;
        DB::raw($query_db); 
        
         //HERE USER FOR pAYMENT tRANSACTION
            $year = date("Y");
            $year = substr( $year, -2);
            $month = date("m");
            $date = date("d");
            $dmy = $year.$month.$date.'101';
            
            // $sql = "SELECT COUNT(isalesid) as isalesid  from ".$db.".trn_sales where isalesid like '".$dmy."'";
            $sql="Select idettrnid ,LastUpdate from ".$db.".trn_salesdetail order by LastUpdate desc limit 1";
            
            $count_row = DB::connection('mysql')->select($sql);
        
            $reccount = $count_row[0]->idettrnid;
            $transaction_id = $reccount + 1;
            return $transaction_id;
    }
    
    public function StrUniqueGetIDBatch(){
        $input = Request::all();
        $db = "u".$input['sid'];
        $query_db = 'USE DATABASE '.$db;
        DB::raw($query_db); 
        
         //HERE USER FOR pAYMENT tRANSACTION
            $year = date("Y");
            $year = substr( $year, -2);
            $month = date("m");
            $date = date("d");
            $dmy = $year.$month.$date.'101';
            
            $sql = "SELECT COUNT(isalesid) as isalesid  from ".$db.".trn_sales where isalesid like '".$dmy."'";
            $count_row = DB::connection('mysql')->select($sql);
        
        
            // $reccount = $count_row[0]->isalesid;
            // $transaction_id = $dmy.($reccount + 1);
            return $dmy;
    }
    public function quickitem_insert(Request $request){
        $input = Request::all();
        $db = "u".$input['sid'];
        
        $validator = Validator::make($input, [
           'sid' => 'required',
           'vitemcode' => 'required',
           'vgroupcode' => 'required',
           'isequence' => 'required',
           'vtype' => 'required',
           'vcolorcode' => 'required',
       ]);
        
        if ($validator->fails()) {
            return response()->json(['message' => $validator->messages()->first()],200);
        }
         
        $query_db = 'USE DATABASE '.$db;
        DB::raw($query_db);  
         
        $sql = "INSERT INTO ".$db.".trn_quickitem SET vitemcode = '" . $input['vitemcode'] . "',
        vgroupcode = '" . $input['vgroupcode'] . "',
        isequence = '" . $input['isequence'] . "' ,
        vtype = '" . $input['vtype'] . "' ,
        vterminalid = 101,
        vcolorcode = '" . $input['vcolorcode'] . "' ,
        SID = '" . (int)$input['sid']."'";
            
        DB::connection('mysql')->insert($sql);
        
        return response()->json(['success' => 'Successfully Added'],200);
        
         
    }
    public function quickitem_select(Request $request){
        $input = Request::all();
        $db = "u".$input['sid'];
        $query_db = 'USE DATABASE '.$db;
        DB::raw($query_db);  
        
        $sql = "SELECT * from ".$db.".trn_quickitem";
            
        if(isset($input['Id']) && !empty($input['Id'])){
            $sql .= " WHERE Id= ". $input['Id'];
        }

        $sql .= " ORDER BY Id DESC";
        
        $return_data = DB::connection('mysql')->select($sql);
        // dd($return_data);
        
        if(!empty($return_data)){
            return response()->json($return_data);
        } else {
            return response()->json(['error'=>'No Data Found'],401);
        }
    }
    public function quickitem_by_group(Request $request){
        $input = Request::all();
        $db = "u".$input['sid'];
        $query_db = 'USE DATABASE'.$db;
        DB::raw($query_db);  
        
        if($input['key'] == 'a'){
            $item_key = 'GROUP1';
        }
        if($input['key'] == 'b'){
            $item_key = 'GROUP2';
        }
        if($input['key'] == 'c'){
            $item_key = 'GROUP3';
        }
        if($input['key'] == 'd'){
            $item_key = 'GROUP4';
        }
        if($input['key'] == 'e'){
            $item_key = 'GROUP5';
        }
        if($input['key'] == 'f'){
            $item_key = 'GROUP6';
        }
        
        $sql = "select d.vitemname, d.vbarcode from ".$db.".trn_quickitem e 
        join ".$db.".mst_item d on e.vitemcode=d.vitemcode 
        where e.vgroupcode = '$item_key'";
        
        $return_data = DB::connection('mysql')->select($sql);
        // dd($return_data);
        
        if(!empty($return_data)){
            return response()->json($return_data);
        } else {
            return response()->json(['error'=>'No Data Found'],401);
        }
    }
    public function quickitem_groupa(Request $request){
        $input = Request::all();
        $db = "u".$input['sid'];
        $query_db = 'USE DATABASE '.$db;
        DB::raw($query_db);  
        
        $sql = "select d.vitemname, d.vbarcode from ".$db.".trn_quickitem e 
        join ".$db.".mst_item d on e.vitemcode=d.vitemcode 
        where e.vgroupcode = 'GROUP1'";
        
        $return_data = DB::connection('mysql')->select($sql);
        
        if(!empty($return_data)){
            return response()->json($return_data);
        } else {
            return response()->json(['error'=>'No Data Found'],401);
        }
    }
    // Hemant code end 13-october 2020
}