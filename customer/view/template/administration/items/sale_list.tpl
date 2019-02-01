<?php echo $header; ?><?php echo $column_left; ?>

<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      
      <!-- <h1><?php echo $heading_title; ?></h1> -->
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <?php if ($success) { ?>
    <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading head_title">
        <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_list; ?></h3>
        
      </div>
      <div class="panel-body">

        <div class="row" style="padding-bottom: 9px;float: right;">
          <div class="col-md-12">
            <div class="">
              <a href="<?php echo $add; ?>" class="btn btn-primary add_new_btn_rotate"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add New</a>
              <button style="display: none;" class="btn btn-info" data-toggle="modal" data-target="#myModalImport"><i class="fa fa-file"></i>&nbsp;&nbsp;Import sale</button>      
            </div>
          </div>
        </div>
        <div class="clearfix"></div>
        
          <div class="table-responsive">
            <table id="sale" class="table table-bordered table-hover" style="">
            <?php if ($sales) { ?>
              <thead>
                <tr>
                  <th style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></th>
                  <th class="text-left"><?php echo $column_sale_name; ?></th>
                  <th class="text-leftr"><?php echo $column_sale_type; ?></th>
                  <th class="text-right"><?php echo $column_buy_qty; ?></th>
                  <th class="text-left"><?php echo $column_start_date; ?></th>
                  <th class="text-left"><?php echo $column_end_date; ?></th>
                  <th class="text-left"><?php echo $column_status; ?></th>
                  <th class="text-left">Action</th>
                </tr>
              </thead>
              <tbody>

                <?php foreach ($sales as $sale) { ?>
                <tr>
                <td data-order="<?php echo $sale['isalepriceid']; ?>" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
                <td class="text-left"><span><?php echo $sale['vsalename']; ?></span></td>
                <td class="text-left"><span><?php echo $sale['vsaletype']; ?></span></td>
                <td class="text-right"><span><?php echo $sale['nbuyqty']; ?></span></td>
                <td class="text-left"><span><?php if($sale['dstartdatetime']!='' && $sale['dstartdatetime'] != "0000-00-00 00:00:00"){echo date("m-d-y", strtotime($sale['dstartdatetime']));} ?></span></td>
                <td class="text-left"><span><?php if($sale['denddatetime']!='' && $sale['denddatetime'] != "0000-00-00 00:00:00"){echo date("m-d-y", strtotime($sale['denddatetime']));} ?></span></td>
                <td class="text-left"><span><?php echo $sale['estatus']; ?></span></td>
                <td class="text-left"><a href="<?php echo $sale['edit']; ?>" data-toggle="tooltip" title="Edit" class="btn btn-sm btn-info edit_btn_rotate" ><i class="fa fa-pencil">&nbsp;&nbsp;Edit</i> </a></td>
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
      </div>
    </div>
  </div>
</div>


<!-- Modal -->
<div id="myModalImport" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-center">Import Sale</h4>
      </div>
      <div class="modal-body">
        <form action="<?php echo $import_sale;?>" method="post" enctype="multipart/form-data" id="form_import_sale">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <span style="display:inline-block;width:8%;">File: </span> <span style="display:inline-block;width:85%;"><input type="file" name="import_sale_file" class="form-control" accept="text/xml" required></span>
              </div>
            </div>
            <div class="col-md-12 text-center">
              <div class="form-group">
                <input type="submit" class="btn btn-success" name="import_sale" value="Import sale">
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
<style type="text/css">
  div.content {
   width : 1000px;
   height : 1000px;
  }

</style>

<?php echo $footer; ?>

<div class="modal fade" id="successModal" role="dialog">
  <div class="modal-dialog modal-sm">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header" style="border-bottom:none;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div class="alert alert-success text-center">
          <p id="success_msg"><strong>Successfully Imported Sale Items!</strong></p>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  $(document).on('submit', 'form#form_import_sale', function(event) {
    event.preventDefault();

    $("div#divLoading").addClass('show');
    $('#myModalImport').modal('hide');

    var import_form_id = $('form#form_import_sale');
    var import_form_action = import_form_id.attr('action');
    
    var import_formdata = false;
        
    if (window.FormData){
        import_formdata = new FormData(import_form_id[0]);
    }
 
    $.ajax({
            url : import_form_action,
            data : import_formdata ? import_formdata : import_form_id.serialize(),
            cache : false,
            contentType : false,
            processData : false,
            type : 'POST',
        }).done(function(response){
          var  response = $.parseJSON(response); //decode the response array
          if( response.code == 1 ) {//success

            $("div#divLoading").removeClass('show');
            $('#successModal').modal('show');
            setTimeout(function(){
              window.location.reload();
            }, 3000);
            
          } else if( response.code == 0 ) {//error
            $("div#divLoading").removeClass('show');
            alert(response.error);
            return;
          }
      
      });
  });
</script>
<script type="text/javascript">
  $(window).load(function() {
    $("div#divLoading").removeClass('show');
  });
</script>