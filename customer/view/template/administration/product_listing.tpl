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
        <div class="clearfix"></div>
        <div class="row">
          <form method="post" id="export_form">
            <div class="col-md-12">
              <input type="button" id="csv_export_btn" name="export" value="Export" class="btn btn-success">
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>


<?php echo $footer; ?>
<link type="text/css" href="view/javascript/bootstrap-datepicker.css" rel="stylesheet" />
<script src="view/javascript/bootstrap-datepicker.js" defer></script>
<script src="view/javascript/jquery.printPage.js"></script>
<script src="view/javascript/bootbox.min.js" defer></script>

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

<script>
  $(function(){
    $("#start_date").datepicker({
      format: 'mm-dd-yyyy',
      todayHighlight: true,
      autoclose: true,
    });

    $("#end_date").datepicker({
      format: 'mm-dd-yyyy',
      todayHighlight: true,
      autoclose: true,
    });
  });
</script>

<script type="text/javascript">
  $(document).ready(function() {
    // $('#report_by').select2({
    //   placeholder: "Please Select Department"
    // });
  });

$(document).on('submit', '#filter_form', function(event) {
  
  if($('#report_by > option:selected').length == 0){
    alert('Please Select Department');
    return false;
  }
  
  if($('#report_by').val() == ''){
    alert('Please Select Department');
    return false;
  }

  if($('#start_date').val() == ''){
    alert('Please Select Start Date');
    return false;
  }

  if($('#end_date').val() == ''){
    alert('Please Select End Date');
    return false;
  }

  $("div#divLoading").addClass('show');
  
});
</script>

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
      
    var check_password_url = '<?php echo $check_password_url; ?>';
    check_password_url = check_password_url.replace(/&amp;/g, '&');
    
    event.preventDefault();
    
    var is_accessible = false;
    bootbox.prompt({
        title: "Please enter password!",
        inputType: 'password',
        callback: function (result) {
            
            $.ajax({
                    url : check_password_url,
                    type : 'POST',
                    data : {'password' : result},
                  }).done(function(password_result){
                    
                    if(password_result == "true")
                    {
                        $("div#divLoading").addClass('show');
                    
                          var csv_export_url = '<?php echo $current_url; ?>';
                        
                          csv_export_url = csv_export_url.replace(/&amp;/g, '&');
                    
                          $.ajax({
                            url : csv_export_url,
                            type : 'POST',
                          }).done(function(response){
                            
                            const data = response,
                            fileName = "product-list.csv";
                    
                            saveData(data, fileName);
                            $("div#divLoading").removeClass('show');
                            
                          });
                    }
                    else
                    {
                        bootbox.alert({ 
                            size: 'small',
                            title: "Attention", 
                            message: "Invalid Password!", 
                            callback: function(){}
                        });
                    }
            });
            
        }
    });
    
    // $("div#divLoading").addClass('show');

    //   var csv_export_url = '<?php echo $current_url; ?>';
    
    //   csv_export_url = csv_export_url.replace(/&amp;/g, '&');

    //   $.ajax({
    //     url : csv_export_url,
    //     type : 'POST',
    //   }).done(function(response){
        
    //     const data = response,
    //     fileName = "product-list.csv";

    //     saveData(data, fileName);
    //     $("div#divLoading").removeClass('show');
        
    //   });
    
  });

</script>