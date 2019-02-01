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
    <?php if ($success) { ?>
    <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading head_title">
        <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_list; ?></h3>
        <div class="top_button">
        </div>
      </div>
      <div class="panel-body">

      <form action="<?php echo $current_url;?>" method="post" id="form_scan_data_search">
        <div class="row">
          <div class="col-md-2">
            <input type="tel" class="form-control" name="management_account_number" maxlength="10" placeholder="Mgmt A/c No./Retail Ctrl No.">
          </div>
          <div class="col-md-2">
           <input type="" class="form-control" name="week_ending_date" value="<?php echo isset($week_ending_date) ? $week_ending_date : ''; ?>" id="week_ending_date" placeholder="Week Ending Date" readonly>
          </div>
          <div class="col-md-3">
            <select name="department_id[]" id="department_id" class="form-control" multiple="true">
              <option value="">-- Please Select Department --</option>
              <?php if(isset($departments) && count($departments) > 0){?>
                <?php foreach($departments as $department){?>
                  <option value="<?php echo $department['vdepcode'];?>"><?php echo $department['vdepartmentname'];?></option>
                <?php } ?>
              <?php } ?>
            </select>
          </div>
          <div class="col-md-2">
            <select name="category_id[]" id="category_id" class="form-control" multiple="true">
              <option value="">-- Please Select Category --</option>
              <?php if(isset($categories) && count($categories) > 0){?>
                <?php foreach($categories as $category){?>
                  <option value="<?php echo $category['vcategorycode'];?>"><?php echo $category['vcategoryname'];?></option>
                <?php } ?>
              <?php } ?>
            </select>
          </div>
          <div class="col-md-2">
              
            <?php $manufacturers = array('1' => 'Phillip Morris(Marlboro)', '2' => 'RJ Reynolds');?>

            <select name="manufacturer" id="manufacturer" style="" class="form-control">
              <option value="">-- Manufacturer --</option>
              
              
                <?php foreach($manufacturers as $key => $value){?>
                  <option value="<?php echo $key;?>"><?php echo $value;?></option>
                <?php } ?>
            </select>
          </div>
          <div class="col-md-1">
            <input type="submit" name="Export" value="Generate" class="btn btn-success">
          </div>
        </div>
      </form>
      </div>
    </div>
  </div>
</div>

<?php echo $footer; ?>

<link type="text/css" href="view/javascript/bootstrap-datepicker.css" rel="stylesheet" />
<script src="view/javascript/bootstrap-datepicker.js" defer></script>
<script src="view/javascript/bootbox.min.js" defer></script>

<script>
  $(function(){
      

    $('#manufacturer').change(function(){
        
        var manufacturer = $(this).val();
        var dateElem = window.$.datepicker._getInst(document.getElementById("week_ending_date"));
        
        if(dateElem){
            $("#week_ending_date").datepicker( "destroy" );
            $("#week_ending_date").val("");
        }
        
        if(manufacturer == 1){
            
            $("#week_ending_date").datepicker({
              format: 'mm-dd-yyyy',
              autoclose: true,
              daysOfWeekDisabled: [0,1,2,3,4,5],
            });
        } 
        
        if(manufacturer == 2){
            $("#week_ending_date").datepicker({
              format: 'mm-dd-yyyy',
              autoclose: true,
              daysOfWeekDisabled: [1,2,3,4,5,6]
            });
        }
    });
    
  });

  $(document).on('submit', 'form#form_scan_data_search', function(event) {
    if($('input[name="management_account_number"]').val() == ''){
        // alert('Please enter management account number Or Retail Control Number!');
        bootbox.alert({ 
          size: 'small',
          title: "Attention", 
          message: "Please enter management account number Or Retail Control Number!", 
          callback: function(){}
        });
        return false;
    }

    if($('#week_ending_date').val() == ''){
        // alert('Please select week ending date!');
        bootbox.alert({ 
          size: 'small',
          title: "Attention", 
          message: "Please select week ending date!", 
          callback: function(){}
        });
        return false;
    }

    if($('#department_id :selected').length == 0 || $('#department_id :selected').val() == ''){
        // alert('Please select department!');
        bootbox.alert({ 
          size: 'small',
          title: "Attention", 
          message: "Please select department!", 
          callback: function(){}
        });
        return false;
    }
    
    if($('#category_id :selected').length == 0 || $('#category_id :selected').val() == ''){
        // alert('Please select department!');
        bootbox.alert({ 
          size: 'small',
          title: "Attention", 
          message: "Please select category!", 
          callback: function(){}
        });
        return false;
    }

    if($('#manufacturer :selected').length == 0 || $('#manufacturer :selected').val() == ''){
        // alert('Please select department!');
        bootbox.alert({ 
          size: 'small',
          title: "Attention", 
          message: "Please select manufacturer!", 
          callback: function(){}
        });
        return false;
    }
    event.preventDefault();

    var ac = $('input[name="management_account_number"]').val();
    var week_e_d = $('#week_ending_date').val();
    var store = '<?php echo $store_name;?>';

    var dateAr = week_e_d.split('-');

    week_e_d = dateAr['2']+''+dateAr['0']+''+dateAr['1'];

    var file_name = store+'_'+ac+'_'+week_e_d;

    $("div#divLoading").addClass('show');

    var csv_export_url = '<?php echo $current_url; ?>';
  
    csv_export_url = csv_export_url.replace(/&amp;/g, '&');

    $.ajax({
      url : csv_export_url,
      data : $('#form_scan_data_search').serialize(),
      type : 'POST',
    }).done(function(response){
      
      const data = response,
      fileName = file_name+".txt";
    //   console.log(response);

      saveData(data, fileName);
      $("div#divLoading").removeClass('show');
      
    });

  });

  $('input[name="management_account_number"]').keypress(function(event) {
      $(this).val($(this).val().replace(/[^\d].+/, ""));
      if ((event.which < 48 || event.which > 57)) {
          event.preventDefault();
      }
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

</script>