<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<div id="content">
  <div class="container-fluid">
    <div class="panel panel-default" style="margin-top:2%;">
      <div class="panel-heading text-center">
        <h2 class="panel-title" style="font-weight:bold;font-size:24px;"><?php echo $heading_title; ?></h2>
      </div>
      <div class="panel-body">
        
        <?php if(isset($reports) && count($reports) > 0 && $reports[0]['hit'] > 0){ ?>
        <br>
        <div class="row">
          <div class="col-md-6">
            <p><b>Date Range: </b><?php echo $p_start_date; ?> to <?php echo $p_end_date; ?></p>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <p><b>Store Name: </b><?php echo $storename; ?></p>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <p><b>Store Address: </b><?php echo $storeaddress; ?></p>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <p><b>Store Phone: </b><?php echo $storephone; ?></p>
          </div>
        </div>
          <br>
          <hr>
          <div class="col-md-12">
          
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th><?php echo $desc_title; ?></th>
                  <th class="text-right">Item Sold</th>
                  <th class="text-right">Net Amt</th>
                  <th class="text-right">Cost Amt</th>
                  <th class="text-right">Profit Amt</th>
                  <th class="text-right">Gross Profit (%)</th>
                </tr>
              </thead>
              <tbody>
                  <?php 
                    $total_hit = 0;
                    $total_Net_Amount = 0;
                    $total_Cost_Amount = 0;
                    $total_Profit_Amount = 0;
                    $total_gross_profit = 0;
                  ?>
                  <?php foreach ($reports as $key => $value){ ?>
                  <tr>
                    <td><?php echo $value['name']; ?></td>
                    <td class="text-right"><?php echo $value['hit']; ?></td>
                    <td class="text-right"><?php echo number_format((float)$value['Net_Amount'], 2, '.', '') ; ?></td>
                    <td class="text-right"><?php echo number_format((float)$value['Cost_Amount'], 2, '.', '') ; ?></td>
                    <td class="text-right"><?php echo number_format((float)$value['Net_Amount'] - $value['Cost_Amount'], 2, '.', ''); ?></td>
                    <?php 
                      $pr_amt = (number_format((float)$value['Net_Amount'] - $value['Cost_Amount'], 2, '.', '')) / number_format((float)$value['Net_Amount'], 2, '.', '');
                    ?>
                    <td class="text-right"><?php echo number_format((float)$pr_amt * 100, 2, '.', ''); ?>%</td>
                    <?php
                    $tot_pro = $value['Net_Amount'] - $value['Cost_Amount'];
                    $total_hit = $total_hit + $value['hit'];
                    $total_Net_Amount = $total_Net_Amount + $value['Net_Amount'] ;
                    $total_Cost_Amount = $total_Cost_Amount + $value['Cost_Amount'];
                    $total_Profit_Amount = $total_Profit_Amount + $tot_pro;
                    $total_gross_profit = $total_gross_profit + $pr_amt;
                  ?>

                  </tr>
                  <?php } ?>
                  <tr>
                    <td><b>Total</b></td>
                    <td class="text-right"><b><?php echo $total_hit;?></b></td>
                    <td class="text-right"><b><?php echo number_format((float)$total_Net_Amount, 2, '.', ''); ?></b></td>
                    <td class="text-right"><b><?php echo number_format((float)$total_Cost_Amount, 2, '.', ''); ?></b></td>
                    <td class="text-right"><b><?php echo number_format((float)$total_Profit_Amount, 2, '.', ''); ?></b></td>
                    <td class="text-right"><b><?php echo number_format((float)($total_Profit_Amount / $total_Net_Amount) * 100, 2, '.', ''); ?>%</b></td>
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