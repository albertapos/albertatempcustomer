<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <style type="text/css">
    .float_left{
      float: left;
      width: 50%;
    }
    .float_right{
      float: right;
      width: 50%;
    }

    body {
      font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
    }

    span.text_display{
      width: 80%;
      /*background: #F0F0F0;*/
      border: none;
      margin-left: 10px;
      margin-bottom: 5px;
      display: block;
      height: 15px;
    }

    hr{
      margin-bottom:0px;margin-top:0px;border: 0;border-top: 3px double #8c8c8c;
    }

    @page { margin: 2px; }
    body { margin: 2px; }
</style>
</head>
<body>
  <div id="content">
    <br>
    <div class="container-fluid">
      <div class="" style="margin-top:2%;">
        <div class="row" style="width:100%;margin-bottom:-15px;">
          <div class="col-md-4" style="width:25%;display:inline-block;">
            <span style="font-size:10px;margin-top:0px;"><b><?php echo $store_data['vstorename'];?></b><br><?php echo $store_data['vaddress1'];?><br><?php echo $store_data['vcity'];?>, <?php echo $store_data['vstate'];?> <?php echo $store_data['vzip'];?></span>
          </div>
          <div class="col-md-8" style="width:40%;display:inline-block;">
            <h3 class="panel-title" style="margin-top:0px;text-align:center;font-family:Helvetica,Arial,sans-serif;"><span style="font-size:18px;"><b>DISTRIBUTOR’S MONTHLY REPORT</b></span><BR><span style="font-size:12px;line-height: 20px;">MALT BEVERAGE PURCHASED, SOLD AND<BR>WITHDRAWN INVENTORIES</span></h3>
          </div>
          <div style="width:35%;display:inline-block;">&nbsp;</div>
        </div>
        <hr style="margin-top:-2%;margin-bottom:10px;">
        <div style="width:100%;">
          <table style="width:100%;">
            <tr>
              <td style="width:80%;border: 1px solid #000;"><span style="font-size:10px;"><b>&nbsp;&nbsp;&nbsp;&nbsp;BUSINESS NAME</b><Br><span class="text_display"></span></span></td>
              <td style="width:20%;border: 1px solid #000;"><span style="font-size:10px;"><b>&nbsp;&nbsp;&nbsp;&nbsp;DATE MM/DD/YYYY</b><Br><span class="text_display"><?php echo date("m/d/Y"); ?></span></span></td>
            </tr>
          </table>
          <table style="width:100%;">
            <tr>
              <td style="width:20%;border: 1px solid #000;border-top: none;"><span style="font-size:10px;"><b>&nbsp;&nbsp;&nbsp;&nbsp;ACCOUNT ID</b><Br><span class="text_display"></span></span></td>
              <td style="width:20%;border: 1px solid #000;border-top: none;"><span style="font-size:10px;"><b>&nbsp;&nbsp;&nbsp;&nbsp;FEDERAL EIN</b><Br><span class="text_display"></span></span></td>
              <td style="width:20%;border: 1px solid #000;border-top: none;"><span style="font-size:10px;"><b>&nbsp;&nbsp;&nbsp;&nbsp;LID NUMBER</b><Br><span class="text_display"></span></span></td>
              <td style="width:20%;border: 1px solid #000;border-top: none;"><span style="font-size:10px;"><b>&nbsp;&nbsp;&nbsp;&nbsp;LCB LICENSE NUMBER</b><Br><span class="text_display"></span></span></td>
              <td style="width:20%;border: 1px solid #000;border-top: none;"><span style="font-size:10px;"><b>&nbsp;&nbsp;&nbsp;&nbsp;REPORTING MONTH/YEAR</b><Br><span class="text_display"><?php echo date('F / Y', strtotime("last day of last month")); ?></span></span></td>
            </tr>
          </table>
        </div>
        <hr style="margin-top:10px;">
        <div class="panel-body" style="width:100%;padding:0px;padding-top:10px;">
          <div class="" style="width:100%;margin-right:0px;margin-left:0px;">
             <div class="" style="width:100%;">
                  <?php if(count($main_bucket_arr) > 0){ ?>
                    <?php
                      foreach($buckets as $bucket){
                        ${'bucket_id_total'.$bucket['id']} = 0 ;
                      }
                      $v_row_total = 0;
                    ?>
                      <table class="table table-bordered" style="width:100%;font-size: 11px;">
                          <thead style="width:100%;">
                              <tr style="width:100%;">
                                 <th>Description</th>
                                 <?php foreach($buckets as $bucket){ ?>
                                  <th class="text-right" style="font-weight:bold;"><?php echo $bucket['bucket_name']; ?></th>
                                 <?php } ?>
                                  <th class="text-right" style="font-weight:bold;">Row Total</th> 
                              </tr>
                          </thead>
                          <tbody style="width:100%;">
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
              </div>

              <div class="row">
                <div class="col-md-12">
                  <p style="font-size:11px;">I HEREBY AFFIRM UNDER PENALTIES PRESCRIBED BY LAW THAT THIS REPORT (INCLUDING ACCOMPANYING SCHEDULES) HAS BEEN EXAMINED BY ME AND TO THE BEST OF MY KNOWLEDGE AND BELIEF IS A TRUE, CORRECT AND COMPLETE REPORT. </p>
                  
                  <div style="width:100%;margin-top:10px;">
                    <table style="width:100%;">
                      <tr>
                        <td style="width:33%;border: 1px solid #000;"><span style="font-size:10px;"><b>&nbsp;&nbsp;&nbsp;&nbsp;NAME OF OWNER OR OFFICER</b><Br><span class="text_display"></span></span></td>
                        <td style="width:33%;border: 1px solid #000;"><span style="font-size:10px;"><b>&nbsp;&nbsp;&nbsp;&nbsp;TITLE</b><Br><span class="text_display"></span></span></td>
                        <td style="width:34%;border: 1px solid #000;"><span style="font-size:10px;"><b>&nbsp;&nbsp;&nbsp;&nbsp;SIGNATURE</b><Br><span class="text_display"></span></span></td>
                      </tr>
                    </table>
                    <table style="width:100%;">
                      <tr>
                        <td style="width:100%;border: 1px solid #000;border-top: none;"><span style="font-size:10px;"><b>&nbsp;&nbsp;&nbsp;&nbsp;NAME OF CORPORATION OR REGISTERED TRADE NAME WITH LIQUOR CONTROL BOARD</b><Br><span class="text_display" style="width:95%;"></span></span></td>
                      </tr>
                    </table>
                  </div>
                </div>
              </div>

              <div class="col-md-12" style="width:100%;padding-left:0px;padding-right:0px;">
                <?php if(count($main_supplier_arr) > 0){ ?>
                  <?php foreach($main_supplier_arr as $k => $main_supplier_array){ ?>
                    <?php if($k != 'Schedule C'){ ?>
                      <?php 
                        foreach($buckets as $bucket){
                            ${'bucket_id_total_sup'.$bucket['id']} = 0 ;
                          }
                          $v_row_total_sup = 0;
                      ?>
                      <p style="page-break-before:always;"></p>
                      <br>
                      <div class="row" style="width:100%;margin-top:2%;margin-bottom:-15px;">
                        <div class="col-md-4" style="width:25%;display:inline-block;">
                          <span style="font-size:10px;margin-top:0px;"><b><?php echo $store_data['vstorename'];?></b><br><?php echo $store_data['vaddress1'];?><br><?php echo $store_data['vcity'];?>, <?php echo $store_data['vstate'];?> <?php echo $store_data['vzip'];?></span>
                        </div>
                        <div class="col-md-8" style="width:40%;display:inline-block;">
                          <h3 class="panel-title" style="text-align:center;font-family:Helvetica,Arial,sans-serif;margin-top:0px;"><span style="font-size:18px;"><b style="text-transform:uppercase;"><?php echo $k;?></b></span><BR><span style="font-size:12px;line-height: 20px;">
                          <?php if($k == 'Schedule A'){ ?>
                            MALT BEVERAGE PURCHASED FROM<br>PENNSYLVANIA MANUFACTURERS
                          <?php }else if($k == 'Schedule B'){ ?>
                            MALT BEVERAGE PURCHASED FROM<br>IMPORTING DISTRIBUTORS
                          <?php }else if($k == 'Schedule C'){ ?>
                            MALT BEVERAGE PURCHASED FROM<br>MANUFACTURERS OUTSIDE PENNSYLVANIA
                          <?php } ?>
                          </span>
                          </h3>
                        </div>
                        <div style="width:35%;display:inline-block;">&nbsp;</div>
                      </div>
                      <hr style="margin-top:-15px;">
                      <div style="width:100%;margin-top:10px;">
                        <table style="width:100%;">
                          <tr>
                            <td style="width:80%;border: 1px solid #000;"><span style="font-size:10px;"><b>&nbsp;&nbsp;&nbsp;&nbsp;BUSINESS NAME</b><Br><span class="text_display"></span></span></td>
                            <td style="width:20%;border: 1px solid #000;"><span style="font-size:10px;"><b>&nbsp;&nbsp;&nbsp;&nbsp;DATE MM/DD/YYYY</b><Br><span class="text_display"><?php echo date("m/d/Y"); ?></span></span></td>
                          </tr>
                        </table>
                        <?php if($k == 'Schedule C'){ ?>
                        <table style="width:100%;">
                          <tr>
                            <td style="width:50%;border: 1px solid #000;"><span style="font-size:10px;"><b>&nbsp;&nbsp;&nbsp;&nbsp;BUSINESS ADDRESS STREET</b><Br><span class="text_display"></span></span></td>
                            <td style="width:20%;border: 1px solid #000;"><span style="font-size:10px;"><b>&nbsp;&nbsp;&nbsp;&nbsp;CITY</b><Br><span class="text_display"></span></span></td>
                            <td style="width:10%;border: 1px solid #000;"><span style="font-size:10px;"><b>&nbsp;&nbsp;&nbsp;&nbsp;STATE</b><Br><span class="text_display"></span></span></td>
                            <td style="width:20%;border: 1px solid #000;"><span style="font-size:10px;"><b>&nbsp;&nbsp;&nbsp;&nbsp;ZIP</b><Br><span class="text_display"></span></span></td>
                          </tr>
                        </table>
                        <?php } ?>
                        <table style="width:100%;">
                          <tr>
                            <td style="width:20%;border: 1px solid #000;border-top: none;"><span style="font-size:10px;"><b>&nbsp;&nbsp;&nbsp;&nbsp;ACCOUNT ID</b><Br><span class="text_display"></span></span></td>
                            <td style="width:20%;border: 1px solid #000;border-top: none;"><span style="font-size:10px;"><b>&nbsp;&nbsp;&nbsp;&nbsp;FEDERAL EIN</b><Br><span class="text_display"></span></span></td>
                            <td style="width:20%;border: 1px solid #000;border-top: none;"><span style="font-size:10px;"><b>&nbsp;&nbsp;&nbsp;&nbsp;LID NUMBER</b><Br><span class="text_display"></span></span></td>
                            <td style="width:20%;border: 1px solid #000;border-top: none;"><span style="font-size:10px;"><b>&nbsp;&nbsp;&nbsp;&nbsp;LCB LICENSE NUMBER</b><Br><span class="text_display"></span></span></td>
                            <td style="width:20%;border: 1px solid #000;border-top: none;"><span style="font-size:10px;"><b>&nbsp;&nbsp;&nbsp;&nbsp;REPORTING MONTH/YEAR</b><Br><span class="text_display"><?php echo date('F / Y', strtotime("last day of last month")); ?></span></span></td>
                          </tr>
                        </table>
                      </div>
                      <hr style="margin-top: 10px;margin-bottom: 10px;">
                      <table class="table table-bordered table-striped table-hover" style="font-size:11px;">
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
                                    <th class="text-right" style="font-weight:bold;"><?php echo $bucket['bucket_name']; ?></th>
                                   <?php } ?>
                                    <th class="text-right" style="font-weight:bold;">Row Total</th> 
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
                                  <td><b>TOTALS</b></td>
                                    <?php foreach($buckets as $bucket){ ?>
                                      <td class="text-right"><?php echo ${'bucket_id_total_sup'.$bucket['id']}; ?></td>
                                    <?php } ?>
                                  <td class="text-right"><?php echo $v_row_total_sup; ?></td>
                                </tr>
                            </tbody>
                      </table>
                    <?php } ?>
                  <?php } ?>

                <?php }else{ ?>
                  <div class="col-md-12">
                       <div class="alert alert-danger">
                          Sorry no supplier product found !!!
                        </div>
                   </div>
                <?php } ?>
            </div>

            <div class="col-md-12" style="width:100%;padding-left:0px;padding-right:0px;">
                <?php if(count($new_sup_c_invc_arr_main) > 0){ ?>
                  <?php foreach($new_sup_c_invc_arr_main as $k => $new_sup_c_invc_arr){ ?>
                  <?php 
                    $sup_name = '';
                    $sup_add = '';
                    $sup_city = '';
                    $sup_state = '';
                    $sup_zip = '';
                    if(count($main_supplier_arr['Schedule C'][$k]) > 0){
                      foreach ($main_supplier_arr['Schedule C'][$k] as $supplier) {
                        $sup_name = $supplier['supplier_name'];
                        $sup_add = $supplier['supplier_vaddress1'];
                        $sup_city = $supplier['supplier_vcity'];
                        $sup_state = $supplier['supplier_vstate'];
                        $sup_zip = $supplier['supplier_vzip'];
                        break;
                      }
                    }
                  ?>
                      <?php 
                        foreach($buckets as $bucket){
                            ${'bucket_id_total_sup'.$bucket['id']} = 0 ;
                          }
                          $v_row_total_sup = 0;
                      ?>
                      <p style="page-break-before:always;"></p>
                      <br>
                      <div class="row" style="width:100%;margin-top:2%;margin-bottom:-15px;">
                        <div class="col-md-4" style="width:25%;display:inline-block;">
                          <span style="font-size:10px;margin-top:0px;"><b><?php echo $store_data['vstorename'];?></b><br><?php echo $store_data['vaddress1'];?><br><?php echo $store_data['vcity'];?>, <?php echo $store_data['vstate'];?> <?php echo $store_data['vzip'];?></span>
                        </div>
                        <div class="col-md-8" style="width:40%;display:inline-block;">
                          <h3 class="panel-title" style="text-align:center;font-family:Helvetica,Arial,sans-serif;margin-top:0px;"><span style="font-size:18px;"><b style="text-transform:uppercase;">Schedule C</b></span><BR><span style="font-size:12px;line-height: 20px;">
                          MALT BEVERAGE PURCHASED FROM<br>MANUFACTURERS OUTSIDE PENNSYLVANIA
                          </span>
                          </h3>
                        </div>
                        <div style="width:35%;display:inline-block;">&nbsp;</div>
                      </div>
                      <hr style="margin-top:-15px;">
                      <div style="width:100%;margin-top:10px;">
                        <table style="width:100%;">
                          <tr>
                            <td style="width:80%;border: 1px solid #000;"><span style="font-size:10px;"><b>&nbsp;&nbsp;&nbsp;&nbsp;BUSINESS NAME</b><Br><span class="text_display"></span></span></td>
                            <td style="width:20%;border: 1px solid #000;"><span style="font-size:10px;"><b>&nbsp;&nbsp;&nbsp;&nbsp;DATE MM/DD/YYYY</b><Br><span class="text_display"><?php echo date("m/d/Y"); ?></span></span></td>
                          </tr>
                        </table>
                        <table style="width:100%;">
                          <tr>
                            <td style="width:50%;border: 1px solid #000;"><span style="font-size:10px;"><b>&nbsp;&nbsp;&nbsp;&nbsp;BUSINESS ADDRESS STREET</b><Br><span class="text_display"></span></span></td>
                            <td style="width:20%;border: 1px solid #000;"><span style="font-size:10px;"><b>&nbsp;&nbsp;&nbsp;&nbsp;CITY</b><Br><span class="text_display"></span></span></td>
                            <td style="width:10%;border: 1px solid #000;"><span style="font-size:10px;"><b>&nbsp;&nbsp;&nbsp;&nbsp;STATE</b><Br><span class="text_display"></span></span></td>
                            <td style="width:20%;border: 1px solid #000;"><span style="font-size:10px;"><b>&nbsp;&nbsp;&nbsp;&nbsp;ZIP</b><Br><span class="text_display"></span></span></td>
                          </tr>
                        </table>
                        <table style="width:100%;">
                          <tr>
                            <td style="width:20%;border: 1px solid #000;border-top: none;"><span style="font-size:10px;"><b>&nbsp;&nbsp;&nbsp;&nbsp;ACCOUNT ID</b><Br><span class="text_display"></span></span></td>
                            <td style="width:20%;border: 1px solid #000;border-top: none;"><span style="font-size:10px;"><b>&nbsp;&nbsp;&nbsp;&nbsp;FEDERAL EIN</b><Br><span class="text_display"></span></span></td>
                            <td style="width:20%;border: 1px solid #000;border-top: none;"><span style="font-size:10px;"><b>&nbsp;&nbsp;&nbsp;&nbsp;LID NUMBER</b><Br><span class="text_display"></span></span></td>
                            <td style="width:20%;border: 1px solid #000;border-top: none;"><span style="font-size:10px;"><b>&nbsp;&nbsp;&nbsp;&nbsp;LCB LICENSE NUMBER</b><Br><span class="text_display"></span></span></td>
                            <td style="width:20%;border: 1px solid #000;border-top: none;"><span style="font-size:10px;"><b>&nbsp;&nbsp;&nbsp;&nbsp;REPORTING MONTH/YEAR</b><Br><span class="text_display"><?php echo date('F / Y', strtotime("last day of last month")); ?></span></span></td>
                          </tr>
                        </table><BR>
                        <table style="width:100%;">
                          <tr>
                            <td style="width:80%;border: 1px solid #000;"><span style="font-size:10px;"><b>&nbsp;&nbsp;&nbsp;&nbsp;MANUFACTURER NAME</b><Br><span class="text_display"><?php echo $sup_name;?></span></span></td>
                            <td style="width:20%;border: 1px solid #000;"><span style="font-size:10px;"><b>&nbsp;&nbsp;&nbsp;&nbsp;MANUFACTURER EIN</b><Br><span class="text_display"></span></span></td>
                          </tr>
                        </table>
                        <table style="width:100%;">
                          <tr>
                            <td style="width:50%;border: 1px solid #000;"><span style="font-size:10px;"><b>&nbsp;&nbsp;&nbsp;&nbsp;MANUFACTURER ADDRESS STREET</b><Br><span class="text_display"><?php echo $sup_add;?></span></span></td>
                            <td style="width:20%;border: 1px solid #000;"><span style="font-size:10px;"><b>&nbsp;&nbsp;&nbsp;&nbsp;CITY</b><Br><span class="text_display"><?php echo $sup_city;?></span></span></td>
                            <td style="width:10%;border: 1px solid #000;"><span style="font-size:10px;"><b>&nbsp;&nbsp;&nbsp;&nbsp;STATE</b><Br><span class="text_display"><?php echo $sup_state;?></span></span></td>
                            <td style="width:20%;border: 1px solid #000;"><span style="font-size:10px;"><b>&nbsp;&nbsp;&nbsp;&nbsp;ZIP</b><Br><span class="text_display"><?php echo $sup_zip;?></span></span></td>
                          </tr>
                        </table>
                      </div>
                      <hr style="margin-top: 10px;margin-bottom: 10px;">
                      <table class="table table-bordered table-striped table-hover" style="font-size:11px;margin-top: 10px;">
                        <thead>
                                <tr>
                                    <th style="width:7%;text-align:center;">MM/DD/YYYY<br>Date</th>
                                    <th style="text-align:center;">Invoice Number</th>
                                   <?php foreach($buckets as $bucket){ ?>
                                    <th class="text-right" style="font-weight:bold;"><?php echo $bucket['bucket_name']; ?></th>
                                   <?php } ?>
                                    <th class="text-right" style="font-weight:bold;">Row Total</th> 
                                </tr>
                            </thead>
                            <tbody>
                              <?php foreach($new_sup_c_invc_arr as $key => $main_invoice){ ?>

                                <?php $sup_row_total = 0;?>

                                <tr>
                                  <td><?php echo $main_invoice['dreceiveddate'];?></td>
                                  <td><?php echo $main_invoice['vinvoiceno'];?></td>
                                  <?php foreach($buckets as $b => $bucket){ ?>
                                    <?php 
                                      $sup_row_total = $sup_row_total + $main_invoice[$bucket['id']];

                                        ${'bucket_id_total_sup'.$bucket['id']} = ${'bucket_id_total_sup'.$bucket['id']} + $main_invoice[$bucket['id']];
                                    ?>
                                    <td class="text-right"><?php echo $main_invoice[$bucket['id']];?></td>
                                  <?php } ?>
                                  <td class="text-right">
                                    <?php echo $sup_row_total; ?>
                                    <?php $v_row_total_sup = $v_row_total_sup + $sup_row_total;  ?>
                                  </td>
                              </tr>
                              <?php } ?>
                              <tr>
                                  <td style="border-left:none;border-bottom:none;"><b>&nbsp;</b></td>
                                  <td><b>TOTALS</b></td>
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
  </body>
  </html>



