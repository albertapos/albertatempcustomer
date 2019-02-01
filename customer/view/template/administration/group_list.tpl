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
            </div>
          </div>
        </div>
        <div class="clearfix"></div>

      <form action="<?php echo $current_url;?>" method="post" id="form_group_search">
        <input type="hidden" name="searchbox" id="iitemgroupid">
        <div class="row">
            <div class="col-md-12">
                <input type="text" name="automplete-product" class="form-control" placeholder="Search Item Group..." id="automplete-product">
            </div>
        </div>
      </form>
       <br>
        
          <div class="table-responsive">
            <table id="group" class="table table-bordered table-hover" style="width:60%;">
            <?php if ($groups) { ?>
              <thead>
                <tr>
                  <th style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></th>
                  <th class="text-left"><?php echo $text_group_name; ?></th>
                  <th class="text-left">Slab Pricing</th>
                  <th class="text-left">Action</th>
                </tr>
              </thead>
              <tbody>

                <?php foreach ($groups as $group) { ?>
                <tr>
                  <td data-order="<?php echo $group['iitemgroupid']; ?>" class="text-center">
                    <span style="display:none;"><?php echo $group['iitemgroupid']; ?></span>
                    <input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" />
                  </td>
                  
                  <td class="text-left">
                    <span><?php echo $group['vitemgroupname']; ?></span>
                  </td>

                  <td class="text-left">
                    <span><?php echo $group['slab_pricing']; ?></span>
                  </td>

                  <td class="text-left">
                    <span></span><a href="<?php echo $group['edit']; ?>" data-toggle="tooltip" title="Edit" class="btn btn-sm btn-info edit_btn_rotate" ><i class="fa fa-pencil">&nbsp;&nbsp;Edit</i>
                    </a></span>
                    <span><a href="<?php echo $group['delete']; ?>" data-toggle="tooltip" title="Delete" class="btn btn-sm btn-info edit_btn_rotate" ><i class="fa fa-trash ">&nbsp;&nbsp;Delete</i>
                    </a></span>
                    
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
          <?php if ($groups) { ?>
          <div class="row" style="margin-left: 0px;margin-right: 0px;">
            <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
            <div class="col-sm-6 text-right"><?php echo $results; ?></div>
          </div>
          <?php } ?>
      </div>
    </div>
  </div>
</div>

<?php echo $footer; ?>

<link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel = "stylesheet">
<script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

<script>
    $(function() {
        
        var url = '<?php echo $searchgroup;?>';
        
        url = url.replace(/&amp;/g, '&');
        
        $( "#automplete-product" ).autocomplete({
            minLength: 2,
            source: function(req, add) {
                $.getJSON(url, req, function(data) {
                    var suggestions = [];
                    $.each(data, function(i, val) {
                        suggestions.push({
                            label: val.vitemgroupname,
                            value: val.vitemgroupname,
                            id: val.iitemgroupid
                        });
                    });
                    add(suggestions);
                });
            },
            select: function(e, ui) {
                $('form#form_group_search #iitemgroupid').val(ui.item.id);
                
                if($('#iitemgroupid').val() != ''){
                    $('#form_group_search').submit();
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