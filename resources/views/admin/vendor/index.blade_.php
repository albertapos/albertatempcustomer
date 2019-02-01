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
        <li><a href="{{ url('/admin') }}"><i class="fa fa-dashboard"></i> Home</a></li>

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
                    <div class="pull-right" style="padding: 10px 10px 10px 10px;">
                        <a href="/admin/vendors/create" class="btn btn-success btn-md">
                        <i class="fa fa-plus-circle"></i> New Store
                        </a>
                    </div>
                </div>
                <br>
                <div class="box-body">
                    <table id="store_listing" class="table table-bordered table-striped table-hover" style="font-size:12px;">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Store</th>
                                <th>Business</th>
                                <th>User</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th>Expiry Date</th>
                                <th>Created</th>
                                <th>Updated</th>
                                @if(Auth::check()) 
                                    @foreach (Auth::user()->roles()->get() as $role)
                                        @if (in_array($role->name, array('Admin','Vendor')))
                                           <th>Actions</th>
                                        @endif
                                    @endforeach
                                @endif
                            </tr>
                        </thead>
                        <tbody>
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
                                <td data-order="{{$store->id}}">{{ $store->id }}</td>
                                <td><a style="cursor:pointer;" href="{{ url('admin/vendors/view',$store->id) }}">{{ $store->name }}</a></td>
                                <td>{{ $store->business_name }}</td>
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
                                <td>{{ $store->phone }}</td>
                                <td>{{ $store->city }},<br>
                                {{ $store->state }},{{ $store->zip }}<br>
                                </td>
                                <td>{{ $store->license_expdate }}</td>
                                <td>{{ $store->created_at->format('m-d-Y g:ia') }}</td>
                                <td>{{ $store->updated_at->format('m-d-Y g:ia') }}</td>
                                @if(Auth::check()) 
                                @foreach (Auth::user()->roles()->get() as $role)
                                    @if (in_array($role->name, array('Admin','Vendor')))
                                        <td>
                                           <a href="/admin/vendors/{{ $store->id }}/edit"
                                            class="btn btn-xs btn-info">
                                                <i class="fa fa-pencil"></i> 
                                            </a>
                                            @if($store->kiosk == 'Y')
                                            &nbsp;&nbsp;&nbsp;&nbsp;
                                                <button class="btn btn-xs btn-danger store_portal" data-username="{{$s_user}}" data-password="{{$s_pass}}" data-store-id="{{$store->id}}" title="Store Portal" style="">
                                                    <i class="fa fa-external-link-square"></i> 
                                                </button>
                                            @endif
                                        </td>
                                    @endif
                                  @endforeach
                                @endif
                            </tr>
                           @endforeach
                       </tbody>
                    </table>
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
        'aTargets': [4,5,9] /* 1st one, start by the right */
    }]
    
});
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
  @stop