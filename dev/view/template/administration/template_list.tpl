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

        <div class="row" style="padding-bottom: 15px;float: right;">
          <div class="col-md-12">
            <div class="">
              <a href="<?php echo $add; ?>" class="btn btn-primary add_new_btn_rotate"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add New</a>     
            </div>
          </div>
        </div>
        <div class="clearfix"></div>

        <?php if ($templates) { ?>
        <form action="<?php echo $current_url;?>" method="post" id="form_template_search">
          <input type="hidden" name="searchbox" id="vtemplatename">
          <div class="row">
              <div class="col-md-12">
                  <input type="text" name="automplete-product" class="form-control" placeholder="Search Template..." id="automplete-product">
              </div>
          </div>
        </form>
       <br>
       <?php } ?>
        
          <div class="table-responsive">
            <table id="template" class="table table-bordered table-hover" style="">
            <?php if ($templates) { ?>
              <thead>
                <tr>
                  <th style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></th>
                  <th class="text-left"><?php echo $text_template_type; ?></th>
                  <th class="text-left"><?php echo $text_inventory_type; ?></th>
                  <th class="text-left"><?php echo $text_template_name; ?></th>
                  <th class="text-right" style="display:none;"><?php echo $text_template_sequence; ?></th>
                  <th class="text-left"><?php echo $text_template_status; ?></th>
                  <th class="text-left">Action</th>
                </tr>
              </thead>
              <tbody>

                <?php foreach ($templates as $template) { ?>
                <tr>
                  <td data-order="<?php echo $template['itemplateid']; ?>" class="text-center">
                    <span style="display:none;"><?php echo $template['itemplateid']; ?></span>
                    <input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" />
                  </td>
                  
                  <td class="text-left">
                    <span><?php echo $template['vtemplatetype']; ?></span>
                  </td>

                  <td class="text-left">
                    <span><?php echo $template['vinventorytype']; ?></span>
                  </td>

                  <td class="text-left">
                    <span><?php echo $template['vtemplatename']; ?></span>
                  </td>

                  <td class="text-left" style="display:none;">
                    <span><?php echo $template['isequence']; ?></span>
                  </td>

                  <td class="text-left">
                    <span><?php echo $template['estatus']; ?></span>
                  </td>

                  <td class="text-left">
                    <a href="<?php echo $template['edit']; ?>" data-toggle="tooltip" title="Edit" class="btn btn-sm btn-info edit_btn_rotate" ><i class="fa fa-pencil">&nbsp;&nbsp;Edit</i>
                    </a>
                  </td>
                </tr>

                <?php } ?>
                <?php } ?>
              </tbody>
            </table>
          </div>
          <?php if ($templates) { ?>
            <div class="row" style="margin-left: 0px;margin-right: 0px;">
              <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
              <div class="col-sm-6 text-right"><?php echo $results; ?></div>
            </div>
          <?php } else {?>
            <div class="row">
              <div class="col-sm-12 text-center"><?php echo $text_no_results; ?></div>
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
        
        var url = '<?php echo $searchtemplate;?>';
        
        url = url.replace(/&amp;/g, '&');
        
        $( "#automplete-product" ).autocomplete({
            minLength: 2,
            source: function(req, add) {
                $.getJSON(url, req, function(data) {
                    var suggestions = [];
                    $.each(data, function(i, val) {
                        suggestions.push({
                            label: val.vtemplatename,
                            value: val.vtemplatename,
                            id: val.itemplateid
                        });
                    });
                    add(suggestions);
                });
            },
            select: function(e, ui) {
                $('form#form_template_search #vtemplatename').val(ui.item.id);
                
                if($('#vtemplatename').val() != ''){
                    $('#form_template_search').submit();
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