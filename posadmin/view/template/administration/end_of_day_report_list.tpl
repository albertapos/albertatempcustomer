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
        <a href="<?php echo $print_page; ?>" id="btnPrint" class="pull-right"><i class="fa fa-print" aria-hidden="true"></i> Print</a>
        <a href="<?php echo $pdf_save_page; ?>" class="pull-right" style="margin-right:10px;"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF</a>
      </div>
      <div class="panel-body">

      <div class="row">
          <form method="post" id="filter_form">

            <div class="col-md-2">
              <input type="" class="form-control" name="start_date" value="<?php echo isset($p_start_date) ? $p_start_date : ''; ?>" id="start_date" placeholder="Date">
            </div>
            
            <div class="col-md-2">
              <input type="submit" class="btn btn-success" value="Filter">
            </div>
          </form>
        </div>
        <br>
        <div class="row">
          <div class="col-md-12">
            <p><b>Date: </b><?php echo isset($p_start_date) ? $p_start_date : date("m-d-Y"); ?></p>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <table class="table table-bordered table-striped table-hover" style="width:50%;">
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
          <div class="col-md-12">
            <div class="title_div" style="width:50%;background-color: #2486c6;color: #fff;">
             <b>Sales by Category</b>
            </div>
            <table class="table table-bordered" style="width:50%;">
              <tbody>
                <?php if(isset($report_categories) && count($report_categories) > 0){ ?>
                  <?php foreach($report_categories as $report_category){ ?>
                  <tr>
                    <td><?php echo $report_category['vcategoryame']; ?></td>
                    <td class="text-right"><?php echo $report_category['namount']; ?></td>
                    <!-- <td class="text-right">0</td> -->
                    <!-- <td class="text-right">0</td> -->
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
        <div class="row">
          <div class="col-md-12">
            <div class="title_div" style="width:50%;background-color: #2486c6;color: #fff;">
             <b>Sales by Department</b>
            </div>
            <table class="table table-bordered" style="width:50%;">
              <tbody>
                <?php if(isset($report_departments) && count($report_departments) > 0){ ?>
                  <?php foreach($report_departments as $report_department){ ?>
                  <tr>
                    <td><?php echo $report_department['vdepatname']; ?></td>
                    <td class="text-right"><?php echo $report_department['namount']; ?></td>
                    <!-- <td class="text-right">0</td> -->
                    <!-- <td class="text-right">0</td> -->
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

<div id="divLoading"></div>

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
</script>

<style type="text/css">

  #divLoading{
    display : none;
  }
  #divLoading.show{
    display : block;
    position : fixed;
    z-index: 100;
    background-image : url('view/image/loading1.gif');
    background-color:#666;
    opacity : 0.9;
    background-repeat : no-repeat;
    background-position : center;
    left : 0;
    bottom : 0;
    right : 0;
    top : 0;
    background-size: 250px;
  }

  #loadinggif.show{
    left : 50%;
    top : 50%;
    position : absolute;
    z-index : 101;
    width : 32px;
    height : 32px;
    margin-left : -16px;
    margin-top : -16px;
  }

  div.content {
   width : 1000px;
   height : 1000px;
  }

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