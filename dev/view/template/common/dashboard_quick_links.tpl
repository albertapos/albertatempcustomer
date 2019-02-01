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
    <?php if ($error_install) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_install; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>

    <div class="panel panel-default" style="border-left:none;border-right:none;border-bottom:none;">
      <div class="panel-body">
        <div class="row">
          <div class="col-md-10">
            <input type="text" class="form-control" placeholder="Search..." name="search_results" id="search_results" style="font-size:18px;">
          </div>
          <div class="col-md-2 text-right">
            <a href="<?php echo $dashboard;?>" class="btn btn-warning" style="border-radius: 0px;">Dashboard</a>
          </div>
        </div>
        <br>
        <?php if($webadmin == true){ ?>
          <div class="row">
            <div class="col-md-12">
              <div class="alert alert-info heading_div"><h3 class="h3_tag">Quick Links</h3></div>
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col-md-12 dash_list">
              <div class="div_icon">
                <div class="icon"> 
                  <a href="<?php echo $items; ?>"><i class="fa fa-gift" aria-hidden="true"></i><span>Item</span></a>
                </div>
              </div>
              <div class="div_icon">
                <div class="icon"> 
                  <a href="<?php echo $category; ?>"><i class="fa fa-folder-open" aria-hidden="true"></i><span>Category</span></a>
                </div>
              </div>
              <div class="div_icon">
                <div class="icon"> 
                  <a href="<?php echo $customer; ?>"><i class="fa fa-child" aria-hidden="true"></i><span>Customer</span></a>
                </div>
              </div>
              <div class="div_icon">
                <div class="icon"> 
                  <a href="<?php echo $department; ?>"><i class="fa fa-server" aria-hidden="true"></i><span>Department</span></a>
                </div>
              </div>
              <div class="div_icon">
                <div class="icon"> 
                  <a href="<?php echo $store_setting; ?>"><i class="fa fa-database" aria-hidden="true"></i><span>Store Settings</span></a>
                </div>
              </div>
              <div class="div_icon">
                <div class="icon"> 
                  <a href="<?php echo $users; ?>"><i class="fa fa-users" aria-hidden="true"></i><span>User</span></a>
                </div>
              </div>
              
              <div class="div_icon">
                <div class="icon"> 
                  <a href="<?php echo $vendor; ?>"><i class="fa fa-building" aria-hidden="true"></i><span>Vendor</span></a>
                </div>
              </div>
              <div class="div_icon">
              <div class="icon"> 
                <a href="<?php echo $item_movement_report; ?>"><i class="fa fa-bars" aria-hidden="true"></i><span>Item Movement</span>
                </a>
              </div>
            </div>
            </div>
          </div>
        <?php } ?>

        <div class="row">
          <div class="col-md-12">
            <div class="alert alert-info heading_div"><h3 class="h3_tag">Reports</h3></div>
          </div>
        </div>
        
        <div class="row">
          <div class="col-md-12 dash_list">
            <div class="div_icon">
              <div class="icon"> 
                <a href="<?php echo $below_cost_report; ?>"><i class="fa fa-bars" aria-hidden="true"></i><span>Below Cost</span></a>
              </div>
            </div>
            <div class="div_icon">
              <div class="icon"> 
                <a href="<?php echo $cash_sales_summary; ?>"><i class="fa fa-bars" aria-hidden="true"></i><span>Cash & Sales Summary</span></a>
              </div>
            </div>
            <div class="div_icon">
              <div class="icon"> 
                <a href="<?php echo $end_of_day_report; ?>"><i class="fa fa-bars" aria-hidden="true"></i><span>End of Day</span></a>
              </div>
            </div>
            <div class="div_icon">
              <div class="icon"> 
                <a href="<?php echo $inventory_on_hand_report; ?>"><i class="fa fa-bars" aria-hidden="true"></i><span>Inventory on Hand</span></a>
              </div>
            </div>
            <?php if($store_kiosk_check == true) {?>
            <div class="div_icon">
              <div class="icon"> 
                <a href="<?php echo $kiosk_item_detail; ?>"><i class="fa fa-bars" aria-hidden="true"></i><span>Kiosk Item Detail</span></a>
              </div>
            </div>
            <?php } ?>
            <div class="div_icon">
              <div class="icon"> 
                <a href="<?php echo $monthly_sales_report; ?>"><i class="fa fa-bars" aria-hidden="true"></i><span>Sales</span></a>
              </div>
            </div>
            <?php if($plcb_reports_check == true) {?>
            <div class="div_icon">
              <div class="icon"> 
                <a href="<?php echo $plcb_reports; ?>"><i class="fa fa-bars" aria-hidden="true"></i><span>PLCB</span></a>
              </div>
            </div>
            <?php } ?>
            <div class="div_icon">
              <div class="icon"> 
                <a href="<?php echo $po_history_report; ?>"><i class="fa fa-bars" aria-hidden="true"></i><span>PO History</span></a>
              </div>
            </div>
            <div class="div_icon">
              <div class="icon"> 
                <a href="<?php echo $profit_loss; ?>"><i class="fa fa-bars" aria-hidden="true"></i><span>Profit & Loss</span>
                </a>
              </div>
            </div>
            <div class="div_icon">
              <div class="icon"> 
                <a href="<?php echo $zero_movement_report; ?>"><i class="fa fa-bars" aria-hidden="true"></i><span>Zero Movement</span></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>

<?php echo $footer; ?>

<script type="text/javascript">
  $(document).on('keyup', '#search_results', function(event) {
    event.preventDefault();
    $('.div_icon').hide();
    $('.heading_div').hide();
    var txt = $('#search_results').val();
    
    if(txt != ''){
      $('.div_icon').each(function(){
        if($(this).text().toUpperCase().indexOf(txt.toUpperCase()) != -1){
          $(this).show();
        }
      });
    }else{
      $('.div_icon').show();
      $('.heading_div').show();
    }
  });
</script>

<style type="text/css">
  .h3_tag{
    margin-top: 5px;
    margin-left: 5px;
    color: #fff;
  }
  .heading_div{
    padding: 1px;
    border-radius: 0px !important; 
    background: #03A9F4 !important;
    border-color: #03A9F4 !important;
  }
</style>

<script type="text/javascript">
  $(window).load(function() {
    $("div#divLoading").removeClass('show');
  });
</script>