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

        <div class="row" style="padding-bottom: 15px; float: right;">
          <div class="col-md-12">
            <div class="">
              <a id="save_button" class="btn btn-primary" title="Save"><i class="fa fa-save"></i>&nbsp;&nbsp;Save</a>
              <button type="button" onclick="addSize();" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add New</button>    
            </div>
          </div>
        </div>
        <div class="clearfix"></div>

      <form action="<?php echo $current_url;?>" method="post" id="form_size_search">
        <input type="hidden" name="searchbox" id="isizeid">
        <div class="row">
            <div class="col-md-12">
                <input type="text" name="automplete-product" class="form-control" placeholder="Search Size..." id="automplete-product">
            </div>
        </div>
      </form>
       <br>
          
        <form action="" method="post" enctype="multipart/form-data" id="form-size">
          <div class="table-responsive">
          <?php if ($sizes) { ?>
            <table id="size" class="text-center table table-bordered table-hover" style="width:50%;">
              <thead>
                <tr>
                  <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
                  <td style="" class="text-left"><?php echo $column_name; ?></td>
                  <!-- <td class="text-center"><?php echo $column_action; ?></td> -->
                </tr>
              </thead>
              <tbody>
                <?php $size_row = 1;$i=0; ?>
                <?php foreach ($sizes as $k => $size) { ?>
                  <tr>
                    <td class="text-center">
                      <input type="checkbox" name="selected[]" id="size[<?php echo $k; ?>][select]"  value="<?php echo $size['isizeid']; ?>" />
                    </td>
                    
                    <td class="text-left">
                    <span style="display:none;"><?php echo $size['vsize']; ?></span>
                    <input type="text" maxlength="45" class="editable size_c" name="size[<?php echo $k; ?>][vsize]" id="size[<?php echo $k; ?>][vsize]" value="<?php echo $size['vsize']; ?>" onclick='document.getElementById("size[<?php echo $k; ?>][select]").setAttribute("checked","checked");' />
          				  <input type="hidden" name="size[<?php echo $k; ?>][isizeid]" value="<?php echo $size['isizeid']; ?>"/>
          				  </td>
                  </tr>
                <?php $size_row++; $i++;?>
                <?php } ?>
              </tbody>
            </table>
            <?php } else { ?>
            <table class="text-center table table-bordered table-hover">
              <tr>
                <td colspan="7" class="text-center"><?php echo $text_no_results;?></td>
              </tr>
            </table>
            <?php } ?>
          </div>
        </form>
        <?php if ($sizes) { ?>
        <div class="row">
          <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
          <div class="col-sm-6 text-right"><?php echo $results; ?></div>
        </div>
        <?php } ?>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">

function addSize() {
  $('#addModal').modal('show');
}

//--></script> 

<!-- Modal Add -->
  <div class="modal fade" id="addModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add New Size</h4>
        </div>
        <div class="modal-body">
          <form action="<?php echo $edit_list; ?>" method="post" id="add_new_form">
            <input type="hidden" name="size[0][isizeid]" value="0">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <div class="col-md-2">
                    <label>Name</label>
                  </div>
                  <div class="col-md-10">  
                    <input name="size[0][vsize]" maxlength="45" id="add_vsize" class="form-control">
                  </div>
                </div>
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col-md-12 text-center">
                <input class="btn btn-success" type="submit" value="Save">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
              </div>
            </div>
          </form>
        </div>
      </div>
      
    </div>
  </div>
<!-- Modal Add-->

<script src="view/javascript/bootbox.min.js" defer></script>
<script type="text/javascript">
  $(document).on('submit', 'form#add_new_form', function(event) {
    
    if($('form#add_new_form #add_vsize').val() == ''){
      // alert('Please enter Size!');
      bootbox.alert({ 
        size: 'small',
        title: "Attention", 
        message: "Please enter Size!", 
        callback: function(){}
      });
      return false;
    }
    $("div#divLoading").addClass('show');
    
  });
</script>

<script type="text/javascript">
  $(document).on('click', '#save_button', function(event) {
    event.preventDefault();

    var edit_url = '<?php echo $edit_list; ?>';
    
    edit_url = edit_url.replace(/&amp;/g, '&');
    
    var all_size = true;
    $('.size_c').each(function(){
      if($(this).val() == ''){
        // alert('Please Enter Size');
        bootbox.alert({ 
          size: 'small',
          title: "Attention", 
          message: "Please enter Size!", 
          callback: function(){}
        });
        all_size = false;
        return false;
      }else{
        all_size = true;
      }
    });
    
    if(all_size == true){
      $('#form-size').attr('action', edit_url);
      $('#form-size').submit();
      $("div#divLoading").addClass('show');
    }
  });
</script>

<?php echo $footer; ?>

<link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel = "stylesheet">
<script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

<script>
    $(function() {
        
        var url = '<?php echo $searchsize;?>';
        
        url = url.replace(/&amp;/g, '&');
        
        $( "#automplete-product" ).autocomplete({
            minLength: 2,
            source: function(req, add) {
                $.getJSON(url, req, function(data) {
                    var suggestions = [];
                    $.each(data, function(i, val) {
                        suggestions.push({
                            label: val.vsize,
                            value: val.vsize,
                            id: val.isizeid
                        });
                    });
                    add(suggestions);
                });
            },
            select: function(e, ui) {
                $('form#form_size_search #isizeid').val(ui.item.id);
                
                if($('#isizeid').val() != ''){
                    $('#form_size_search').submit();
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

  $(window).load(function() {
    $("div#divLoading").removeClass('show');
  });
</script>