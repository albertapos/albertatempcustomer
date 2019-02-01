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
              <button <?php if(isset($items) && count($items) == 0){?> disabled <?php }?> title="Update" class="btn btn-primary" id="update_button"><i class="fa fa-save"></i>&nbsp;&nbsp;Update</button>      
            </div>
          </div>
        </div>
        <div class="clearfix"></div>
        
        <form action="<?php echo $edit_list;?>" method="post" enctype="multipart/form-data" id="form-quick-item">
          <div class="table-responsive">
            <table id="item" class="table table-bordered table-hover">
            <?php if ($items) { ?>
              <thead>
                <tr>
                  <th style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></th>
                  <th class="text-left">Group Name</th>
                  <th class="text-left">Register Name</th>
                  <th class="text-right">Sequence</th>
                  <th class="text-left">Status</th>
                </tr>
              </thead>
              <tbody>
                
                <?php foreach ($items as $i => $item) { ?>
                  <tr>
                    <td data-order="<?php echo $item['iitemgroupid']; ?>" class="text-center">
                    <input type="checkbox" name="selected[]" id="quick_item[<?php echo $i; ?>][select]"  value="<?php echo $item['iitemgroupid']; ?>" />
                    <input type="hidden"  name="quick_item[<?php echo $i; ?>][iitemgroupid]" value="<?php echo $item['iitemgroupid']; ?>">
                    </td>
                    
                    <td class="text-left">
                      <input type="text" class="editable quick_vitemgroupname" name="quick_item[<?php echo $i; ?>][vitemgroupname]" value="<?php echo $item['vitemgroupname']; ?>" onclick='document.getElementById("quick_item[<?php echo $i; ?>][select]").setAttribute("checked","checked");' />
                    </td>

                    <td class="text-left">
                      <span><?php echo $item['vterminalid']; ?></span>
                    </td>

                    <td class="text-right">
                      <input type="text" class="editable quick_sequence" name="quick_item[<?php echo $i; ?>][isequence]" value="<?php echo $item['isequence']; ?>" onclick='document.getElementById("quick_item[<?php echo $i; ?>][select]").setAttribute("checked","checked");' style="text-align: right;" />
                    </td>

                    <td class="text-left">
                      <span><?php echo $item['estatus']; ?></span>
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
        </form>
        <div class="row">
          <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
          <div class="col-sm-6 text-right"><?php echo $results; ?></div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php echo $footer; ?>

<script src="view/javascript/bootbox.min.js" defer></script>
<script type="text/javascript">
  $(document).on('click', '#update_button', function(event) {
    
    var all_itemgroupname = true;
    var all_itemgroupname_arr = [];

    var all_sequence = true;
    var all_sequence_arr = [];
    var all_correct = true;

    $('.quick_vitemgroupname').each(function(){
      if($(this).val() == ''){
        // alert('Please Enter Group Name');

        bootbox.alert({ 
          size: 'small',
          title: "Attention", 
          message: "Please Enter Group Name", 
          callback: function(){}
        });

        all_itemgroupname = false;
        all_correct = false;
        return false;
      }else{
        if(jQuery.inArray($(this).val(), all_itemgroupname_arr) !== -1){
          // alert('Please Enter Unique Group Name');

          bootbox.alert({ 
            size: 'small',
            title: "Attention", 
            message: "Please Enter Unique Group Name", 
            callback: function(){}
          });

          all_itemgroupname = false;
          all_correct = false;
          return false;
        }else{
          all_itemgroupname_arr.push($(this).val());
          all_itemgroupname = true;
        }
      }
    });

    if(all_itemgroupname == true){
      $('.quick_sequence').each(function(){
        if($(this).val() == ''){
          // alert('Please Enter Sequence');

          bootbox.alert({ 
            size: 'small',
            title: "Attention", 
            message: "Please Enter Sequence", 
            callback: function(){}
          });

          all_sequence = false;
          all_correct = false;
          return false;
        }else{
          if(jQuery.inArray($(this).val(), all_sequence_arr) !== -1){
            // alert('Please Enter Unique Sequence');

            bootbox.alert({ 
              size: 'small',
              title: "Attention", 
              message: "Please Enter Unique Sequence", 
              callback: function(){}
            });

            all_sequence = false;
            all_correct = false;
            return false;
          }else{
            all_sequence_arr.push($(this).val());
            all_sequence = true;
          }
        }
      });
    }

    if(all_correct == true){
      $('#form-quick-item').submit();
      $("div#divLoading").addClass('show');
    }
  });

$(document).on('keypress keyup blur', '.quick_sequence', function(event) {

    $(this).val($(this).val().replace(/[^\d].+/, ""));
    if ((event.which < 48 || event.which > 57)) {
        event.preventDefault();
    }
    
  });
</script>

<script type="text/javascript">
  $(window).load(function() {
    $("div#divLoading").removeClass('show');
  });
</script>