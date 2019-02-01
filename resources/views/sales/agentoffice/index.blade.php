@extends('main')
@section('content')
<div class="col-md-12">
 
</div>
<section class="content-header">
	<h1>
	   Agent Office listing
	</h1>
	<ol class="breadcrumb">
	    <li><a href="{{ url('/sales/agentoffice') }}"><i class="fa fa-dashboard"></i> Home</a></li>
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
		            <h3 class="box-title">Agent Office</h3>
			        <div class="text-right" style="padding: 10px 10px 10px 10px;">
			            <a href="/sales/agentoffice/create" class="btn btn-success btn-md">
			            <i class="fa fa-plus-circle"></i> New Agent
			            </a>
			        </div>
		        </div>
		        <div class="box-body table-responsive no-padding">
		            <table class="table table-hover">
		                <tr>
	                        <tr>
		                        <th>ID</th>
		                        <th>Name</td>
		                        <th>Created</th>
		                        <th>Updated</th>
		                        <th colspan="2">&nbsp;&nbsp;&nbsp;Actions</th>
		                    </tr>
	            		</tr>
	            		 @foreach ($agentOffices as $office)
		                <tr>
		                    <td>{{ $office->id }}</td>
	                        <td>{{ $office->title }}</td>
	                        <td>{{ $office->created_at->format('j-M-y g:ia') }}</td>
	                        <td>{{ $office->updated_at->format('j-M-y g:ia') }}</td>
	                         <td>
	                            <a href="/sales/agentoffice/{{ $office->id }}/edit"
	                            class="btn btn-xs btn-info">
	                                <i class="fa fa-pencil"></i> 
	                            </a>
	                        </td>
	                        <td>
	                           <form class="form-group delete" action="{{ url('sales/agentoffice', $office->id) }}" method="post" accept-charset="utf-8">
	                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
	                                <input type="hidden" name="_method" value="DELETE">
	                                <button type="submit" class="btn btn-xs btn-danger"><i class="fa fa-trash-o"></i></button>
	                           </form>
	                        </td>
		                </tr>
		               @endforeach
		            </table>
		        </div><!-- /.box-body -->

		    </div><!-- /.box -->
		</div>
	</div> 
<passport-clients></passport-clients>
<passport-authorized-clients></passport-authorized-clients>
<passport-personal-access-tokens></passport-personal-access-tokens> 
</section> 
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>        
<script>
    $(".delete").on("submit", function(){
        return confirm("Do you want to delete this Agent Office?");
    });
</script>
  @stop