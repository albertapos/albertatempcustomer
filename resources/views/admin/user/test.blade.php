@extends('main')
@section('content')
<section class="content-header">
	<h1>
	  New User
	    <small>it all starts here</small>
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
			        <div class="box-body">
                      {!! Form::open(['url'=>'admin/users', 'method'=>'Post', 'files'=> true]) !!}
                       <div class="row">
                           <div class="form-group col-xs-5">
                           
                                <label class="control-label col-xs-3 ">Role</label>
                                <div class="col-xs-7">
                                   {!! Form::select('roleName',['0' => 'Select Role'] + $role_array,null,['class'=>'form-control','id'=>'role','onChange'=>"showStore(this)"]) !!}<br>   
                                </div>
                            </div>
                            <div class="form-group col-xs-5" style="display:none" id ='hidden_div'>
                                <label class="control-label col-xs-3">Store</label>
                                <div class="col-xs-7">
                                   {!! Form::select('storeName',['0' => 'Select Store'] + $store_array,null,['class'=>'form-control']) !!}<br>   
                                </div>
                            </div>
                           
                        </div>
                        <div class="row">
                            <div class="form-group col-xs-5">
                                <label class=" control-label col-xs-3">First Name</label>
                                <div class="col-xs-7">
                                    <input type="text" class="form-control" name="fname" value="{{ old('fname') }}">
                                </div>
                            </div>
                            <div class="form-group col-xs-5">
                                <label class="control-label col-xs-3">Last Name</label>
                                <div class="col-xs-7">
                                    <input type="text" class="form-control" name="lname" value="{{ old('lname') }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-xs-5">
                                <label class="control-label col-xs-3">Phone</label>
                                <div class="col-xs-7">
                                    <input type="text" class="form-control" name="phone" value="{{ old('phone') }}">
                                </div>
                            </div>

                            <div class="form-group col-xs-5">
                                <label class="control-label col-xs-4">E-Mail Address</label>
                                <div class="col-xs-7">
                                    <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-xs-5">
                                <label class=" control-label col-xs-3">Password</label>
                                <div class="col-xs-7">
                                    <input type="password" class="form-control" name="password">
                                </div>
                            </div>

                            <div class="form-group col-xs-5">
                                <label class=" control-label col-xs-5">Confirm Password</label>
                                <div class="col-xs-7">
                                    <input type="password" class="form-control" name="password_confirmation">
                                </div>
                            </div>
                        </div>
                            <div class="form-group">
                                <div class="col-md-4 col-md-offset-3 text-center">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fa fa-disk-o"></i>
                                        Save New User
                                    </button>
                                </div>
                            </div><br><br><br>
                    {!! Form::close() !!}
                </div>
			    </div><!-- /.box -->
			</div>
		</div>  
    </section>   
    <script type="text/javascript">
    function showStore(elem){
        if(elem.value == 2){
          document.getElementById('hidden_div').style.display = "block";
        }
        else{
            document.getElementById('hidden_div').style.display = "none";
        }
    }
  </script>       

  @stop

  