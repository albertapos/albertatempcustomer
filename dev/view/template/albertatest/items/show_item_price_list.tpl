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
        <div class="row">
          <form action="<?php echo $current_url;?>" method="post" id="search_form">
          <div class="col-md-4">
            <input type="text" class="form-control" name="searchbox" placeholder="Search Item..." value="<?php echo isset($searchbox) ? $searchbox : ''; ?>" required>
          </div>
          <div class="col-md-4">
            <input type="submit" class="btn btn-info" value="Search">
          </div>
        </form>
        </div>

        <div class="clearfix"></div>
        <br>
        <div class="table-responsive">
          <table id="item" class="table table-bordered table-hover" style="width: 50%;">
          <?php if ($items) { ?>
            <thead>
              <tr>
                <th class="text-left">Item Name</th>
                <th class="text-left">SKU</th>
                <th class="text-right">Price</th>
              </tr>
            </thead>
            <tbody>
              
              <?php foreach ($items as $i => $item) { ?>
                <tr>
                  
                  <td class="text-left">
                    <span><?php echo $item['vitemname']; ?></span>
                  </td>

                  <td class="text-left">
                    <span><?php echo $item['vbarcode']; ?></span>
                  </td>

                  <td class="text-right">
                    <span><?php echo $item['dunitprice']; ?></span>
                  </td>
                </tr>
  
              <?php } ?>
              <?php } else { ?>
                <?php if($item_row_found){?>
                  <tr>
                    <td colspan="7" class="text-center"><?php echo $text_no_results;?></td>
                  </tr>
                <?php } ?>
              <?php } ?>
            </tbody>
          </table>
        </div>
        
      </div>
    </div>
  </div>
</div>

<?php echo $footer; ?>

<script type="text/javascript">
  $(document).on('submit', '#search_form', function(event) {
    $("div#divLoading").addClass('show');
  });
</script>

<script type="text/javascript">
  $(window).load(function() {
    $("div#divLoading").removeClass('show');
  });
</script>