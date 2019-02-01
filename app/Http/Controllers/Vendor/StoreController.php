<?php

namespace pos2020\Http\Controllers\Vendor;

use Request;
use pos2020\Http\Controllers\Controller;
use pos2020\Http\Requests;
use pos2020\Store;
use Auth;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stores = Auth::User()->store()->where('store_view_permission','!=',1)->get();

        foreach (Auth::user()->roles()->get() as $role)
        {
            if($role->name == 'Store Manager'){
                $stores = Store::join('user_stores', 'stores.id','=','user_stores.store_id')->where('user_stores.user_id','=',2)->get(array('stores.*'));
            }
        }
        
        $store_array = array();
        foreach ($stores as $storesData) {
           $store_array[$storesData->id] = $storesData->name;
        }
        if (Request::isJson()){
            return $stores->toJson();
        }else{
            return view('vendor.store.index',compact('stores','store_array'));
        }
       
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
     * Store a newly created resource in stor(ge.
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
}
