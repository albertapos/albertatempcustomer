@extends('main')
@section('content')

<style type="text/css">

  #divLoading{
    display : none;
  }
  #divLoading.show{
    display : block;
    position : fixed;
    z-index: 9999;
    background-image : url('/assets/img/loading1.gif');
    background-color:#666;
    opacity : 0.9;
    background-repeat : no-repeat;
    background-position : center;
    left : 0;
    bottom : 0;
    right : 0;
    top : 0;
    background-size: 250px;
  }

  #loadinggif.show{
    left : 50%;
    top : 50%;
    position : absolute;
    z-index : 101;
    width : 32px;
    height : 32px;
    margin-left : -16px;
    margin-top : -16px;
  }

  div.content {
   width : 1000px;
   height : 1000px;
  }

</style>

<div id="divLoading" class=""></div>

<link href="{{ asset('/assets/js/plugins/datatables/dataTables.bootstrap.css')}}" rel="stylesheet" type="text/css" />
<div class="col-md-12">
 
</div>
<section class="content-header">
    <h1>
       PLCB Products listing
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
                    <h3 class="box-title">PLCB Products Details</h3>
                </div>
                <br>
                <div class="box-body">
                    {!!Form::open(array('method' => 'post','id' => 'form_product_search')) !!}
                        <input type="hidden" name="product_id" id="product_id">
                        <div class="row">
                            <div class="col-md-12">
                                <input type="text" class="form-control" placeholder="Search Product..." id="automplete-product">
                            </div>
                        </div>
                        <br><br>
                    {!!form::close() !!}
                    <table id="plcb_products_listing" class="table table-bordered table-striped table-hover" style="font-size:12px;">
                        <thead>
                            <tr>
                                {{-- <th>ID</th> --}}
                                <th>
                                    @if(!empty(Request::get('product_name')) && Request::get('product_name') == 'desc')
                                        <span class="product_name_sort" data-href="/admin/plcb-products?product_name=asc" style="cursor:pointer;">Product Name&nbsp;&nbsp;<i class="fa fa-caret-up" style="font-size:18px;" aria-hidden="true"></i></span>
                                    @elseif(!empty(Request::get('product_name')) && Request::get('product_name') == 'asc')
                                        <span class="product_name_sort" data-href="/admin/plcb-products?product_name=desc" style="cursor:pointer;">Product Name&nbsp;&nbsp;<i class="fa fa-caret-down" style="font-size:18px;" aria-hidden="true"></i></span>
                                    @else
                                        <span class="product_name_sort" data-href="/admin/plcb-products?product_name=asc" style="cursor:pointer;">Product Name&nbsp;&nbsp;<i class="fa fa-sort" style="font-size:18px;" aria-hidden="true"></i></span>
                                    @endif
                                    
                                </th>
                                <th>Unit</th>
                                <th>Unit Value</th>
                                <th>
                                    @if(!empty(Request::get('bucket_name')) && Request::get('bucket_name') == 'desc')
                                        <span class="bucket_name_sort" data-href="/admin/plcb-products?bucket_name=asc" style="cursor:pointer;">Bucket Name&nbsp;&nbsp;<i class="fa fa-caret-up" style="font-size:18px;" aria-hidden="true"></i></span>
                                    @elseif(!empty(Request::get('bucket_name')) && Request::get('bucket_name') == 'asc')
                                        <span class="bucket_name_sort" data-href="/admin/plcb-products?bucket_name=desc" style="cursor:pointer;">Bucket Name&nbsp;&nbsp;<i class="fa fa-caret-down" style="font-size:18px;" aria-hidden="true"></i></span>
                                    @else
                                        <span class="bucket_name_sort" data-href="/admin/plcb-products?bucket_name=asc" style="cursor:pointer;">Bucket Name&nbsp;&nbsp;<i class="fa fa-sort" style="font-size:18px;" aria-hidden="true"></i></span>
                                    @endif
                                </th>
                                <th>Previous Month beginning Qty</th>
                                <th>Previous Month ending Qty</th>
                                <th>Malt</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        @if(count($plcb_products) > 0)
                            @foreach($plcb_products as $plcb_product)
                                <tr>
                                    {{-- <td data-order="{{$plcb_product->iitemid}}">
                                        {{$plcb_product->iitemid}}
                                    </td> --}}
                                    <td>
                                        {{$plcb_product->vitemname}}
                                        <input type="hidden" name="prduct_name" value="{{$plcb_product->vitemname}}">
                                    </td>
                                    <td>
                                        {{-- {{ $plcb_product->unit_id or '' }} --}}
                                        <select name="unit_id" class="form-control" required>
                                            <option value="">Select Unit</option>
                                            @foreach($units as $unit)
                                                @if($unit->id == $plcb_product->unit_id)
                                                    <option value="{{$unit->id}}" selected="selected">{{$unit->unit_name}}</option>
                                                @else
                                                    <option value="{{$unit->id}}">{{$unit->unit_name}}</option>
                                                @endif
                                            @endforeach
                                    </td>
                                    <td>
                                        <input type="text" class="editable" name="unit_value" id="" value="{{ $plcb_product->unit_value or '' }}" />
                                    </td>
                                    <td>
                                        {{-- {{ $plcb_product->bucket_name or '' }} --}}
                                        <select name="bucket_id" class="form-control" required>
                                            <option value="">Select Bucket</option>
                                            @foreach($buckets as $bucket)
                                                @if($bucket->id == $plcb_product->bucket_id)
                                                    <option value="{{$bucket->id}}" selected="selected">{{$bucket->bucket_name}}</option>
                                                @else
                                                    <option value="{{$bucket->id}}">{{$bucket->bucket_name}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        {{-- {{ $plcb_product->prev_mo_beg_qty or '' }} --}}
                                        <input type="text" class="editable" name="prev_mo_beg_qty" id="" value="{{ $plcb_product->prev_mo_beg_qty or '' }}" />
                                    </td>
                                    <td>
                                        {{-- {{ $plcb_product->prev_mo_end_qty or '' }} --}}
                                        <input type="text" class="editable" name="prev_mo_end_qty" id="" value="{{ $plcb_product->prev_mo_end_qty or '' }}" />
                                    </td>
                                    <td>
                                        <input type="checkbox" name="malt" value="1" {{$plcb_product->malt==1?'checked':''}}>
                                    </td>
                                    <td>
                                        <a href="/admin/plcb-products/{{ $plcb_product->iitemid }}/edit" class="btn btn-xs btn-info update_record">Save</a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <div class="col-md-12">
                                <div class="alert alert-danger">
                                  Sorry we not found any product!!!
                                </div>
                           </div>
                        @endif
                       </tbody>
                    </table>
                </div><!-- /.box-body -->
                <div class="pull-left" style="margin-top: 30px;"> Showing {{($plcb_products->currentPage() * $plcb_products->perPage()) - $plcb_products->perPage() + 1}} to {{($plcb_products->lastPage() == $plcb_products->currentPage() ? $plcb_products->total() : $plcb_products->currentPage() * $plcb_products->perPage())}} of {{$plcb_products->total()}} Products</div>
                <div class="dataTables_paginate pull-right">
                    {{$plcb_products->links()}}
                </div>
                <div style="clear:both"></div>
                
            </div><!-- /.box -->
        </div>
    </div>  
</section>

<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<!-- DataTables -->
{{-- <script src="{{asset('/assets/js/plugins/datatables/jquery.dataTables.min.js')}}"></script> --}}
{{-- <script src="{{asset('/assets/js/plugins/datatables/dataTables.bootstrap.min.js')}}"></script> --}}

<link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel = "stylesheet">
<script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

<script type="text/javascript">
// $('#plcb_products_listing').DataTable({
//     "paging": true,
//     "iDisplayLength": 25,
//     "lengthChange": true,
//     "searching": true,
//     "ordering": true,
//     "info": true,
//     "autoWidth": true,
//     "processing": true ,
//     // "aaSorting": [[ 7, "desc" ]],
//     // 'aoColumnDefs': [{
//     //     'bSortable': false,
//     //     'aTargets': [4,5,9] /* 1st one, start by the right */
//     // }]
//     "fnDrawCallback": function( oSettings ) {
//       $('#divLoading').removeClass('show');
//     }
    
// });

</script>
<!-- DataTables -->

<script type="text/javascript">
    $('.editable').focus(function() {
        $(this).addClass("focusField");     
      if (this.value == this.defaultValue){
        this.select();
        }
      if(this.value != this.defaultValue){
            this.select();
      }
    });
    $('.editable').change(function() {
        $(this).removeClass("focusField");              
      if (this.value == ''){
        this.value = (this.defaultValue ? this.defaultValue : '');          
        }               
   });     
</script>

<style type="text/css">
    .focusField {
        color: #000;
        border: solid 2px #EEEEEE !important;
        background: #FFC !important;
    }
    .editable {
        color: #000;
        border: none;   
        background: none;
        cursor: pointer;
    }
</style>

<script type="text/javascript">
    $(document).on('click', '.update_record', function(event) {
    event.preventDefault();

        $("div#divLoading").addClass('show');

        var url = $(this).attr('href');
        var prduct_name = $(this).parent().parent().find('input[name="prduct_name"]').val();
        var unit_id = $(this).parent().parent().find('select[name="unit_id"]').val();
        var unit_value = $(this).parent().parent().find('input[name="unit_value"]').val();
        var bucket_id = $(this).parent().parent().find('select[name="bucket_id"]').val();
        var prev_mo_beg_qty = $(this).parent().parent().find('input[name="prev_mo_beg_qty"]').val();
        var prev_mo_end_qty = $(this).parent().parent().find('input[name="prev_mo_end_qty"]').val();

        if($(this).parent().parent().find('input[name="malt"]').prop('checked') == true){
            var malt = 1;
        }else{
            var malt = '';
        }

        if(unit_id == ''){
            alert('Please Select Unit!!!');
            $("div#divLoading").removeClass('show');
            return false;
        }

        if(unit_value == ''){
            alert('Please Enter Unit Value!!!');
            $("div#divLoading").removeClass('show');
            return false;
        }

        if(bucket_id == ''){
            alert('Please Select Bucket!!!');
            $("div#divLoading").removeClass('show');
            return false;
        }

        if(prev_mo_beg_qty == ''){
            alert('Please Enter beginning Qty!!!');
            $("div#divLoading").removeClass('show');
            return false;
        }

        if(prev_mo_end_qty == ''){
            alert('Please Enter End Qty!!!');
            $("div#divLoading").removeClass('show');
            return false;
        }

        $.ajax({
                url : url,
                data : {prduct_name:prduct_name, unit_id:unit_id, unit_value:unit_value, bucket_id:bucket_id, prev_mo_beg_qty:prev_mo_beg_qty, prev_mo_end_qty:prev_mo_end_qty, malt:malt},
                type : 'POST',
            }).done(function(response){
                if( response.code == 1 ) {//success
                    $("div#divLoading").removeClass('show');
                    $('#successModal').modal('show');
                    setTimeout(function(){
                      $('#successModal').modal('hide');
                    }, 3000);
                    return false;
                } else if( response.code == 0 ) {//error
                    $("div#divLoading").removeClass('show');
                    alert(response.response);
                    return;
                }
            });
        
    });
</script>


<!-- Modal -->
<div id="successModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
    <br>
      <div class="modal-body">
        <div class="alert alert-success text-center">
          <strong>PLCB Product Data Updated Successfully!!!</strong>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
    $(document).on('click', '.product_name_sort, .bucket_name_sort', function(event) {
        event.preventDefault();
        var url_sort = $(this).attr('data-href');
        window.location = url_sort;
    });
</script>

 <script>
    $(function() {
        
        $( "#automplete-product" ).autocomplete({
            minLength: 2,
            source: function(req, add) {
                $.getJSON("/admin/plcb-products-list", req, function(data) {
                    var suggestions = [];
                    $.each(data, function(i, val) {
                        suggestions.push({
                            label: val.vitemname,
                            value: val.vitemname,
                            id: val.iitemid
                        });
                    });
                    add(suggestions);
                });
            },
            select: function(e, ui) {
                $('#product_id').val(ui.item.id);

                if($('#product_id').val() != ''){
                    $('#form_product_search').submit();
                }
            }
        });
    });
</script>

  @stop