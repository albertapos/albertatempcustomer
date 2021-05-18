@extends('layouts.layout')
@section('title', 'Item Adjustment')
@section('main-content')

<div id="content">

  <nav class="navbar navbar-expand-lg sub_menu_navbar navbar-dark bg-primary headermenublue">
    <div class="container-fluid">
        <div class="collapse navbar-collapse" id="main_nav">
            <div class="menu">
                <span class="font-weight-bold text-uppercase"> <?php echo $text_list; ?></span>
            </div>
            <div class="nav-submenu">
              <a type="button" href="<?php echo $add; ?>" class="btn btn-gray headerblack  buttons_menu add_new_btn_rotate"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add New</a>
          </div>
        </div> <!-- navbar-collapse.// -->
    </div>
  </nav>

  <section class="section-content py-6">
      {{-- <div class="page-header">
        <div class="container-fluid">
          
          <ul class="breadcrumb">
            <?php foreach ($breadcrumbs as $breadcrumb) { ?>
            <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
            <?php } ?>
          </ul>
        </div>
      </div> --}}
      <div class="container-fluid">
        <?php if ($error_warning) { ?>
        <div class="alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
          <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        <?php } ?>
        <?php if ($success) { ?>
        <div class="alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
          <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        <?php } ?>
        <div class="panel panel-default">
          
          <div class="panel-body">
    
            
            <div class="clearfix"></div>
    
            <form action="<?php echo $current_url;?>" method="post" id="form_adjustment_search">
                @csrf
              <input type="hidden" name="searchbox" id="vordertitle">
              <div class="row">
                  <div class="col-md-12">
                      <input type="text" name="automplete-product" class="form-control" placeholder="Search Adjustment Inventory..." id="automplete-product">
                  </div>
              </div>
            </form>
            <br>
            
              <div class="table-responsive">
                <table id="adjustment_detail" class="table table-hover" data-toggle="table" data-classes="table table-hover table-condensed promotionview"
                data-row-style="rowColors" data-striped="true" data-pagination="true" data-click-to-select="true">
                <?php if ($adjustment_details) { ?>
                  <thead>
                    <tr class="header-color">
                      <th class="text-center" ><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></th>
                      <th class="text-left text-uppercase"><?php echo $text_number; ?></th>
                      <th class="text-left text-uppercase"><?php echo $text_created; ?></th>
                      <th class="text-left text-uppercase"><?php echo $text_title; ?></th>
                      <th class="text-left text-uppercase"><?php echo $text_status; ?></th>
                      <th class="text-left text-uppercase">Action</th>
                    </tr>
                  </thead>
                  <tbody>
    
                    <?php foreach ($adjustment_details as $adjustment_detail) { ?>
                    <tr>
                      <td data-order="<?php echo $adjustment_detail['ipiid']; ?>" class="text-center">
                        <span style="display:none;"><?php echo $adjustment_detail['ipiid']; ?></span>
                        <input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" />
                      </td>
                      
                      <td class="text-left">
                        <span><?php echo $adjustment_detail['vrefnumber']; ?></span>
                      </td>
    
                      <td class="text-left">
                        <?php
                        
                          if(isset($adjustment_detail['dcreatedate']) && !empty($adjustment_detail['dcreatedate']) && $adjustment_detail['dcreatedate'] != '0000-00-00 00:00:00'){
                            $dcreatedate =  DateTime::createFromFormat('Y-m-d H:i:s', $adjustment_detail['dcreatedate'])->format('m-d-Y');
                          }else{
                            $dcreatedate = '';
                          }
                        
                        ?>
                        <span><?php echo $dcreatedate; ?></span>
                      </td>
    
                      <td class="text-left">
                        <span><?php echo $adjustment_detail['vordertitle']; ?></span>
                      </td>
    
                      <td class="text-left">
                        <span><?php echo $adjustment_detail['estatus']; ?></span>
                      </td>
    
                      <td class="text-left">
                        <a href="<?php echo $adjustment_detail['edit']; ?>" data-toggle="tooltip" title="Edit" class="btn btn-sm btn-info edit_btn_rotate" ><i class="fa fa-pencil">&nbsp;&nbsp;Edit</i>
                        </a>
                      </td>
                    </tr>
    
                    <?php } ?>
                    <?php } else { ?>
                    <tr>
                      <td colspan="7" class="text-center"><?php echo $text_no_results;?></td>
                    </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
              <?php if ($adjustment_details) { ?>
              <div class="row">
                <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
                <div class="col-sm-6 text-right"><?php echo $results; ?></div>
                {{$adjustment_details->links()}}
              </div>
              <?php } ?>
          </div>
        </div>
      </div>
  </section>
</div>

@endsection

@section('page-script')


<link href = "https://code.jquery.com/ui/1.12.1/themes/ui-lightness/jquery-ui.css" rel = "stylesheet">
<script src = "https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script>
    $(function() {
        
        var url = '<?php echo $searchadjustment;?>';
        
        url = url.replace(/&amp;/g, '&');
        
        $( "#automplete-product" ).autocomplete({
            minLength: 2,
            dataType: "json",
            source: function(req, add) {
                $.getJSON(url, req, function(data) {
                    var suggestions = [];
                    $.each(data, function(i, val) {
                        suggestions.push({
                            label: val.vordertitle,
                            value: val.vordertitle,
                            id: val.ipiid
                        });
                    });
                    add(suggestions);
                });
            },
            select: function(e, ui) {
                $('form#form_adjustment_search #vordertitle').val(ui.item.id);
                
                if($('#vordertitle').val() != ''){
                    $('#form_adjustment_search').submit();
                    $("div#divLoading").addClass('show');
                }
            }
        });
    });

    $(function() { $('input[name="automplete-product"]').focus(); });
</script>

<script type="text/javascript">
  $(document).ready(function($) {
    $("div#divLoading").addClass('show');
  });

  // $(window).load(function() {
  //   $("div#divLoading").removeClass('show');
  // });
</script>

@endsection