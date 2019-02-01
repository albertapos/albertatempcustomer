<?php echo $header; ?><?php echo $column_left; ?>

<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <!-- <h1><?php echo $heading_title; ?></h1> -->
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
      </div>
      <div class="panel-body">

        <div class="row" style="padding-bottom: 15px;float: right;">
          <div class="col-md-12">
            <a id="csv_export_btn" href="<?php echo $csv_export; ?>" class="pull-right" style="margin-right:10px;"><i class="fa fa-file-excel-o" aria-hidden="true"></i> CSV</a>
            <a href="<?php echo $print_page; ?>" id="btnPrint" class="pull-right" style="margin-right:10px;"><i class="fa fa-print" aria-hidden="true"></i> Print</a>
          <a id="pdf_export_btn" href="<?php echo $pdf_save_page; ?>" class="pull-right" style="margin-right:10px;"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF</a>
          </div>
        </div>
        <div class="clearfix"></div>

      <div class="row">
          <form method="post" id="filter_form">
            <div class='col-md-12'>
               
                <div class="col-md-2">
                  <input type="" class="form-control" name="start_date" value="<?php echo isset($p_start_date) ? $p_start_date : ''; ?>" id="start_date" placeholder="Date">
                </div>
                
                <div class="col-md-2">
                  <input type="submit" class="btn btn-success" value="Generate">
                </div> 
                
            </div>
            
          </form>
        </div>
        <br>
    
    <?php // if (isset($data_set)) {    ?>
    
        <div class="row">
          <div class="col-md-12">
            <div class='col-md-6'>
                <p><b>Store Name: </b><?php echo $storename; ?></p>
            </div>
          </div>
        </div>
        
        <div class="row">
          <div class="col-md-12">
            <div class='col-md-6'>
                <p><b>Store Address: </b><?php echo $storeaddress; ?></p>
            </div>    
          </div>
        </div>
        
        <div class="row">
          <div class="col-md-12">
            <div class='col-md-6'>
                <p><b>Store Phone: </b><?php echo $storephone; ?></p>
            </div>
          </div>
        </div>
        
        <div class="row">
          <div class="col-md-12">
            <div class='col-md-6'>
                <p><b>Date: </b><?php echo isset($p_start_date) ? $p_start_date : date("m-d-Y"); ?></p>
            </div>
          </div>
        </div>
        
        <div class="row">
          <div class="table-responsive">
              
            <div class="col-md-12">
                
               <div class="col-md-6">
                
                    <table class="table table-bordered table-striped table-hover">
                        
                        
                        <tr>
                            <th>Store Sales with Tax (excluding Liability Sales)</th>
                            <td class="text-right"><?php echo $report_sub_totals[0]['Sales_With_Tax']-$report_liability_sales[0]['Liability_Amount']; ?></td>
                        </tr>
                        
                        <tr>
                            <th>Liablity Sales</th>
                            <td class="text-right"><?php echo isset($report_liability_sales[0]['Liability_Amount']) ? $report_liability_sales[0]['Liability_Amount']:"0.00"; ?></td>
                        </tr>
                        
                        <tr>
                            <th>Fuel Sales</th>
                            <td class="text-right"><?php echo "0.00"; ?></td>
                        </tr>
                        
                        <tr>
                            <th>Total Sales</th>
                            <td class="text-right"><?php echo $total_sales = $report_sub_totals[0]['Sales_With_Tax']; ?></td>
                        </tr>
                        
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        
                        <tr>
                            <th>Taxable Sales</th>
                            <td class="text-right"><?php echo isset($report_sub_totals[0]['Taxable_Total']) ? $report_sub_totals[0]['Taxable_Total']:"0.00"; ?></td>
                        </tr>
                        
                        <tr>
                            <th>Non-Taxable Sales</th>
                            <td class="text-right"><?php echo isset($report_sub_totals[0]['Non_Taxable_Sales']) ? $report_sub_totals[0]['Non_Taxable_Sales']:"0.00"; ?></td>
                        </tr>
                        
                        <tr>
                            <th>Total Store Sales</th>
                            <td class="text-right"><?php echo ($report_sub_totals[0]['Taxable_Total'] + $report_sub_totals[0]['Non_Taxable_Sales']); ?></td>
                        </tr>
                        
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        
                        <tr>
                            <th>Tax1</th>
                            <td class="text-right"><?php echo $tax1 = isset($report_liability_sales[0]['Tax1_Total']) ? number_format((float)$report_liability_sales[0]['Tax1_Total'], 2, '.', ''):"0.00"; ?></td>
                            
                            
                        </tr>
                        
                         <tr>
                            <th>Tax2</th>
                            <td class="text-right"><?php echo $tax2 = isset($report_liability_sales[0]['Tax2_Total']) ? number_format((float)$report_liability_sales[0]['Tax2_Total'], 2, '.', '') :"0.00"; ?></td>
                            
                            
                        </tr>
                        
                        <tr>
                            <th>Total Sales Tax</th>
                            <!--<td class="text-right"><?php //echo isset($report_sub_totals[0]['Total_Tax']) ? $report_sub_totals[0]['Total_Tax']: 0.00; ?></td>-->
                            <td class="text-right"><?php echo $tax1 + $tax2; ?></td>
                        </tr>
                        
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        
                        <tr>
                            <th>Lottery Sales</th>
                            <td class="text-right"><?php echo isset($report_liability_sales[0]['Lot_Sales']) ? $report_liability_sales[0]['Lot_Sales']:"0.00"; ?></td>
                            
                            
                        </tr>
                        
                        <tr>
                            <th>Instant Sales</th>
                            <td class="text-right"><?php echo isset($report_liability_sales[0]['Inst_Sales']) ? $report_liability_sales[0]['Inst_Sales']:"0.00"; ?></td>
                            
                            
                        </tr>
                        
                        <tr>
                            <th>Lottery Redeem</th>
                            <td class="text-right"><?php echo isset($report_liability_sales[0]['Lot_Redeem']) ? $report_liability_sales[0]['Lot_Redeem']:"0.00"; ?></td>
                            
                            
                        </tr>
                        
                        <tr>
                            <th>Instant Redeem</th>
                            <td class="text-right"><?php echo isset($report_liability_sales[0]['Inst_Redeem']) ? $report_liability_sales[0]['Inst_Redeem']:"0.00"; ?></td>
                            
                            
                        </tr>
                        
                        <tr>
                            <th>Lotto Sales</th>
                            <td class="text-right"><?php $lotto_sales = ($report_liability_sales[0]['Lot_Sales']+$report_liability_sales[0]['Inst_Sales']+$report_liability_sales[0]['Lot_Redeem']+$report_liability_sales[0]['Inst_Redeem']); echo number_format((float)$lotto_sales, 2, '.', ''); ?></td>
                        </tr>
                        
        
        
                        <tr>
                            <th>Other Liability sales</th>
                            <td class="text-right"><?php $other_liability_sales = ($report_liability_sales[0]['Liability_Amount'] - $lotto_sales); echo number_format((float)$other_liability_sales, 2, '.', '');?></td>
                        </tr>
                        
                        <tr>
                            <th>&nbsp;</th>
                            <td>&nbsp;</td>
                        </tr>
                        
                        <tr>
                            <th>House Charged</th>
                            <td class="text-right"><?php echo $house_charged = isset($report_sub_totals[0]['House_Charged']) ? $report_sub_totals[0]['House_Charged']:"0.00"; ?></td>
                            
                            
                        </tr>
                        
                        <tr>
                            <th>House Charge Payments</th>
                            <td class="text-right"><?php echo $house_charge_payments = isset($report_house_charge[0]['housecharge_payments']) ? $report_house_charge[0]['housecharge_payments']:"0.00"; ?></td>
                            
                            
                        </tr>
                        
                        <tr>
                            <th>Bottle Deposit</th>
                            <td class="text-right"><?php echo $bottle_deposit = isset($report_liability_sales[0]['Bottle_Deposit']) ? $report_liability_sales[0]['Bottle_Deposit']:"0.00"; ?></td>
                            
                            
                        </tr>
                        
                        <tr>
                            <th>Bottle Deposit Redeem</th>
                            <td class="text-right"><?php echo $bottle_deposit_redeem = isset($report_liability_sales[0]['Bottle_Deposit_Redeem']) ? $report_liability_sales[0]['Bottle_Deposit_Redeem']:"0.00"; ?></td>
                        </tr>  
        
        
        
                        <tr>
                            <th>Payouts Total</th>
                            <td class="text-right"><?php $paid_out_index = count($report_paid_out) - 1; echo  $payouts = isset($report_paid_out[$paid_out_index]['Amount']) ? $report_paid_out[$paid_out_index]['Amount']:"0.00"; ?></td>
                        </tr>
                        
                        <tr>
                            <th>&nbsp;</th>
                            <td>&nbsp;</td>
                        </tr>
                        
                        <tr>
                            <th>Cash</th>
                            <td class="text-right"><?php echo $cash = ($report_sub_totals[0]['Sales_With_Tax'] - $report_sub_totals[0]['Credit_Card_Payments']); ?></td>
                            
                            
                        </tr>
                        
                        <tr>
                            <th>Coupon</th>
                            <td class="text-right"><?php echo $coupon = isset($report_liability_sales[0]['Coupon_Redeem']) ? $report_liability_sales[0]['Coupon_Redeem']:"0.00"; ?></td>
                            
                            
                        </tr>
                        
                        <tr>
                            <th>Check</th>
                            <td class="text-right"><?php echo $check = isset($report_sub_totals[0]['Check_Payments']) ? $report_sub_totals[0]['Check_Payments']:"0.00"; ?></td>
                            
                            
                        </tr>
                        
                        <tr>
                            <th>Discount</th>
                            <td class="text-right"><?php echo isset($report_sub_totals[0]['Discount_Amount']) ? $report_sub_totals[0]['Discount_Amount']:"0.00"; ?></td>
                            
                            
                        </tr>
        
                        <tr>
                            <th>Master Card</th>
                            <td class="text-right"><?php echo $mc = isset($report_card_master[0]['nauthamount']) ? $report_card_master[0]['nauthamount']:"0.00"; ?></td>
                        </tr>
                        
                        <tr>
                            <th>Visa</th>
                            <td class="text-right"><?php echo $vi = isset($report_card_visa[0]['nauthamount']) ? $report_card_visa[0]['nauthamount']:"0.00"; ?></td>
                        </tr>
                        
                        <tr>
                            <th>DISCOVER</th>
                            <td class="text-right"><?php echo $di = isset($report_card_discover[0]['nauthamount']) ? $report_card_discover[0]['nauthamount']:"0.00"; ?></td>
                        </tr>
                        
                        <tr>
                            <th>Amex</th>
                            <td class="text-right"><?php echo $am = isset($report_card_amex[0]['nauthamount']) ? $report_card_amex[0]['nauthamount']:"0.00"; ?></td>
                        </tr>
                        
                        <tr>
                            <th>EBT Cash</th>
                            <td class="text-right"><?php echo $ebt_cash = isset($report_sub_totals[0]['EBT_Cash_Payments']) ? $report_sub_totals[0]['EBT_Cash_Payments']:"0.00"; ?></td>
                        </tr>
                        
                        <tr>
                            <th>EBT</th>
                            <td class="text-right"><?php echo $ebt = isset($report_card_ebt[0]['nauthamount']) ? $report_card_ebt[0]['nauthamount']:"0.00"; ?></td>
                         
                            
                            
                        </tr>
                        
                        <tr>
                            <th>Credit Card Total</th>
                            <!--<td class="text-right"><?php //echo $credit_card_total = isset($report_sub_totals[0]['Credit_Card_Payments']) ? $report_sub_totals[0]['Credit_Card_Payments']: 0.00; ?></td>-->
                            <td class="text-right"><?php echo $mc+$vi+$di+$am+$ebt_cash+$ebt; ?></td>
                            
                            
                        </tr>
                        
                        
                        <tr>
                            <th>Start Cash</th>
                            <td class="text-right"><?php echo $start_cash = isset($start_cash[0]['start_cash']) ? $start_cash[0]['start_cash']:"0.00"; ?></td>
                            
                            
                        </tr>

                   
                        <tr>
                            <th>Drawer Total With Start Cash Amount</th>
                            <td class="text-right"><?php echo $drawer_total = ($cash + $start_cash + $lotto_sales + $other_liability_sales + $house_charge_payments + $bottle_deposit - $payouts - $house_charged - $bottle_deposit_redeem - $credit_card_total - $check - $coupon); ?></td>
                            
                            
                        </tr>
                        
                        <tr>
                            <th>Store Deposit</th>
                            <td class="text-right"><?php echo $store_deposit = $drawer_total - $other_liability_sales - $lotto_sales; ?></td>
                            
                            
                        </tr>
                        
                        <tr>
                            <th>Liablity Deposit</th>
                            <td class="text-right"><?php echo $liability_deposit = $lotto_sales - $other_liability_sales; ?></td>
                        </tr>
                        
                        <tr>
                            <th>Collected Cash</th>
                            <td class="text-right"><?php echo $collected_cash = isset($report_total_shift_cash[0]['TotalAmount']) ? $report_total_shift_cash[0]['TotalAmount']:"0.00"; ?></td>
                            
                            
                        </tr>
        
                        <tr>
                            <th>Over/short Cash</th>

                            <td class="text-right"><?php echo $collected_cash - $drawer_total-$start_cash; ?></td>
                            
                            
                        </tr>
                        
                        <tr>
                            <th>Discount Total</th>
                            <td class="text-right"><?php echo isset($report_sub_totals[0]['Discount_Amount']) ? $report_sub_totals[0]['Discount_Amount']:"0.00"; ?></td>
                            
                            
                        </tr>
                        
                        <tr>
                            <th>Void Total</th>
                            <td class="text-right"><?php echo isset($report_void_sale_amount[0]['Void_Amount']) ? $report_void_sale_amount[0]['Void_Amount']:"0.00"; ?></td>
                        </tr>
                        
                        <tr>
                            <th>Delete Total</th>
                            <td class="text-right"><?php echo isset($report_deleted_sales[0]['Deleted_Items_Amount']) ? $report_deleted_sales[0]['Deleted_Items_Amount']:"0.00"; ?></td>
                        </tr>                
                        
                      <!--<tr>
                        <th>Opening Balance</th>
                        <td class="text-right"><?php echo isset($report_shifts[0]['NOPENINGBALANCE']) ? $report_shifts[0]['NOPENINGBALANCE']: 0; ?></td>
                      </tr>
                      <tr>
                        <th>Cash on Drawer</th>
                        <td class="text-right"><?php echo isset($report_shifts[0]['CASHONDRAWER']) ? $report_shifts[0]['CASHONDRAWER']: 0; ?></td>
                      </tr>
                      <tr>
                        <th>User Closing Balance</th>
                        <td class="text-right"><?php echo isset($report_shifts[0]['userclosingbalance']) ? $report_shifts[0]['userclosingbalance']: 0; ?></td>
                      </tr>
                      <tr>
                        <th>Cash Short/Over</th>
                        <td class="text-right"><?php echo isset($report_shifts[0]['CashShort']) ? $report_shifts[0]['CashShort']: 0; ?></td>
                      </tr>
                      <tr>
                        <th>Sales</th>
                        <td class="text-right"><?php echo isset($report_shifts[0]['Nebtsales']) ? $report_shifts[0]['Nebtsales']: 0; ?></td>
                      </tr>
                      <tr>
                        <th>Cash Added</th>
                        <td class="text-right"><?php echo isset($report_shifts[0]['naddcash']) ? $report_shifts[0]['naddcash']: 0; ?></td>
                      </tr>
                      <tr>
                        <th>SubTotal</th>
                        <td class="text-right"><?php echo isset($report_shifts[0]['NSUBTOTAL']) ? $report_shifts[0]['NSUBTOTAL']: 0; ?></td>
                      </tr>
                      <tr>
                        <th>Closing Balance</th>
                        <td class="text-right"><?php echo isset($report_shifts[0]['NCLOSINGBALANCE']) ? $report_shifts[0]['NCLOSINGBALANCE']: 0; ?></td>
                      </tr>
                      <tr>
                        <th>Total Tax</th>
                        <td class="text-right"><?php echo isset($report_shifts[0]['NTAXTOTAL']) ? $report_shifts[0]['NTAXTOTAL']: 0; ?></td>
                      </tr>
                      <tr>
                        <th>Taxable Sales</th>
                        <td class="text-right"><?php echo isset($report_shifts[0]['ntaxable']) ? $report_shifts[0]['ntaxable']: 0; ?></td>
                      </tr>
                      <tr>
                        <th>Nontaxable Sales</th>
                        <td class="text-right"><?php echo isset($report_shifts[0]['nnontaxabletotal']) ? $report_shifts[0]['nnontaxabletotal']: 0; ?></td>
                      </tr>
                      <tr>
                        <th>Discount</th>
                        <td class="text-right"><?php echo isset($report_shifts[0]['ndiscountamt']) ? $report_shifts[0]['ndiscountamt']: 0; ?></td>
                      </tr>
                      <tr>
                        <th>Sale Discount</th>
                        <td class="text-right"><?php echo isset($report_shifts[0]['ntotalsalediscount']) ? $report_shifts[0]['ntotalsalediscount']: 0; ?></td>
                      </tr>
                      <tr>
                        <th>Total Sales (Without Tax)</th>
                        <td class="text-right"><?php echo isset($report_shifts[0]['ntotalsaleswtax']) ? $report_shifts[0]['ntotalsaleswtax']: 0; ?></td>
                      </tr>
                      <tr>
                        <th>Total Credit Amt</th>
                        <td class="text-right"><?php echo isset($report_shifts[0]['noncredittotal']) ? $report_shifts[0]['noncredittotal']: 0; ?></td>
                      </tr>-->
                    </table>                
                
                </div> 
                
                
                <div class="col-md-6">
                
                    <table class="table table-bordered table-striped table-hover">
                        
                        <tr>
                            <th>Transaction Count</th>
                            <td class="text-right"><?php echo $trans_count = isset($report_sales_total[0]['No_of_Sales']) ? $report_sales_total[0]['No_of_Sales']: 0; ?></td>
                        </tr>
                        
                        
                        <tr>
                            
                        </tr>
                        
                            <th>Number of Sales</th>
                            <td class="text-right"><?php echo $number_of_sales = $trans_count - $report_sales_total[0]['No_of_Void']; ?></td>                    
                        
                        <tr>
                            <th>Number of Void Sales</th>
                            <td class="text-right"><?php echo isset($report_sales_total[0]['No_of_Void']) ? $report_sales_total[0]['No_of_Void']: 0; ?></td>                            
                        </tr>
                        

                        
                        <tr>
                            <th>Number of Delete</th>
                            <td class="text-right"><?php echo isset($report_deleted_sales[0]['No_of_Trn_Items_Deleted']) ? $report_deleted_sales[0]['No_of_Trn_Items_Deleted']: 0; ?></td> 
                        </tr>
                        
                                           

                        
                        <tr>
                            <th>Number of NoSales</th>
                            <td class="text-right"><?php echo isset($report_sales_total[0]['No_Sales']) ? $report_sales_total[0]['No_Sales']: 0; ?></td> 
                        </tr>

                                           
                        
                        <tr>
                            <th>&nbsp;</th>
                            <td class="text-right"><?php echo ""; ?></td>
                        </tr>
                        
                                            
                        
                        <tr>
                            <th>Gross Cost</th>
                            <td class="text-right"><?php echo isset($report_liability_sales[0]['Gross_Cost']) ? $report_liability_sales[0]['Gross_Cost']: 0.00; ?></td>
                        </tr>
                        
                            
                        
                        <tr>
                            <th>Gross Profit</th>
                            <td class="text-right"><?php echo $profit = $total_sales - $report_liability_sales[0]['Gross_Cost']; ?></td>
                        </tr>
    
                            
                        
                        <tr>
                            <th>Gross Profit (%)</th>
                            <td class="text-right"><?php $profit_percent = (($profit / $total_sales)*100); echo number_format((float)$profit_percent, 2, '.', ''); ?></td>
                        </tr>
    
                            
                        
                        <tr>
                            <th>Average Sales</th>
                            <td class="text-right"><?php $avg_sales = $trans_count != 0? ($total_sales/$trans_count): 0.00; echo number_format((float)$avg_sales, 2, '.', ''); ?></td>
                        </tr>
    
                            
                        
                        <tr>
                            <th>Returns</th>
                            <td class="text-right"><?php echo isset($report_liability_sales[0]['Return_Amount']) ? number_format((float)$report_liability_sales[0]['Return_Amount'], 2, '.', ''):"0.00"; ?></td>
                        </tr>
    
                        
                        
                        <tr>
                            <th>&nbsp;</th>
                            <td><?php echo ""; ?></td>
                        </tr>
    
                            
                        
                        <tr>
                            <th>Hourly Sales</th>
                            <td class="text-right"><b>Amount</b></td>
                        </tr>


                        <?php foreach($report_hourly as $r) { ?>
                            
                            <tr>
                                <th><?php echo isset($r['Hours']) ? $r['Hours']: 0; ?></th>
                                <td class='text-right'><?php echo isset($r['Amount']) ? $r['Amount']: 0; ?></td>
                            </tr>
                        
                        
                        <?php } ?>
                        
                    </table>
                
                </div>
                
            </div>
            
            
            <div class='col-md-12'>
                
                <div class='col-md-6'>

                    <table class="table table-bordered table-striped table-hover">
                    
                    
                        <tr>
                            <th>Department</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <!--<th>Average</th>
                            <th>% Total</th>-->
                        </tr>
                        <?php foreach($report_department_summary as $v){ ?>
                            <tr>
                                <td><?php echo isset($v['Dept']) ? $v['Dept']: ""; ?></td>
                                <td><?php echo isset($v['Qty']) ? $v['Qty']: 0; ?></td>
                                <td><?php echo isset($v['Amount']) ? $v['Amount']: 0; ?></td>
                                <!--<td class="text-right"></td>
                                <td class="text-right"></td>-->
                            </tr>
                        <?php } ?>
                    
                    
                    </table>
                
                </div>
                
                
                <div class='col-md-6'>
                
                
                    <table class="table table-bordered table-striped table-hover">
                    
                    
                        <tr>
                            <th>No.</th>
                            <th>Vendor Name</th>
                            <th>Amount</th>
                        </tr>
                        <?php 
                            $count = 0; 
                            foreach($report_paid_out as $v){
                            
                            if($v['vpaidoutname'] == null || $v['vpaidoutname'] == ''){
                                continue;
                            }
                        ?>
                            <tr>
                                <td><?php echo ++$count; ?></td>
                                <td><?php echo isset($v['vpaidoutname']) ? $v['vpaidoutname']: ""; ?></td>
                                <td><?php echo isset($v['Amount']) ? $v['Amount']: 0.00; ?></td>
                            </tr>
                        <?php
                            }
                        ?>
                    
                    
                    
                    </table>
                    
                </div>
                
            </div>
            
            
            
            
            
          </div>
          <div class="col-md-12" style="display:none;">
            <div class="title_div" style="width:50%;background-color: #2486c6;color: #fff;">
             <b>Tender Detail</b>
            </div>
            <table class="table table-bordered" style="width:50%;">
              <tbody>
                <?php if(isset($report_tenders) && count($report_tenders) > 0){ ?>
                  <?php foreach($report_tenders as $report_tender){ ?>
                  <tr>
                    <td><?php echo $report_tender['vtendername']; ?></td>
                    <td class="text-right"><?php echo $report_tender['namount'].'['.$report_tender['ntotcount'].']'; ?></td>
                  </tr>
                  <?php } ?>
                <?php } else { ?>
                <tr>
                  <td><b>Sorry no data found!</b></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
<?php //} ?>
        <div class="row">
          <div class="col-md-12" style="display:none;">
            <div class="title_div" style="width:50%;background-color: #2486c6;color: #fff;">
              <b>Hourly Sales</b>
            </div>
            <table class="table table-bordered" style="width:50%;">
              <tbody>
                <?php if(isset($report_hourly_sales) && count($report_hourly_sales) > 0){ ?>
                  <?php foreach($report_hourly_sales as $report_hourly_sale){ ?>
                  <tr>
                    <td><?php echo $report_hourly_sale['TODATE']; ?></td>
                    <td class="text-right"><?php echo $report_hourly_sale['AMT']; ?></td>
                  </tr>
                  <?php } ?>
                <?php } else { ?>
                <tr>
                  <td><b>Sorry no data found!</b></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>

        </div>

      </div>
    </div>
  </div>
</div>

<?php echo $footer; ?>
<link type="text/css" href="view/javascript/bootstrap-datepicker.css" rel="stylesheet" />
<script src="view/javascript/bootstrap-datepicker.js" defer></script>
<script src="view/javascript/jquery.printPage.js"></script>

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

<script>
  $(function(){
    $("#start_date").datepicker({
      format: 'mm-dd-yyyy',
      todayHighlight: true,
      autoclose: true,
    });
  });

  $(document).on('submit', '#filter_form', function(event) {

    if($('#start_date').val() == ''){
      bootbox.alert({ 
        size: 'small',
        title: "Attention", 
        message: "Please Select Date", 
        callback: function(){}
      });
      return false;
    }

    $("div#divLoading").addClass('show');
  });
</script>

<style type="text/css">



  .title_div{
    border: 1px solid #ddd;
    padding: 5px;
  }

</style>

<script>  
$(document).ready(function() {
  $("#btnPrint").printPage();
});
</script>

<script type="text/javascript">
  $(window).load(function() {
    $("div#divLoading").removeClass('show');
  });
</script>

<script type="text/javascript">

  const saveData = (function () {
    const a = document.createElement("a");
    document.body.appendChild(a);
    a.style = "display: none";
    return function (data, fileName) {
        const blob = new Blob([data], {type: "octet/stream"}),
            url = window.URL.createObjectURL(blob);
        a.href = url;
        a.download = fileName;
        a.click();
        window.URL.revokeObjectURL(url);
    };
  }());

  $(document).on("click", "#csv_export_btn", function (event) {

    event.preventDefault();

    $("div#divLoading").addClass('show');

      var csv_export_url = '<?php echo $csv_export; ?>';
    
      csv_export_url = csv_export_url.replace(/&amp;/g, '&');

      $.ajax({
        url : csv_export_url,
        type : 'GET',
      }).done(function(response){
        
        const data = response,
        fileName = "end-of-day-report.csv";

        saveData(data, fileName);
        $("div#divLoading").removeClass('show');
        
      });
    
  });

  $(document).on("click", "#pdf_export_btn", function (event) {

    event.preventDefault();

    $("div#divLoading").addClass('show');

    var pdf_export_url = '<?php echo $pdf_save_page; ?>';
  
    pdf_export_url = pdf_export_url.replace(/&amp;/g, '&');

    var req = new XMLHttpRequest();
    req.open("GET", pdf_export_url, true);
    req.responseType = "blob";
    req.onreadystatechange = function () {
      if (req.readyState === 4 && req.status === 200) {

        if (typeof window.navigator.msSaveBlob === 'function') {
          window.navigator.msSaveBlob(req.response, "End-of-Day-Report.pdf");
        } else {
          var blob = req.response;
          var link = document.createElement('a');
          link.href = window.URL.createObjectURL(blob);
          link.download = "End-of-Day-Report.pdf";

          // append the link to the document body

          document.body.appendChild(link);

          link.click();
           
        }
      }
      $("div#divLoading").removeClass('show');
    };
    req.send();
    
  });
</script>

<script src="view/javascript/bootbox.min.js" defer></script>
<script>
    
    $("#pdf_export_btn1").click(function(e){
        e.preventDefault();
        var date=$("#start_date").val();
        $.ajax({
           url:"index.php?route=administration/end_of_day_report/get_pdf_day/",
           data:{date:date},
           type:"POST",
           dataType:"JSON",
           success:function(data){
               alert(data);
           },
           error:function(xhr){
               alert(xhr.responseText);
               
               
           }
            
            
            
        });
        
        
    });
    
    
</script>