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
            <p><b>Date: </b><?php echo date("m-d-Y"); ?></p>
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
            <table class="table table-bordered" style="border:none;">
              <thead>
                <tr style="border-top: 1px solid #ddd;">
                  <th>Supplier</th>
                  <th>Item</th>
                  <th>Department</th>
                  <th class="text-right">Cost</th>
                  <th class="text-right">Price</th>
                </tr>
              </thead>
              <tbody>
                  <?php $tot_cost = 0; ?>
                  <?php $tot_price = 0; ?>
                  <?php foreach ($reports as $key => $value){ ?>
                  <tr>
                    <td><?php echo $value['suppliername']; ?></td>
                    <td><?php echo $value['itemname']; ?></td>
                    <td><?php echo $value['vname']; ?></td>
                    <td class="text-right"><?php echo number_format((float)$value['cost'], 2, '.', '') ; ?></td>
                    <td class="text-right"><?php echo number_format((float)$value['price'], 2, '.', '') ; ?></td>
                    <?php $tot_cost = $tot_cost + $value['cost']; ?>
                    <?php $tot_price = $tot_price + $value['price']; ?>
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