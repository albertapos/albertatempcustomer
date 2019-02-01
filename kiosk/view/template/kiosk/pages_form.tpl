<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right"> 
        <button type="submit" form="form-page" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i> Save</button> 
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
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-pages" class="form-horizontal">
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-name<?php echo $entry_internalid; ?>"><?php echo $entry_internalid; ?></label>
            <div class="col-sm-10">
              <input type="text" name="InternalTitle" value="<?php echo isset($InternalTitle) ? $InternalTitle : ''; ?>" placeholder="<?php echo $entry_internalid; ?>" id="input-name<?php echo $entry_internalid; ?>" class="form-control" />
              <?php if ($error_internal_title) { ?>
              <div class="text-danger"><?php echo $error_internal_title; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-name<?php echo $entry_displaytitle; ?>"><?php echo $entry_displaytitle; ?></label>
            <div class="col-sm-10">
              <input type="text" name="DisplayTitle" value="<?php echo isset($DisplayTitle) ? $DisplayTitle : ''; ?>" placeholder="<?php echo $entry_displaytitle; ?>" id="input-name<?php echo $entry_displaytitle; ?>" class="form-control" />
              <?php if ($error_display_title) { ?>
              <div class="text-danger"><?php echo $error_display_title; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-name<?php echo $entry_rowsize; ?>"><?php echo $entry_rowsize; ?></label>
            <div class="col-sm-10">
              <input type="text" name="RowSize" value="<?php echo isset($RowSize) ? $RowSize : ''; ?>" placeholder="<?php echo $entry_rowsize; ?>" id="RowSize" class="form-control" />
            </div>
          </div>
          <div class="form-group ">
            <label class="col-sm-2 control-label" for="input-name<?php echo $entry_columnsize; ?>"><?php echo $entry_columnsize; ?></label>
            <div class="col-sm-10">
              <input type="text" name="ColumnSize" value="<?php echo isset($ColumnSize) ? $ColumnSize : ''; ?>" placeholder="<?php echo $entry_columnsize; ?>" id="ColumnSize" class="form-control" />
            </div>
          </div>
          <div class="form-group" align="center"> <a  id="boxes" data-toggle="tooltip" title="Genrate Boxes" class="btn btn-primary">Genrate Pages</a> </div>
        
        <div class="form-group" id="showboxes"><div class="table-responsive">
                <table id="pages" class="table table-striped table-bordered table-hover">
                  <thead>
                    <tr>
                      <td class="text-left">Image</td>
                      <td class="text-left">Name</td>
                      <td class="text-left">More/Less Action</td>
                      <td class="text-left">Real Item</td>
                      <td class="text-left">Price</td>
                      <td></td>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $pages_row = 1; ?>
                    <?php foreach ($pages as $page) { ?>
                    <tr id="pages-row<?php echo $pages_row; ?>">
                      <td><?php if ($page['itemimage']) { ?><img src="data:image/jpeg; base64,<?php echo $page['itemimage']; ?>" class="img-thumbnail" height="100" width="100" />
                    <?php } else { ?>
                    <span class="img-thumbnail list"><i class="fa fa-camera fa-2x"></i></span>
                    <?php } ?>
					 <input type="hidden" name="pages[<?php echo $pages_row; ?>][PageDetailId]" value="<?php echo $page['PageDetailId']; ?>" />
                    <input type="hidden" name="pages[<?php echo $pages_row; ?>][DisplaySeq]" value="<?php echo $pages_row; ?>" /></td>
                      <td class="text-left"><select name="pages[<?php echo $pages_row; ?>][iitemid]" class="form-control">
                          <option value="">-- Select Item --</option>
                          <?php foreach ($items as $item) { ?>
                          <?php if ($item['iitemid'] == $page['iitemid']) { ?>
                          <option value="<?php echo $item['iitemid']; ?>" selected="selected"><?php echo $item['vitemname']; ?></option>
                          <?php } else { ?>
                          <option value="<?php echo $item['iitemid']; ?>"><?php echo $item['vitemname']; ?></option>
                          <?php } ?>
                          <?php }?>
                        </select></td>
                      <td class="text-left">
                      <select name="pages[<?php echo $pages_row; ?>][MoreLessAction]" class="form-control">
                          <option value="No" <?php if ($page['MoreLessAction']=='No') { ?> selected="selected" <?php } ?>>No</option>
                          <option value="Yes" <?php if ($page['MoreLessAction']=='Yes') { ?> selected="selected" <?php } ?> >Yes</option>                          
                      </select>
                    <td class="text-left"><select name="pages[<?php echo $pages_row; ?>][RealItem]" class="form-control">
                          <option value="Yes" <?php if ($page['RealItem']=='Yes') { ?> selected="selected" <?php } ?> >Yes</option>
                          <option value="No" <?php if ($page['RealItem']=='No') { ?> selected="selected" <?php } ?>>No</option>
                      </select></td>
                    <td class="text-left"><input type="text" name="pages[<?php echo $pages_row; ?>][Price]" value="<?php echo $page['Price']; ?>" placeholder="Price" class="form-control" /></td>
                    <td class="text-left"><button type="button" onclick="$('#pages-row<?php echo $pages_row; ?>').remove();" data-toggle="tooltip" title="Remove" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
                    </tr>
                    <?php $pages_row++; ?>
                    <?php } ?>
                  </tbody>                  
                </table>
              </div></div> <!-- show boxes end -->
              
      </form>
      </div>
    </div>
  </div>
 
 <script type="text/javascript"><!--
var pages_row = <?php echo $pages_row; ?>;

///alert(parseInt(pages_row));

function addPages() {
	
	var rows = ($("#RowSize").val()  * $("#ColumnSize").val());
	//alert(pages_row);
	if(rows<1)
	{
		alert("Please Add Row Size and Colummn Size!");	
		return false;
	}
	else if(pages_row>rows)
	{
		alert("Maximum "+rows+" Pages Allowed!");	
		return false;
	}
	html = '';
	
	//for(i=< ?php echo $pages_row; ?>;i<=rows;i++)
	//{
		//var pages_row = i;
		
		html += '<tr id="pages-row' + pages_row + '">';
		
			html += '  <td class="text-left"><img src="data:image/jpeg; base64, <?php echo $placeholder; ?>" alt="" height="100" width="100" /><input type="hidden" name="pages[' + pages_row + '][DisplaySeq]" value="' + pages_row + '" /></td>';
		
		html += '  <td class="text-left"><select name="pages[' + pages_row + '][iitemid]" class="form-control">';
		html += '    <option value="">-- Select Item --</option>';
		<?php foreach ($items as $item) { ?>
		html += '    <option value="<?php echo $item["iitemid"]; ?>"><?php echo addslashes($item["vitemname"]); ?></option>';
		<?php } ?>
		html += '  </select></td>';
		html += '  <td class="text-right"><select name="pages[' + pages_row + '][MoreLessAction]" class="form-control">';
		html += '    <option value="No">No</option>';
		html += '    <option value="Yes">Yes</option>';		
		html += '  </select></td>';
		
		html += '  <td class="text-right"><select name="pages[' + pages_row + '][RealItem]" class="form-control">';
		html += '    <option value="Yes">Yes</option>';
		html += '    <option value="No">No</option>';
		html += '  </select></td>';
		
		html += '  <td class="text-left"><input type="text" name="pages[' + pages_row + '][Price]" value="0.00" placeholder="Price" class="form-control" /></td>';
		html += '  <td class="text-left"><button type="button" onclick="$(\'#pages-row' + pages_row + '\').remove();" data-toggle="tooltip" title="Remove" class="btn btn-danger"><i class="fa fa-minus-circle"></i> Delete Row</button></td>';
		html += '</tr>';
	//}
	$('#pages tbody').append(html);

	pages_row++;
}

$('#boxes').click(function() {
	
	var rows = ($("#RowSize").val()  * $("#ColumnSize").val());
	
	if(rows<1)
	{
		alert("Please Add Row Size and Colummn Size!");	
		return false;
	}
	else
	{
		for(i=pages_row;i<=rows;i++)
		{
			addPages();	
		}	
	}
	

});
//--></script>
 
  <script type="text/javascript"><!--
 
$('#boxesdd').click(function() {
	var data = $('#form-pages').serialize();
	$.ajax({
		url: '<?php echo str_replace("&amp;","&",$action); ?>',
		type: 'POST',
		//url: 'index.php?route=kiosk/pages/addboxes&token=<?php echo $token; ?>',
		dataType: 'html',
		data: data,
		success: function(data) {
			var json = jQuery.parseJSON(data);
			var rows=json.Rows;
			var columns=json.Columns;
			var warning=json.warning;
			//var InternalTitle=json.InternalTitle;
			//var DisplayTitle=json.DisplayTitle;
			
			if(warning)
			{
				alert(warning);
			}else{
			
				var html='';
				var seqno=1;
				html += '<form action="#" method="post" enctype="multipart/form-data" id="form-pages" class="form-horizontal"><div class="container">';
				for(i=1;i<=rows;i++)
				{
					html += '<div class="row">';
					
						
					html += '<div class="col-sm-4 col-md-4" align="center"><div class="thumbnail">';
	
						html += '<div class="caption">';
                      html += '<h3 id="itemname">Item Name label</h3><p id="diplay">Display Seq - 0</p><p id="moreless">More/Less - Yes</p><p id="realitem"> Real Item - No</p><p id="price">Price - 0.00</p>';
					  
                      html += '<p><a href="#" class="btn btn-primary" role="button" data-toggle="modal" data-target="#myModal'+seqno+'">Select Item</a> </p>';
                        
                       html += '<div id="myModal" class="modal fade" role="dialog"><div class="modal-dialog"><div class="modal-content"><div class="modal-header modal-header-primary"><button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title">Select Item</h4></div>';
					   html += '';
					   html += '';
					   html += '';
					   html += '<div class="modal-footer"> <a  id="boxes" data-toggle="tooltip" title="Save" class="btn btn-primary">Save</a><button type="button" class="btn btn-default" data-dismiss="modal">Close</button></div></div></div></div>';
											
						html += '</div>';
						html += '</div></div>';
						
						seqno ++;	
				}
			}
			
			html += '</div></form>';
			
			$("#showboxes").html(html);
		}
	});
	
	//alert('sa');
	return false;
});

$(function() {
    function reposition() {
        var modal = $(this),
            dialog = modal.find('.modal-dialog');
        modal.css('display', 'block');
        
        // Dividing by two centers the modal exactly, but dividing by three 
        // or four works better for larger screens.
        dialog.css("margin-top", Math.max(0, ($(window).height() - dialog.height()) / 2));
    }
    // Reposition when a modal is shown
    $('.modal').on('show.bs.modal', reposition);
    // Reposition when the window is resized
    $(window).on('resize', function() {
        $('.modal:visible').each(reposition);
    });
});

//--></script> 
</div>
<?php echo $footer; ?>