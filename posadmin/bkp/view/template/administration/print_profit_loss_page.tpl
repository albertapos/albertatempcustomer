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
        
        <?php if(isset($reports) && count($reports) > 0){ ?>
        <br>
        <div class="row">
          <div class="col-md-12">
          <br>
            <table class="table table-bordered" style="border:none;">
              <thead>
                <tr style="border-top: 1px solid #ddd;">
                  <th>Name</th>
                  <th class="text-right">Unit Cost</th>
                  <th class="text-right">Price</th>
                  <th class="text-right">Qty Sold</th>
                  <th class="text-right">Total Cost</th>
                  <th class="text-right">Total Price</th>
                  <th class="text-right">Mark Up(%)</th>
                  <th class="text-right">Gross Profit</th>
                </tr>
              </thead>
              <tbody>
                  <?php 
                    $grand_total_qty_sold = 0;
                    $grand_total_total_cost = 0;
                    $grand_total_total_price = 0;
                    $grand_total_mark_up = 0;
                    $grand_total_gross_profit = 0;
                  ?>
                  <?php foreach ($reports as $key => $value){ ?>
                    <tr>
                      <td style="border:none;"><b><?php echo $key; ?></b></td>
                    </tr>
                    <?php 
                      $total_qty_sold = 0;
                      $total_total_cost = 0;
                      $total_total_price = 0;
                      $total_mark_up = 0;
                      $total_gross_profit = 0;
                    ?>
                    <?php foreach ($value as $k => $v){ ?>
                      <tr>
                        <td><?php echo $v['vITemName']; ?></td>
                        <td class="text-right"><?php echo number_format((float)$v['DCOSTPRICE'], 2, '.', '') ; ?></td>
                        <td class="text-right"><?php echo number_format((float)$v['dUnitPrice'], 2, '.', '') ; ?></td>
                        <td class="text-right"><?php echo $v['TotalQty']; ?></td>
                        <td class="text-right"><?php echo number_format((float)$v['TotCostPrice'], 2, '.', '') ; ?></td>
                        <td class="text-right"><?php echo number_format((float)$v['TOTUNITPRICE'], 2, '.', '') ; ?></td>
                        <td class="text-right"><?php echo number_format((float)$v['AmountPer'], 2, '.', '') .'%'; ?></td>
                        <td class="text-right"><?php echo number_format((float)$v['Amount'], 2, '.', '') ; ?></td>

                        <?php 
                          $total_qty_sold = $total_qty_sold + $v['TotalQty'];
                          $total_total_cost = $total_total_cost + number_format((float)$v['TotCostPrice'], 2, '.', '') ;
                          $total_total_price = $total_total_price + number_format((float)$v['TOTUNITPRICE'], 2, '.', '') ;
                          $total_mark_up = $total_mark_up + number_format((float)$v['AmountPer'], 2, '.', '') ;
                          $total_gross_profit = $total_gross_profit + number_format((float)$v['Amount'], 2, '.', '') ;
                        ?>

                      </tr>
                    <?php } ?>
                    <tr>
                      <td><b>Sub Total</b></td>
                      <td>&nbsp;&nbsp;</td>
                      <td>&nbsp;&nbsp;</td>
                      <td class="text-right"><b><?php echo $total_qty_sold; ?></b></td>
                      <td class="text-right"><b><?php echo number_format((float)$total_total_cost, 2, '.', '') ; ?></b></td>
                      <td class="text-right"><b><?php echo number_format((float)$total_total_price, 2, '.', '') ; ?></b></td>
                      <td class="text-right"><b><?php echo number_format((float)$total_mark_up, 2, '.', '') .'%'; ?></b></td>
                      <td class="text-right"><b><?php echo number_format((float)$total_gross_profit, 2, '.', '') ; ?></b></td>

                      <?php 
                        $grand_total_qty_sold = $grand_total_qty_sold + $total_qty_sold;
                        $grand_total_total_cost = $grand_total_total_cost + $total_total_cost;
                        $grand_total_total_price = $grand_total_total_price + $total_total_price;
                        $grand_total_mark_up = $grand_total_mark_up + $total_mark_up;
                        $grand_total_gross_profit = $grand_total_gross_profit + $total_gross_profit;
                      ?>

                    </tr>
                  <?php } ?>
                  <tr>
                    <td><b>Grand Total</b></td>
                    <td>&nbsp;&nbsp;</td>
                    <td>&nbsp;&nbsp;</td>
                    <td class="text-right"><b><?php echo $grand_total_qty_sold; ?></b></td>
                    <td class="text-right"><b><?php echo number_format((float)$grand_total_total_cost, 2, '.', '') ; ?></b></td>
                    <td class="text-right"><b><?php echo number_format((float)$grand_total_total_price, 2, '.', '') ; ?></b></td>
                    <td class="text-right"><b><?php echo number_format((float)$grand_total_mark_up, 2, '.', '') .'%'; ?></b></td>
                    <td class="text-right"><b><?php echo number_format((float)$grand_total_gross_profit, 2, '.', '') ; ?></b></td>
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
                  <strong>Sorry we not found any result!!!</strong>
                </div>
              </div>
            </div>
          <?php } ?>
        <?php } ?>
      </div>
    </div>
  </div>
</div>