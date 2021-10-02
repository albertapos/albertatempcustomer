@extends('main')

@section('head')
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
@stop

@section('content')
<link href="{{ asset('/assets/js/plugins/datatables/dataTables.bootstrap.css')}}" rel="stylesheet" type="text/css" />
<div class="col-md-12">
 
</div>
<section class="content-header">
	<h1>
	   NPL Items
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
		            <h3 class="box-title">NPL Items</h3>
			        <div class="text-right" style="padding: 10px 10px 10px 10px;">
			            <!--<a href="/admin/npl-item/create" class="btn btn-success btn-md"><i class="fa fa-plus-circle"></i> New Item</a>-->
			            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#importItemModal"><i class="fa fa-file-text-o"></i>&nbsp;&nbsp;Import NPL Items</button>
                        <a href="{{ url('/admin/npl-list-insert') }}" title="" class="btn btn-primary add_new_btn_rotate"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add New</a>&nbsp; 
			            <button type="button" class="btn btn-danger" id="delete_btn" style="border-radius: 0px;float: right;"><i class="fa fa-file-text-o"></i>&nbsp;&nbsp;Delete Items</button>
			        
		                <div class="col-md-2">
			                <select class="form-control" id="done_editing" name="done_editing">
    			                <option value='0' selected>Draft</option>
    			                <option value='1' >Finished</option>
    			                <option value='-1'>All</option>
    			            </select>
    			        </div>

			            
			            
			        
			        
			        
			        
			        
			        
			        </div>
		        </div>
		        <div class="box-body">
		            <table id="item_listing" class="table table-bordered table-striped table-hover" style="font-size:12px;">
		                <thead>
                            <tr>
                                <th style="width: 1px;" class="text-center"><input id="thCheckbox" type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></th>
                                <th>SKU</th>
                                <th>Item Name</th>
                                <th>Item Type</th>
                                <th>Dept.</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Cost</th>
                            </tr>
                        </thead>
                        
	                    
		            </table>
		        </div><!-- /.box-body -->
		        
                <div style="clear:both"></div>
		    </div><!-- /.box -->
		</div>
	</div> 
<!--passport-clients></passport-clients>
<passport-authorized-clients></passport-authorized-clients>
<passport-personal-access-tokens></passport-personal-access-tokens> -->

<script type="text/javascript">
  $(document).on('click', '#delete_btn', function(event) {
    event.preventDefault();
    
    $('#deleteItemModal').modal('show');

  });
</script>


<!-- Modal -->
<div id="deleteItemModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-sm">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Delete Selected Items</h4>
      </div>
      <div class="modal-body">
        <p>Are you Sure?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <input type="button" class="btn btn-danger" id='deleteItems' name="deleteItems" value="Delete">
      </div>
    </div>

  </div>
</div>



<div id="importItemModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Import NPL Items</h4>
      </div>
      <div class="modal-body">
      <form method="post" action="" id="form_item_import">
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <span style="display:inline-block;width:15%;">Separated By: </span> <span style="display:inline-block;width:80%;">
                <input type="radio" name="separated_by" value="comma" checked="checked">&nbsp;&nbsp;Comma&nbsp;&nbsp;
                <input type="radio" name="separated_by" value="pipe">&nbsp;&nbsp;Pipe
              </span>
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <span style="display:inline-block;width:15%;">File: </span> <span style="display:inline-block;width:80%;"><input type="file"  id="file" name="import_item_file" class="form-control" required></span>
            </div>
          </div>
          <div class="col-md-12 text-center">
            <div class="form-group">
              <input type="submit" value="Import" id="upload_csv" class="btn btn-success">&nbsp;
              <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
          </div>
        </div>
      </form>
      </div>
    </div>

  </div>
</div>

<div class="modal fade" id="successModal" role="dialog">
  <div class="modal-dialog modal-sm">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header" style="border-bottom:none;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div class="alert alert-success text-center">
          <!--<p id="success_msg"><strong>Items Imported Successfully!</strong></p>-->
          <p id="success_msg"><strong><span id='span_success_msg'></span></strong></p>
        </div>
        <div class="text-center" style="display:none;">
          <a id="status_file" href="" download="import-item-status-report.txt">Status of Imported File</a>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="loadingModal" role="dialog">
  <div class="modal-dialog modal-sm">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header" style="border-bottom:none;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div class="alert alert-success text-center">
          <p id="import_success_msg"><strong>Items getting imported...!!</strong></p>
        </div>
        <div class="text-center" style="display:none;">
          <!--<a id="status_file" href="/view/template/administration/import-item-status-report.txt" download="import-item-status-report.txt">Status of Imported File</a>-->
        </div>
      </div>
    </div>
  </div>
</div>






</section> 




  @stop
  
 @section('scripts')
 
 
 <!--<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>-->

<!-- DataTables -->
<script src="{{asset('/assets/js/plugins/datatables/jquery.dataTables.min.js')}}"></script>

<script src="{{asset('/assets/js/plugins/datatables/dataTables.bootstrap.min.js')}}"></script>

<!--<script src="https://code.jquery.com/jquery-3.3.1.min.js" 
    integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
    crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>-->


<script type="text/javascript">
// $('#item_listing').DataTable({
//     "processing": true,
//     "serverSide": true,
//     "paging": true,
//     "iDisplayLength": 15,
//     "lengthChange": true,
//     "searching": true,
//     "ordering": true,
//     "info": true,
//     "autoWidth": true,
//     'aoColumnDefs': [{
//         'bSortable': false,
//         'aTargets': [3,4,6] /* 1st one, start by the right */
//     }]
    
// });



$(document).ready(function() {
    
    var done_editing = $("#done_editing").val();
    
    data = {
        done_editing: done_editing
    };
    
    // $.noConflict();
    $("#item_listing").DataTable({
            "processing": true,
            "iDisplayLength": 20,
            "serverSide": true,
            "bLengthChange": false,
            "ajax": {
              url: '/admin/npl-list/search',
              type: 'POST',
              data: data
            },
            columns: [
              {
                  data: "barcode", render: function(data, type, row){
                    //   return '<input type="checkbox" name="selected[]" data-order="" class="iitemid" value="'+data+'"/>';
                      return $("<input>").attr({
                            type: 'checkbox',
                            class: "iitemid",
                            value: data,
                            name: "selected[]",
                            "data-order": data
                      })[0].outerHTML;
                  }
              },
              { "data": "barcode"},
              { "data": "item_name", render: function(data, type, row){
                  //console.log("data:"+data);
                  //  console.log("row:"+row);
                   return '<a href="/admin/npl-list-edit/'+row.barcode+'">'+data+'</a>';
              }},
              { "data": "item_type"},
              { "data": "department"},
              { "data": "category"},
              { "data": "selling_price"},
              { "data": "cost"}
            ],
            /*initComplete:function(){
                $(this).find("tbody input[type=checkbox]").icheck({
                    checkboxClass:
                });
            }*/
            "fnDrawCallback": function( oSettings ) {
                $(this).find("tbody input[type=checkbox]").iCheck({
                    checkboxClass:"icheckbox_minimal"
                });
            }
        });
    
    
    /*url = '/search?term='+term;
    
    $('#item_listing').DataTable( {
        "processing": true,
        "serverSide": true,
        "paging": true,
        "ajax": url
    } );*/
    var childCheckedStatus = true;
    $("#thCheckbox").on("ifChecked ifUnchecked", function(){
        console.log("prop");
        var status = $(this).prop('checked');
        if(childCheckedStatus && status){
    	    $("#item_listing").find("tbody input[type=checkbox]").prop('checked', status).iCheck('update');
    	    childCheckedStatus = true;
        }
        // $("#item_listing").find("tbody input[type=checkbox]");
    });
    
    $("#item_listing").on("ifChanged", "tbody input[type=checkbox]", function(){
       var parentStatus =  $("#thCheckbox").prop("checked"),
           childStatus = $(this).prop("checked");
           
        if(!childStatus && parentStatus){
            childCheckedStatus = false;
            $("#thCheckbox").iCheck('toggle');
        }
    });
});
</script>
<!-- DataTables -->

 <script>
//     $(".delete").on("submit", function(){
//         return confirm("Do you want to delete this User?");
//     });
 </script>


<script type="text/javascript">
  $("#upload_csv").click(function(e){
        e.preventDefault();
        
        console.log("Upload csv");

        $('#importItemModal').modal('hide');
        $('#loadingModal').modal('show');

        var import_form_id = $('form#form_item_import');
        var import_form_action = import_form_id.attr('action');
        
        var import_formdata = false;
            
        if (window.FormData){
            import_formdata = new FormData(import_form_id[0]);
        }
        
        
        //var formData = new FormData();
        //formData.append('file', $('#file')[0].files[0]);
        $.ajax({
           url : '/admin/npl/uploadcsv',
           type : 'POST',
           data : import_formdata ? import_formdata : import_form_id.serialize(),
           processData: false,  // tell jQuery not to process the data
           contentType: false,
           dataType:"text",// tell jQuery not to set contentType
        })
        .done(function(response){
          console.log(response);
          var  response = $.parseJSON(response); //decode the response array
          if( response.code == 1 ) {//success

            // $("div#divLoading").removeClass('show');
            $('#loadingModal').modal('hide');

            $('#successModal').modal('show');
            //$('#status_file')[0].click();
            
            setTimeout(function(){
              window.location.reload();
            }, 3000);
            
          } else if( response.code == 0 ) {//error
            // $("div#divLoading").removeClass('show');
            $('#loadingModal').modal('hide');
            alert(response.error);
            return;
          }
      
        });
            
    });
    
  $('#deleteItems').click(function(e){
    console.log('clicked delete');
    var barcodes = [];
    var barcode;
    $('div.checked').each(function (index, value) {
        barcode = $(value).find('input.iitemid').val();
        barcodes.push(barcode);
    });
    
    
    
    $.ajax({
      method: "POST",
      url: "/admin/delete/multiple/nplitems",
      data: {barcode: barcodes},
      success: function( msg ) {
        console.log( "Data Saved: " + msg.success );
        
        $('#deleteItemModal').modal('hide');
        
        $('#span_success_msg').html(msg.success);
        $('#successModal').modal('show');
        
        window.setTimeout(function(){location.reload()},3000);
      }
    });
    
    
    
    /*$.each($('div.checked'), function(v){
        console.log(v.closest('td').html());
    });*/
  });
  
$('#done_editing').on('change', function(){
    
    
    done_editing = $(this).val();
    
    console.log(done_editing);
    
    
    data = {
        done_editing: done_editing
    };
    $("#item_listing").dataTable().fnDestroy();

    $("#item_listing").DataTable({
            "processing": true,
            "iDisplayLength": 20,
            "serverSide": true,
            "bLengthChange": false,
            "ajax": {
              url: '/admin/npl-list/search',
              type: 'POST',
              data: data
            },
            columns: [
              {
                  data: "barcode", render: function(data, type, row){
                    //   return '<input type="checkbox" name="selected[]" data-order="" class="iitemid" value="'+data+'"/>';
                      return $("<input>").attr({
                            type: 'checkbox',
                            class: "iitemid",
                            value: data,
                            name: "selected[]",
                            "data-order": data
                      })[0].outerHTML;
                  }
              },
              { "data": "barcode"},
              { "data": "item_name", render: function(data, type, row){
                  //console.log("data:"+data);
                  //  console.log("row:"+row);
                   return '<a href="/admin/npl-list-edit/'+row.barcode+'">'+data+'</a>';
              }},
              { "data": "item_type"},
              { "data": "department"},
              { "data": "category"},
              { "data": "selling_price"},
              { "data": "cost"}
            ],
            "fnDrawCallback": function( oSettings ) {
                $(this).find("tbody input[type=checkbox]").iCheck({
                    checkboxClass:"icheckbox_minimal"
                });
            }
        });
});  
  
  
</script>
 
 @stop