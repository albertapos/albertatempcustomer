<?php

namespace pos2020\Http\Controllers\Sales;

use Request;
use pos2020\Http\Controllers\Controller;
use Bican\Roles\Models\Role;
use Bican\Roles\Models\Permission;
use pos2020\Http\Requests;
use pos2020\User;
use pos2020\Store;
use pos2020\agentOffice;
use Auth;

class AgentOfficeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $agentOffices = agentOffice::all();

        $stores = Store::all();
        $store_array = array();
        foreach ($stores as $storesData) {
           $store_array[$storesData->id] = $storesData->name;
        }

       return view('sales.agentoffice.index',compact('store_array','agentOffices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $stores = Store::all();
        $store_array = array();
        foreach ($stores as $storesData) {
           $store_array[$storesData->id] = $storesData->name;
        }
        if (Request::isJson()){
           return config('app.RETURN_MSG.SUCCESS');
        }

        return view('sales.agentoffice.create',compact('store_array'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = agentOffice::Validate(Request::all());
        if($validation->fails() === false)
        {
            $agent = new agentOffice;
            $agent->title = Request::get('title');
            $agent->save();

            return redirect('sales/agentoffice')->withSuccess('Agent Office Created Successfully');
        }
        else
        {
            if (Request::isJson()){
               return  $validation->errors()->all();
            }
                return redirect('/sales/agentoffice/create')->withInput()
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
        $agentOffice = agentOffice::findOrFail($id);
        $stores = Store::all();
        $store_array = array();
        foreach ($stores as $storesData) {
           $store_array[$storesData->id] = $storesData->name;
        }

        return view('sales.agentoffice.edit', compact('store_array','agentOffice'));
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
        $agentOffice = agentOffice::findOrFail($id);
        $validation = agentOffice::Validate(Request::all());
        if($validation->fails() === false)
        {
            $agentOffice->title = Request::get('title');
            $agentOffice->save();

            return redirect('sales/agentoffice')->withSuccess('Detail Updated Successfully');

        }
        else
        {
            if (Request::isJson()){
                return  $validation->errors()->all();
            }
            return redirect('sales/agentoffice/'.$agentOffice->id.'/edit')
                        ->withErrors($validation);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $agentOffice = agentOffice::findOrFail($id);
        $agentOffice->delete();

        if (Request::isJson()){
            return config('app.RETURN_MSG.SUCCESS');
         }else{
            return redirect('sales/agentoffice')->withSuccess('Agent Office Detail Deleted!');
        }
    }
}
