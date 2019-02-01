@extends('main')
@section('content')
<div class="col-md-12">
 
</div>
<section class="content-header">
	<h1>
	   Store listing
	</h1>
	<ol class="breadcrumb">
	    <li><a href="{{ url('/vendor')}}"><i class="fa fa-dashboard"></i> Home</a></li>

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
			        <div class="box-header">
			            <h3 class="box-title">Store Detail</h3>
			        </div><!-- /.box-header -->
			        <div class="box-body table-responsive no-padding">
			            <table class="table table-hover">
			                <tr>
		                        <th>ID</th>
		                        <th>Store Name</th>
		                        <th>User Name</th>
		                        <th>Description</th>
		                        <th>Phone</th>
		                        <th>Created</th>
		                        <th>Updated</th>
		                        <th>Action</th>
                    		</tr>
                    		@foreach ($stores as $store)
                    		<?php
                            
                                if(!empty($store->user()->first()->email) && !empty($store->user()->first()->password)){
                                    $s_user = $store->user()->first()->email;
                                    $s_pass = $store->user()->first()->password;
                                }else{
                                    $s_user = '';
                                    $s_pass = '';
                                }

                            ?>
			                <tr>
			                    <td>{{ $store->id }}</td>
	                            <td>{{ $store->name }}</td>
	                             <td>
	                            @if($store->user->count()>1)
	                               @foreach($store->user as $row)
                                        {{ $row->fname }}  <br>
                                   @endforeach
	                            @else
	                               @foreach($store->user as $row)
                                        {{ $row->fname }} 
                                   @endforeach
	                          	@endif
	                            </td>
	                            <td>{{ $store->description }}</td>
	                            <td>{{ $store->phone }}</td>
	                            @if($store->created_at or null)
	                            <td>{{ $store->created_at->format('j-M-y g:ia')  }}</td>
	                            @endif
	                            @if($store->updated_at or null)
	                            <td>{{ $store->updated_at->format('j-M-y g:ia') }}</td>
	                            @endif
	                           <td>
	                           		<button class="btn btn-xs btn-success store_administration" data-username="{{$s_user}}" data-password="{{$s_pass}}" data-store-id="{{$store->id}}" title="Store Administration" style=""><i class="fa fa-external-link-square"></i> </button>
                                </td>
			                </tr>
			               @endforeach
			            </table>
			        </div><!-- /.box-body -->
			    </div><!-- /.box -->
			</div>
		</div>  
    </section>          

<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<div style="display:none">
    <form action="https://administration.insloc.com/index.php?route=common/login" id="form_store_administration" method="post" enctype="multipart/form-data" target="_blank">
	    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>"> 
	    <input type="text" name="username" id="input_username_administration">

	    <input type="password" name="password" id="input_password_administration">
	    <input type="text" name="SID" id="store_id_administration">
	    
	    <button type="submit">Login</button>
	</form>
</div>
<script type="text/javascript">
    $(document).on('click', '.store_administration', function(event) {

        event.preventDefault();

        var u_name = $(this).attr('data-username');
        var u_password = $(this).attr('data-password');
        var u_store_id = $(this).attr('data-store-id');

        if(u_name != '' && u_password != ''){
            $('form#form_store_administration #input_username_administration').val(u_name);
            $('form#form_store_administration #input_password_administration').val(u_password);
            $('form#form_store_administration #store_id_administration').val(u_store_id);

            $('form#form_store_administration').submit();
        }else{
            bootbox.alert({ 
                size: 'medium',
                message: "Sorry we not found any user for this store !!!", 
                callback: function(){}
            });
        }
        
    });
</script>    

  @stop