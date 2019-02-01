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
        if($sku) { 
            $obj = Item::where('vbarcode',$sku);
            if(Request::get('sid')) {
                $obj->where('SID',Request::get('sid'));
            }
            $data = $obj->get(array('vbarcode','vitemname','vitemtype','npack','dunitprice','dcostprice','iqtyonhand','nsaleprice','SID'));
            return $data->toArray();
        }
        else
        {
            return response()->json(['error'=>'SKU is  missing '],401);
        }
       
    }
    
    //Adarsh: Function to get the item detail from SKU
    public function get_item_by_sku(Request $request) {
        $sku = Request::get('sku');
        if($sku) { 
            $obj = Nplitem::find($sku, ['barcode','item_name','cost','selling_price','qty_on_hand','tax1','tax2']);
            
            if($obj == null){
                return response()->json(['error'=>'Item not found in NPL'],401);
            }

            return response()->json($obj, 200);
        } else {
            return response()->json(['error'=>'SKU is  missing '],401);
        }
       
    }
    
    //Adarsh: Function to insert an item from NPL (inslocdb->npl_items) to customer (database(u*****)->mst_item)
    public function insert_item_customer(Request $request){
        
        $input = Request::all();
        
        $store = Store::where('id','=',Request::get('sid'))->first();
        
        $db = "u".$store->id;
        
        $query_db = 'USE DATABASE '.$db;
        
        DB::raw($query_db);
        
        //$itemid = $input['itemid'];
        
        $barcode = $input['barcode'];
        
        $itemname = $input['item_name'];
        
        $itemtype = array_key_exists('itemtype', $input)?$input['itemtype']:'Standard';
        
        $category_code = array_key_exists('category_code', $input)?$input['category_code']:1;
        
        $cost = $input['cost'];
        
        $selling_price = $input['selling_price'];
        
        $qty_on_hand = $input['qty_on_hand'];
        
        $tax1 = array_key_exists('tax1', $input)?$input['tax1']:"N";
        
        $tax2 = array_key_exists('tax2', $input)?$input['tax2']:"N";
        
        
        $estatus = "Active";
        
        $query_insert = "INSERT INTO ".$db.".mst_item (vbarcode,vitemcode,vitemname,vitemtype,vcategorycode,SID,estatus,dcostprice,dunitprice,iquantity,vtax1,vtax2) VALUES(".$barcode.",".$barcode.",'".$itemname."','".$itemtype."',".$category_code.",".$store->id.",'".$estatus."',".$cost.",".$selling_price.",".$qty_on_hand.",'".$tax1."','".$tax2."')";

        
        //return $query_insert = "INSERT INTO ".$db.".mst_item ('iitemid','vitemname','SID') VALUES(20001,'".$input['itemname']."',".$input['sid'].")";
        
        $insert = DB::insert($query_insert);
        
        $success_message = "Item inserted successfully in ".$db;
        
        if($insert){
            return response()->json($success_message, 200);
        } else {
           return response()->json(['error'=>'Item could not be inserted.'],401); 
        }
    }

    public function updatePriceBySKU(Request $request) {
        $sku = Request::get('sku');
        $price = Request::get('price');

        if($sku && $price) { 
            $obj = Item::where('vbarcode',$sku);
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
            }

            return response()->json(['message'=>'Price Updated Successfully '],200);
        } else {
            return response()->json(['error'=>'SKU and Price is  missing  '],401);

        }
    }
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

}
