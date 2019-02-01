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
          <br>
          <hr>
          <div class="col-md-12">
          
            <table class="table table-bordered" style="border:none;">
              <thead>
                <tr style="border-top: 1px solid #ddd;">
                  <th>Date</th>
                  <th class="text-right">Sales</th>
                  <th class="text-right">Cash Added</th>
                  <th class="text-right">Subtotal</th>
                  <th class="text-right">Total Tax</th>
                  <th class="text-right">Taxable Sales</th>
                  <th class="text-right">Nontaxable Sales</th>
                  <th class="text-right">Discount</th>
                  <th class="text-right">Sale Discount</th>
                  <th class="text-right">Total Sales (Without Tax)</th>
                  <th class="text-right">Total Credit Amt</th>
                </tr>
              </thead>
              <tbody>
                  <?php 
                    $tot_nettotal = 0;
                    $tot_nsubtotal = 0;
                    $tot_nettotalcashadded = 0;
                    $tot_ntaxtotal = 0;
                    $tot_ntaxable = 0;
                    $tot_nnontaxabletotal = 0;
                    $tot_ndiscountamt = 0;
                    $tot_ntotalsalediscount = 0;
                    $tot_totalsalewithout = 0;
                    $tot_totalcreditamt = 0;
                  ?>
                  <?php foreach ($reports as $key => $value){ ?>
                    <tr>
                      <td><?php echo $value['date_sale'];?></td>
                      <td class="text-right"><?php echo number_format((float)$value['nettotal'], 2, '.', '') ;?></td>
                      <td class="text-right"><?php echo number_format((float)$value['nettotalcashadded'], 2, '.', '') ;?></td>
                      <td class="text-right"><?php echo number_format((float)$value['nsubtotal'], 2, '.', '') ;?></td>
                      <td class="text-right"><?php echo number_format((float)$value['ntaxtotal'], 2, '.', '') ;?></td>
                      <td class="text-right"><?php echo number_format((float)$value['ntaxable'], 2, '.', '') ;?></td>
                      <td class="text-right"><?php echo number_format((float)$value['nnontaxabletotal'], 2, '.', '') ;?></td>
                      <td class="text-right"><?php echo number_format((float)$value['ndiscountamt'], 2, '.', '') ;?></td>
                      <td class="text-right"><?php echo number_format((float)$value['ntotalsalediscount'], 2, '.', '') ;?></td>
                      <td class="text-right"><?php echo number_format((float)$value['ntotalsaleswithout'], 2, '.', '') ;?></td>
                      <td class="text-right"><?php echo number_format((float)$value['totalcreditamt'], 2, '.', '') ;?></td>

                      <?php 
                        $tot_nettotal = $tot_nettotal + $value['nettotal'];
                        $tot_nsubtotal = $tot_nsubtotal + $value['nsubtotal'];
                        $tot_nettotalcashadded = $tot_nettotalcashadded + $value['nettotalcashadded'];
                        $tot_ntaxtotal = $tot_ntaxtotal + $value['ntaxtotal'];
                        $tot_ntaxable = $tot_ntaxable + $value['ntaxable'];
                        $tot_nnontaxabletotal = $tot_nnontaxabletotal + $value['nnontaxabletotal'];
                        $tot_ndiscountamt = $tot_ndiscountamt + $value['ndiscountamt'];
                        $tot_ntotalsalediscount = $tot_ntotalsalediscount + $value['ntotalsalediscount'];
                        $tot_totalsalewithout = $tot_totalsalewithout + $value['ntotalsaleswithout'];
                        $tot_totalcreditamt = $tot_totalcreditamt + $value['totalcreditamt'];
                      ?>
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