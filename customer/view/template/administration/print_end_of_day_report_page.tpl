<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<div class="row">
    <div class='col-md-6'>
        <p><b>Store Name: </b><?php echo $storename; ?></p>
    </div>
</div>

<div class="row">
    <div class='col-md-6'>
        <p><b>Store Address: </b><?php echo $storeaddress; ?></p>
    </div>    
</div>

<div class="row">
    <div class='col-md-6'>
        <p><b>Store Phone: </b><?php echo $storephone; ?></p>
    </div>
</div>

<div class="row">
    <div class='col-md-6'>
        <p><b>Date: </b><?php echo isset($p_start_date) ? $p_start_date : date("m-d-Y"); ?></p>
    </div>
</div>



<!=============================== DATA =================================================->

<div class="row">
    <div class='col-md-12'>
        <table class="table table-bordered table-striped table-hover"  >
                      

        <tr>
            <td class="col-md-6">Store Sales with Tax</td>
            <td class="text-right"><?php echo isset($report_sub_totals[0]['Sales_With_Tax']) ? $report_sub_totals[0]['Sales_With_Tax']: 0; ?></td>
        </tr>
        
        <tr>
            <td>Liablity Sales</td>
            <td class="text-right"><?php echo isset($report_liability_sales[0]['Liability_Amount']) ? $report_liability_sales[0]['Liability_Amount']: 0; ?></td>
        </tr>
        
        <tr>
            <td>Fuel Sales</td>
            <td class="text-right"><?php echo "0.00"; ?></td>
        </tr>
        
        <tr>
            <td>Total Sales</td>
            <td class="text-right"><?php echo $total_sales = $report_sub_totals[0]['Sales_With_Tax']; ?></td>
        </tr>
        
        <tr>
            <td>Taxable Sales</td>
            <td class="text-right"><?php echo isset($report_sub_totals[0]['Taxable_Total']) ? $report_sub_totals[0]['Taxable_Total']: 0; ?></td>
        </tr>
        
        <tr>
            <td>Non-Taxable Sales</td>
            <td class="text-right"><?php echo isset($report_sub_totals[0]['Non_Taxable_Sales']) ? $report_sub_totals[0]['Non_Taxable_Sales']: 0; ?></td>
        </tr>
        
        <tr>
            <td>Total Store Sales</td>
            <td class="text-right"><?php echo ($report_sub_totals[0]['taxable_sales'] + $report_sub_totals[0]['nontaxable_sales']); ?></td>
        </tr>
        
        
        <tr>
            <td>Tax1</td>
            <td class="text-right"><?php echo isset($report_liability_sales[0]['Tax1_Total']) ? number_format((float)$report_liability_sales[0]['Tax1_Total'], 2, '.', ''): 0; ?></td>
            
            
        </tr>
        
         <tr>
            <td>Tax2</td>
            <td class="text-right"><?php echo isset($report_liability_sales[0]['Tax2_Total']) ? number_format((float)$report_liability_sales[0]['Tax2_Total'], 2, '.', '') : 0; ?></td>
            
            
        </tr>
        
        <tr>
            <td>Total Sales Tax</td>
            <td class="text-right"><?php echo isset($report_sub_totals[0]['Total_Tax']) ? $report_sub_totals[0]['Total_Tax']: 0; ?></td>
            
            
        </tr>
        

        <tr>
            <td>Lottery Sales</td>
            <td class="text-right"><?php echo isset($report_liability_sales[0]['Lot_Sales']) ? $report_liability_sales[0]['Lot_Sales']: 0; ?></td>
            
            
        </tr>
        
        <tr>
            <td>Instant Sales</td>
            <td class="text-right"><?php echo isset($report_liability_sales[0]['Inst_Sales']) ? $report_liability_sales[0]['Inst_Sales']: 0; ?></td>
            
            
        </tr>
        
        <tr>
            <td>Lottery Redeem</td>
            <td class="text-right"><?php echo isset($report_liability_sales[0]['Lot_Redeem']) ? $report_liability_sales[0]['Lot_Redeem']: 0; ?></td>
            
            
        </tr>
        
        <tr>
            <td>Instant Redeem</td>
            <td class="text-right"><?php echo isset($report_liability_sales[0]['Inst_Redeem']) ? $report_liability_sales[0]['Inst_Redeem']: 0; ?></td>
            
            
        </tr>
        
        <tr>
            <td>Lotto Sales</td>
            <td class="text-right"><?php echo $lotto_sales = ($report_liability_sales[0]['Lot_Sales']+$report_liability_sales[0]['Inst_Sales']-$report_liability_sales[0]['Lot_Redeem']-$report_liability_sales[0]['Inst_Redeem']); ?></td>
            
            
        </tr>
        


        <tr>
            <td>Other Liability sales</td>
            <td class="text-right"><?php echo $other_liability_sales = ($report_liability_sales[0]['Liability_Amount'] - ($report_liability_sales[0]['Lot_Sales']+$report_liability_sales[0]['Inst_Sales']-$report_liability_sales[0]['Lot_Redeem']-$report_liability_sales[0]['Inst_Redeem'])); ?></td>
            
            
        </tr>
        
        <tr>
            <td>House Charged</td>
            <td class="text-right"><?php echo $house_charged = isset($report_sub_totals[0]['House_Charged']) ? $report_sub_totals[0]['House_Charged']: 0; ?></td>
            
            
        </tr>
        
        <tr>
            <td>House Charge Payments</td>
            <td class="text-right"><?php echo $house_charge_payments = isset($report_house_charge[0]['housecharge_payments']) ? $report_house_charge[0]['housecharge_payments']: 0; ?></td>
            
            
        </tr>
        
        <tr>
            <td>Bottle Deposit</td>
            <td class="text-right"><?php echo $bottle_deposit = isset($report_liability_sales[0]['Bottle_Deposit']) ? $report_liability_sales[0]['Bottle_Deposit']: 0; ?></td>
            
            
        </tr>
        
        <tr>
            <td>Bottle Deposit Redeem</td>
            <td class="text-right"><?php echo $bottle_deposit_redeem = isset($report_liability_sales[0]['Bottle_Deposit_Redeem']) ? $report_liability_sales[0]['Bottle_Deposit_Redeem']: 0; ?></td>
            
            
        </tr>  



        <tr>
            <td>Payouts Total</td>
            <td class="text-right"><?php echo $payouts = isset($report_paid_out[0]['Amount']) ? $report_paid_out[0]['Amount']: 0; ?></td>
            
            
        </tr>
        
        <tr>
            <td>Cash</td>
            <td class="text-right"><?php echo $cash = ($report_sub_totals[0]['Sales_With_Tax'] - $report_sub_totals[0]['Credit_Card_Payments']); ?></td>
            
            
        </tr>
        
        <tr>
            <td>Coupon</td>
            <td class="text-right"><?php echo $coupon = isset($report_liability_sales[0]['Coupon_Redeem']) ? $report_liability_sales[0]['Coupon_Redeem']: 0; ?></td>
            
            
        </tr>
        
        <tr>
            <td>Check</td>
            <td class="text-right"><?php echo $check = isset($report_sub_totals[0]['Check_Payments']) ? $report_sub_totals[0]['Check_Payments']: 0; ?></td>
            
            
        </tr>
        
        <tr>
            <td>Discount</td>
            <td class="text-right"><?php echo isset($report_sub_totals[0]['Discount_Amount']) ? $report_sub_totals[0]['Discount_Amount']: 0; ?></td>
            
            
        </tr>

        <tr>
            <td>Master Card</td>
            <td class="text-right"><?php echo $mc = isset($report_card_master[0]['nauthamount']) ? $report_card_master[0]['nauthamount']:"0.00"; ?></td>
        </tr>
        
        <tr>
            <td>Visa</td>
            <td class="text-right"><?php echo $vi = isset($report_card_visa[0]['nauthamount']) ? $report_card_visa[0]['nauthamount']:"0.00"; ?></td>
        </tr>
        
        <tr>
            <td>DISCOVER</td>
            <td class="text-right"><?php echo $di = isset($report_card_discover[0]['nauthamount']) ? $report_card_discover[0]['nauthamount']:"0.00"; ?></td>
        </tr>
        
        <tr>
            <td>Amex</td>
            <td class="text-right"><?php echo $am = isset($report_card_amex[0]['nauthamount']) ? $report_card_amex[0]['nauthamount']:"0.00"; ?></td>
        </tr>
        
        <tr>
            <td>EBT Cash</td>
            <td class="text-right"><?php echo $ebt_cash = isset($report_sub_totals[0]['EBT_Cash_Payments']) ? $report_sub_totals[0]['EBT_Cash_Payments']:"0.00"; ?></td>
        </tr>
        
        <tr>
            <td>EBT</td>
            <td class="text-right"><?php echo $ebt = isset($report_card_ebt[0]['nauthamount']) ? $report_card_ebt[0]['nauthamount']:"0.00"; ?></td>
        </tr>
            
            
        <tr>
            <td>Credit Card Total</td>
            <td class="text-right"><?php echo $mc+$vi+$di+$am+$ebt_cash+$ebt; ?></td>
        </tr>
        
        
        <tr>
            <td>Start Cash</td>
            <td class="text-right"><?php echo $start_cash = isset($start_cash[0]['start_cash']) ? $start_cash[0]['start_cash']:"0.00"; ?></td>
        </tr>

   
        <tr>
            <td>Drawer Total With Start Cash Amount</td>
            <td class="text-right"><?php echo $drawer_total = ($cash + $start_cash + $lotto_sales + $other_liability_sales + $house_charge_payments + $bottle_deposit - $payouts - $house_charged - $bottle_deposit_redeem - $credit_card_total - $check - $coupon); ?></td>
        </tr>
        
        <tr>
            <td>Store Deposit</td>
            <td class="text-right"><?php echo $store_deposit = $drawer_total - $other_liability_sales - $lotto_sales; ?></td>
        </tr>
        
        <tr>
            <td>Liablity Deposit</td>
            <td class="text-right"><?php echo $liability_deposit = $lotto_sales - $otder_liability_sales; ?></td>
        </tr>
        
        <tr>
            <td>Collected Cash</td>
            <td class="text-right"><?php echo $collected_cash = isset($report_total_shift_cash[0]['TotalAmount']) ? $report_total_shift_cash[0]['TotalAmount']:"0.00"; ?></td>
        </tr>

        <tr>
            <td>Over/short Cash</td>
            <td class="text-right"><?php echo $collected_cash - $drawer_total-$start_cash; ?></td>
        </tr>
        
        <tr>
            <td>Discount Total</td>
            <td class="text-right"><?php echo isset($report_sub_totals[0]['Discount_Amount']) ? $report_sub_totals[0]['Discount_Amount']:"0.00"; ?></td>
        </tr>
        
        <tr>
            <td>Void Total</td>
            <td class="text-right"><?php echo isset($report_void_sale_amount[0]['Void_Amount']) ? $report_void_sale_amount[0]['Void_Amount']:"0.00"; ?></td>
        </tr>
        
        <tr>
            <td>Delete Total</td>
            <td class="text-right"><?php echo isset($report_deleted_sales[0]['Deleted_Items_Amount']) ? $report_deleted_sales[0]['Deleted_Items_Amount']:"0.00"; ?></td>
        </tr>               
        
    
    </table>
    </div>
</div>

<div class="row">
    <div class='col-md-12'>
        <table class="table table-bordered table-striped table-hover" >
                        
            <tbody>
                <tr>
                    <td>Transaction Count</td>
                    <td class="text-right"><?php echo $trans_count = isset($report_sales_total[0]['No_of_Sales']) ? $report_sales_total[0]['No_of_Sales']: 0; ?></td>
                </tr>
                
                
                <tr>
                    <td>Number of Sales</td>
                    <td class="text-right"><?php echo $number_of_sales = $trans_count - $report_sales_total[0]['No_of_Void']; ?></td>
                </tr>
                
                <tr>
                    <td>Number of Void Sales</td>
                    <td class="text-right"><?php echo isset($report_sales_total[0]['No_of_Void']) ? $report_sales_total[0]['No_of_Void']: 0; ?></td>                            
                </tr>
                

                
                <tr>
                    <td>Number of Delete</td>
                    <td class="text-right"><?php echo isset($report_deleted_sales[0]['No_of_Trn_Items_Deleted']) ? $report_deleted_sales[0]['No_of_Trn_Items_Deleted']: 0; ?></td> 
                </tr>
                
                                   

                
                <tr>
                    <td>Number of NoSales</td>
                    <td class="text-right"><?php echo isset($report_sales_total[0]['No_Sales']) ? $report_sales_total[0]['No_Sales']: 0; ?></td> 
                </tr>

                                   
                
                <tr>
                    <td>&nbsp;</td>
                    <td class="text-right"><?php echo ""; ?></td>
                </tr>
                
                                    
                
                <tr>
                    <td>Gross Cost</td>
                    <td class="text-right"><?php echo isset($report_liability_sales[0]['Gross_Cost']) ? $report_liability_sales[0]['Gross_Cost']: 0.00; ?></td>
                </tr>
                
                    
                
                <tr>
                    <td>Gross Profit</td>
                    <td class="text-right"><?php echo $profit = $total_sales - $report_liability_sales[0]['Gross_Cost']; ?></td>
                </tr>

                    
                
                <tr>
                    <td>Gross Profit (%)</td>
                    <td class="text-right"><?php $profit_percent = (($profit / $total_sales)*100); echo number_format((float)$profit_percent, 2, '.', ''); ?></td>
                </tr>

                    
                
                <tr>
                    <td>Average Sales</td>
                    <td class="text-right"><?php $avg_sales = $trans_count != 0? ($total_sales/$trans_count): 0.00; echo number_format((float)$avg_sales, 2, '.', ''); ?></td>
                </tr>

                    
                
                <tr>
                    <td>Returns</td>
                    <td class="text-right"><?php echo isset($report_liability_sales[0]['Return_Amount']) ? number_format((float)$report_liability_sales[0]['Return_Amount'], 2, '.', ''):"0.00"; ?></td>
                </tr>

                
                
                <tr>
                    <td>&nbsp;</td>
                    <td class="text-right"><?php echo ""; ?></td>
                </tr>

                    
                
                <tr>
                    <td><b></b>Hourly Sales</b></td>
                    <td class="text-right"><b>Amount</b></td>
                </tr>


                <?php foreach($report_hourly as $r) { ?>
                    
                    <tr>
                        <td><?php echo isset($r['Hours']) ? $r['Hours']: 0; ?></td>
                        <td class='text-right'><?php echo isset($r['Amount']) ? $r['Amount']: 0; ?></td>
                    </tr>
                
                
                <?php } ?>
            </tbody>
    </table>        
    </div>
</div>



<!=============================== DEPARTMENT SUMMARY =================================================->



<div class='row'>
    
    <div class='col-md-12'>

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
        
</div>


<!=============================== VENDOR SUMMARY =================================================->



<div class='row'>
        
    <div class='col-md-12'>
        
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
    
    

    
	
	
            
             

                    
                
	

	




<style type="text/css">
  
  
  .table {            
        page-break-after: always;
/*        page-break-inside: avoid;*/
        /*break-inside: avoid;*/
    }
 
 tr{border:1pt solid;}


</style>
 