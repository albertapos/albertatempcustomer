<?php
class ControllerAdministrationEndOfDayReport extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('administration/end_of_day_report');

		$this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('administration/end_of_day_report');
		$this->load->model('api/end_of_day_report');

		$this->getList();
	}

    public function csv_export() {

        ini_set('max_execution_time', 0);
        ini_set("memory_limit", "2G");

        /*$report_hourly_sales = $this->session->data['report_hourly_sales'];
        $report_categories = $this->session->data['report_categories'];
        $report_departments = $this->session->data['report_departments'];
        $report_shifts = $this->session->data['report_shifts'];
        $report_tenders = $this->session->data['report_tenders'];*/
        
        
        $report_sub_totals = $this->session->data['report_sub_totals'];
            
        $report_liability_sales = $this->session->data['report_liability_sales'];
            
        $report_deleted_sales = $this->session->data['report_deleted_sales'];
    
        $report_void_sale_amount = $this->session->data['report_void_sale_amount'];
            
        $report_house_charge = $this->session->data['report_house_charge'];
            
        $report_department_summary = $this->session->data['report_department_summary'];
            
        $report_sales_total = $this->session->data['report_sales_total'];
            
        $report_hourly = $this->session->data['report_hourly'];
            
        $report_paid_out = $this->session->data['report_paid_out'];
            
        $report_total_shift_cash = $this->session->data['report_total_shift_cash'];
        
        $report_card_amex = $this->session->data['report_card_amex'];
    
        $report_card_master = $this->session->data['report_card_master'];
    
        $report_card_visa = $this->session->data['report_card_visa'];
    
        $report_card_discover = $this->session->data['report_card_discover'];
    
        $report_card_ebt = $this->session->data['report_card_ebt'];
    
        $start_cash = $this->session->data['start_cash'];

        $data_row = '';
        
        $data_row .= "Store Name: ".$this->session->data['storename'].PHP_EOL;
        $data_row .= "Store Address: ".$this->session->data['storeaddress'].PHP_EOL;
        $data_row .= "Store Phone: ".$this->session->data['storephone'].PHP_EOL;

        /*if(isset($report_shifts[0]['NOPENINGBALANCE'])){
            $data_row .= 'Opening Balance,'. $report_shifts[0]['NOPENINGBALANCE'] .PHP_EOL;
        }else{
            $data_row .= 'Opening Balance,0'.PHP_EOL;
        }

        if(isset($report_shifts[0]['CASHONDRAWER'])){
            $data_row .= 'Cash on Drawer,'. $report_shifts[0]['CASHONDRAWER'] .PHP_EOL;
        }else{
            $data_row .= 'Cash on Drawer,0'.PHP_EOL;
        }

        if(isset($report_shifts[0]['userclosingbalance'])){
            $data_row .= 'User Closing Balance,'.$report_shifts[0]['userclosingbalance'] .PHP_EOL;
        }else{
            $data_row .= 'User Closing Balance,0'.PHP_EOL;
        }
        
        if(isset($report_shifts[0]['CashShort'])){
            $data_row .= 'Cash Short/Over,'. $report_shifts[0]['CashShort'] .PHP_EOL;
        }else{
            $data_row .= 'Cash Short/Over,0'.PHP_EOL;
        }
        
        if(isset($report_shifts[0]['Nebtsales'])){
            $data_row .= 'Sales,'. $report_shifts[0]['Nebtsales'] .PHP_EOL;
        }else{
            $data_row .= 'Sales,0' .PHP_EOL;
        }

        if(isset($report_shifts[0]['naddcash'])){
            $data_row .= 'Cash Added,'. $report_shifts[0]['naddcash'] .PHP_EOL;
        }else{
            $data_row .= 'Cash Added,0'.PHP_EOL;
        }

        if(isset($report_shifts[0]['NSUBTOTAL'])){
            $data_row .= 'SubTotal,'. $report_shifts[0]['NSUBTOTAL'] .PHP_EOL;
        }else{
            $data_row .= 'SubTotal,0'.PHP_EOL;
        }

        if(isset($report_shifts[0]['NCLOSINGBALANCE'])){
            $data_row .= 'Closing Balance,'. $report_shifts[0]['NCLOSINGBALANCE'] .PHP_EOL;
        }else{
            $data_row .= 'Closing Balance,0'.PHP_EOL;
        }

        if(isset($report_shifts[0]['NTAXTOTAL'])){
            $data_row .= 'Total Tax,'. $report_shifts[0]['NTAXTOTAL'] .PHP_EOL;
        }else{
            $data_row .= 'Total Tax,0'.PHP_EOL;
        }

        if(isset($report_shifts[0]['ntaxable'])){
            $data_row .= 'Taxable Sales,'. $report_shifts[0]['ntaxable'] .PHP_EOL;
        }else{
            $data_row .= 'Taxable Sales,0'.PHP_EOL;
        }

        if(isset($report_shifts[0]['nnontaxabletotal'])){
            $data_row .= 'Nontaxable Sales,'. $report_shifts[0]['nnontaxabletotal'] .PHP_EOL;
        }else{
            $data_row .= 'Nontaxable Sales,0'.PHP_EOL;
        }

        if(isset($report_shifts[0]['ndiscountamt'])){
            $data_row .= 'Discount,'. $report_shifts[0]['ndiscountamt'] .PHP_EOL;
        }else{
            $data_row .= 'Discount,0'.PHP_EOL;
        }

        if(isset($report_shifts[0]['ntotalsalediscount'])){
            $data_row .= 'Sale Discount,'. $report_shifts[0]['ntotalsalediscount'] .PHP_EOL;
        }else{
            $data_row .= 'Sale Discount,0'.PHP_EOL;
        }

        if(isset($report_shifts[0]['ntotalsaleswtax'])){
            $data_row .= 'Total Sales (Without Tax),'. $report_shifts[0]['ntotalsaleswtax'] .PHP_EOL;
        }else{
            $data_row .= 'Total Sales (Without Tax),0'.PHP_EOL;   
        }
        
        if(isset($report_shifts[0]['noncredittotal'])){
            $data_row .= 'Total Credit Amt,'. $report_shifts[0]['noncredittotal'] .PHP_EOL;
        }else{
            $data_row .= 'Total Credit Amt,0'.PHP_EOL;
        }

        $data_row .= 'Sales by Category'.PHP_EOL;

        if(isset($report_categories) && count($report_categories) > 0){
            foreach($report_categories as $report_category){
                $data_row .= str_replace(',',' ',$report_category['vcategoryame']).','.$report_category['namount'].''.PHP_EOL;
            }
        }else{
            $data_row .= 'Sorry no data found!'.PHP_EOL;
        }

        $data_row .= 'Sales by Department'.PHP_EOL;

        if(isset($report_departments) && count($report_departments) > 0){
            foreach($report_departments as $report_department){
                $data_row .= str_replace(',',' ',$report_department['vdepatname']).','.$report_department['namount'].''.PHP_EOL;
            }
        }else{
            $data_row .= 'Sorry no data found!'.PHP_EOL;
        }*/
        
        
        $data_row .= PHP_EOL;
        $data_row .= "Store Sales with Tax (excluding Liability Sales): ";
        
        if(isset($report_sub_totals[0]['Sales_With_Tax']) && isset($report_liability_sales[0]['Liability_Amount'])){
            $data_row .= $report_sub_totals[0]['Sales_With_Tax']-$report_liability_sales[0]['Liability_Amount'];
        } else {
            $data_row .= "0.00";
        }
        

        $data_row .= PHP_EOL."Liablity Sales: ";
        
        if(isset($report_liability_sales[0]['Liability_Amount'])){
            $data_row .= $report_liability_sales[0]['Liability_Amount'];
        } else {
            $data_row .= "0.00";
        }
        
        $data_row .= PHP_EOL."Fuel Sales: 0.00";
        
        $data_row .= PHP_EOL."Total Sales: ";
        
        $total_sales = $report_sub_totals[0]['Sales_With_Tax'];
        
        $data_row .= $total_sales;
        
        $data_row .= PHP_EOL.PHP_EOL;
                        
        $data_row .=  "Taxable Sales: ";
        if (isset($report_sub_totals[0]['Taxable_Total'])) {
            $data_row .= $report_sub_totals[0]['Taxable_Total'];
        } else {
            $data_row .= "0.00";
        }
        
        $data_row .= PHP_EOL."Non-Taxable Sales: ";
        if (isset($report_sub_totals[0]['Non_Taxable_Sales'])){
            $data_row .= $report_sub_totals[0]['Non_Taxable_Sales'];
        } else {
            $data_row .= "0.00";
        }
        
        $data_row .= PHP_EOL."Total Store Sales: ".($report_sub_totals[0]['Taxable_Total'] + $report_sub_totals[0]['Non_Taxable_Sales']);
        
        $data_row .= PHP_EOL.PHP_EOL;
        
        $data_row .= "Tax1";
        $tax1 = isset($report_liability_sales[0]['Tax1_Total']) ? number_format((float)$report_liability_sales[0]['Tax1_Total'], 2, '.', ''):"0.00";
        $data_row .= $tax1;
        
        $data_row .= PHP_EOL."Tax2: ";
        $tax2 = isset($report_liability_sales[0]['Tax2_Total']) ? number_format((float)$report_liability_sales[0]['Tax2_Total'], 2, '.', '') :"0.00";
        $data_row .= $tax2;

        $data_row .= PHP_EOL."Total Sales Tax :";
        $data_row .= $tax1 + $tax2;
        
        $data_row .= PHP_EOL.PHP_EOL;
        
        $data_row .= PHP_EOL."Lottery Sales: ";
        if(isset($report_liability_sales[0]['Lot_Sales'])) {
            $data_row .= $report_liability_sales[0]['Lot_Sales'];
        } else {
            $data_row .= "0.00"; 
        }
            
        $data_row .= PHP_EOL."Instant Sales: ";
        if(isset($report_liability_sales[0]['Inst_Sales'])) {
            $data_row .= $report_liability_sales[0]['Inst_Sales'];
        } else {
            $data_row .= "0.00";
        }
        
        $data_row .= PHP_EOL."Lottery Redeem: ";
        if(isset($report_liability_sales[0]['Lot_Redeem'])) {
            $data_row .= $report_liability_sales[0]['Lot_Redeem'];
        } else {
            $data_row .= "0.00";
        }
        
        $data_row .= PHP_EOL."Instant Redeem";
        if(isset($report_liability_sales[0]['Inst_Redeem'])){
            $data_row .= $report_liability_sales[0]['Inst_Redeem'];
        } else {
            $data_row .= "0.00";
        }
        
        $data_row .= PHP_EOL."Lotto Sales: ";
        $lotto_sales = ($report_liability_sales[0]['Lot_Sales']+$report_liability_sales[0]['Inst_Sales']+$report_liability_sales[0]['Lot_Redeem']+$report_liability_sales[0]['Inst_Redeem']); 
        $data_row .=  number_format((float)$lotto_sales, 2, '.', '');
        
        $data_row .= PHP_EOL."Other Liability sales: ";
        $other_liability_sales = ($report_liability_sales[0]['Liability_Amount'] - $lotto_sales); 
        $data_row .= number_format((float)$other_liability_sales, 2, '.', '');
        
        $data_row .= PHP_EOL.PHP_EOL;
        
        $data_row .= PHP_EOL."House Charged: ";
        if(isset($report_sub_totals[0]['House_Charged'])){
            $house_charged =  $report_sub_totals[0]['House_Charged'];
        } else {
            $house_charged = "0.00";
        }
        $data_row .= $house_charged;
        
        $data_row .= PHP_EOL."House Charge Payments: ";
        if(isset($report_house_charge[0]['housecharge_payments'])){
            $data_row .= $report_house_charge[0]['housecharge_payments'];
        } else {
            $data_row .= "0.00";
        }
                            
        $data_row .= PHP_EOL."Bottle Deposit: ";
        if(isset($report_liability_sales[0]['Bottle_Deposit'])){
            $data_row .= $report_liability_sales[0]['Bottle_Deposit'];
        } else {
            $data_row .= "0.00";
        }


        $data_row .= PHP_EOL."Bottle Deposit Redeem: ";
        if(isset($report_liability_sales[0]['Bottle_Deposit_Redeem'])){
            $bottle_deposit_redeem = $report_liability_sales[0]['Bottle_Deposit_Redeem'];
        } else {
            $bottle_deposit_redeem = "0.00";
        }
        $data_row .= $bottle_deposit_redeem;

        
        $data_row .= PHP_EOL."Payouts Total: ";
        $paid_out_index = count($report_paid_out) - 1;
        if(isset($report_paid_out[$paid_out_index]['Amount'])){
            $payouts = $report_paid_out[$paid_out_index]['Amount'];
        } else {
            $payouts = "0.00";
        }
        
        $data_row .= PHP_EOL.PHP_EOL;

        $data_row .= "Cash: ";
        $cash .= $report_sub_totals[0]['Sales_With_Tax'] - $report_sub_totals[0]['Credit_Card_Payments'];
        $data_row .= $cash;
        /*if(){
            
        } else {
            
        }*/

        $data_row .= "Coupon: ";
        $coupon = isset($report_liability_sales[0]['Coupon_Redeem']) ? $report_liability_sales[0]['Coupon_Redeem']:"0.00";
        $data_row .= $coupon.PHP_EOL;
        
        $data_row .= "Check";
        $check = isset($report_sub_totals[0]['Check_Payments']) ? $report_sub_totals[0]['Check_Payments']:"0.00";
        $data_row .= $check.PHP_EOL;
                        
        $data_row .= "Discount";
        $discount = isset($report_sub_totals[0]['Discount_Amount']) ? $report_sub_totals[0]['Discount_Amount']:"0.00";
        $data_row .= $discount.PHP_EOL;
        
        $data_row .= "Discount";
        $discount = isset($report_sub_totals[0]['Discount_Amount']) ? $report_sub_totals[0]['Discount_Amount']:"0.00";
        $data_row .= $discount.PHP_EOL;

        $data_row .= "Master Card";
        $mc = isset($report_card_master[0]['nauthamount']) ? $report_card_master[0]['nauthamount']:"0.00";
        $data_row .= $mc.PHP_EOL;

        $data_row .= "Visa";
        $vi = isset($report_card_visa[0]['nauthamount']) ? $report_card_visa[0]['nauthamount']:"0.00";
        $data_row .= $vi.PHP_EOL;

        $data_row .= "DISCOVER";
        $di = isset($report_card_discover[0]['nauthamount']) ? $report_card_discover[0]['nauthamount']:"0.00";
        $data_row .= $di.PHP_EOL;

        $data_row .= "Amex";
        $am = isset($report_card_amex[0]['nauthamount']) ? $report_card_amex[0]['nauthamount']:"0.00";
        $data_row .= $am.PHP_EOL;

        $data_row .= "EBT Cash";
        $ebt_cash = isset($report_sub_totals[0]['EBT_Cash_Payments']) ? $report_sub_totals[0]['EBT_Cash_Payments']:"0.00";
        $data_row .= $ebt_cash.PHP_EOL;

        $data_row .= "EBT";
        $ebt = isset($report_card_ebt[0]['nauthamount']) ? $report_card_ebt[0]['nauthamount']:"0.00";
        $data_row .= $ebt.PHP_EOL;

        $data_row .= "Credit Card Total";
        $credit_card_total = $mc+$vi+$di+$am+$ebt_cash+$ebt;
        $data_row .= $credit_card_total.PHP_EOL;        

        $data_row .= "Start Cash";
        $start_cash = isset($start_cash[0]['start_cash']) ? $start_cash[0]['start_cash']:"0.00";
        $data_row .= $start_cash.PHP_EOL;

        $data_row .= "Drawer Total With Start Cash Amount";
        $drawer_total = ($cash + $start_cash + $lotto_sales + $other_liability_sales + $house_charge_payments + $bottle_deposit - $payouts - $house_charged - $bottle_deposit_redeem - $credit_card_total - $check - $coupon);
        $data_row .= $drawer_total.PHP_EOL;

        $data_row .= "Store Deposit";
        $store_deposit = $drawer_total - $other_liability_sales - $lotto_sales;
        $data_row .= $store_deposit.PHP_EOL;

        $data_row .= "Liablity Deposit";
        $liability_deposit = $lotto_sales - $other_liability_sales;
        $data_row .= $liability_deposit.PHP_EOL;

        $data_row .= "Collected Cash";
        $collected_cash = isset($report_total_shift_cash[0]['TotalAmount']) ? $report_total_shift_cash[0]['TotalAmount']:"0.00";
        $data_row .= $collected_cash.PHP_EOL;

        $data_row .= "Over/short Cash";
        $collected_cash - $drawer_total-$start_cash;
        $data_row .= $collected_cash.PHP_EOL;

        $data_row .= "Discount Total";
        $discount_total = isset($report_sub_totals[0]['Discount_Amount']) ? $report_sub_totals[0]['Discount_Amount']:"0.00";
        $data_row .= $discount_total.PHP_EOL;

        $data_row .= "Void Total";
        $void_total = isset($report_void_sale_amount[0]['Void_Amount']) ? $report_void_sale_amount[0]['Void_Amount']:"0.00";
        $data_row .= $void_total.PHP_EOL;

        $data_row .= "Delete Total";
        $delete_total = isset($report_deleted_sales[0]['Deleted_Items_Amount']) ? $report_deleted_sales[0]['Deleted_Items_Amount']:"0.00";
        $data_row .= $delete_total.PHP_EOL;
        
        $data_row .= PHP_EOL.PHP_EOL;


        $data_row .= "--------------------------------------------".PHP_EOL;
        $data_row .= "              DEPARTMENT SUMMARY            ".PHP_EOL;
        $data_row .= "--------------------------------------------".PHP_EOL;

        $data_row .= PHP_EOL;

        $data_row .= "Department|Quantity|Price".PHP_EOL;

        foreach ($report_department_summary as $k => $v) {
            $dept = isset($v['Dept']) ? $v['Dept']: "";
            $qty = isset($v['Qty']) ? $v['Qty']: 0;
            $amt = isset($v['Amount']) ? $v['Amount']: 0;

            $data_row .= $dept."|".$qty."|".$amt.PHP_EOL;
        }

        $data_row .= PHP_EOL.PHP_EOL;

        $data_row .= "Transaction Count";
        $trans_count = isset($report_sales_total[0]['No_of_Sales']) ? $report_sales_total[0]['No_of_Sales']: 0;
        $data_row .= $trans_count.PHP_EOL;

        $data_row .= "Number of Sales";
        $number_of_sales = $trans_count - $report_sales_total[0]['No_of_Void'];
        $data_row .= $number_of_sales.PHP_EOL;

        $data_row .= "Number of Void Sales";
        $void_sales = isset($report_sales_total[0]['No_of_Void']) ? $report_sales_total[0]['No_of_Void']: 0;
        $data_row .= $void_sales.PHP_EOL;

        $data_row .= "Number of Delete";
        $number_delete = isset($report_deleted_sales[0]['No_of_Trn_Items_Deleted']) ? $report_deleted_sales[0]['No_of_Trn_Items_Deleted']: 0;
        $data_row .= $number_delete.PHP_EOL;

        $data_row .= "Number of NoSales";
        $number_nosales = isset($report_sales_total[0]['No_Sales']) ? $report_sales_total[0]['No_Sales']: 0;
        $data_row .= $number_nosales.PHP_EOL;

        $data_row .= PHP_EOL.PHP_EOL;

        $data_row .= "Gross Cost: ";
        $gross_cost = isset($report_liability_sales[0]['Gross_Cost']) ? $report_liability_sales[0]['Gross_Cost']: 0.00;
        $data_row .= $gross_cost.PHP_EOL;

        $data_row .= "Gross Profit: ";
        $profit = $total_sales - $report_liability_sales[0]['Gross_Cost'];
        $data_row .= $profit.PHP_EOL;

        $data_row .= "Gross Profit (%): ";
        $profit_percent = (($profit / $total_sales)*100);
        $profit_percent = number_format((float)$profit_percent, 2, '.', '');
        $data_row .= $profit_percent.PHP_EOL;

        $data_row .= "Average Sales: ";
        $avg_sales = $trans_count != 0? ($total_sales/$trans_count): 0.00; 
        $avg_sales = number_format((float)$avg_sales, 2, '.', '');
        //  $avg_sales = $trans_count != 0? ($total_sales/$trans_count): 0.00; echo number_format((float)$avg_sales, 2, '.', ''); 
        $data_row .= $avg_sales.PHP_EOL;

        $data_row .= "Returns: ";
        $returns = isset($report_liability_sales[0]['Return_Amount']) ? number_format((float)$report_liability_sales[0]['Return_Amount'], 2, '.', ''):"0.00";
        $data_row .= $returns.PHP_EOL;

        $data_row .= PHP_EOL.PHP_EOL;

        $data_row .= "--------------------------------------------".PHP_EOL;
        $data_row .= "            HOURLY SALES SUMMARY            ".PHP_EOL;
        $data_row .= "--------------------------------------------".PHP_EOL;

        $data_row .= PHP_EOL;

        $data_row .= "Hourly Sales|Amount".PHP_EOL;

        foreach($report_hourly as $r) {
            $hours = isset($r['Hours']) ? $r['Hours']: 0;
            $amount = isset($r['Amount']) ? $r['Amount']: 0;

            $data_row .= $hours."|".$amount.PHP_EOL;
        }
        
        $data_row .= PHP_EOL.PHP_EOL;

        $data_row .= "--------------------------------------------".PHP_EOL;
        $data_row .= "               VENDOR SUMMARY               ".PHP_EOL;
        $data_row .= "--------------------------------------------".PHP_EOL;

        $data_row .= PHP_EOL;

        $data_row .= "Sl. No.|Vendor Name|Amount".PHP_EOL;

        $count = 0; 
        foreach($report_paid_out as $v){                            
                            
            if($v['vpaidoutname'] == null || $v['vpaidoutname'] == ''){ continue;}
            
            ++$count;
            $vendor_name = isset($v['vpaidoutname']) ? $v['vpaidoutname']: "";
            $amount = isset($v['Amount']) ? $v['Amount']: 0.00;

            $data_row .= $count."|".$vendor_name."|".$amount.PHP_EOL;
        }


        $file_name_csv = 'end-of-day-report.csv';

        $file_path = DIR_TEMPLATE."/administration/end-of-day-report.csv";

        $myfile = fopen( DIR_TEMPLATE."/administration/end-of-day-report.csv", "w");

        fwrite($myfile,$data_row);
        fclose($myfile);

        $content = file_get_contents ($file_path);
        header ('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename='.basename($file_name_csv));
        echo $content;
        exit;
    }


  public function print_page() {

    ini_set('max_execution_time', 0);
    ini_set("memory_limit", "2G");

    /*$data['report_hourly_sales'] = $this->session->data['report_hourly_sales'];
    $data['report_categories'] = $this->session->data['report_categories'];
    $data['report_departments'] = $this->session->data['report_departments'];
    $data['report_shifts'] = $this->session->data['report_shifts'];
    $data['report_tenders'] = $this->session->data['report_tenders'];*/
    
    $data['report_sub_totals']    = $this->session->data['report_sub_totals'];
            
    $data['report_liability_sales'] = $this->session->data['report_liability_sales'];
        
    $data['report_deleted_sales'] = $this->session->data['report_deleted_sales'];

    $data['report_void_sale_amount'] = $this->session->data['report_void_sale_amount'];
        
    $data['report_house_charge'] = $this->session->data['report_house_charge'];
        
    $data['report_department_summary'] = $this->session->data['report_department_summary'];
        
    $data['report_sales_total'] = $this->session->data['report_sales_total'];
        
    $data['report_hourly'] = $this->session->data['report_hourly'];
        
    $data['report_paid_out'] = $this->session->data['report_paid_out'];
        
    $data['report_total_shift_cash'] = $this->session->data['report_total_shift_cash'];
    
    
    
    $data['storename'] = $this->session->data['storename'];
    $data['storeaddress'] = $this->session->data['storeaddress'];
    $data['storephone'] = $this->session->data['storephone'];
    
    if(!empty($this->session->data['p_start_date'])){
        $data['p_start_date'] = $this->session->data['p_start_date'];
    }else{
        $data['p_start_date'] = date("m-d-Y");
    }

    $data['heading_title'] = 'End of Day Report';

    $this->response->setOutput($this->load->view('administration/print_end_of_day_report_page', $data));
  }

  public function pdf_save_page() {
error_reporting(E_ALL);
ini_set("display_errors", 1);
    ini_set('max_execution_time', 0);
    ini_set("memory_limit", "2G");
// 	$this->load->model('api/end_of_day_report');
    /*$data['report_hourly_sales'] = $this->session->data['report_hourly_sales'];
    $data['report_categories'] = $this->session->data['report_categories'];
    $data['report_departments'] = $this->session->data['report_departments'];
    $data['report_shifts'] = $this->session->data['report_shifts'];
    $data['report_tenders'] = $this->session->data['report_tenders'];*/


    $data['report_sub_totals']    = $this->session->data['report_sub_totals'];
            
    $data['report_liability_sales'] = $this->session->data['report_liability_sales'];
        
    $data['report_deleted_sales'] = $this->session->data['report_deleted_sales'];

    $data['report_void_sale_amount'] = $this->session->data['report_void_sale_amount'];
        
    $data['report_house_charge'] = $this->session->data['report_house_charge'];
        
    $data['report_department_summary'] = $this->session->data['report_department_summary'];
        
    $data['report_sales_total'] = $this->session->data['report_sales_total'];
        
    $data['report_hourly'] = $this->session->data['report_hourly'];
        
    $data['report_paid_out'] = $this->session->data['report_paid_out'];
        
    $data['report_total_shift_cash'] = $this->session->data['report_total_shift_cash'];
    
    $data['report_card_amex'] = $this->session->data['report_card_amex'];

    $data['report_card_master'] = $this->session->data['report_card_master'];

    $data['report_card_visa'] = $this->session->data['report_card_visa'];

    $data['report_card_discover'] = $this->session->data['report_card_discover'];

    $data['report_card_ebt'] = $this->session->data['report_card_ebt'];

    $data['start_cash'] = $this->session->data['start_cash'];
    
    
    
    //die($data);
    //exit;
    
    $data['storename'] = $this->session->data['storename'];
    $data['storeaddress'] = $this->session->data['storeaddress'];
    $data['storephone'] = $this->session->data['storephone'];

    if(!empty($this->session->data['p_start_date'])){
        $data['p_start_date'] = $this->session->data['p_start_date'];
    }else{
        $data['p_start_date'] = date("m-d-Y");
    }
    /*$data['report_card_amex'] = $this->model_api_end_of_day_report->getCreditCardReport($data['p_start_date'],"amex");
            $data['report_card_master'] = $this->model_api_end_of_day_report->getCreditCardReport($data['p_start_date'],"mastercard");
            $data['report_card_visa'] = $this->model_api_end_of_day_report->getCreditCardReport($data['p_start_date'],"visa");
            $data['report_card_discover'] = $this->model_api_end_of_day_report->getCreditCardReport($data['p_start_date'],"discover");
            $data['report_card_ebt'] = $this->model_api_end_of_day_report->getCreditCardReport($data['p_start_date'],"EBT");*/
            
    $data['heading_title'] = 'End of Day Report';
//$this->load->view('administration/print_end_of_day_report_page', $data);die();

    $html = $this->load->view('administration/print_end_of_day_report_page', $data);
    
    $this->dompdf->loadHtml($html);

// $paper_orientation = 'landscape';
// $customPaper = array(0,0,950,950);
// $this->dompdf->setPaper($customPaper,$paper_orientation);


    //(Optional) Setup the paper size and orientation
    // $this->dompdf->setPaper('A4', 'landscape');

    // Render the HTML as PDF
    $this->dompdf->render();

    // Output the generated PDF to Browser
    $this->dompdf->stream('End-of-Day-Report.pdf');
  }
	  
	protected function getList() {
 error_reporting(E_ALL); ini_set('display_errors', 1); 
        ini_set('max_execution_time', 0);
        ini_set("memory_limit", "2G");

		$url = '';

        if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
            
            $data['data_set'] = 1;
            
            $data['report_sub_totals'] = $this->model_api_end_of_day_report->getSumTotal($this->request->post['start_date']);
            
            $data['report_liability_sales'] = $this->model_api_end_of_day_report->liabilitySales($this->request->post['start_date']);
            
            $data['report_deleted_sales'] = $this->model_api_end_of_day_report->deletedSales($this->request->post['start_date']);

            $data['report_void_sale_amount'] = $this->model_api_end_of_day_report->voidSaleAmount($this->request->post['start_date']);
            
            $data['report_house_charge'] = $this->model_api_end_of_day_report->houseCharge($this->request->post['start_date']);
            
            $data['report_department_summary'] = $this->model_api_end_of_day_report->deptSummary($this->request->post['start_date']);
            
            $data['report_sales_total'] = $this->model_api_end_of_day_report->salesTotal($this->request->post['start_date']);
            
            $data['report_hourly'] = $this->model_api_end_of_day_report->hourlyReport($this->request->post['start_date']);
            
            $data['report_paid_out'] = $this->model_api_end_of_day_report->paidOut($this->request->post['start_date']);
            
            $data['report_total_shift_cash'] = $this->model_api_end_of_day_report->totalShiftCash($this->request->post['start_date']);

            $data['report_card_amex'] = $this->model_api_end_of_day_report->getCreditCardReport($this->request->post['start_date'],"amex");
            
            $data['report_card_master'] = $this->model_api_end_of_day_report->getCreditCardReport($this->request->post['start_date'],"mastercard");
            
            $data['report_card_visa'] = $this->model_api_end_of_day_report->getCreditCardReport($this->request->post['start_date'],"visa");
            
            $data['report_card_discover'] = $this->model_api_end_of_day_report->getCreditCardReport($this->request->post['start_date'],"discover");
            
            $data['report_card_ebt'] = $this->model_api_end_of_day_report->getCreditCardReport($this->request->post['start_date'],"EBT");

            $data['start_cash'] = $this->model_api_end_of_day_report->getStartCash($this->request->post['start_date']);
            /*$data['report_hourly_sales'] = $this->model_api_end_of_day_report->getHourlySalesReport($this->request->post);

            $data['report_categories'] = $this->model_api_end_of_day_report->getCategoriesReport($this->request->post);

            $data['report_departments'] = $this->model_api_end_of_day_report->getDepartmentsReport($this->request->post);

            $data['report_shifts'] = $this->model_api_end_of_day_report->getShiftsReport($this->request->post);

            $data['report_tenders'] = $this->model_api_end_of_day_report->getTenderReport($this->request->post);*/

            $data['p_start_date'] = $this->request->post['start_date'];
            $this->session->data['p_start_date'] = $data['p_start_date'];
            
        }else{
            
            $today = date("m-d-Y");
            
            $data['report_sub_totals'] = $this->model_api_end_of_day_report->getSumTotal($today);
            
            $data['report_liability_sales'] = $this->model_api_end_of_day_report->liabilitySales($today);
            
            $data['report_deleted_sales'] = $this->model_api_end_of_day_report->deletedSales($today);

            $data['report_void_sale_amount'] = $this->model_api_end_of_day_report->voidSaleAmount($today);
            
            $data['report_house_charge'] = $this->model_api_end_of_day_report->houseCharge($today);
            
            $data['report_department_summary'] = $this->model_api_end_of_day_report->deptSummary($today);
            
            $data['report_sales_total'] = $this->model_api_end_of_day_report->salesTotal($today);
            
            $data['report_hourly'] = $this->model_api_end_of_day_report->hourlyReport($today);
            
            $data['report_paid_out'] = $this->model_api_end_of_day_report->paidOut($today);
            
            $data['report_total_shift_cash'] = $this->model_api_end_of_day_report->totalShiftCash($today);
            
            $data['report_card_amex'] = $this->model_api_end_of_day_report->getCreditCardReport($today,"amex");
            
            $data['report_card_master'] = $this->model_api_end_of_day_report->getCreditCardReport($today,"mastercard");
            
            $data['report_card_visa'] = $this->model_api_end_of_day_report->getCreditCardReport($today,"visa");
            
            $data['report_card_discover'] = $this->model_api_end_of_day_report->getCreditCardReport($today,"discover");
            
            $data['report_card_ebt'] = $this->model_api_end_of_day_report->getCreditCardReport($today,"EBT");
            
            $data['start_cash'] = $this->model_api_end_of_day_report->getStartCash($this->request->post['start_date']);
            
            /*$data['report_hourly_sales'] = $this->model_api_end_of_day_report->getHourlySalesReport();

            $data['report_categories'] = $this->model_api_end_of_day_report->getCategoriesReport();

            $data['report_departments'] = $this->model_api_end_of_day_report->getDepartmentsReport();

            $data['report_shifts'] = $this->model_api_end_of_day_report->getShiftsReport();*/

            // $data['report_paidouts'] = $this->model_api_end_of_day_report->getPaidoutsReport();

            // $data['report_picups'] = $this->model_api_end_of_day_report->getPicupsReport();

            /*$data['report_tenders'] = $this->model_api_end_of_day_report->getTenderReport();*/

        }
        
        
        //dd($data);

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('administration/end_of_day_report', 'token=' . $this->session->data['token'] . $url, true)
		);

        $data['reportdata'] = $this->url->link('administration/end_of_day_report/reportdata', 'token=' . $this->session->data['token'] . $url, true);
        $data['print_page'] = $this->url->link('administration/end_of_day_report/print_page', 'token=' . $this->session->data['token'] . $url, true);
        $data['pdf_save_page'] = $this->url->link('administration/end_of_day_report/pdf_save_page', 'token=' . $this->session->data['token'] . $url, true);
        $data['csv_export'] = $this->url->link('administration/end_of_day_report/csv_export', 'token=' . $this->session->data['token'] . $url, true);
		
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');
		
		$data['button_remove'] = $this->language->get('button_remove');
		$data['button_save'] = $this->language->get('button_save');
		$data['button_view'] = $this->language->get('button_view');
		$data['button_add'] = $this->language->get('button_add');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_delete'] = $this->language->get('button_delete');
		$data['button_rebuild'] = $this->language->get('button_rebuild');
		
		$data['token'] = $this->session->data['token'];

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}


 /*       $this->session->data['report_sub_totals'] = $data['report_sub_totals'];
            
        $this->session->data['report_liability_sales'] = $data['report_liability_sales'];
        
        $this->session->data['report_deleted_sales'] = $data['report_deleted_sales'];

        $this->session->data['report_void_sale_amount'] = $data['report_void_sale_amount'];
        
        $this->session->data['report_house_charge'] = $data['report_house_charge'];
        
        $this->session->data['report_department_summary'] = $data['report_department_summary'];
        
        $this->session->data['report_sales_total'] = $data['report_sales_total'];
        
        $this->session->data['report_hourly'] = $data['report_hourly'];
        
        $this->session->data['report_paid_out'] = $data['report_paid_out'];
        
        $this->session->data['report_total_shift_cash'] = $data['report_total_shift_cash'];*/
        
        
        $this->session->data['report_sub_totals'] = $data['report_sub_totals'];
            
        $this->session->data['report_liability_sales'] = $data['report_liability_sales'];
        
        $this->session->data['report_deleted_sales'] = $data['report_deleted_sales'];

        $this->session->data['report_void_sale_amount'] = $data['report_void_sale_amount'];
        
        $this->session->data['report_house_charge'] = $data['report_house_charge'];
        
        $this->session->data['report_department_summary'] = $data['report_department_summary'];
        
        $this->session->data['report_sales_total'] = $data['report_sales_total'];
        
        $this->session->data['report_hourly'] = $data['report_hourly'];
        
        $this->session->data['report_paid_out'] = $data['report_paid_out'];
        
        $this->session->data['report_total_shift_cash'] = $data['report_total_shift_cash'];

        $this->session->data['report_card_amex'] = $data['report_card_amex'];

        $this->session->data['report_card_master'] = $data['report_card_master'];

        $this->session->data['report_card_visa'] = $data['report_card_visa'];

        $this->session->data['report_card_discover'] = $data['report_card_discover'];

        $this->session->data['report_card_ebt'] = $data['report_card_ebt'];

        $this->session->data['start_cash'] = $data['start_cash'];



        /*$this->session->data['report_hourly_sales'] = $data['report_hourly_sales'];
        $this->session->data['report_categories']   = $data['report_categories'];
        $this->session->data['report_departments']  = $data['report_departments'];
        $this->session->data['report_shifts']       = $data['report_shifts'];
        $this->session->data['report_tenders']      = $data['report_tenders'];*/
      
        $data['storename'] = $this->session->data['storename'];
        $data['storeaddress'] = $this->session->data['storeaddress'];
        $data['storephone'] = $this->session->data['storephone'];
        
        //print_r($data); exit;
    
    	$data['header'] = $this->load->controller('common/header');
    	$data['column_left'] = $this->load->controller('common/column_left');
    	$data['footer'] = $this->load->controller('common/footer');
    	
    	$this->response->setOutput($this->load->view('administration/end_of_day_report_list', $data));
	}
	
	protected function validateEditList() {
    	if(!$this->user->hasPermission('modify', 'administration/profit_loss')) {
      		$this->error['warning'] = $this->language->get('error_permission');
    	}
		if (!$this->error) {
	  		return TRUE;
		} else {
	  		return FALSE;
		}
    }

  public function reportdata(){
    $return = array();

    $this->load->model('administration/cash_sales_summary');

    if(!empty($this->request->get['report_by'])){
      if($this->request->get['report_by'] == 1){
        $datas = $this->model_administration_cash_sales_summary->getCategories();
      }elseif($this->request->get['report_by'] == 2){
        $datas = $this->model_administration_cash_sales_summary->getDepartments();
      }

      $return['code'] = 1;
      $return['data'] = $datas;
    }else{
      $return['code'] = 0;
    }
    echo json_encode($return);
    exit;  
  }
  public function get_pdf_day(){echo 1;die();


      
  }
  
  
	
}
