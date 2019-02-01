@extends('main')
@section('content')
<link href="{{ asset('/assets/js/plugins/datatables/dataTables.bootstrap.css')}}" rel="stylesheet" type="text/css" />
<div class="col-md-12">
 
</div>
<section class="content-header">
    <h1>
       Store listing
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/sales') }}"><i class="fa fa-dashboard"></i> Home</a></li>
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
                    @if(Auth::user()->id != 51)
                     @foreach (Auth::user()->roles()->get() as $role)
                        @if(in_array($role->name, array('Sales Agent')))
                            <div class="pull-right" style="padding: 10px 10px 10px 10px;">
                                <a href="/sales/vendors/create" class="btn btn-success btn-md">
                                <i class="fa fa-plus-circle"></i> New Store
                                </a>
                            </div>
                         @endif
                     @endforeach
                    @endif
                </div><br>
                <div class="box-body">
                    @if(count($stores) > 0)
                    <table id="store_listing" class="table table-bordered table-striped table-hover" style="font-size:12px;">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Store</th>
                                <th>User</th>
                                <th>Contact</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th>Expiry Date</th>
                                <th>Created By</th>
                                <th>Created</th>
                                <th>Updated</th>
                                @foreach (Auth::user()->roles()->get() as $role)
                                    @if($role->name != 'Store Manager')
                                        <th>Actions</th>
                                    @endif
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @if(Auth::user()->id == 51)
                                <?php $not_found = 0;?>
                                @foreach ($stores as $store)
                                    @if($store->kiosk == 'Y')
                                        <?php
                                            $not_found ++;

                                            if(!empty($store->user()->first()->email) && !empty($store->user()->first()->password)){
                                                $s_user = $store->user()->first()->email;
                                                $s_pass = $store->user()->first()->password;

                                            }else{
                                                $s_user = '';
                                                $s_pass = '';

                                                $role_name = '';
                                            }
                                            

                                        ?>
                                        <tr>
                                            <td data-order="{{$store->id}}">{{ $store->id }}</td>
                                            <td><a href="{{ url('sales/vendors/view',$store->id) }}">{{ $store->name }}</a></td>
                                            <td>
                                                @if($store->user)
                                                   @foreach($store->user as $row)
                                                           {{ $row->fname }}
                                                   @endforeach
                                                @endif
                                            </td>
                                            <td>{{$store->contact_name}}</td>
                                            <td>{{ $store->phone }}</td>
                                            <td>{{ $store->city }},<br>
                                            {{ $store->state }},{{ $store->zip }}<br>
                                            </td>
                                            <td>{{ $store->license_expdate }}</td>
                                            <td>
                                                @if($store->salesUsers)
                                                   @foreach($store->salesUsers as $row)
                                                           {{ $row->fname }} {{ $row->lname }}
                                                   @endforeach
                                                @endif
                                            </td>
                                            <td>{{ $store->created_at->format('m-d-Y g:ia') }}</td>
                                            <td>{{ $store->updated_at->format('m-d-Y g:ia') }}</td>
                                             @foreach (Auth::user()->roles()->get() as $role)
                                                @if($role->name != 'Store Manager')
                                                 <td>
                                                    @if($store->kiosk == 'Y')
                                                    &nbsp;
                                                        <button class="btn btn-xs btn-danger store_portal" data-username="{{$s_user}}" data-password="{{$s_pass}}" data-store-id="{{$store->id}}" title="Store Portal" style="">
                                                            <i class="fa fa-external-link-square"></i> 
                                                        </button>
                                                    @endif
                                                </td>
                                                @endif
                                             @endforeach
                                        </tr>
                                    @endif
                                @endforeach
                                @if($not_found == 0)
                                    <div class="col-md-12">
                                        <div class="alert alert-danger">
                                          Sorry we not found any store!!!
                                        </div>
                                   </div>
                                @endif
                            @else
                                @foreach ($stores as $store)
                                    <?php
                                    
                                        if(!empty($store->user()->first()->email) && !empty($store->user()->first()->password)){
                                            $s_user = $store->user()->first()->email;
                                            $s_pass = $store->user()->first()->password;

                                        }else{
                                            $s_user = '';
                                            $s_pass = '';

                                            $role_name = '';
                                        }
                                        

                                    ?>
                                    <tr>
                                        <td data-order="{{$store->id}}">{{ $store->id }}</td>
                                        <td><a href="{{ url('sales/vendors/view',$store->id) }}">{{ $store->name }}</a></td>
                                        <td>
                                            @if($store->user)
                                               @foreach($store->user as $row)
                                                       {{ $row->fname }}
                                               @endforeach
                                            @endif
                                        </td>
                                        <td>{{$store->contact_name}}</td>
                                        <td>{{ $store->phone }}</td>
                                        <td>{{ $store->city }},<br>
                                        {{ $store->state }},{{ $store->zip }}<br>
                                        </td>
                                        <td>{{ $store->license_expdate }}</td>
                                        <td>
                                            @if($store->salesUsers)
                                               @foreach($store->salesUsers as $row)
                                                       {{ $row->fname }} {{ $row->lname }}
                                               @endforeach
                                            @endif
                                        </td>
                                        <td>{{ $store->created_at->format('m-d-Y g:ia') }}</td>
                                        <td>{{ $store->updated_at->format('m-d-Y g:ia') }}</td>
                                         @foreach (Auth::user()->roles()->get() as $role)
                                            @if($role->name != 'Store Manager')
                                             <td>
                                                @if(!in_array($store->id, array(100136)))
                                                 <a href="/sales/vendors/{{ $store->id }}/edit"
                                                class="btn btn-xs btn-info">
                                                   <i class="fa fa-pencil"></i> 
                                                </a>
                                                @endif
                                                @if($store->kiosk == 'Y' && Auth::user()->roles()->first()->name == "Kiosk Admin")
                                                &nbsp;
                                                    <button class="btn btn-xs btn-danger store_portal" data-username="{{$s_user}}" data-password="{{$s_pass}}" data-store-id="{{$store->id}}" title="Store Portal" style="">
                                                        <i class="fa fa-external-link-square"></i> 
                                                    </button>
                                                @endif
                                                @if(Auth::user()->roles()->first()->name != "Kiosk Admin")
                                                    &nbsp;
                                                    <button class="btn btn-xs btn-success store_administration" data-username="{{$s_user}}" data-password="{{$s_pass}}" data-store-id="{{$store->id}}" title="Store Administration" style="">
                                                        <i class="fa fa-external-link-square"></i> 
                                                    </button>
                                                @endif
                                            </td>
                                            @endif
                                         @endforeach
                                    </tr>
                                @endforeach
                            @endif
                            
                       </tbody>
                    </table>
                    @else
                        <div class="col-md-12">
                            <div class="alert alert-danger">
                              Sorry we not found any store!!!
                            </div>
                       </div>
                    @endif
                </div><!-- /.box-body -->
                <div style="clear:both"></div>
            </div><!-- /.box -->
        </div>
    </div>  
</section>          
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<!-- DataTables -->
<script src="{{asset('/assets/js/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('/assets/js/plugins/datatables/dataTables.bootstrap.min.js')}}"></script>
<script type="text/javascript">
@foreach (Auth::user()->roles()->get() as $role)
    @if(in_array($role->name, array('Store Manager')))
        
        $('#store_listing').DataTable({
            "paging": true,
            "iDisplayLength": 25,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true,
            "aaSorting": [[ 0, "desc" ]],
            'aoColumnDefs': [{
                'bSortable': false,
                'aTargets': [4,5] /* 1st one, start by the right */
            }]
    
        });

    @else
        $('#store_listing').DataTable({
            "paging": true,
            "iDisplayLength": 25,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true,
            "aaSorting": [[ 0, "desc" ]],
            'aoColumnDefs': [{
                'bSortable': false,
                'aTargets': [4,5,10] /* 1st one, start by the right */
            }]
    
        });
        
    @endif
@endforeach
</script>
<!-- DataTables -->

<script>
    $(".delete").on("submit", function(){
        return confirm("Do you want to delete this Store?");
    });
</script>

<div style="display:none">
    <form action="https://kiosk.insloc.com/index.php?route=common/login" id="form_store_protal" method="post" enctype="multipart/form-data" target="_blank">
    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>"> 
        <input type="text" name="username" id="input_username">

        <input type="password" name="password" id="input_password">
        <input type="text" name="SID" id="store_id">
        
        <button type="submit">Login</button>
</form>

</div>
<script type="text/javascript">
    $(document).on('click', '.store_portal', function(event) {

        event.preventDefault();

        var u_name = $(this).attr('data-username');
        var u_password = $(this).attr('data-password');
        var u_store_id = $(this).attr('data-store-id');

        if(u_name != '' && u_password != ''){
            $('form#form_store_protal #input_username').val(u_name);
            $('form#form_store_protal #input_password').val(u_password);
            $('form#form_store_protal #store_id').val(u_store_id);

            $('form#form_store_protal').submit();
        }else{
            bootbox.alert({ 
                size: 'medium',
                message: "Sorry we not found any user for this store !!!", 
                callback: function(){}
            });
        }
        
    });
</script>

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