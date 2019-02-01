<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<style type="text/css">
  .text-right{
    text-align: right;
  }
</style>
<div id="content">
  <div class="container-fluid">
    <div class="panel panel-default" style="margin-top:2%;">
      <div class="panel-heading text-center">
        <h2 class="panel-title" style="font-weight:bold;font-size:24px;"><?php echo $heading_title; ?></h2>
      </div>
      <div class="panel-body">
        <div class="row">
          <div class="col-md-12">
            <p style="text-align:center"><b>From: </b><?php echo $p_start_date; ?> <b>To: </b> <?php echo $p_end_date; ?></p>
          </div>
          <div class="col-md-12">
            <p><b>Store Name: </b><?php echo $storename; ?></p>
          </div>
          <div class="col-md-12">
            <p><b>Store Address: </b><?php echo $storeaddress; ?></p>
          </div>
          <div class="col-md-12">
            <p><b>Store Phone: </b><?php echo $storephone; ?></p>
          </div>
          <hr>
        </div>
        <?php if(isset($reports) && count($reports) > 0 && ( count($reports['voids']) > 0 ||  count($reports['deletes']) > 0) ){ ?>
        <br>
        <div class="row">
          
          <div class="col-md-12">
            <table class="table table-bordered table-striped table-hover">
              <thead>
                <tr style="border-top: 1px solid #ddd;">
                  <th>User</th>
                  <th>Item Barcode</th>
                  <th>Item Name</th>
                  <th class="text-right">Qty</th>
                  <th class="text-right">Price</th>
                  <th class="text-right">Total Price</th>
                  <th class="text-left">Date Time</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php if(isset($reports['voids']) && count($reports['voids']) > 0){ ?>
                  <?php foreach($reports['voids'] as $report){?>
                    <tr>
                      <td><?php echo $report['vusername'];?></td>
                      <td><?php echo $report['vitemcode'];?></td>
                      <td><?php echo $report['vitemname'];?></td>
                      <td class="text-right"><?php echo (int)$report['ndebitqty'];?></td>
                      <td class="text-right"><?php echo $report['nunitprice'];?></td>
                      <td class="text-right"><?php echo $report['nextunitprice'];?></td>
                      <td><?php echo $report['trn_date_time'];?></td>
                      <td><?php echo $report['vtrntype'];?></td>
                    </tr>
                  <?php } ?>
                <?php } ?>
                <?php if(isset($reports['deletes']) && count($reports['deletes']) > 0){ ?>
                  <?php foreach($reports['deletes'] as $report){?>
                    <tr>
                      <td><?php echo $report['vusername'];?></td>
                      <td><?php echo $report['vitemcode'];?></td>
                      <td><?php echo $report['vitemname'];?></td>
                      <td class="text-right"><?php echo (int)$report['ndebitqty'];?></td>
                      <td class="text-right"><?php echo $report['nunitprice'];?></td>
                      <td class="text-right"><?php echo $report['nextunitprice'];?></td>
                      <td><?php echo $report['trn_date_time'];?></td>
                      <td><?php echo $report['vtrntype'];?></td>
                    </tr>
                  <?php } ?>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
        <?php }else{ ?>
            <div class="row">
              <div class="col-md-12"><br><br>
                <div class="alert alert-info text-center">
                  <strong>Sorry no data found!</strong>
                </div>
              </div>
            </div>
        <?php } ?>
      </div>
    </div>
  </div>
</div>