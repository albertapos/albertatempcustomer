<?php

namespace pos2020\Http\Controllers;

use Illuminate\Http\Request;

use pos2020\Http\Requests;

use pos2020\Http\Controllers\Controller;
use pos2020\Store;
use Auth;
class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()) { 
            $user = Auth::user();
            foreach ($user->roles()->get() as $role)
            {
                   if ($role->name == 'Admin')
                    {
                        $url = '/admin';
                    }

                    if ($role->name == 'Vendor')
                    {
                        $url =  '/admin';
                    }
                    if ($role->name == 'Sales Admin')
                    {
                        $url = '/sales/agentoffice';
                    }
                    if ($role->name == 'Sales Manager')
                    {
                        $url = '/sales/users';
                    }
                    if ($role->name == 'Sales Agent')
                    {
                        $url = '/sales/users';
                    }
                    if ($role->name == 'Store Manager')
                    {
                       $url =  '/admin';
                    }
            }

        } else {
            $url =  '/login';
        }
      //  dd($url);
        return redirect($url);        
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
}
