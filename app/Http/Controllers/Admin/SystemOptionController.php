<?php

namespace pos2020\Http\Controllers\Admin;

//use Illuminate\Http\Request;

use pos2020\Http\Requests;
use pos2020\Http\Controllers\Controller;
use pos2020\Store;
use Request;
use pos2020\systemOption;


class SystemOptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stores = Store::with('user')->get();
        $title = 'All Stores';
        $store_array = array();
        foreach ($stores as $storesData) {
           $store_array[$storesData->id] = $storesData->name;
        }

        $systemOption = systemOption::all();

        if (Request::isJson()){
            return $systemOption->toJson();
        }else{
            return view('admin.systemOption.index',compact('store_array','systemOption'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $stores = Store::with('user')->get();
        $title = 'All Stores';
        $store_array = array();
        foreach ($stores as $storesData) {
           $store_array[$storesData->id] = $storesData->name;
        }

        return view('admin.systemOption.create',compact('store_array'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = systemOption::Validate(Request::all());

        if($validation->fails() === false)
        {
            $systemOption = new systemOption;
            $systemOption->name = Request::get('name');
            $systemOption->value = Request::get('value');
            $systemOption->save();

            if (Request::isJson()){
                 return config('app.RETURN_MSG.SUCCESS');
            }
            return redirect('admin/systemOption')->withSuccess('System option created successfully');
        }
        else
        {
            if (Request::isJson()){
               return  $validation->errors()->all();
            }
                return redirect('/admin/systemOption/create')->withInput()
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
        $systemOption = systemOption::findOrFail($id);
        $stores = Store::with('user')->get();
        $title = 'All Stores';
        $store_array = array();
        foreach ($stores as $storesData) {
           $store_array[$storesData->id] = $storesData->name;
        }

        if (Request::isJson()){
            return $systemOption->toJson();
        }else{
            return view('admin.systemOption.edit', compact('store_array','systemOption'));
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
        $systemOption = systemOption::findOrFail($id);

        $validation = systemOption::Validate(Request::all());

        if($validation->fails() === false)
        { 
            $systemOption->name = Request::get('name');
            $systemOption->value = Request::get('value');
            $systemOption->save();

            return redirect('admin/systemOption')->withSuccess('System option updated successfully');
        }
        else
        {
             if (Request::isJson()){
               return  $validation->errors()->all();
            }
                 return redirect('admin/systemOption/'.$systemOption->id.'/edit')->withInput()
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
        $option = systemOption::findOrFail($id);
        $option->delete();

         if (Request::isJson()){
            return config('app.RETURN_MSG.SUCCESS');
         }else{
            return redirect('admin/systemOption')->withSuccess('System Option  Deleted!');
        }
    }

    public function postEdit(Request $request,$id)
    {
        $validation = systemOption::Validate(Request::all());

        if($validation->fails() === false)
        {
            $systemOption = systemOption::findOrFail($id);
            $systemOption->name = Request::get('name');
            $systemOption->value = Request::get('value');
            $systemOption->save();
            $message = 'Option is updated';

            if (Request::isJson()){
                 return config('app.RETURN_MSG.SUCCESS');
             }
            return redirect('admin/systemOption')->withMessage($message);

        }
        else
        {
             if (Request::isJson()){
               return  $validation->errors()->all();
            }
                 return redirect('admin/systemOption/'.$systemOption->id.'/edit')->withInput()
                        ->withErrors($validation);
       
        }
    }
}
