 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
 <style type="text/css">
   @page { size: landscape; }
   @page :left {
      margin-left: 1px;
      margin-right: 1px;
   }

   @page :right {
      margin-left: 1px;
      margin-right: 1px;
   }
 </style>
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
          
            <table class="table table-bordered" style="border:none;font-size:1vw;">
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
                  <th class="text-right">Total Cash Sales</th>
                  <th class="text-right">Total EBT Sales</th>
                  <th class="text-right">Total Coupons Sales</th>
                  <th class="text-right">Total Paid out</th>
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
                    $tot_ntotalcashsales = 0;
                    $tot_nnetpaidout = 0;
                    $tot_ntotalebtsales = 0;
                    $tot_ntotalcouponsales = 0;
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
                      <td class="text-right"><?php echo number_format((float)$value['ntotalcashsales'], 2, '.', '') ;?></td>
                      <td class="text-right"><?php echo number_format((float)$value['ntotalebtsales'], 2, '.', '') ;?></td>
                      <td class="text-right"><?php echo number_format((float)$value['ntotalcouponsales'], 2, '.', '') ;?></td>
                      <td class="text-right"><?php echo number_format((float)$value['nnetpaidout'], 2, '.', '') ;?></td>

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
                        $tot_ntotalcashsales = $tot_ntotalcashsales + $value['ntotalcashsales'];
                        $tot_ntotalebtsales = $tot_ntotalebtsales + $value['ntotalebtsales'];
                        $tot_ntotalcouponsales = $tot_ntotalcouponsales + $value['ntotalcouponsales'];
                        $tot_nnetpaidout = $tot_nnetpaidout + $value['nnetpaidout'];
                      ?>
                    </tr>
                  <?php } ?>
                  <tr>
                    <td><b>Total</b></td>
                    <td class="text-right"><b><?php echo number_format((float)$tot_nettotal, 2, '.', '') ;?></b></td>
                    <td class="text-right"><b><?php echo number_format((float)$tot_nettotalcashadded, 2, '.', '') ;?></b></td>
                    <td class="text-right"><b><?php echo number_format((float)$tot_nsubtotal, 2, '.', '') ;?></b></td>
                    <td class="text-right"><b><?php echo number_format((float)$tot_ntaxtotal, 2, '.', '') ;?></b></td>
                    <td class="text-right"><b><?php echo number_format((float)$tot_ntaxable, 2, '.', '') ;?></b></td>
                    <td class="text-right"><b><?php echo number_format((float)$tot_nnontaxabletotal, 2, '.', '') ;?></b></td>
                    <td class="text-right"><b><?php echo number_format((float)$tot_ndiscountamt, 2, '.', '') ;?></b></td>
                    <td class="text-right"><b><?php echo number_format((float)$tot_ntotalsalediscount, 2, '.', '') ;?></b></td>
                    <td class="text-right"><b><?php echo number_format((float)$tot_totalsalewithout, 2, '.', '') ;?></b></td>
                    <td class="text-right"><b><?php echo number_format((float)$tot_totalcreditamt, 2, '.', '') ;?></b></td>
                    <td class="text-right"><b><?php echo number_format((float)$tot_ntotalcashsales, 2, '.', '') ;?></b></td>
                    <td class="text-right"><b><?php echo number_format((float)$tot_ntotalebtsales, 2, '.', '') ;?></b></td>
                    <td class="text-right"><b><?php echo number_format((float)$tot_ntotalcouponsales, 2, '.', '') ;?></b></td>
                    <td class="text-right"><b><?php echo number_format((float)$tot_nnetpaidout, 2, '.', '') ;?></b></td>
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