<?php

namespace pos2020\Http\Controllers\Vendor;

use Request;

use pos2020\Http\Requests;
use pos2020\Http\Controllers\Controller;
//use pos2020\Http\Requests\UserUpdateRequest;

use Auth;
use pos2020\User;


class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userId = Auth::User()->id;
        $myProfile = User::where('id','=',$userId)->get();

        $stores = Auth::User()->store()->get();
        $store_array = array();
        foreach ($stores as $storesData) {
           $store_array[$storesData->id] = $storesData->name;
        }

        if (Request::isJson()){
            return $myProfile->toJson();
        }else{
            return view('vendor.myProfile.index',compact('myProfile','store_array'));
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
        $myProfile = User::findOrFail($id);
        $stores = Auth::User()->store()->get();
        $store_array = array();
        foreach ($stores as $storesData) {
           $store_array[$storesData->id] = $storesData->name;
        }
        if (Request::isJson()){
            return $myProfile->toJson();
        }else{
             return view('vendor.myProfile.edit', compact('myProfile','store_array'));
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
        $myProfile = User::findOrFail($id);
        $validation = User::Validate(Request::all());
        if($validation->fails() === false)
        {
            $myProfile->fill(User::userFillData());
            $myProfile->save();

            return redirect('vendor/myProfile');
        }
        else
        {
            if (Request::isJson()){
                if($validation->fails() === false)
                {
                   return config('app.RETURN_MSG.SUCCESS');
                }
                else{
                  return redirect('vendor/myProfile/'.$myProfile->id.'/edit')
                        ->withErrors($validation);
                }
            }
            return redirect('vendor/myProfile/'.$myProfile->id.'/edit')
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
        //
    }
    public function postEdit(Request $request,$id){
        $myProfile = User::findOrFail($id);
        $validation = User::Validate(Request::all());
       // dd(Request::all());
        if($validation->fails() === false)
        {
            $myProfile->fill(User::userFillData());
            $myProfile->save();
            
            if (Request::isJson()){
                return config('app.RETURN_MSG.SUCCESS');
            }

            return redirect('vendor/myProfile');
        }
        else
        {
            return redirect('vendor/myProfile/'.$myProfile->id.'/edit')
                        ->withErrors($validation);
        }
    }
}
