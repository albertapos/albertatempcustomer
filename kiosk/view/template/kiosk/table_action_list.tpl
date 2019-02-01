<?php echo $header; ?><?php echo $column_left; ?>

<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right"> <a onclick="$('#form-category').attr('action', '<?php echo $edit_list; ?>'); $('#form-category').submit();" class="btn btn-primary"><i class="fa fa-save"></i></a>
        <button type="button" onclick="addCategory();" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus"></i></button>        
      </div>
      <h1><?php echo $heading_title; ?></h1>
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
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-list"></i> &nbsp;</h3>
      </div>
      <div class="panel-body">
        <div class="">
          <table id="table_action" class="table table-bordered table-hover" style="width:50%;">
              <thead style="display:none;">
                <tr>
                  <th>&nbsp;</th>
                  <th>&nbsp;</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>
                    <b>Table Export : </b>
                  </td>
                  <td>
                    <button title="Export" class="btn btn-info" id="export_btn" data-href="<?php echo $export; ?>">Export</button> &nbsp;&nbsp;&nbsp;
                    <a id="export_download" href="" download style="display:none;">
                      Click Here to Download
                    </a>
                  </td>
                </tr>
                <tr>
                  <td>
                    <b>Table Import : </b>
                  </td>
                  <td>
                    <button title="Import" class="btn btn-info" data-toggle="modal" data-target="#importModal">Import</button>
                  </td>
                </tr>
              </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>


<!-- Modal -->
  <div class="modal fade" id="importModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Import Data</h4>
        </div>
        <form action="<?php echo $import; ?>" id="import_form" method="post" enctype="multipart/form-data">
          <div class="modal-body">
              <input type="file" class="form-control" name="import_file" id="import_file">
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-success">Import</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </form>
      </div>
      
    </div>
  </div>
<!-- Modal -->

<div id="divLoading"></div>

<script type="text/javascript">
  $(document).on('click', '#export_btn', function(event) {
    event.preventDefault();
    
    $("div#divLoading").addClass('show');

    var url = $(this).attr('data-href');
    
    $.ajax({
      url : url,
      type : 'GET',
    }).done(function(response){
      var  response = $.parseJSON(response); //decode the response array
      
      if( response.code == 1 ) {//success
        $('#export_btn').prop('disabled', true);
        
        $('#export_download').show();
        $('#export_download').attr('href',response.response);

        $("div#divLoading").removeClass('show');
       
        return false;
      }else if( response.code == 0 ) {//error

          alert('Something Went Wrong!!!');
          $('#export_btn').prop('disabled', false);
          return false;;
      
      }
      
    });
  });
</script>

<style type="text/css">

  #divLoading{
    display : none;
  }
  #divLoading.show{
    display : block;
    position : fixed;
    z-index: 100;
    background-image : url('view/image/loading1.gif');
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

<script type="text/javascript">
  $(document).on('submit', '#import_form', function(event) {
    event.preventDefault();

    if($('#import_file').val() == ''){
      alert('Please Select file');
      return false;
    }

    // console.log($('#import_file').val());
    // return false;

    $("div#divLoading").addClass('show');
    $('#importModal').modal('hide');

    var import_form_id = $('form#import_form');
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

        $('#import_confirm_form #sure_msg').html(response.response);
        $('#import_confirm_form #backup_file_path').val(response.backup_file_path);
        $('#import_confirm_form #uploaded_file_path').val(response.uploaded_file_path);

        $("div#divLoading").removeClass('show');

        $('#importModal').modal('hide');
        $('#importconfirmModal').modal('show');
        
        return false;
      }else if(response.code == 2){
        $('#import_confirm_form #sure_msg').html(response.response);
        $('#import_confirm_form #backup_file_path').val(response.backup_file_path);
        $('#import_confirm_form #uploaded_file_path').val(response.uploaded_file_path);

        $("div#divLoading").removeClass('show');

        $('#importModal').modal('hide');
        $('#importconfirmModal').modal('show');
      }
      
    });

  });
</script>

<!-- import confirm Modal -->
  <div class="modal fade" id="importconfirmModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <form action="<?php echo $import_confirm; ?>" id="import_confirm_form" method="post" enctype="multipart/form-data">
          <div class="modal-body text-center">
              <p id="sure_msg"></p>
              <input type="hidden" name="backup_file_path" id="backup_file_path" value="">
              <input type="hidden" name="uploaded_file_path" id="uploaded_file_path" value="">
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-success">Sure</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          </div>
        </form>
      </div>
      
    </div>
  </div>
<!-- import confirm Modal -->

<script type="text/javascript">
  $(document).on('submit', '#import_confirm_form', function(event) {
    event.preventDefault();

    $('#importconfirmModal').modal('hide');
    $("div#divLoading").addClass('show');
    
    var import_confirm_form_id = $('form#import_confirm_form');
    var import_confirm_form_action = import_confirm_form_id.attr('action');
    
    var import_confirm_formdata = false;
        
    if (window.FormData){
        import_confirm_formdata = new FormData(import_confirm_form_id[0]);
    }

    $.ajax({
        url : import_confirm_form_action,
        data : import_confirm_formdata ? import_confirm_formdata : import_confirm_form_id.serialize(),
        cache : false,
        contentType : false,
        processData : false,
        type : 'POST',
    }).done(function(response){

      var  response = $.parseJSON(response); //decode the response array
      
      if( response.code == 1 ) {//success
        $("div#divLoading").removeClass('show');
        $('#importconfirmModal').modal('hide');
        $('#successModal').modal('show');
        return false;
      }else if(response.code == 0){
        $("div#divLoading").removeClass('show');
        $('#importconfirmModal').modal('hide');
        alert('Something Went Wrong!!!');
        return false;
      }
      
    });

  });
</script>

<!-- Modal -->
  <div class="modal fade" id="successModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="border-bottom:none;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body text-center">
          <div class="alert alert-success">
            <h3><strong>Data Imported Successfully!!!</strong></h3>
          </div>
        </div>
        
      </div>
      
    </div>
  </div>

<?php echo $footer; ?>