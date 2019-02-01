@extends('main')
@section('content')
<section class="content-header">
	<h1>
	  New User
	</h1>
	<ol class="breadcrumb">
	    <!-- <li><a href="#"><i class="fa fa-dashboard"></i> </a></li>
	    <li><a href="#"></a></li>
	    <li class="active"></li> -->
	</ol>
</section><br>
	<div class="col-md-12">
			  @include('layouts.partials.errors')
			  @include('layouts.partials.flash')
			  @include('layouts.partials.success')
	</div>
  	<section class="content">
		<div class="row">
			<div class="col-xs-12">
			    <div class="box">
			        <div class="box-body col-xs-offset-1">
                      {!! Form::open(['url'=>'sales/users', 'method'=>'Post', 'files'=> true]) !!}
                      @if(Auth::check()) 
                        @foreach (Auth::user()->roles()->get() as $role)
                            @if ($role->name == 'Sales Admin')
                               <div class="row">
                                   <div class="form-group col-xs-5">
                                        <label class="control-label">Role</label>
                                        <div class="">
                                           {!! Form::select('roleName',['0' => 'Select Role'] + $role_array,null,['class'=>'form-control','id'=>'role','onChange'=>"showStore(this)"]) !!}<br>   
                                        </div>
                                    </div>
                                    <div class="form-group col-xs-5">
                                        <label class="control-label">Agent Office</label>
                                        <div class="">
                                           {!! Form::select('officeName',['0' => 'Select Agent Office']+$agent_arry,null,['class'=>'form-control']) !!}<br>   
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if ($role->name == 'Sales Manager' ||  $role->name == 'Sales Agent')
                            <div class="row">
                               <div class="form-group col-xs-5">
                                    <label class="control-label">Role</label>
                                    <div class="">
                                       {!! Form::select('roleName',['0' => 'Select Role'] + $role_array,null,['class'=>'form-control','id'=>'role','onChange'=>"showStore(this)"]) !!}<br>   
                                    </div>
                                </div>
                                <div class="form-group col-xs-5" style="display:none" id ='hidden_div'>
                                        <label class="control-label">Store</label>
                                        <div class="">
                                             {!! Form::select('storeName[]',$store_array,null,['class'=>'form-control','multiple','required']) !!}<br>   
                                        </div>
                                 </div>
                            </div>
                            @endif
                            @endforeach
                        @endif
                        <div class="row">
                            <div class="form-group col-xs-5">
                                <label class="control-label">First Name <font color="red">*</font></label>
                                <div class="">
                                    <input type="text" class="form-control" name="fname" value="{{ old('fname') }}">
                                </div>
                            </div>
                            <div class="form-group col-xs-5">
                                <label class="control-label">Last Name <font color="red">*</font></label>
                                <div class="">
                                    <input type="text" class="form-control" name="lname" value="{{ old('lname') }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-xs-5">
                                <label class="control-label">Phone <font color="red">*</font></label>
                                <div class="">
                                    <input type="text" class="form-control" name="phone" value="{{ old('phone') }}" id="phone">
                                </div>
                            </div>

                            <div class="form-group col-xs-5">
                                <label class="control-label">E-Mail Address <font color="red">*</font></label>
                                <div class="">
                                    <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-xs-5">
                                <label class="control-label">Password <font color="red">*</font></label>
                                <div class="">
                                    <input type="password" class="form-control" name="password">
                                </div>
                            </div>

                            <div class="form-group col-xs-5">
                                <label class="control-label">Confirm Password</label>
                                <div class="">
                                    <input type="password" class="form-control" name="password_confirmation">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-xs-3">
                                <input type="checkbox" class="form-control" name="is_mobile_user" id="is_mobile_user" value="True" checked><strong>&nbsp;&nbsp;Is Mobile App User</strong>
                            </div>
                        </div>
                        <div class="box-footer">
                            <div class="col-md-4 col-md-offset-3 text-center">
                                <button type="submit" class="btn btn-primary btn-md" id="save">
                                <i class="fa fa-disk-o"></i>
                                    Save
                                </button>
                                <a class="btn  btn-close btn btn-primary" style="margin-left: 20px;" href="{{ url('/sales/users') }}">Cancel</a><br><br>

                            </div>
                        </div><br><br><br>
                    {!! Form::close() !!}
                </div>
			    </div><!-- /.box -->
			</div>
		</div>  
    </section>   
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

    <script type="text/javascript">
    function showStore(elem){
        if(elem.value == 2 || elem.value == 6 || elem.value == 7){
          document.getElementById('hidden_div').style.display = "block";
        }
        else{
            document.getElementById('hidden_div').style.display = "none";
        }
    }
  </script>  
   <script type="text/javascript">
    $(document).ready(function() {
        $('#save').on('click', function () {
            if ($("#phone").val().length == 0 ) {
                bootbox.alert({ 
                    size: 'small',
                    message: "You must provid a phone number !", 
                    callback: function(){}
                });
                $("#phone").focus();
                return false;
            }
            if (($("#phone").val().length > 10  )) {
                bootbox.alert({ 
                    size: 'small',
                    message: "Invalid Phone Number !", 
                    callback: function(){}
                });
                $("#phone").focus();
                return false;
            }
            if (($("#phone").val().length < 10  )) {
                bootbox.alert({ 
                    size: 'small',
                    message: "Invalid Phone Number !", 
                    callback: function(){}
                });
                $("#phone").focus();
                return false;
            }
        });
    });  
    </script>       

  @stop

  