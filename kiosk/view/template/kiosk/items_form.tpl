<?php echo $header; ?><?php echo $column_left; ?>

<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-category" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i> Cancel</a></div>
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
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_form; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-category" class="form-horizontal">
          <input type="hidden" name="nlastcost" value="0" />
          <input type="hidden"  name="vbarcode" id="vbarcode" value="<?php echo $vbarcode?>"/>
          <div class="form-group required">
            <label class="col-sm-2 control-label ">Item Name :</label>
            <div class="col-xs-10">
              <input type="text" class="form-control" name="vitemname" value="<?php echo $vitemname ?>">
              <?php if ($error_itemname) { ?>
              <div class="text-danger"><?php echo $error_itemname; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label ">Category</label>
            <div class="col-xs-10">
              <select name="vcategorycode" class="form-control">
                <?php if(isset($cateorys) &&  count($cateorys) > 0) { ?>
                <?php foreach ($cateorys as $cateory) { ?>
                <?php if ($cateory['vcategorycode'] == $vcategorycode) { ?>
                <option value="<?php echo $cateory['vcategorycode']; ?>" selected="selected"><?php echo $cateory['vcategoryname']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $cateory['vcategorycode']; ?>"><?php echo $cateory['vcategoryname']; ?></option>
                <?php } ?>
                <?php } ?>
                <?php } else {?>
                <option value="1">General</option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label ">Department</label>
            <div class="col-xs-10">
              <select name="vdepcode" class="form-control">
                <?php if(isset($departments) &&  count($departments) >0) { ?>
                <?php foreach ($departments as $department) { ?>
                <?php if ($department['vdepcode'] == $vdepcode) { ?>
                <option value="<?php echo $department['vdepcode']; ?>" selected="selected"><?php echo $department['vdepartmentname']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $department['vdepcode']; ?>"><?php echo $department['vdepartmentname']; ?></option>
                <?php } ?>
                <?php } ?>
                <?php } else { ?>
                <option value="1">General</option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label ">Station</label>
            <div class="col-xs-10">
              <select name="stationid" class="form-control">
                <?php foreach ($stations as $station) { ?>
                <?php if ($station['Id'] == $stationid) { ?>
                <option value="<?php echo $station['Id']; ?>" selected="selected"><?php echo $station['stationname']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $station['Id']; ?>"><?php echo $station['stationname']; ?></option>
                <?php } ?>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="form-group">
                <label class="control-label col-sm-2 ">Taxable</label>
                <div class="col-sm-10">
                  <div class="col-sm-1">
                    <input type="hidden" class="form-control" name="vtax1" value="N">
                    <input type="checkbox" class="form-control" name="vtax1" value="Y"  <?php if($vtax1=='Y'){ echo"checked";}?>> Tax 1                    
                    </div>
                  <!--<div class="col-sm-1">
                    <input type="hidden" class="form-control" name="vtax2" value="N">
                    <input type="checkbox" class="form-control" name="vtax2" value="Y" < ?php if($vtax2=='Y'){ echo 'checked';}?>>Tax 2</div>
                </div>-->
              </div>
            </div>
          <div class="form-group">
            <label class="col-md-2 control-label">Images</label>
            <div class="col-sm-10">
            <p style="color:#900; font-weight:bold; font-size:16px;">max file size 600(h) or 600(w) and only .jpeg file allowed</p>
              <input type="file" name="image" id="image" />
              <br />
              <img src="data:image/jpeg; base64, <?php echo $itemimage; ?>" id="desp_image" height="150" width="150" />             
              <?php if(isset($iitemid) && $iitemid!=""){?>
              <input type="hidden" name="image" value="<?php echo $itemimage; ?>" id="input-image" /> 
              <?php }?>
              <?php if ($error_image) { ?>
              <div class="text-danger"><?php echo $error_image; ?></div>
              <?php } ?>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script>
function readURL(input) {

	if (input.files && input.files[0]) {
		var reader = new FileReader();
	
		reader.onload = function (e) {
			$('#desp_image').attr('src', e.target.result);
		}
	
		reader.readAsDataURL(input.files[0]);
	}
}

$("#image").change(function(){
    readURL(this);
});
</script> 
<script><!--
function checksku(val)
{
	$.ajax({
		type: 'post',
		url: 'index.php?route=kiosk/items/validateSKU&token=<?php echo $token; ?>&vbarcode='+val,
		dataType: 'html',		
		success: function (json) {
			
			var data  = $.parseJSON(json);
			
			if(data.msg !='')
			{
				alert(data.msg);
			}
		}
	});
}
--></script> 
<?php echo $footer; ?>