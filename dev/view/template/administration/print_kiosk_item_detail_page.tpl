<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<div id="content">
  <div class="container-fluid">
    <div class="" style="margin-top:2%;">
      <div class="text-center">
        <h2 class="panel-title" style="font-weight:bold;font-size:24px;"><?php echo $heading_title; ?></h2>
      </div>
      <div class="panel-body">
        <?php if(isset($reports) && count($reports) > 0){ ?>
        <br><br><br>
        <div class="row">
          <div class="col-md-6 pull-left">
            <p><b>Date Range: </b><?php echo $p_start_date; ?> to <?php echo $p_end_date; ?></p>
          </div>
          <div class="col-md-6 pull-right">
            <p><b>Store Name: </b><?php echo $storename; ?></p>
          </div>
        </div>
        
        <div class="row">
          <div class="col-md-6 pull-right">
            <p><b>Store Address: </b><?php echo $storeaddress; ?></p>
          </div>
        </div>
        
        <div class="row">
          <div class="col-md-6 pull-right">
            <p><b>Store Phone: </b><?php echo $storephone; ?></p>
          </div>
        </div>
        
          <br>
          <hr>
        <div class="row">
          <div class="col-md-12">
            <table class="table table-bordered" style="border:none;">
              <thead>
                <tr style="border-top: 1px solid #ddd;">
                  <th class="text-right">Total Qty</th>
                  <th class="text-right">Total Amt</th>
                  <th class="text-right">Total Up Sale Qty</th>
                  <th class="text-right">Total Up Sale Amt</th>
                </tr>
              </thead>
              <tbody>
                  <?php foreach ($reports as $key => $value){ ?>
                    <tr>
                      <td class="text-right"><?php echo empty($value['totalqty']) ? 0 : $value['totalqty'] ; ?></td>
                      <td class="text-right"><?php echo number_format((float)$value['totalamount'], 2, '.', '') ;?></td>
                      <td class="text-right"><?php echo empty($value['totalupsaleqty']) ? 0 : $value['totalupsaleqty'] ; ?></td>
                      <td class="text-right"><?php echo number_format((float)$value['totalupsaleamount'], 2, '.', '') ;?></td>
                    </tr>
                  <?php } ?>
              </tbody>
            </table>
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