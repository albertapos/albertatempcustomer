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
        
        <?php if(isset($reports) && count($reports) > 0){ ?>
        <br>
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
          <div class="col-md-12">
            <?php 
              $qtysold_total = 0;
              $extunitprice_total = 0;
              $extcostprice_total = 0;
            ?>
            <table class="table table-bordered table-striped table-hover">
              <thead>
                <tr style="border-top: 1px solid #ddd;">
                  <th>Name</th>
                  <th class="text-right">Qty Sold</th>
                  <th class="text-right">Ext. Unit Price</th>
                  <th class="text-right">Ext.Cost Price</th>
                </tr>
              </thead>
              <tbody>
                  <?php foreach ($reports as $key => $value){ ?>
                    <?php 
                      $qtysold_total += $value['qtysold'];
                      $extunitprice_total += $value['extunitprice'];
                      $extcostprice_total += $value['extcostprice'];
                    ?>
                    <tr>
                      <td><?php echo $value['vsuppliername'];?></td>
                      <td class="text-right"><?php echo $value['qtysold'];?></td>
                      <td class="text-right"><?php echo $value['extunitprice'];?></td>
                      <td class="text-right"><?php echo $value['extcostprice'];?></td>
                    </tr>
                  <?php } ?>
                  <tr>
                    <td class="text-right"><b>Total</b></td>
                    <td class="text-right"><b><?php echo $qtysold_total;?></b></td>
                    <td class="text-right"><b><?php echo $extunitprice_total;?></b></td>
                    <td class="text-right"><b><?php echo $extcostprice_total;?></b></td>
                  </tr>
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