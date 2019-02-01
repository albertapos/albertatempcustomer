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
        <div class="row">
          <div class="col-md-12">
          <br>
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th><?php echo $desc_title;?></th>
                  <th>Supplier</th>
                  <th>Item</th>
                  <th class="text-right">QOH</th>
                  <th class="text-right">Cost</th>
                  <th class="text-right">Price</th>
                  <th >Shelf</th>
                  <th >Shelving</th>
                  <th >Aisle</th>
                </tr>
              </thead>
              <tbody>
                  <?php 
                    $tot_cost = 0;
                    $tot_price = 0;
                    $tot_qoh = 0;
                   ?>
                  <?php foreach ($reports as $k => $v){ ?>
                  <tr>
                    <td colspan="9"><?php echo $v['name'];?></td>
                  </tr>

                  <?php foreach ($v['items'] as $key => $value){ ?>
                    <tr>
                      <td><?php echo $value['vname'];?></td>
                      <td><?php echo $value['suppliername'];?></td>
                      <td><?php echo $value['itemname'];?></td>
                      <td class="text-right"><?php echo $value['iqtyonhand'];?></td>
                      <td class="text-right"><?php echo number_format((float)$value['cost'], 2, '.', '') ;?></td>
                      <td class="text-right"><?php echo number_format((float)$value['price'], 2, '.', '') ;?></td>
                      <td><?php echo $value['shelf'];?></td>
                      <td><?php echo $value['shelving'];?></td>
                      <td><?php echo $value['aisle'];?></td>
                      <?php 
                        $tot_cost = $tot_cost + $value['cost'];
                        $tot_price = $tot_price + $value['price'];
                        $tot_qoh = $tot_qoh + $value['iqtyonhand'];
                       ?>
                    </tr>
                  <?php } ?>
                  <?php } ?>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td><b>Total</b></td>
                    <td class="text-right"><b><?php echo $tot_qoh ;?></b></td>
                    <td class="text-right"><b>$<?php echo number_format((float)$tot_cost, 2, '.', '') ;?></b></td>
                    <td class="text-right"><b>$<?php echo number_format((float)$tot_price, 2, '.', '') ;?></b></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
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