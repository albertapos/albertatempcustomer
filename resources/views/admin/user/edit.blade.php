@extends('main')
@section('content')
<section class="content-header">
	<h1>
	   User Edit
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
                    {!! Form::open(['files'=> true, 'method'=>'put','id'=>'form1','url'=>['admin/users', $user->id]]) !!}
                    <div class="row">
                        <div class="form-group col-xs-5">
                            <label class="control-label">Role</label>
                            <div class="">
                                <!--{!! Form::select('roleName',['0' => 'Select Role'] + $role_array,$id,['class'=>'form-control','id'=>'role','onChange'=>"showStore(this)"]) !!}<br>   -->
                                {!! Form::select('roleName',$role_array,$id,['class'=>'form-control','id'=>'role','onChange'=>"showStore(this)"]) !!}<br>   
                             </div>
                        </div>
                        <div class="form-group col-xs-5" style="display:block" id ='hidden_div'>
                            <label class="control-label">Store</label>
                            <div class="">
                                {!! Form::select('storeName[]',$store_array,$user->store()->pluck('stores.id')->toArray(),['class'=>'form-control','multiple']) !!}<br>   
                            </div>
                        </div>
                    </div>
                    <div class="row">
                       <div class="form-group col-xs-5">
                            <label class="control-label">First Name</label>
                            <div class="">
                                <input type="text" class="form-control" name="fname" value="{{ $user->fname }}">
                            </div>
                        </div>
                        <div class="form-group col-xs-5">
                            <label class="control-label">Last Name</label>
                            <div class="">
                                <input type="text" class="form-control" name="lname" value="{{ $user->lname }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-xs-5">
                            <label class="control-label">Phone</label>
                            <div class="">
                                <input type="text" class="form-control" name="phone" value="{{ $user->phone }}" id="phone">
                            </div>
                        </div>

                        <div class="form-group col-xs-5">
                            <label class="control-label">E-Mail Address</label>
                            <div class="">
                                <input type="email" class="form-control" name="email" value="{{ $user->email }}" >
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-xs-5">
                            <label class="control-label">Password</label>
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
                    </div><br>
                    <div class="row">
                            <div class="form-group col-xs-2">
                                <input type="checkbox" class="form-control" name="is_mobile_user" id="is_mobile_user" value="True"{{$user->is_mobile_user=='True'?'checked':''}} ><strong>&nbsp;&nbsp;Is Mobile User</strong>
                            </div>
                    </div>
                    <div class="box-footer">
                        <div class="col-md-offset-4">
                          <button type="submit" class="btn btn-primary btn-md" id="save">
                            Save
                          </button>
                          <a class="btn  btn-close btn btn-primary" style="margin-left: 20px;" href="{{ url('/admin/users') }}">Cancel</a><br><br>
                        </div>
                    </div><br><br><br><br>
                 {!! Form::close() !!}
                </div>
			    </div><!-- /.box -->
			</div>
		</div>  
    </section>  
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>   
    <script type="text/javascript">
     if(document.getElementById('role').value == 2){
        document.getElementById('hidden_div').style.display = "block";
     }
     function showStore(elem){
        // if(elem.value == 2){
        //   document.getElementById('hidden_div').style.display = "block";
        // }
        // else{
        //     document.getElementById('hidden_div').style.display = "none";
        // }
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