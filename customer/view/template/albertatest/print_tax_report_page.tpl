<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<div id="content">
  <div class="container-fluid">
    <div class="" style="margin-top:2%;">
      <div class="text-center">
        <h3 class="panel-title" style="font-weight:bold;font-size:24px;"><?php echo $heading_title; ?></h3>
      </div>
      <div class="panel-body">
        <div class="row">
          <div class="col-md-6 pull-left">
            <p><b>Date Range: </b><?php echo $p_start_date; ?> to <?php echo $p_end_date; ?></p>
          </div>
          <div class="col-md-6 pull-right">
            <p><b>Store Name: </b><?php echo $storename; ?></p>
          </div>
        </div>
        <hr>
        <?php if(isset($reports) && count($reports) > 0){ ?>
        <div class="row" style="width: 50%;">
          <div class="col-md-6 col-sm-6">
            <p><b style="float: left;">NON-TAXABLE SALES</b>
            <span style="float: right;">$<?php echo number_format((float)$reports['nnontaxabletotal'], 2) ; ?></span></p>
          </div>
        </div><br>
        <div class="row" style="width: 50%;">
          <div class="col-md-6 col-sm-6">
            <p><b style="float: left;">TAX 1 SALES</b>
            <span style="float: right;">$<?php echo number_format((float)$reports['tax1_sales'], 2) ; ?></span></p>
          </div>
        </div><br>
        <div class="row" style="width: 50%;">
          <div class="col-md-6 col-sm-6">
            <p><b style="float: left;">TAX 2 SALES</b>
            <span style="float: right;">$<?php echo number_format((float)$reports['tax2_sales'], 2) ; ?></span></p>
          </div>
        </div>
        <div class="row" style="width: 50%;">
          <div class="col-md-6 col-sm-12">
            <hr style="border-top: 2px solid #ccc;">
          </div>
        </div>
        <div class="row" style="width: 50%;">
          <div class="col-md-6 col-sm-6">
            <p><b style="float: left;">NET SALES</b>
            <span style="float: right;">$<?php echo number_format((float)($reports['nnontaxabletotal'] + $reports['tax1_sales'] + $reports['tax2_sales']), 2) ; ?></span></p>
          </div>
        </div><br><br>
        <div class="row" style="width: 50%;">
          <div class="col-md-6 col-sm-12">
            <hr style="border-top: 2px solid #ccc;">
          </div>
        </div>
        <div class="row" style="width: 50%;">
          <div class="col-md-6 col-sm-6">
            <p><b style="float: left;">TAX 1</b>
            <span style="float: right;">$<?php echo number_format((float)$reports['tax1'], 2) ; ?></span></p>
          </div>
        </div><br>
        <div class="row" style="width: 50%;">
          <div class="col-md-6 col-sm-6">
            <p><b style="float: left;">TAX 2</b>
            <span style="float: right;">$<?php echo number_format((float)$reports['tax2'], 2) ; ?></span></p>
          </div>
        </div>
        <div class="row" style="width: 50%;">
          <div class="col-md-6 col-sm-12">
            <hr style="border-top: 2px solid #ccc;">
          </div>
        </div>
        <div class="row" style="width: 50%;">
          <div class="col-md-6 col-sm-6">
            <p><b style="float: left;">TOAL TAX</b>
            <span style="float: right;">$<?php echo number_format((float)($reports['tax1'] + $reports['tax2']), 2) ; ?></span></p>
          </div>
        </div>
        <?php }else{ ?>
          <?php if(isset($p_start_date)){ ?>
            <div class="row">
              <div class="col-md-12"><br><br>
                <div class="alert alert-info text-center">
                  <strong>Sorry no data found!</strong>
                </div>
              </div>
            </div>
          <?php } ?>
        <?php } ?>
      </div>
    </div>
  </div>
</div>