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
            <p><b>Date :</b><?php echo isset($p_start_date) ? $p_start_date : date("m-d-Y"); ?></p>
          </div>
          <div class="col-md-6 pull-right">
            <p><b>Store Name: </b><?php echo $storename; ?></p>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <table class="table table-bordered" style="">
              <tr>
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
              </tr>
            </table>
          </div>
          <div class="col-md-6">
            <div class="title_div">
             <b>Tender Detail</b>
            </div>
            <table class="table table-bordered">
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
                  <td><b>There is no data for tender detail !!!</b></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="title_div">
              <b>Hourly Sales</b>
            </div>
            <table class="table table-bordered">
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
                  <td><b>There is no data for Hourly Sales !!!</b></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
          <div class="col-md-6">
            <div class="title_div">
             <b>Sales by Category</b>
            </div>
            <table class="table table-bordered">
              <tbody>
                <?php if(isset($report_categories) && count($report_categories) > 0){ ?>
                  <?php foreach($report_categories as $report_category){ ?>
                  <tr>
                    <td><?php echo $report_category['vcategoryame']; ?></td>
                    <td class="text-right"><?php echo $report_category['namount']; ?></td>
                    <td class="text-right">0</td>
                    <td class="text-right">0</td>
                  </tr>
                  <?php } ?>
                <?php } else { ?>
                <tr>
                  <td><b>There is no data Sales by Category!!!</b></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="title_div">
             <b>Sales by Department</b>
            </div>
            <table class="table table-bordered">
              <tbody>
                <?php if(isset($report_departments) && count($report_departments) > 0){ ?>
                  <?php foreach($report_departments as $report_department){ ?>
                  <tr>
                    <td><?php echo $report_department['vdepatname']; ?></td>
                    <td class="text-right"><?php echo $report_department['namount']; ?></td>
                    <td class="text-right">0</td>
                    <td class="text-right">0</td>
                  </tr>
                  <?php } ?>
                <?php } else { ?>
                <tr>
                  <td><b>There is no data Sales by Department!!!</b></td>
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

<style type="text/css">
  .title_div{
    border: 1px solid #ddd;
    padding: 5px;
  }
</style>