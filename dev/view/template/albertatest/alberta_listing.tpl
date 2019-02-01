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
    
    <div class="panel panel-default">
      <div class="panel-heading head_title">
        <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_list; ?></h3>
      </div>
      <div class="panel-body">
          <div class="table-responsive">
            <?php if ($listings) { ?>
              <table class="table table-bordered table-hover" style="width: 50%;">
                <thead>
                  <tr>
                    <th class="text-left">Sr No.</th>
                    <th class="text-left">Name</th>
                    <th class="text-left">Page Link</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($listings as $k => $listing) { ?>
                  <tr>
                    <td class="text-left">
                      <?php echo $k + 1; ?>
                    </td>
                    <td class="text-left">
                      <?php echo $listing['name']; ?>
                    </td>
                    <td class="text-left">
                      <a class="btn btn-info" href="<?php echo $listing['link']; ?>">Click Here</a>
                    </td>
                  </tr>

                  <?php } ?>
                  
                </tbody>
              </table>
            <?php } ?>
          </div>
      </div>
    </div>
  </div>
</div>

<?php echo $footer; ?>

<link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel = "stylesheet">
<script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>


<script type="text/javascript">
  $(document).ready(function($) {
    $("div#divLoading").addClass('show');
  });

  $(window).load(function() {
    $("div#divLoading").removeClass('show');
  });
</script>