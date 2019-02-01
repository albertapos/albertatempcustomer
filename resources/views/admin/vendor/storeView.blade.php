@extends('main')
@section('content')
<?php $u_role = false; ?>
@foreach (Auth::user()->roles()->get() as $role)
    @if(in_array($role->name, array('Admin', 'Sales Admin')))
        <?php $u_role = true; ?>
    @endif
@endforeach
<div class="col-md-12">
 
</div>
	<ol class="breadcrumb">
    <li class="pull-right"><a href="{{ url('/admin') }}"><i class="fa fa-dashboard"></i> Home</a></li>
</ol>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
		    <div class="no-padding">
		     	<div class="">
                <div class="row">
                    <div class="text-center custom_title " >
                        <h4>Store Detail<span class="custom_color"></span></h4>
                        <div class="about_border"></div>
                    </div>
                </div>
            </div><br>
                <div class='row'>
		     	    <div class="row panel panel-default" style="margin-left: 57px;margin-right: 72px;">
    		            <table class="table table-striped table-bordered table-hove" >
    	                    <thead>
    	                        <tr>
    	                            <th style="width: 350px;">Store ID</th>
    	                            <th>{{$store->id}}</th>
    	                        </tr>
    	                    </thead>
    	                    <tbody>
    	                    	<tr>
    	                    		<td>Store Name</td>
    	                    		<td>{{ $store->name }}</td>
    	                    	</tr>
    	                    	<tr>
    	                    		<td>User Name</td>
                                    <td>
        	                    		@if($store->user->count()>1)
                                           @foreach($store->user as $row)
                                                {{ $row->fname }}
                                           @endforeach
                                        @else
                                           @foreach($store->user as $row)
                                                {{ $row->fname }} 
                                           @endforeach
                                        @endif
                                    </td>
    	                    	</tr>
    	                    	<tr>
    	                    		<td>Phone </td>
    	                    		<td>{{ $store->phone }}</td>
    	                    	</tr>
                                <tr>
                                    <td>Contact Name </td>
                                    <td>{{ $store->contact_name }}</td>
                                </tr>
                                <tr>
                                    <td>Address </td>
                                    <td>{{ $store->address }}, {{$store->state}} - {{$store->zip}}</td>
                                </tr>
                                    <td>Expiry Date </td>
                                    <td>{{ $store->license_expdate }}</td>
                                </tr>
                                @if($user_role == 'Admin')
                                </tr>
                                    <td>Database Name </td>
                                    <td>{{ $store->db_name }}</td>
                                </tr>
                                </tr>
                                    <td>Database Username </td>
                                    <td>{{ $store->db_username }}</td>
                                </tr>
                                </tr>
                                    <td>Database Password </td>
                                    <td>{{ $store->db_password }}</td>
                                </tr>
                                @endif
                                <tr>
                                    <td>Created </td>
                                    <td>{{ $store->created_at->format('j-M-y g:ia') }}</td>
                                </tr>
                                    <td>Last Updated </td>
                                    <td>{{ $store->updated_at->format('j-M-y g:ia') }}</td>
                                </tr>
                                <tr>
                                    <td>Number Of computer Detail</td>
                                    <td>{{ $numberOfComputer }}</td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <table class="table table-striped table-bordered table-hover">
                                         <thead>
                                            <tr>
                                                 <th>UID</th>
                                                 <th>Register</th>
                                                 <th>Kiosk</th>
                                                 <th>Server</th>
                                                 <th @if($u_role == false) style="display:none;" @endif>Activation Code</th>
                                                 <th @if($u_role == false) style="display:none;" @endif>Activated</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($storeComputer as $computer)
                                            <tr>
                                                <td>{{ $computer->uid }}</td>
                                                <td>{{ $computer->register }}</td>
                                                <td>{{ $computer->kiosk }}</td>
                                                <td>{{ $computer->server }}</td>
                                                <td @if($u_role == false) style="display:none;" @endif>{{ $computer->hashcode }}</td>
                                                <td @if($u_role == false) style="display:none;" @endif>{{ $computer->status }}</td>
                                            </tr> 
                                            @endforeach
                                        </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">Service Detail</td>
                                <tr>
                                <tr>
                                    <td colspan="2">                               
                                        <table class="table table-striped table-bordered table-hover">
                                         <thead>
                                            <tr>
                                                 <th>POS</th>
                                                 <th>Kiosk</th>
                                                 <th>Mobile</th>
                                                 <th>Credit Card</th>
                                                 <th>Web Store</th>
                                                 <th>Portal</th>
                                                 <th>License Expiry Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>{{ $store->pos }}</td>
                                                <td>{{ $store->kiosk }}</td>
                                                <td>{{ $store->mobile }}</td>
                                                <td>{{ $store->creditcard }}</td>
                                                <td>{{ $store->webstore }}</td>
                                                <td>{{ $store->portal }}</td>
                                                <td>{{ $store->license_expdate }}</td>
                                            </tr> 
                                        </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td>User</td>
                                    <td>
                                        @foreach($store->user as $row)
                                            {{ $row->fname }} 
                                        @endforeach
                                    </td>
                                <tr>
                                <tr>
                                    <td>Store</td>
                                    @if($primaryStore)
                                    <td>
                                        {{ $primaryStoreName }}

                                    </td>
                                    @endif
                                    
                                <tr>
    	                    </tbody>
    	                </table>
                    </div>
                        <button class="btn btn-success btn-md col-md-offset-5" aligin="center" onclick="history.go(-1);">Go Back </button>

	            </div>
		    </div>
		</div>
	</div>  
</section> 
<style type="text/css">
    .about_border {
        border-top: 1px solid black;
        height: 1px;
        margin: 15px auto 0;
        position: relative;
        width: 94%;
        padding-bottom: 16px;
    }
    .about_border:before {
        background-color: black;
        border: 1px ridge black;
        content: "";
        height: 10px;
        left: 50%;
        margin-left: -20px;
        position: absolute;
        top: -5px;
        width: 40px;
    }
    .custom_title h4 {
        text-transform: uppercase;
        font-weight: 700;
        font-size: 20px;
        color: #111;
    }
    .labeltext {
        float: left;
    }
    .label {
        display: inline-block;
        max-width: 100%;
        margin-bottom: 5px;
        font-weight: 700;
    }
    </style>       

@stop