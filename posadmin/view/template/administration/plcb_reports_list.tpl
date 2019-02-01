<?php echo $header; ?><?php echo $column_left; ?>

<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_list; ?></h3>
        <a href="<?php echo $plcb_print_page; ?>" id="btnPrint" class="pull-right"><i class="fa fa-print" aria-hidden="true"></i> Print</a>
        <a href="<?php echo $pdf_save_page; ?>" class="pull-right" style="margin-right:10px;"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF</a>
      </div>
      <div class="panel-body">
        <div class="alert alert-info" style="overflow: hidden;">
          <div class="row">
              <div class="col-md-4">
                 <span><b>Date: </b><?php echo date("F j, Y"); ?></span>
             </div>
             <div class="col-md-4">
                 <span><b>Report Month: </b> <?php echo date('F, Y', strtotime("last day of last month")); ?></span>
             </div>
             <div class="col-md-4">
                 <span><b>Store Name: </b><?php echo $store_name; ?></span>
             </div>
          </div>
         </div><br>
         <div class="row">
           <div class="col-md-12">
                <?php if(count($main_bucket_arr) > 0){ ?>

                  <?php
                    foreach($buckets as $bucket){
                      ${'bucket_id_total'.$bucket['id']} = 0 ;
                    }
                    $v_row_total = 0;
                  ?>

                    <table class="table table-bordered table-striped table-hover">
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

                                <?php if(count($schedules) > 0){ ?>
                                  <?php foreach($schedules as $s_key => $schedule){ ?>
                                    <tr>
                                      <td><b><?php echo $s_key;?></b></td>
                                      <?php $schedule_a_h_total = 0; ?>
                                      <?php foreach($buckets as $bucket){ ?>
                                      <?php
                                        $schedule_a_h_total = $schedule_a_h_total + $schedule[$bucket['id']];
                                        ${'bucket_id_total'.$bucket['id']} = ${'bucket_id_total'.$bucket['id']} + $schedule[$bucket['id']];
                                      ?>
                                      <td class="text-right"><?php echo $schedule[$bucket['id']]; ?></td>
                                      <?php } ?>
                                      <td class="text-right">
                                        <?php echo $schedule_a_h_total; ?>
                                        <?php $v_row_total = $v_row_total + $schedule_a_h_total;  ?>
                                      </td>
                                    </tr>
                                  <?php } ?>
                                <?php } ?>

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
                  <?php foreach($main_supplier_arr as $k => $main_supplier_array){ ?>
                    <?php 
                      foreach($buckets as $bucket){
                          ${'bucket_id_total_sup'.$bucket['id']} = 0 ;
                        }
                        $v_row_total_sup = 0;
                    ?>
                    
                    <table class="table table-bordered table-striped table-hover">
                      <thead>
                              <tr>
                                 <?php if($k == 'Schedule A'){ ?>
                                    <th>NAME AND ADDRESS OF MANUFACTURES</th>
                                  <?php }else if($k == 'Schedule B'){ ?>
                                    <th>NAME AND ADDRESS OF IMPORTING DISTRIBUTOR</th>
                                  <?php }else if($k == 'Schedule C'){ ?>
                                    <th>NAME AND ADDRESS OF IMPORTING DISTRIBUTORS</th>
                                  <?php } ?>
                                 <?php foreach($buckets as $bucket){ ?>
                                  <th class="text-right" ><?php echo $bucket['bucket_name']; ?></th>
                                 <?php } ?>
                                  <th class="text-right">Row Total</th> 
                              </tr>
                          </thead>
                          <tbody>
                          
                            <?php foreach($main_supplier_array as $key => $main_arr_suppliers){ ?>
                              <?php if(count($main_arr_suppliers) > 0){ ?>
                              <?php 
                                $temp_sup_name = array();
                                foreach ($main_arr_suppliers as $b => $bvalue) {
                                  $temp_sup_name[] = $bvalue;
                                }
                              ?>
                                
                                  <tr>
                                    <td><span style="font-weight:normal;"><b><?php echo $temp_sup_name[0]['supplier_name']; ?></b><br><?php echo $temp_sup_name[0]['supplier_vaddress1']; ?>, <?php echo $temp_sup_name[0]['supplier_vcity']; ?>, <?php echo $temp_sup_name[0]['supplier_vstate']; ?> <?php echo $temp_sup_name[0]['supplier_vzip']; ?></span></td>
                                    <?php $sup_row_total = 0;?>
                                    <?php foreach($buckets as $bucket){ ?>
                                       <?php $sup_not_bucket = false; ?>
                                      <?php foreach($main_arr_suppliers as $supplier_array){ ?>
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
                                <td><b>Total Purchases from Importing Distributors (<?php echo $k;?>)</b></td>
                                  <?php foreach($buckets as $bucket){ ?>
                                    <td class="text-right"><?php echo ${'bucket_id_total_sup'.$bucket['id']}; ?></td>
                                  <?php } ?>
                                <td class="text-right"><?php echo $v_row_total_sup; ?></td>
                              </tr>
                          </tbody>
                    </table>


                  <?php } ?>

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

<?php echo $footer; ?>
<script src="view/javascript/jquery.printPage.js"></script>
<style type="text/css">
  .table.table-bordered.table-striped.table-hover thead > tr {
    background-color: #2486c6;
    color: #fff;
  }
</style>
<script>  
$(document).ready(function() {
  $("#btnPrint").printPage();
});
</script>