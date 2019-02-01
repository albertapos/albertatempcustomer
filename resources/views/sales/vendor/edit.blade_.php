@extends('main')
@section('content')
<?php $u_role = false; ?>
@foreach (Auth::user()->roles()->get() as $role)
    @if(in_array($role->name, array('Admin', 'Sales Admin')))
        <?php $u_role = true; ?>
    @endif
@endforeach

<section class="content-header">
	<h1>
	   Store Edit
	</h1>
</section><br>
<div class="col-md-12">
		  @include('layouts.partials.errors')
		  @include('layouts.partials.flash')
		  @include('layouts.partials.success')
</div>
<section class="content">
    <div class="container box box-body "><br>
    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#basic_detail">Store Details</a></li>
        <li><a href="#computers" disabled="disabled">Computer</a></li>
        <li><a href="#service" disabled="disabled" >Services</a></li>
        <li><a href="#user" disabled="disabled" >User</a></li>
        <li><a href="#store" disabled="disabled" >Multi Store</a></li>

    </ul>
    {!! Form::open(['files'=> true, 'method'=>'put','url'=>['sales/vendors', $store->id]]) !!}
    <div class="tab-content">
        <div id="basic_detail" class="tab-pane fade in active"><br>
            <div class="panel panel-default col-xs-offset-1" style="width:800px">
                <div class="panel-heading">
                    <div class="row">
                            <div class="col-sm-7">   
                               <strong>Edit Store Details</strong>
                            </div>
                    </div>
                </div>
                <div class="row  col-xs-offset-1">
                    <div class="row"><br>
                        <div class="form-group col-xs-5">
                            <label class="control-label">Store Name <font color="red">*</font></label>
                            <div class="">
                                <input type="text" class="form-control" name="name" value="{{ $store->name }}" id="name">
                            </div>
                        </div>
                        <div class="form-group col-xs-5">
                                <label class="control-label">Business Name <font color="red">*</font></label>
                                <div class="">
                                    <input type="text" class="form-control required" name="business_name" value="{{  $store->business_name }}" id="business_name">
                                </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-xs-5">
                            <label class="control-label">Address <font color="red">*</font></label>
                            <div class="">
                                <input type="text" class="form-control" name="address" value="{{ $store->address }}" id="address">
                            </div>
                        </div>
                        <div class="form-group col-xs-5">
                            <label class="control-label">City <font color="red">*</font></label>
                            <div class="">
                                <input type="text" class="form-control" name="city" value="{{ $store->city }}" id="city">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-xs-5">
                            <label class="control-label">State <font color="red">*</font></label>
                            <div class="">
                                <select class="form-control" name="state" id="state">
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-xs-5">
                            <label class="control-label">Zip <font color="red">*</font></label>
                            <div class="">
                                <input type="text" class="form-control" maxlength="5" name="zip" value="{{ $store->zip }}" id="zip">
                            </div>
                        </div>
                        <input type="hidden" name="country" value="USA">
                    </div>
                    <div class="row">
                        <div class="form-group col-xs-5">
                            <label class="control-label">Phone <font color="red">*</font></label>
                            <div class="">
                                <input type="text" class="form-control" maxlength="10" name="phone" value="{{ $store->phone }}" id="phone">
                            </div>
                        </div>

                        <div class="form-group col-xs-5">
                            <label class="control-label">Contact Name <font color="red">*</font></label>
                            <div class="">
                                <input type="text" class="form-control" name="contact_name" value="{{ $store->contact_name }}" id="contact_name">
                            </div>
                        </div>
                    </div>      
                    <div class="row">
                        <div class="form-group col-xs-10">
                            <label class="control-label">Description</label>
                            <div class="">
                                <textarea class="textarea" placeholder="Place some text here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" name="description">{{ $store->description }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <a class="btn  btn-close btn btn-primary col-sm-offset-4" href="{{ url('/sales/vendors') }}">Cancel</a>
            <button class="btn btn-primary" id="nexttab" type="button" style="width: 70px;margin-left: 20px;">Next</button>                   
            <br><br>
        </div>
        <div id="computers" class="tab-pane"><br>
            <div class="panel panel-default col-xs-offset-1" style="width:900px">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-sm-7">   
                           <strong>Number of Computer</strong>
                        </div>
            
                    </div>
                </div><br>
                <div class="row" style="padding-left:15px;padding-right:15px;">
                    <div class="col-md-12">
                        <div>
                          <button class="btn btn-success pull-right" id="go"  onClick = "generateForm1(); " type="button"><i class="fa fa-plus-circle"></i> Add New Computer</button>
                          <input type="hidden" name="no_of_computers" id="no_of_computers" class="form-control" value="{{$storeComputer->count()}}" placeholder="Number of Computer">  
                        </div>
                    </div>
                </div>
                <div class="form-group clearfix" style="padding-left:15px;padding-right:15px;">
                    <div class="form-group" id="create">
                      <div class="clearfix"></div>
                        <div id="my_div"><br><br>
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-striped table-bordered table-hover" id="num_of_comp_table">
                                        <thead>
                                            <tr>
                                                <th width="20%" class="text-center">UID</th>
                                                <th class="text-center">Register</th>
                                                <th class="text-center">Kiosk</th>
                                                <th class="text-center">Server</th>
                                                <th width="20%" class="text-center" @if($u_role == false) style="display:none;" @endif>Activation Code</th>
                                                <th class="text-center" @if($u_role == false) style="pointer-events:none;" @endif>Activated</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($storeComputer as $key=>$computer)
                                            <tr data-comp-id="{{$computer->id}}">
                                                <td class="text-center">
                                                    <input type='text' id="uid_{{$computer->id}}" class="form-control simplebox text-center" name="uid_{{$computer->id}}" value="{{ $computer->uid }}" readonly>
                                                </td>
                                                @if($computer->status == 'Y')
                                                    <td class="text-center {{$computer->register=='Y'?'activated_computer':''}} ">
                                                        <input type='checkbox' class='form-control simplebox' disabled name="" id=""  onclick="selectOnlyThis(this.id)" {{$computer->register=='Y'?'checked':''}} >
                                                        <input type="hidden"  name="register_{{$computer->id}}"  id="register_{{$computer->id}}"  onclick="selectOnlyThis(this.id)" value="{{$computer->register}}" >
                                                    </td>
                                                    <td class="text-center {{$computer->kiosk=='Y'?'activated_computer':''}} ">
                                                        <input type='checkbox' class='form-control simplebox' disabled name="" id="" onclick="selectOnlyThis(this.id)" value="Y"{{$computer->kiosk=='Y'?'checked':''}}>
                                                        <input type="hidden" name="kiosk_{{$computer->id}}" id="kiosk_{{$computer->id}}" onclick="selectOnlyThis(this.id)" value="{{$computer->kiosk}}" >
                                                    </td>
                                                    <td class="text-center {{$computer->server=='Y'?'activated_computer':''}} ">
                                                        <input type='checkbox' class='form-control simplebox' disabled name="" id="" value=""{{$computer->server=='Y'?'checked':''}}>
                                                        <input type="hidden" name="server_{{$computer->id}}" id="server_{{$computer->id}}" value="{{$computer->server}}" >
                                                    </td>
                                                    <td class="text-center" @if($u_role == false) style="display:none;" @endif>
                                                        <input type='text' class='form-control simplebox text-center' name="hexa_{{$computer->id}}" id="hexa_{{$computer->id}}" value="{{ $computer->hashcode }}" readonly>
                                                    </td>
                                                    <td class="text-center" @if($u_role == false) style="pointer-events:none;" @endif>
                                                        <input type='checkbox' class='form-control simplebox' name="status_{{$computer->id}}"  id="status_{{$computer->id}}"  value="Y"{{$computer->status=='Y'?'checked':''}} >
                                                    </td>
                                                @else
                                                    <td class="text-center">
                                                        <input type='checkbox' class='form-control simplebox' name="register_{{$computer->id}}"  id="register_{{$computer->id}}"  onclick="selectOnlyThis(this.{{$computer->id}})" value="Y"{{$computer->register=='Y'?'checked':''}}>
                                                    </td>
                                                    <td class="text-center">
                                                        <input type='checkbox' class='form-control simplebox' name="kiosk_{{$computer->id}}" id="register_{{$computer->id}}"  onclick="selectOnlyThis(this.{{$computer->id}})" value="Y"{{$computer->kiosk=='Y'?'checked':''}}>
                                                    </td>
                                                    <td class="text-center">
                                                        <input type='checkbox' class='form-control simplebox' name="server_{{$computer->id}}" id="server_{{$computer->id}}" value="Y"{{$computer->server=='Y'?'checked':''}}>
                                                    </td>
                                                    <td class="text-center" @if($u_role == false) style="display:none;" @endif>
                                                        <input type='text' class='form-control simplebox text-center' name="hexa_{{$computer->id}}" id="hexa_{{$computer->id}}" value="{{ $computer->hashcode }}" readonly>
                                                    </td>
                                                    <td class="text-center" @if($u_role == false) style="pointer-events:none;" @endif>
                                                        <input type='checkbox' class='form-control simplebox' name="status_{{$computer->id}}" id="status_{{$computer->id}}" value="Y"{{$computer->status=='Y'?'checked':''}} >
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div> 
                </div>
            </div>
            <a class="btn btn-primary btnPrevious1 col-md-offset-3" >Previous</a> &nbsp;&nbsp;&nbsp;&nbsp;
            <a class="btn  btn-close btn btn-primary" href="{{ url('/sales/vendors') }}">Cancel</a>
            <button class="btn btn-primary" id="next2tab" type="button" style="width: 70px;margin-left: 20px;">Next</button>
            <br><br>           
        </div>            
        <div id="service" class="tab-pane fade"><br>
            <div class="panel panel-default col-xs-offset-1" style="width:800px">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-sm-7">   
                           <strong>Service Type </strong>
                        </div>
                        <div class="col-sm-3">   
                           <strong> &nbsp;Activated </strong>
                        </div>
                    </div>
                </div><br>
                <div class="row">
                    <div class="col-sm-7">   
                        <div class="form-group col-xs-5">
                            <label class="control-label">POS</label>  
                        </div>
                    </div>
                    <div class="col-sm-3">   
                        <div class="form-group col-sm-2">
                            <input type="checkbox" class="form-control" name="pos1" id="pos1" value="Y"{{$store->pos=='Y'?'checked':''}}>
                        </div>
                    </div>
                    <!-- <div class="col-sm-2">   
                          <div class="form-group col-md-2">
                            <input type="checkbox" class="form-control" name="pos1" id="pos1" value="N"{{$store->pos=='N'?'checked':''}}>
                        </div>
                    </div> -->
                </div>
                <div class="row">
                    <div class="col-sm-7">   
                        <div class="form-group col-xs-5">
                            <label class="control-label">Kiosk</label>  
                        </div>
                    </div>
                    <div class="col-sm-3">   
                        <div class="form-group col-sm-2">
                            <input type="checkbox" class="form-control" name="kiosk1" id="kiosk1" value="Y"{{$store->kiosk=='Y'?'checked':''}}>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-7">   
                        <div class="form-group col-xs-5">
                            <label class="control-label">Mobile App</label>  
                        </div>
                    </div>
                    <div class="col-sm-3">   
                        <div class="form-group col-sm-2">
                            <input type="checkbox" class="form-control" name="mobile1" id="mobile1" value="Y"{{$store->mobile=='Y'?'checked':''}}>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-7">   
                        <div class="form-group col-xs-5">
                            <label class="control-label">Credit Card</label>  
                        </div>
                    </div>
                    <div class="col-sm-3">   
                        <div class="form-group col-sm-2">
                            <input type="checkbox" class="form-control" name="card1" id="card1" value="Y"{{$store->creditcard=='Y'?'checked':''}}>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-7">   
                        <div class="form-group col-xs-5">
                            <label class="control-label">Web Store</label>  
                        </div>
                    </div>
                    <div class="col-sm-3">   
                        <div class="form-group col-sm-2">
                            <input type="checkbox" class="form-control" name="webstore1" id="store1" value="Y"{{$store->webstore=='Y'?'checked':''}}>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-7">   
                        <div class="form-group col-xs-5">
                            <label class="control-label">Portal</label>  
                        </div>
                    </div>
                    <div class="col-sm-3">   
                        <div class="form-group col-sm-2">
                            <input type="checkbox" class="form-control" name="portal1" id="portal1" value="Y"{{$store->portal=='Y'?'checked':''}}>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-7">   
                        <div class="form-group col-sm-5">
                            <label class="control-label">License Expiry Date</label>  
                        </div>
                    </div>
                    <div class="col-sm-3">   
                        {!! Form::date('lexpdate', $store->license_expdate ,array('class'=>"form-control",'id'=>"lexpdate")) !!}
                    </div>
                </div>
            </div>
            <a class="btn btn-primary btnPrevious2 col-md-offset-3" >Previous</a> &nbsp;&nbsp;&nbsp;&nbsp;
            <a class="btn  btn-close btn btn-primary" href="{{ url('/sales/vendors') }}">Cancel</a>
            <button class="btn btn-primary" id="next3tab" type="button" style="width: 70px;margin-left: 20px;">Next</button>
            <br><br>
        </div>
        <div id="user" class="tab-pane"><br>
            <div class="panel panel-default col-xs-offset-1" style="width:800px">
                <div class="panel-heading">
                     <strong>User</strong>
                    <strong><button type="button" class="pull-right btn btn-primary btn-md" data-toggle="modal" data-target="#myModal" style="margin-top: -7px;">Add User</button></strong>

                </div><br>
                <div class="box-body table-responsive no-padding" id="div_users" >
                    
                </div>
        
            </div>
            <a class="btn btn-primary btnPrevious3 col-md-offset-3" >Previous</a> &nbsp;&nbsp;&nbsp;&nbsp;
            <a class="btn  btn-close btn btn-primary" href="{{ url('/sales/vendors') }}">Cancel</a>
            <button class="btn btn-primary" id="next4tab" type="button" style="width: 70px;margin-left: 20px;">Next</button>
            <br><br> 
            </div>
      
        <div id="store" class="tab-pane"><br>
            <div class="panel panel-default col-xs-offset-1" style="width:800px">
                <div class="panel-heading">
                     <strong>Store</strong>
                </div><br>
                <div class="row col-xs-offset-1">
                        <a href="#multistore">
                            <div class="form-group col-xs-2 multistore">
                                <div class="">
                                    <input type="checkbox" class="form-control" name="multistore" id="multistores" value="Y"{{$store->multistore=='Y'?'checked':''}} >MultiStore
                                </div>
                            </div>
                        </a>
                        <div class="form-group col-xs-5" id="storeId" style="display:none">
                            <div class="">
                                {!! Form::select('storeName',$store_array,$store->primary_storeId,['class'=>'form-control']) !!}<br>   
                            </div>
                        </div>
                </div>
            </div>
            <div class="row">
                <div class="box-footer">
                   <div class="orm-group col-xs-5">
                        <a class="btn btn-primary btnPrevious4 col-md-offset-3" >Previous</a> &nbsp;&nbsp;&nbsp;
                        <a class="btn  btn-close btn btn-primary" href="{{ url('/sales/vendors') }}">Cancel</a>
                        <button type="submit" class="btn btn-primary" style="margin-left: 20px;">
                        <i class="fa fa-disk-o"></i>
                            Save 
                        </button>
                        <br><br>
                    </div>   
                </div> 
            </div>
        </div>
    </div>
    {!! Form::close() !!}
</div>  
</section>
{!! Form::open(['files'=> false, 'method'=>'Post','id'=>'user_form']) !!}
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">User Detail</h4>
            </div>
            <div class="alert alert-danger" id="user_error" >
            </div>
             @if(Auth::check()) 
                @foreach (Auth::user()->roles()->get() as $role)
                    @if ($role->name == 'Sales Admin')
                       <div class="row col-xs-offset-1">
                           <div class="form-group col-xs-5">
                                <label class="control-label">Role</label>
                                <div class="">
                                   {!! Form::select('roleName',$role_array,null,['class'=>'form-control','id'=>'role']) !!}<br>   
                                </div>
                            </div>
                            <div class="form-group col-xs-5">
                                <label class="control-label">Agent Office</label>
                                <div class="">
                                   {!! Form::select('officeName',$agent_arry,null,['class'=>'form-control','id'=>'officeName']) !!}<br>   
                                </div>
                            </div>
                        </div>
                    @endif
                    @if ($role->name == 'Sales Manager' ||  $role->name == 'Sales Agent')
                    <div class="row col-xs-offset-1">
                       <div class="form-group col-xs-5">
                            <label class="control-label">Role</label>
                            <div class="">
                               {!! Form::select('roleName',['0' => 'Select Role'] + $role_array,null,['class'=>'form-control','id'=>'role' ,'onChange'=>"showStore(this)"]) !!}<br>   
                            </div>
                        </div>
            
                    </div>
                    @endif
                    @endforeach
            @endif
            <div class="row col-xs-offset-1">
                <div class="form-group col-xs-5">
                    <label class="control-label">First Name <font color="red">*</font></label>
                    <div class="">
                        <input type="text" class="form-control" name="fname" id="fname" value="{{ old('fname') }}">
                        <input type="hidden" name="exist_user" id="exist_user" value="">
                    </div>
                </div>
                <div class="form-group col-xs-5">
                    <label class="control-label">Last Name <font color="red">*</font></label>
                    <div class="">
                        <input type="text" class="form-control" name="lname" id="lname" value="{{ old('lname') }}">
                    </div>
                </div>
            </div>
            <div class="row col-xs-offset-1">
                <div class="form-group col-xs-5">
                    <label class="control-label">Phone <font color="red">*</font></label>
                    <div class="">
                        <input type="text" class="form-control" name="phone" id="phoneuser" value="{{ old('phone') }}" >
                    </div>
                </div>

                <div class="form-group col-xs-5">
                    <label class="control-label">E-Mail Address <font color="red">*</font></label>
                    <div class="">
                        <input type="email" class="form-control" name="email" id="email" value="{{ old('email') }}">
                    </div>
                </div>
            </div>
            <div class="row col-xs-offset-1">
                <div class="form-group col-xs-5">
                    <label class="control-label">Password <font color="red">*</font></label>
                    <div class="">
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                </div>

                <div class="form-group col-xs-5">
                    <label class="control-label">Confirm Password</label>
                    <div class="">
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                    </div>
                </div>
            </div>
             <div class="row row col-xs-offset-1">
                    <div class="form-group col-xs-3">
                        <input type="checkbox" class="form-control" name="is_mobile_user" id="is_mobile_user" value="True" checked><strong>&nbsp;&nbsp;Is Mobile App User</strong>
                    </div>
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" id="userclose">Close</button>
                <button type="submit" class="btn btn-primary btn-md" id="usersave">
                <i class="fa fa-disk-o"></i>
                    Save
                </button>                   
            </div>
        </div>
    </div>
</div> 
{!! Form::close() !!}
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    if ($('#multistores').is(":checked"))
    {
         $('#storeId').css({'display':'block'});
    }else
    {
        $('#storeId').css({'display':'none'});
    }
    $('input[name="multistore"]').on('ifChanged', function (e) {
        $(this).trigger("onclick", e);
        if($(this).prop("checked") == true){
            $('#storeId').css({'display':'block'});
        }
         else
         {
            $('#storeId').css({'display':'none'});
         }
    });
    var $tabs = $('.container li');
    $('#nexttab').on('click', function () {
        if ($("#name").val().length == 0 ) {
            bootbox.alert({ 
                size: 'small',
                message: "Please Enter Store Name", 
                callback: function(){}
            });
            $("#name").focus();
            return false;
        }
        if ($("#business_name").val().length == 0 ) {
            bootbox.alert({ 
                size: 'small',
                message: "Please Enter Business Name", 
                callback: function(){}
            });
            $("#business_name").focus();
            return false;
        }
        if ($("#address").val().length == 0 ) {
            bootbox.alert({ 
                size: 'small',
                message: "Please Enter Address", 
                callback: function(){}
            });
            $("#address").focus();
            return false;
        }
        if ($("#city").val().length == 0 ) {
            bootbox.alert({ 
                size: 'small',
                message: "Please Enter City", 
                callback: function(){}
            });
            $("#city").focus();
            return false;
        }
        if ($("#state").find('option:selected').val() == 0 || $("#state").find('option:selected').val() == '') {
            bootbox.alert({ 
                size: 'small',
                message: "Please Select State", 
                callback: function(){}
            });
            $("#state").focus();
            return false;
        }
        if ($("#zip").val().length == 0 || !$("#zip").val().match(/^\d{5}$/)) {
            bootbox.alert({ 
                size: 'small',
                message: "Please Enter Valid Zip Code", 
                callback: function(){}
            });
            $("#zip").focus();
            return false;
        }
        if ($("#phone").val().length == 0 ) {
            bootbox.alert({ 
                size: 'small',
                message: "You must provide a phone number", 
                callback: function(){}
            });
            $("#phone").focus();
            return false;
        }
        if (!($("#phone").val().length  > 0 && ($("#phone").val()).match(/^\d{10}$/))) {
            bootbox.alert({ 
                size: 'small',
                message: "Invalid Phone Number", 
                callback: function(){}
            });
            $("#phone").focus();
            return false;
        }
        if ($("#contact_name").val().length == 0 ) {
            bootbox.alert({ 
                size: 'small',
                message: "Please Enter Contact Name", 
                callback: function(){}
            });
            $("#contact_name").focus();
            return false;
        }
        $tabs.filter('.active').next('li').find('a[href="#computers"]').tab('show');
      // generateForm();
    });
    $('#next2tab').on('click', function () {
        var val_tab = true;
        var server_check = false;

        var server_count = 0;
        $("#num_of_comp_table tbody tr").each(function(){
            if($(this).find('td:eq(3)').find('input[type="checkbox"]').prop("checked") == true){
                server_count++;
            }
        });
        if(server_count > 1 || server_count == 0){
            bootbox.alert({ 
                size: 'medium',
                message: "Must select only one server!!!", 
                callback: function(){ }
             });
            return false;
        }else{
            server_check = true;
        }

        if(server_check == true){
           $("#num_of_comp_table tbody tr").each(function(m){
                var first_checkbox = false;
                var second_checkbox = false;
                $(this).find('input[type="checkbox"]').each(function(i,v){
                    if(i == 0 && $(this).prop("checked") == true){
                        first_checkbox = true;
                    }
                    if(i == 1 && $(this).prop("checked") == true){
                        second_checkbox = true;
                    }
                });
                
                if(first_checkbox == true && second_checkbox == true){
                    bootbox.alert({ 
                        size: 'medium',
                        message: "You Can't Select both Register and Kiosk !<br> Select only One", 
                        callback: function(){ }
                     });
                    val_tab = false;
                    return false;
                }
            }); 
        }

        

        if(val_tab == true){
            $tabs.filter('.active').next('li').find('a[href="#service"]').tab('show');
        }
    });
     $('#next3tab').on('click', function () {
        $tabs.filter('.active').next('li').find('a[href="#user"]').tab('show');
    });
    $('#next4tab').on('click', function () {
        $tabs.filter('.active').next('li').find('a[href="#store"]').tab('show');
    });
    $('.btnPrevious1').click(function(){
          $('.nav-tabs > .active').prev('li').find('a[href="#basic_detail"]').tab('show');
    });
    $('.btnPrevious2').click(function(){
          $('.nav-tabs > .active').prev('li').find('a[href="#computers"]').tab('show');
    });
     $('.btnPrevious3').click(function(){
          $('.nav-tabs > .active').prev('li').find('a[href="#service"]').tab('show');
    });
    $('.btnPrevious4').click(function(){
          $('.nav-tabs > .active').prev('li').find('a[href="#user"]').tab('show');
    });
});
</script> 

<script type="text/javascript">
    function generateForm1() 
    { 
 
        var rowCount = $('#num_of_comp_table tbody tr').length;
        var nextRowCount = parseInt(rowCount) + 1;
        
        var last_row_id = $('#num_of_comp_table tbody tr:last').attr('data-comp-id');
        var next_row_id = parseInt(last_row_id) + 1;
        
        // var a = parseInt(document.getElementById("no_of_computers").value); 
        // my_div.innerHTML = ""; 
        // my_div.innerHTML = my_div.innerHTML + "<br><div class='row'><div class='form-group col-xs-6 col-md-offset-3 '><div class='row'><div class='col-md-2 '>Register</div><div class='col-md-2 col-md-offset-1 temp'>Kiosk</div><div class='col-md-2'>Server</div><div class='col-md-2'>&nbsp;Active</div></div></div></div></div>" 

        // var num = {!! $numberOfComputer or null!!}

        // var i = num + 1;
        // for(;i<=a+num;i++) 
        // { 
        //   var color = getRandomColor();
          // my_div.innerHTML = my_div.innerHTML + "<div class='row'><div class='col-md-3 temp'><div class='form-group'><label  class=\"control-label labeltext\">Uid"+"</label><input type='text' id='uid_"+ i +"' class=\"form-control\" required name='uid_"+ i +"' value='10"+ i +"' ></div></div><div class='col-md-6 temp'><br><div class='row'><div class='col-md-2'><input type='checkbox' class='form-control' name='register_"+ i +"' id='register' value='Y'></div><div class='col-md-3 temp'><input type='checkbox' class='form-control' name='kiosk_"+ i +"' id='kiosk' value='Y'></div><div class='col-md-2 temp'><input type='checkbox' class='form-control' name='server_"+ i +"' id='server' value='Y'></div><div class='col-md-4 temp'><input type='hidden' class='form-control' name='hexa_"+ i +"' id='hexa_"+ i +"' value=\""+color+"\"  readonly></div><div class='col-md-3 '><input type='checkbox' disabled= 'disabled' class='form-control' name='status_"+ i +"' id='active' value='Y'></div></div></div>" 
        // } 
        // my_div.innerHTML = my_div.innerHTML



        var color = getRandomColor();
        
        var tr_html = '';
        tr_html += '<tr data-comp-id="'+ next_row_id +'">';
        tr_html += '<td class="text-center">';
        tr_html += '<input type="text" id="uid_'+next_row_id+'" class="form-control text-center simplebox" name="uid_new[]" value="10'+nextRowCount+'" readonly>';
        tr_html += '</td>';
        tr_html += '<td class="text-center">';
        tr_html += '<input type="checkbox" class="check_boxes check_click" name="register_'+next_row_id+'" id="register_'+next_row_id+'" value="Y">';
        tr_html += '<label for="register_'+next_row_id+'"></label>';
        tr_html += '<input type="hidden" name="register_new[]" id="new_register_'+next_row_id+'"  value="N">';
        tr_html += '</td>';
        tr_html += '<td class="text-center">';
        tr_html += '<input type="checkbox" class="check_boxes check_click" name="kiosk_'+next_row_id+'" id="kiosk_'+next_row_id+'" value="Y">';
        tr_html += '<label for="kiosk_'+next_row_id+'"></label>';
        tr_html += '<input type="hidden" name="kiosk_new[]" id="new_kiosk_'+next_row_id+'" value="N">';
        tr_html += '</td>';
        tr_html += '<td class="text-center">';
        tr_html += '<input type="checkbox" class="check_boxes check_click" name="server_'+next_row_id+'" id="server_'+next_row_id+'" value="Y">';
        tr_html += '<label for="server_'+next_row_id+'"></label>';
        tr_html += '<input type="hidden" name="server_new[]" id="new_server_'+next_row_id+'" value="N">';
        tr_html += '</td>';
        tr_html += '<td class="text-center" @if($u_role == false) style="display:none;" @endif>';
        tr_html += '<input type="text" class="form-control text-center simplebox" name="hexa_new[]" id="hexa_'+next_row_id+'" value="'+color+'"  readonly>';
        tr_html += '</td>';
        tr_html += '<td class="text-center" style="cursor: not-allowed;">';
        tr_html += '<input type="checkbox" class="check_boxes1" name="status_'+next_row_id+'" id="active_'+next_row_id+'" value="Y" readonly>';
        tr_html += '<label for=""></label>';
        tr_html += '<input type="hidden" name="status_new[]" value="N">';
        tr_html += '</td>';
        tr_html += '</tr>';

        $('#num_of_comp_table tbody tr:last').after(tr_html);

        $('#no_of_computers').val(nextRowCount);

        $('#successModal').modal('show');
       
    }
    function getRandomColor(previous) {
        var letters = '0123456789ABCDEF';
        var color = '';
        for (var i = 0; i < 6; i++ ) {
            color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
    }  
    function selectOnlyThis(id) {
        //alert("in");
        alert(id);
        $('input[type="checkbox"]').on('change', function() {
            $('input[id="' + this.id + '"]').not(this).prop('checked', false);
        });
    }

    //new check box click event 

    $(document).on('click', '.check_click', function(event) {
        var ch_id = $(this).attr('id');
        if($(this).prop('checked') == true){
            $('#new_'+ ch_id).val('Y');
        }else{
            $('#new_'+ ch_id).val('N');
        }
        
    }); 
</script> 

<!-- Success Modal -->
  <div class="modal fade" id="successModal" role="dialog">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
      <div class="modal-header" style="border-bottom:none;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
            <div class="modal-body">
              <p class="text-success text-center"><strong>New Computer has been Added Successfully !!!</strong></p>
            </div>
            <div class="modal-footer" style="border-top:none;">
              
            </div>
      </div>
    </div>
  </div>
<!-- Modal -->

<script type="text/javascript">
$("#usersave").on('click', function(event){
event.preventDefault();
if ($("#phoneuser").val().length == 0 ) {
            bootbox.alert({ 
                size: 'small',
                message: "You must provid a phone number !", 
                callback: function(){ }
             });
            $("#phoneuser").focus();
            return false;
        }
        if (!($("#phoneuser").val().length  > 0 && ($("#phoneuser").val()).match(/^\d{10}$/))) {
            bootbox.alert({ 
                size: 'small',
                message: "Invalid Phone Number !", 
                callback: function(){}
            });
            $("#phoneuser").focus();
            return false;
        }

var id = {!! $store->id  or null!!}; 
$('#user_error').hide() ;
$.ajax({
         data: { fname:$('#fname').val() , lname:$('#lname').val() , phone:$('#phoneuser').val() ,email:$('#email').val(),password:$('#password').val(),password_confirmation:$('#password_confirmation').val(), exist_user:$('#exist_user').val(),role:$('#role').val(),officeName:$('#officeName').val(),is_mobile_user:$('#is_mobile_user').val()},
         type: "post",
         url: "/sales/storeUsers/"+id,
         success: function(data){
            if(data == 'success') {
                $('#myModal').modal('hide');
                $('#exist_user').val('no');
                $('#user_error').html('') ;
                getUsers();
                $("#user_form").trigger('reset');

            } else if(data == 'exits')
            {
                $('#user_error').show() ;
                $('#user_error').html('This User is already existing in system. <br> Still you want to assign it ?') ;
                $('#exist_user').val('yes');
            }
            else {
                $('#user_error').show() ;
                $('#user_error').html(data) ;
            }
          //   user_div.innerHTML = user_div.innerHTML
         }

    });
});
$("#userclose").on('click', function(event){
event.preventDefault();
    $("#user_form").trigger('reset');
    });
function getUsers(){
    $.ajax({
         type: "get",
         url: "/sales/vendors/"+{!! $store->id  or null!!}+"/users",
         success: function(data){
            $('#div_users').html(data) ;
         }
    });
}
getUsers();
$('#user_error').hide() ;
</script> 

<!-- States  -->

<script src="{{ asset('/assets/js/states.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        var state_abb = "<?php echo $store->state; ?>";
        var options = '';
        var options = '<option value="">Please Select State</option>';
        $.each(window.states, function(i, v) {
            if(i == state_abb){
                options += '<option value="' + i + '" selected="selected">' + v + '</option>';
            }else{
                options += '<option value="' + i + '">' + v + '</option>';
            }
            
        });
        $('#state').append(options);
    });
</script>


<!-- States  -->   

<!-- Zip code Validation  -->
<script type="text/javascript">
    $(document).on('change', '#zip', function(event) {
        event.preventDefault();
        if ($(this).val().length == 5 && $(this).val() != NaN) {
            var url = 'http://maps.googleapis.com/maps/api/geocode/json?address='+$(this).val()+'&sensor=true';
            $.getJSON(url, function(d) {
                if(d.status == 'OK'){
                    var add_str = d.results[0].formatted_address;
                    if(add_str.indexOf("USA") >= 0){
                        // console.log('country match');
                    }else{
                        bootbox.alert({ 
                            size: 'small',
                            message: "Please Enter USA Zipcode", 
                            callback: function(){}
                        });
                        $("#zip").focus();
                        return false;
                    }
                }else{
                    bootbox.alert({ 
                        size: 'small',
                        message: "Please Enter Valid Zipcode", 
                        callback: function(){}
                    });
                    $("#zip").focus();
                    return false;
                }
            });
        }else{
            bootbox.alert({ 
                size: 'small',
                message: "Please Enter Zipcode", 
                callback: function(){}
            });
            $("#zip").focus();
            return false;
        }
    });  
</script>
<!-- Zip code Validation  -->  

<style type="text/css">
    input[type="checkbox"] {
      display: none;
    }
    label {
      cursor: pointer;
    }
    .check_boxes + label:before {
      border: 1px solid #ccc;
      content: "\00a0";
      display: inline-block;
      font: 16px/1em sans-serif;
      height: 18px;
      /*margin: 0 .25em 0 0;*/
      padding: 0;
      vertical-align: top;
      width: 18px;
    }

    .check_boxes1 + label:before {
      border: 1px solid #ccc;
      content: "\00a0";
      display: inline-block;
      font: 16px/1em sans-serif;
      height: 18px;
      /*margin: 0 .25em 0 0;*/
      padding: 0;
      vertical-align: top;
      width: 18px;
    }
    .check_boxes + label:hover {
        border: 1px solid #000;
    }
    .check_boxes:checked + label:before {
      /*background: #fff;*/
      color: #000;
      background: url(/assets/img/1.jpg) no-repeat;
      text-align: center;
    }
    .check_boxes:checked + label:after {
      font-weight: bold;
    }

</style>   

  @stop