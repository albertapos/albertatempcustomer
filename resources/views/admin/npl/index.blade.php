@extends('main')

@section('content')

<style>
    .panel-default>.panel-heading{
        background-color:#fff !important;
        border-top: 2px solid #c1c1c1;
    }
    .panel-title{
        font-size:20px !important;
    }
</style>
<link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel = "stylesheet">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!--<aside class="left-side sidebar-offcanvas">-->
    <!-- sidebar: style can be found in sidebar.less -->
<!--    @include('layouts.sidebar')-->

<!--</aside>-->
<!--<aside class="right-side">-->
<!-- Content Header (Page header) -->

<section class="content-header">


<div id="content">
  <div class="page-header" style="border:none;">
    
  </div>
  <div class="container-fluid">

   
    <div class="panel panel-default">
      <div class="panel-heading head_title">
         
        <h3 class="panel-title" >NPL Items </h3>
        
      </div>
      <div class="panel-body">
        <div class="row" style="padding-bottom: 15px;float: right;">
          <div class="col-md-12">
            <div class="">
              <!--<span><input type="checkbox" name="disable_checkbox" >&nbsp;&nbsp;<b>Show Disable Items</b></span>&nbsp;&nbsp;-->
              <!--<a href="" title="Show All Items" class="btn btn-primary show_all_btn_rotate"><i class="fa fa-eye"></i>&nbsp;&nbsp;Show All NPL Items</a>-->
               
                 <!--<button type="button" class="btn btn-danger" id="delete_btn" style="border-radius: 0px;float: right;" disabled="true"><i class="fa fa-file-text-o"></i>&nbsp;&nbsp;Delete Selected Items</button>-->
             
              <button type="button" class="btn btn-info" data-toggle="modal" data-target="#importItemModal"><i class="fa fa-file-text-o"></i>&nbsp;&nbsp;Import NPL Items</button>
              <button type="button" data-toggle="modal" data-target="#importItemModal" class="btn btn-warning"><i class="fa fa-file-text-o"></i>&nbsp;&nbsp;Import (SKU, ItemName & Size only)</button>

              <a href="{{ url('/admin/npl-list-insert') }}" title="" class="btn btn-primary add_new_btn_rotate"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add New</a>&nbsp;  
            </div>
          </div>
        </div>
        
       
          <div class="row">
              <div class="col-md-12">
                    {!!Form::open(array('method' => 'post','id' => 'form_npl_search')) !!}
                        <input type="hidden" name="barcode" id="barcode">
                  <input type="text" name="automplete-search-box" class="form-control" placeholder="Search Item..." id="automplete-product" >
              </div>
          </div>
        
        <br>
                    {!!form::close() !!}
        <form action="" method="post" enctype="multipart/form-data" id="form-items">
          
          <div class="table-responsive">
            <table id="item" class="table table-bordered table-hover">
   
              <thead>
                <tr>
                  <th style="width: 1px;" class="text-center"><input type="checkbox" onclick=""/></th>
                  <th class="text-left "><a href="" style="color: #fff;" class="show_all_btn_rotate"></a>Item Name</th>
                  <th class="text-left ">Item Type</th>
                  <th class="text-left ">Sku</th>
               
                       <th class="text-left ">Dept.</th>
                   
                    <th class="text-left ">Category</th>
                    <th class="text-left ">Price</th>
                    <th class="text-left ">Cost</th>
                    <!--<th class="text-right text-uppercase">QTY. ON HAND</th>-->
                    <!--<th class="text-right text-uppercase"></th>-->
            
                </tr>
              </thead>
              <tbody id="myTable">
                
              
                  
                    @foreach($nplitems as $nplitem)
                    <tr>
                        <td data-order="{{$nplitem->barcode}}" class="text-center">
                        
                            <input type="checkbox" name="selected[]" class="iitemid"  value="" />
                    
                        </td>
                    
                        <td class="text-left">
                            <a href="{{url('/admin/npl-list-edit', [$nplitem->barcode])}}" data-toggle="tooltip" title="Edit" class="edit_btn_rotate">
                                {{$nplitem->item_name}}
                            </a>
                        </td>
                    
                        <td class="text-left">
                            <span>{{$nplitem->item_type}}</span>
                        </td>

                        <td class="text-left">
                            <span>{{(string)$nplitem->barcode}}</span>
                        </td>

                   
                        <td class="text-left">
                         
                            <span>{{$nplitem->department}}</span>
                          
                            <span></span>
                      
                            <span></span>
                        
                            <span></span>
                        
                            <span></span>
                    
                            <span></span>
                   
                            <span></span>
                    
                            <span></span>
                       
                            <span></span>
                       
                   
                        
                        </td>
                 
                        <td class="text-left">
                            <span>{{$nplitem->category}}</span>
                        </td>
    
                        <td class="text-left">
                            <span>{{$nplitem->selling_price}}</span>
                        </td>
    
                        <td class="text-left">
                            <span>{{$nplitem->cost}}</span>
                        </td>
                          <!--<td class="text-right">-->
                          <!--  <span></span>-->
                          <!--</td>-->
                 @endforeach

                  </tr>
    
        
                <!--<tr>-->
                <!--  <td colspan="7" class="text-center"></td>-->
                <!--</tr>-->
           
              </tbody>
            </table>
            @if(count($nplitems)!= 0)
            {{ $nplitems->links() }}
            @endif
          </div>
        </form>
        <div class="row">
          <div class="col-sm-6 text-left"></div>
          <div class="col-sm-6 text-right"></div>
        </div>
      </div>
    </div>
  </div>
</div>





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
        <input type="submit" class="btn btn-danger" name="deleteItems" value="Delete">
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
          <p id="success_msg"><strong>Items Imported Successfully!</strong></p>
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
          <p id="success_msg"><strong>Items getting imported...!!</strong></p>
        </div>
        <div class="text-center" style="display:none;">
          <!--<a id="status_file" href="/view/template/administration/import-item-status-report.txt" download="import-item-status-report.txt">Status of Imported File</a>-->
        </div>
      </div>
    </div>
  </div>
</div>
</section> 

<!-- Main content -->


</div>




@stop


@section('scripts')
<script type="text/javascript">

    /*console.log($('.iitemid').filter(':checked').length);


    var checkBoxes = $('.iitemid');*/
    
    /*var checkBoxes = $('.iitemid');

    checkBoxes.change(function () {
        console.log(checkBoxes.filter(':checked').length);
        $('#delete_btn').prop('disabled', checkBoxes.filter(':checked').length < 1);
    });*/
    

    $(document).on('click', '.iitemid', function(event) {
        var flag = $('.iitemid').filter(':checked').length < 1?true:false;
        console.log(flag);
        $('#delete_btn').prop('disabled', flag);
    
    });


    $(document).on('click', '#delete_btn', function(event) {
        event.preventDefault();
        
        $('#deleteItemModal').modal('show');
    
    });
    
    
  
    $(document).on('click', 'input[name=deleteItems]', function(){
        $('#deleteItemModal').modal('hide');
        
        var dataItemOrders = [];
         $('.iitemid').filter(':checked').each(function(){
             dataItemOrders.push($(this).parents('td').data('order'));
         });
        console.log($('.iitemid').filter(':checked').length);
        
        $.ajax({
             
            url : "/admin/delete/multiple/nplitems",
            data : JSON.stringify(dataItemOrders),
            method : 'POST',
            contentType: "application/json",
            dataType: 'json',
            success: function(data) {
                console.log(data);
                $('#success_msg').html('<strong>'+ data.success +'</strong>');
                //$("div#divLoading").removeClass('show');
                $('#successModal').modal('show');
        
                setTimeout(function(){
                 $('#successModal').modal('hide');
                 window.location.reload();
                }, 3000);
            },
            error: function(jqXHR, exception) { // if error occured
                //var  response_error = $.parseJSON(xhr.responseText); //decode the response array
                console.log(exception + ": " +jqXHR.responseText);
                

                return false;
            }
        });
        
        
    });
    
    
    
    
  
</script>


<script type="text/javascript">

  $("#upload_file").click(function(e){
        e.preventDefault();
        
        console.log("Upload File: Name & SKU");

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

    
    


 
    //     $( "#automplete-product" ).autocomplete({
    //         minLength: 1,
    //         source: function(req, add) {
    //             $.getJSON("/admin/npl-items", req, function(data) {
    //                 var suggestions = [];
    //                 $.each(data, function(i, val) {
    //                     suggestions.push({
    //                         label: val.item_name,
    //                         value: val.item_name,
    //                         id: val.barcode
    //                     });
    //                 });
    //                 add(suggestions);
    //             });
    //         },
    //         select: function(e, ui) {
    //             $('#barcode').val(ui.item.barcode);

    //             if($('#barcode').val() != ''){
    //                 $('#form_npl_search').submit();
    //             }
    //         }
    //     });
    // });
    
    
    $("#automplete-product").on("keyup", function() {
    
        var searchText = $('#automplete-product').val();
        url = "/search?term="+searchText;
    
        $( "#automplete-product" ).autocomplete({
            minLength: 2,
            source: function(req, add) {
                $.getJSON(url, req, function(data) {
                    window.suggestions = [];
                    $.each(data, function(i, val) {
                        suggestions.push({
                            label: val.item_name,
                            value: val.item_name,
                            id: val.barcode
                        });
                    });
                    add(window.suggestions);
                });
            },
            select: function(e, ui) {
              var edit_url = "/admin/npl-list-edit/";
              edit_url = edit_url+ui.item.id;

              $("div#divLoading").addClass('show');
            //   console.log(edit_url);
              window.location.href = edit_url;
            }
        });
    
    
    
    });
    
    
    
    
    
      /*$("#automplete-product").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#myTable tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      });*/
</script>

@stop