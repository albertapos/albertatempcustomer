<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<div id="content">
  <div class="container-fluid">
    <div class="" style="margin-top:2%;">
      <div class=" text-center">
        <h3 class="panel-title" style="font-weight:bold;font-size:24px;"><?php echo $heading_title; ?></h3>
      </div>
      <div class="panel-body">
          <div class="row">
            &nbsp;&nbsp;&nbsp;
            <span><b>Date: </b><?php echo date("F j, Y"); ?></span>
            &nbsp;&nbsp;&nbsp;&nbsp;
            <span><b>Report Month: </b> <?php echo date('F, Y', strtotime("last day of last month")); ?></span>
            &nbsp;&nbsp;&nbsp;&nbsp;
            <span><b>Store Name: </b><?php echo $store_name; ?></span>
          </div>
         <br>
         <div class="row">
           <div class="col-md-12">
                <?php if(count($main_bucket_arr) > 0){ ?>

                  <?php
                    foreach($buckets as $bucket){
                      ${'bucket_id_total'.$bucket['id']} = 0 ;
                    }
                    $v_row_total = 0;
                  ?>

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                               <th>Description</th>
                               <?php foreach($buckets as $bucket){ ?>
                                <th class="text-right" ><?php echo $bucket['bucket_name']; ?></th>
                               <?php } ?>
                                <th class="text-right">Row Total</th> 
                            </tr>
                        </thead>
                        <tbody>
                                <tr>
                                <td><b>Inventory Beginning of Month</b></td>
                                <?php $row_total = 0;?>
                                  <?php foreach($buckets as $bucket){ ?>
                                  <?php $not_bucket = false; ?>
                                    <?php foreach($main_bucket_arr as $bucket_arr){ ?>
                                      <?php if($bucket['id'] == $bucket_arr['bucket_id']){ ?>
                                        <td class="text-right"><?php echo $bucket_arr['tot_qty']; ?></td>
                                        <?php 
                                          $row_total = $row_total + $bucket_arr['tot_qty'];
                                          ${'bucket_id_total'.$bucket['id']} = ${'bucket_id_total'.$bucket['id']} + $bucket_arr['tot_qty'];

                                          $not_bucket = false;
                                          break;
                                        ?>
                                      <?php }else{ ?>
                                        <?php $not_bucket = true; ?>
                                      <?php } ?>
                                    <?php } ?>
                                    
                                    <?php if($not_bucket == true){ ?>
                                      <td class="text-right">0</td>
                                    <?php } ?>
                                  <?php } ?>
                                <td class="text-right">
                                  <?php echo $row_total; ?>
                                  <?php $v_row_total = $v_row_total + $row_total;  ?>
                                </td>
                                </tr>
                                <tr>
                                  <td><b>Schedule A</b></td>
                                  <?php $schedule_a_h_total = 0; ?>
                                  <?php foreach($buckets as $bucket){ ?>
                                  <?php
                                    $schedule_a_h_total = $schedule_a_h_total + $schedule_a[$bucket['id']];
                                    ${'bucket_id_total'.$bucket['id']} = ${'bucket_id_total'.$bucket['id']} + $schedule_a[$bucket['id']];
                                  ?>
                                  <td class="text-right"><?php echo $schedule_a[$bucket['id']]; ?></td>
                                  <?php } ?>
                                  <td class="text-right">
                                    <?php echo $schedule_a_h_total; ?>
                                    <?php $v_row_total = $v_row_total + $schedule_a_h_total;  ?>
                                  </td>
                                </tr>
                                <tr>
                                  <td><b>Total</b></td>
                                    <?php foreach($buckets as $bucket){ ?>
                                      <td class="text-right"><?php echo ${'bucket_id_total'.$bucket['id']}; ?></td>
                                    <?php } ?>
                                  <td class="text-right"><?php echo $v_row_total; ?></td>
                                </tr>
                                <tr>
                                  <td><b>Inventory at End of Month</b></td>
                                    <?php $int_end_mon_total = 0; ?>
                                    <?php foreach($buckets as $bucket){ ?>
                                      <?php 
                                      $int_end_mon_total = $int_end_mon_total + $main_bucket_arr_end[$bucket['id']];
                                      ?>
                                      <td class="text-right"><?php echo $main_bucket_arr_end[$bucket['id']]; ?></td>
                                    <?php } ?>
                                  <td class="text-right"><?php echo $int_end_mon_total; ?></td>
                                </tr>
                                <tr>
                                  <td><b>Balance to be Accounted for</b></td>
                                    
                                    <?php foreach($buckets as $bucket){ ?>
                                      <?php
                                      if($main_bucket_arr_end[$bucket['id']] < 0){
                                        $temp_accounted = -($main_bucket_arr_end[$bucket['id']]);
                                      }else{
                                          $temp_accounted = $main_bucket_arr_end[$bucket['id']];
                                      }

                                        $bal_ac = ${'bucket_id_total'.$bucket['id']} - $temp_accounted;
                                      ?>
                                      <td class="text-right"><?php echo $bal_ac; ?></td>
                                    <?php } ?>
                                  <td class="text-right"><?php echo $v_row_total - $int_end_mon_total; ?></td>
                                </tr>
                                <tr>
                                  <td><b>Sales of Malt Beverage</b></td>
                                    <?php $malt_h_total = 0; ?>
                                    <?php foreach($buckets as $bucket){ ?>
                                      <?php 
                                        $malt_h_total = $malt_h_total + $main_bucket_arr_malt[$bucket['id']];
                                      ?>
                                      <td class="text-right"><?php echo $main_bucket_arr_malt[$bucket['id']]; ?></td>
                                    <?php } ?>
                                  <td class="text-right"><?php echo $malt_h_total; ?></td>
                                </tr>
                        </tbody>
                    </table>
                <?php }else{ ?>
                    <div class="col-md-12">
                       <div class="alert alert-danger">
                          Sorry no product found!!!
                        </div>
                   </div>
                <?php } ?>
                
                <br><br>

                <?php if(count($main_supplier_arr) > 0){ ?>

                <?php 
                  foreach($buckets as $bucket){
                      ${'bucket_id_total_sup'.$bucket['id']} = 0 ;
                    }
                    $v_row_total_sup = 0;
                ?>
                  <table class="table table-bordered">
                    <thead>
                            <tr>
                               <th>Name and Address of Importing Distributors</th>
                               <?php foreach($buckets as $bucket){ ?>
                                <th class="text-right" ><?php echo $bucket['bucket_name']; ?></th>
                               <?php } ?>
                                <th class="text-right">Row Total</th> 
                            </tr>
                        </thead>
                        <tbody>
                          <?php foreach($main_supplier_arr as $k => $main_supplier_array){ ?>
                            <?php if(count($main_supplier_array) > 0){ ?>
                            <tr>
                                <td><b><?php echo $main_supplier_array[0]['supplier_name'];?> </b></td>
                                <?php $sup_row_total = 0;?>
                                <?php foreach($buckets as $bucket){ ?>
                                   <?php $sup_not_bucket = false; ?>
                                  <?php foreach($main_supplier_array as $supplier_array){ ?>
                                    <?php if($bucket['id'] == $supplier_array['bucket_id']){ ?>
                                      <td class="text-right"><?php echo $supplier_array['tot_qty']; ?></td>
                                      <?php 
                                      $sup_row_total = $sup_row_total + $supplier_array['tot_qty'];

                                      ${'bucket_id_total_sup'.$bucket['id']} = ${'bucket_id_total_sup'.$bucket['id']} + $supplier_array['tot_qty'];

                                      $sup_not_bucket = false;
                                      break;
                                    ?>
                                    <?php }else{ ?>
                                      <?php $sup_not_bucket = true; ?>
                                    <?php } ?>
                                  <?php } ?>
                                  <?php if($sup_not_bucket == true){ ?>
                                    <td class="text-right">0</td>
                                  <?php } ?>
                                <?php } ?>
                                <td class="text-right">
                                  <?php echo $sup_row_total; ?>
                                  <?php $v_row_total_sup = $v_row_total_sup + $sup_row_total;  ?>
                                </td>
                            </tr>
                            <?php } ?>
                          <?php } ?>
                          <tr>
                            <td><b>Total Purchases from Importing Distributors (Schedule A)</b></td>
                              <?php foreach($buckets as $bucket){ ?>
                                <td class="text-right"><?php echo ${'bucket_id_total_sup'.$bucket['id']}; ?></td>
                              <?php } ?>
                            <td class="text-right"><?php echo $v_row_total_sup; ?></td>
                          </tr>
                        </tbody>
                  </table>
                <?php }else{ ?>
                  <div class="col-md-12">
                       <div class="alert alert-danger">
                          Sorry no supplier product found !!!
                        </div>
                   </div>
                <?php } ?>
            </div>
       </div>
      </div>
    </div>
  </div>
</div>
