@extends('main')
@section('content')
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
                        <h4>User Detail<span class="custom_color"></span></h4>
                        <div class="about_border"></div>
                    </div>
                </div>
            </div><br>
            <div class='row'>
		     	<div class="panel panel-default" style="margin-left: 57px;margin-right: 72px;">
		            <table class="table table-striped table-bordered table-hover">
	                    <thead>
	                        <tr>
	                            <th>User ID</th>
	                            <th>{{$user->id}}</th>
	                        </tr>
	                    </thead>
	                    <tbody>
	                    	<tr>
	                    		<td>User name</td>
	                    		<td>{{ $user->fname }} {{ $user->lname }}</td>
	                    	</tr>
	                    	<tr>
	                    		<td>User Role</td>
	                    		@if($user->roles)
		                        	@foreach($user->roles as $role)
		                        	    <td>{{ $role->name }}</td>
		                        	@endforeach
	                       		@endif	
	                    	</tr>
	                    	<tr>
	                    		<td>Email</td>
	                    		<td>{{ $user->email }}</td>
	                    	</tr>
	                    	<tr>
	                    		<td>Phone </td>
	                    		<td>{{ $user->phone }}</td>
	                    	</tr>
                            <tr>
                                <td>User Stores </td>
                                <td>
                                    <table class="table  table-bordered">
                                    @if($user->roles()->count() > 0)
                                        @if($user->roles()->first()->name == "Admin")
                                            @foreach($stores as $row)
                                                   <tr>
                                                       <td>  {{ $row->name }} </td>
                                                    </tr>
                                            @endforeach
                                        @else
                                            @if($user->store)
                                                   @foreach($user->store as $row)
                                                   <tr>
                                                       <td>  {{ $row->name }} </td>
                                                    </tr>
                                                   @endforeach
                                               
                                            @endif
                                        @endif 
                                    @endif
                                    </table>
                                </td>
                            </tr>
                            </tr>
                                <td>Created </td>
                                <td>{{ $user->created_at->format('j-M-y g:ia') }}</td>
                            </tr>
                                <td>Last Updated </td>
                                <td>{{ $user->updated_at->format('j-M-y g:ia') }}</td>
                            </tr>
	                    </tbody>
	                </table>
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