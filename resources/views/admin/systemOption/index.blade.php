@extends('main')
@section('content')
<div class="col-md-12">
 
</div>
<section class="content-header">
	<h1>
	   System Option
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
		            <h3 class="box-title">Options</h3>
			        <div class="pull-right" style="padding: 10px 10px 10px 10px;">
			            <a href="/admin/systemOption/create" class="btn btn-success btn-md">
			            <i class="fa fa-plus-circle"></i> New Option
			            </a>
			        </div>
		        </div>
		        <div class="box-body table-responsive no-padding">
		            <table class="table table-hover">
		                <tr>
	                        <tr>
		                        <th>ID</th>
		                        <th>Name</th>
		                        <th>Value</th>
		                        <th>Created</th>
		                        <th>Updated</th>
		                        <th colspan="2">&nbsp;&nbsp;&nbsp;Actions</th>
		                    </tr>
	            		</tr>
	            		 @foreach ($systemOption as $option)
		                <tr>
		                    <td>{{ $option->id }}</td>
	                        <td>{{ $option->name }}</td>	
	                        <td>{{ $option->value }}</td>
	                        <td>{{ $option->created_at->format('j-M-y g:ia') }}</td>
	                        <td>{{ $option->updated_at->format('j-M-y g:ia') }}</td>
	                        <td>
	                            <a href="/admin/systemOption/{{ $option->id }}/edit"
	                            class="btn btn-xs btn-info">
	                                <i class="fa fa-pencil"></i> 
	                            </a>
	                        </td>
	                        <td>
	                           <form class="form-group delete" action="{{ url('admin/systemOption', $option->id) }}" method="post" accept-charset="utf-8">
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
</section> 
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>        
<script>
    $(".delete").on("submit", function(){
        return confirm("Do you want to delete this Option?");
    });
</script>
  @stop