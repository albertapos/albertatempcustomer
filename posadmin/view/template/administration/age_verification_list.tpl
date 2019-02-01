<?php echo $header; ?><?php echo $column_left; ?>

<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right"> <a id="save_button" class="btn btn-primary" title="Save"><i class="fa fa-save"></i>&nbsp;&nbsp;Save</a>
        <button type="button" onclick="addAgeVerification();" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add New</button>        
      </div>
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
    <?php if ($success) { ?>
    <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_list; ?></h3>
      </div>
      <div class="panel-body">
        
        <form action="" method="post" enctype="multipart/form-data" id="form-age-verification">
          <input type="hidden" name="MenuId" value="<?php echo $filter_menuid; ?>"/>
          <div class="">
            <table id="age-verification" class="text-center table table-bordered table-hover" style="width:50%;">
              <thead>
                <tr>
                  <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
                  <td style="" class="text-center"><?php echo $column_description; ?></td>
                  <td class="text-center"><?php echo $column_value; ?></td>
                  <!-- <td class="text-center"><?php echo $column_action; ?></td> -->
                </tr>
              </thead>
              <tbody>
                <?php if ($age_verifications) { ?>
                <?php $age_verification_row = 1;$i=0; ?>
                <?php foreach ($age_verifications as $age_verification) { ?>
                <?php if($age_verification['Id'] == 100){ ?>
                  <tr id="age_verification-row<?php echo $age_verification_row; ?>">
                    <td data-order="<?php echo $age_verification['Id']; ?>" class="text-center">
                    <span style="display:none;"><?php echo $age_verification['Id']; ?></span>
                    <input type="checkbox" name="" id="" value="" />
                    </td>
                    <td class="text-left">
                      <span style="display:none;"><?php echo $age_verification['vname']; ?></span>
                      <?php echo $age_verification['vname']; ?>
                    </td>
                    <td class="text-left">
                      <?php echo $age_verification['vvalue']; ?>
                    </td>
                  </tr>
                <?php }else{ ?>

                <tr id="age_verification-row<?php echo $age_verification_row; ?>">
                  <td class="text-center"><?php if (in_array($age_verification['Id'], $selected)) { ?>
                    <input type="checkbox" name="selected[]" id="age_verification[<?php echo $age_verification_row; ?>][select]" value="<?php echo $age_verification['Id']; ?>" checked="checked" />
                    <?php } else { ?>
                    <input type="checkbox" name="selected[]" id="age_verification[<?php echo $age_verification_row; ?>][select]"  value="<?php echo $age_verification['Id']; ?>" />
                    <?php } ?></td>
                  
                  <td class="text-left">
                  <span style="display:none;"><?php echo $age_verification['vname']; ?></span>
                  <input type="text" class="editable age_verification_c" name="age_verification[<?php echo $i; ?>][vname]" id="age_verification[<?php echo $i; ?>][vname]" value="<?php echo $age_verification['vname']; ?>" onclick='document.getElementById("age_verification[<?php echo $age_verification_row; ?>][select]").setAttribute("checked","checked");' />
        				  <input type="hidden" name="age_verification[<?php echo $i; ?>][Id]" value="<?php echo $age_verification['Id']; ?>"/>
        				  </td>
                  
                    <td class="text-left"><input type="text" class="editable age_verification_s" name="age_verification[<?php echo $i; ?>][vvalue]" id="age_verification[<?php echo $i; ?>][vvalue]" value="<?php echo $age_verification['vvalue']; ?>" onclick='document.getElementById("age_verification[<?php echo $age_verification_row; ?>][select]").setAttribute("checked","checked");' /></td>
                  
                </tr>
                <?php } ?>
                <?php $age_verification_row++; $i++;?>
                <?php } ?>
                <?php } else { ?>
                <?php if($filter_menuid!=""){ ?>
                
                <?php $age_verification_row++;$i++;}else { ?>
                <tr>
                  <td colspan="7" class="text-center"><?php echo $text_no_results;?></td>
                </tr>
                <?php } ?>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </form>
        <!-- <div class="row">
          <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
          <div class="col-sm-6 text-right"><?php echo $results; ?></div>
        </div> -->
      </div>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
$('#button-filter').on('click', function() {
	url = 'index.php?route=administration/age_verification&token=<?php echo $token; ?>';
	
	var filter_menuid = $('select[name=\'MenuId\']').val();
	
	if (filter_menuid) {
		url += '&filter_menuid=' + encodeURIComponent(filter_menuid);
	}
	
	location = url;
});
function filterpage(){
	url = 'index.php?route=administration/age_verification&token=<?php echo $token; ?>';
	
	var filter_menuid = $('select[name=\'MenuId\']').val();
	
	if (filter_menuid) {
		url += '&filter_menuid=' + encodeURIComponent(filter_menuid);
	}
	
	location = url;
}

//--></script> 
<script type="text/javascript"><!--
var age_verification_row = <?php echo $age_verification_row; ?>;

function addAgeVerification() {
	
		html  = '<tr id="age_verification-row' + age_verification_row + '">';

		  html += '  <td class="text-left"><input type="checkbox" name="selected[]" id="age_verification['+ age_verification_row +'][select]"/></td>';
      html += ' <input type="hidden" name="age_verification[' + age_verification_row + '][Id]" value="0"/>';

		 html += '  <td class="text-right"><input type="text" name="age_verification[' + age_verification_row + '][vname]" value="" placeholder="<?php echo $entry_description; ?>" class="form-control age_verification_c" /></td>';

    html += '  <td class="text-right"><input type="text" name="age_verification[' + age_verification_row + '][vvalue]" value="" placeholder="<?php echo $entry_value; ?>" class="form-control age_verification_s" /></td>';
		
		html += '  <td class="text-right">   <button type="button" onclick="$(\'#age_verification-row' + age_verification_row + '\').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-sm btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
		html += '</tr>';
	
		$('#age-verification tbody').append(html);
	
		age_verification_row++;
	
}

//--></script> 

<script type="text/javascript">
  $(document).on('click', '#save_button', function(event) {
    event.preventDefault();

    var edit_url = '<?php echo $edit_list; ?>';
    
    edit_url = edit_url.replace(/&amp;/g, '&');
    
    var all_age_verification = true;
    $('.age_verification_c').each(function(){
      if($(this).val() == ''){
        alert('Please Enter Description');
        all_age_verification = false;
        return false;
      }else{
        all_age_verification = true;
      }
    });

    var numericReg = /^[0-9]*(?:\.\d{1,2})?$/;
    if(all_age_verification == true){
      var all_done = true;
      $('.age_verification_s').each(function(){
        if($(this).val() == ''){
          alert('Please Enter Age');
          all_done = false;
          return false;
        }else{
          if(!numericReg.test($(this).val())){
            alert('Please Enter Valid Age');
            all_done = false;
            return false;
          }else{
            all_done = true;
          }
        }
      });
    }else{
      all_done = false;
    }
    
    if(all_done == true){
      $('#form-age-verification').attr('action', edit_url);
      $('#form-age-verification').submit();
    }
  });
</script>

<!-- DataTables -->
<!-- <script src="view/javascript/dataTables.bootstrap.css"></script> -->
<script src="view/javascript/jquery.dataTables.min.js"></script>
<script src="view/javascript/dataTables.bootstrap.min.js"></script>
<script type="text/javascript">
$('#age-verification').DataTable({
    "paging": true,
    "iDisplayLength": 25,
    "lengthChange": true,
    "searching": true,
    "ordering": true,
    "info": true,
    "autoWidth": true,
    "aaSorting": [[ 0, "desc" ]],
    // 'aoColumnDefs': [{
    //     'bSortable': false,
    //     'aTargets': [4,5,9] /* 1st one, start by the right */
    // }]
    
});

</script>

<style type="text/css">
  #age-verification_filter, #age-verification_paginate{
    float: right;
  }
  #age-verification_filter{
    margin-bottom: 5%;
  }
</style>

<script type="text/javascript">
  $(document).ready(function() {
    $('#age-verification_length').parent().hide();
    $('#age-verification_info').parent().hide();

    $('#age-verification_filter').css('float','left');
    $('#age-verification_paginate').css('float','left');

    $('#age-verification_filter').find('input[type="search"]').css('width','200%');

  });
</script>
<!-- DataTables -->
<?php echo $footer; ?>