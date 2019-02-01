@extends('main')
@section('content')
<link href="{{ asset('/assets/js/plugins/datatables/dataTables.bootstrap.css')}}" rel="stylesheet" type="text/css" />
<div class="col-md-12">
 
</div>
<section class="content-header">
	<h1>
	   Users listing
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
		            <h3 class="box-title">Users</h3>
			        <div class="text-right" style="padding: 10px 10px 10px 10px;">
			            <a href="/admin/users/create" class="btn btn-success btn-md">
			            <i class="fa fa-plus-circle"></i> New User
			            </a>
			        </div>
		        </div>
		        <div class="box-body">
		            <table id="user_listing" class="table table-bordered table-striped table-hover" style="font-size:12px;">
		                <thead>
	                        <tr>
		                        <th>ID</th>
		                        <th>Name</th>
		                        <th>Role</th>
		                        <th>Phone</th>
		                        <th>Email</th>
		                        <th>Created</th>
		                        <th>Updated</th>
		                        <th>Actions</th>
		                    </tr>
	            		</thead>
	                    <tbody>
		            		@foreach ($users as $user)
			                <tr>
			                    <td data-order="{{$user->id}}">{{ $user->id }}</td>
		                        <td><a style="cursor:pointer;" href="{{ url('admin/users/view',$user->id) }}">{{ $user->fname }} {{ $user->lname }}</a></td>
		                        @if($user->roles)
		                        	@if(count($user->roles) > 0)
                                        @foreach($user->roles as $role)
                                            <td>{{ $role->name }}</td>
                                        @endforeach
                                    @else
                                        <td>&nbsp;</td>
                                    @endif
                                @else
                                    <td>&nbsp;</td>
		                        @endif	
		                        <td>{{ $user->phone }}</td>
		                        <td>{{ $user->email }}</td>
		                        <td>{{ $user->created_at->format('m-d-Y g:ia') }}</td>
		                        <td>{{ $user->updated_at->format('m-d-Y g:ia') }}</td>
		                         <td>
		                            <a href="/admin/users/{{ $user->id }}/edit"
		                            class="btn btn-xs btn-info">
		                                <i class="fa fa-pencil"></i> 
		                            </a>
		                        &nbsp;&nbsp;&nbsp;&nbsp;
		                           <button type="button" class="btn btn-xs btn-danger del_button" data-id="{{$user->id}}"><i class="fa fa-trash-o"></i></button>
		                        </td>
			                </tr>
			               @endforeach
		               </tbody>
		            </table>
		        </div><!-- /.box-body -->
		        
                <div style="clear:both"></div>
		    </div><!-- /.box -->
		</div>
	</div> 
<passport-clients></passport-clients>
<passport-authorized-clients></passport-authorized-clients>
<passport-personal-access-tokens></passport-personal-access-tokens> 
</section> 
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<!-- DataTables -->
<script src="{{asset('/assets/js/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('/assets/js/plugins/datatables/dataTables.bootstrap.min.js')}}"></script>
<script type="text/javascript">
$('#user_listing').DataTable({
    "paging": true,
    "iDisplayLength": 25,
    "lengthChange": true,
    "searching": true,
    "ordering": true,
    "info": true,
    "autoWidth": true,
    'aoColumnDefs': [{
        'bSortable': false,
        'aTargets': [3,4,7] /* 1st one, start by the right */
    }]
    
});
</script>
<!-- DataTables -->

 <script>
//     $(".delete").on("submit", function(){
//         return confirm("Do you want to delete this User?");
//     });
 </script>

<script type="text/javascript">
	$(document).on('click', '.del_button', function(event) {
		event.preventDefault();
        var user_id = $(this).attr('data-id');
        $('form#form_user_delete').attr('action','/admin/users/'+user_id);
		$('#deleteModal').modal('show');
	});
</script>

<!-- Modal -->
  <div class="modal fade" id="deleteModal" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
      	<form class="form-group delete" action="" method="post" accept-charset="utf-8" id="form_user_delete">
	    	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	    	<input type="hidden" name="_method" value="DELETE">
	        <div class="modal-body">
	          <p>Do you want to delete this User?</p>
	        </div>
	        <div class="modal-footer">
	          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
	          <button type="submit" class="btn btn-danger">Delete</button>
	        </div>
	     </form>
      </div>
    </div>
  </div>
<!-- Modal -->
  @stop