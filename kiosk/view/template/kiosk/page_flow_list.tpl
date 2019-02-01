<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right"><a title="Move Page Flow" id="movepgflow" class="btn btn-primary"><i class="fa fa-arrows"></i> Move Page Flow</a>  <a title="<?php echo $button_add; ?>" id="copytoallpages" class="btn btn-primary"><i class="fa fa-copy"></i> Copy Pages To All</a> <a data-toggle="modal" data-target="#newpageflowitems" title="<?php echo $button_add; ?>" class="btn btn-primary" onclick="loadleftitems()"><i class="fa fa-plus"></i> Add Items</a>
       <button type="button" data-toggle="tooltip"  class="btn btn-primary" id="updateitemsequence"><i class="fa fa-save"></i> Save Seq.</button>
       <button type="button" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger" onclick="confirm('<?php echo $text_confirm; ?>') ? $('#form-page').submit() : false;"><i class="fa fa-trash-o"></i> Delete</button>
      </div>
      <h1><?php echo $heading_title; ?></h1>
      <div id="model_pageflow"></div>
      <div id="model_itemimageview"></div>
      <div id="model_movepageflow" class="modal fade" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header modal-header-info">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title" id="cartLabel">Move page flow for <span id="pg_flow_itemname"></span></h4>
            </div>
            <div class="modal-body">
              <form action="" method="post" enctype="multipart/form-data" id="form-model_movepg"  class="form-horizontal">
              <input type="hidden" name="medetailid" id="menudetailid"  />
                <div class="form-group">
                  <label class="col-sm-2 control-label" for="input-name<?php echo $entry_menu; ?>"><?php echo $entry_menu; ?></label>
                  <div class="col-sm-3">
                    <select name="MenuId" id="MenuId" class="form-control">
                      <option value="">-- Select Menu --</option>
                      <?php foreach ($menus as $menu) { ?>
                      <?php if ($menu['MenuId'] == $filter_menuid) { ?>
                      <option value="<?php echo $menu['MenuId']; ?>" selected="selected"><?php echo $menu['Title']; ?></option>
                      <?php } else { ?>
                      <option value="<?php echo $menu['MenuId']; ?>"><?php echo $menu['Title']; ?> </option>
                      <?php } ?>
                      <?php } ?>
                    </select>
                    <?php if ($error_menu) { ?>
                    <div class="text-danger"><?php echo $error_menu; ?></div>
                    <?php } ?>
                  </div>
                  <label class="col-sm-2 control-label" for="input-name<?php echo $entry_category; ?>"><?php echo $entry_category; ?></label>
                  <div class="col-sm-3"> <span id="modelcategory">
                    <select name="CategoryId"  id="CategoryId" class="form-control">
                      <option value="">-- Select Category --</option>
                      <?php foreach ($categorys as $category) { ?>
                      <?php if ($category['CategoryId'] == $filter_categoryid) { ?>
                      <option value="<?php echo $category['CategoryId']; ?>" selected="selected"><?php echo $category['Category']; ?></option>
                      <?php } else { ?>
                      <option value="<?php echo $category['CategoryId']; ?>"><?php echo $category['Category']; ?></option>
                      <?php } ?>
                      <?php }?>
                    </select>
                    </span>
                    <?php if ($error_category) { ?>
                    <div class="text-danger"><?php echo $error_category; ?></div>
                    <?php } ?>
                  </div>
                </div>                
              </form>
            </div>
            <div class="modal-footer">
            
              <button type="button" class="btn btn-primary" data-dismiss="modal" id="movepgflowsave">Save</button>
              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
      
      <div class="modal fade" id="newpageflowitems" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header modal-header-info">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title" id="cartLabel">Add Page Flow Items</h4>
            </div>
            <div class="modal-body">
              <form action="" method="post" enctype="multipart/form-data" id="form-model"  class="form-horizontal">
                <div class="form-group">
                  <label class="col-sm-2 control-label" for="input-name<?php echo $entry_menu; ?>"><?php echo $entry_menu; ?></label>
                  <div class="col-sm-3">
                    <select name="MenuId" id="MenuId" class="form-control">
                      <option value="">-- Select Menu --</option>
                      <?php foreach ($menus as $menu) { ?>
                      <?php if ($menu['MenuId'] == $filter_menuid) { ?>
                      <option value="<?php echo $menu['MenuId']; ?>" selected="selected"><?php echo $menu['Title']; ?></option>
                      <?php } else { ?>
                      <option value="<?php echo $menu['MenuId']; ?>"><?php echo $menu['Title']; ?> </option>
                      <?php } ?>
                      <?php } ?>
                    </select>
                    <?php if ($error_menu) { ?>
                    <div class="text-danger"><?php echo $error_menu; ?></div>
                    <?php } ?>
                  </div>
                  <label class="col-sm-2 control-label" for="input-name<?php echo $entry_category; ?>"><?php echo $entry_category; ?></label>
                  <div class="col-sm-3"> <span id="modelcategory">
                    <select name="CategoryId"  id="CategoryId" class="form-control">
                      <option value="">-- Select Category --</option>
                      <?php foreach ($categorys as $category) { ?>
                      <?php if ($category['CategoryId'] == $filter_categoryid) { ?>
                      <option value="<?php echo $category['CategoryId']; ?>" selected="selected"><?php echo $category['Category']; ?></option>
                      <?php } else { ?>
                      <option value="<?php echo $category['CategoryId']; ?>"><?php echo $category['Category']; ?></option>
                      <?php } ?>
                      <?php }?>
                    </select>
                    </span>
                    <?php if ($error_category) { ?>
                    <div class="text-danger"><?php echo $error_category; ?></div>
                    <?php } ?>
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-sm-5">
                    <div class="table-responsive" >
                    <div><input type="text" name="searchbox" id="searchbox" value="<?php echo $searchbox;?>" class="form-control input-sm" placeholder="Search"/><input type="hidden" name="searchboxid" id="searchboxid"/></div>
                      
                      <div class="div-table-content">
                        <table class="table table-bordered table-hover" id="itemsort1">
                          <tbody>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-2" align="center" style="margin-top:125px;"><div id="loading" style="z-index:100;"><i class="fa fa-refresh fa-5x" aria-hidden="true"></i></div> <a class="btn btn-primary" onclick="addrightitem()"><i class="fa fa-arrow-right fa-3x"></i> </a> <br />
                    <br />
                    <a class="btn btn-primary" onclick="addleftitem()"><i class="fa fa-arrow-left fa-3x"></i></a> </div>
                  <div class="col-sm-5">
                    <div class="table-responsive">
                      <table class="table table-bordered table-hover" style="padding:0px; margin:0px;">
                        <thead>                          
                        <td>Items</td>
                            </thead>
                      </table>
                      <div class="div-table-content">
                        <table class="table table-bordered table-hover" id="itemsort2">
                          <tbody>
                          </tbody>
                        </table>
                      </div>
                    </div>
                    <input type="hidden" name="right_itemsadded" id="right_itemsadded" value="" />
                  </div>
                </div>
              </form>
            </div>
            <div class="modal-footer">
            
              <button type="button" class="btn btn-primary" data-dismiss="modal" id="modelsave">Save</button>
              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
      
      <div class="modal fade" id="editpageflowmodel" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header modal-header-info">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title" id="cartLabel">Edit <?php echo $heading_title; ?></h4>
            </div>
            <div class="modal-body">
              <form action="" method="post" enctype="multipart/form-data" id="modelform-pageedit"  class="form-horizontal">
                <input type="hidden" name="MenuDetailId" id="MenuDetailId" value="" />
                <input type="hidden" name="iitemid" id="iitemid" value="" />
                <div class="form-group">
                  <label class="col-sm-2 control-label" for="input-name<?php echo $entry_menu; ?>"><?php echo $entry_menu; ?></label>
                  <div class="col-sm-3">
                    <select name="MenuId" id="MenuId" class="form-control">
                      <option value="">-- Select Menu --</option>
                      <?php foreach ($menus as $menu) { ?>
                      <?php if ($menu['MenuId'] == $filter_menuid) { ?>
                      <option value="<?php echo $menu['MenuId']; ?>" selected="selected"><?php echo $menu['Title']; ?></option>
                      <?php } else { ?>
                      <option value="<?php echo $menu['MenuId']; ?>"><?php echo $menu['Title']; ?></option>
                      <?php } ?>
                      <?php } ?>
                    </select>
                    <?php if ($error_menu) { ?>
                    <div class="text-danger"><?php echo $error_menu; ?></div>
                    <?php } ?>
                  </div>
                  <label class="col-sm-2 control-label" for="input-name<?php echo $entry_category; ?>"><?php echo $entry_category; ?></label>
                  <div class="col-sm-3"> <span id="modelcategory">
                    <select name="CategoryId"  id="CategoryId" class="form-control" >
                      <option value="">-- Select Category --</option>
                      <?php foreach ($categorys as $category) { ?>
                      <?php if ($category['CategoryId'] == $filter_categoryid) { ?>
                      <option value="<?php echo $category['CategoryId']; ?>" selected="selected"><?php echo $category['Category']; ?></option>
                      <?php } else { ?>
                      <option value="<?php echo $category['CategoryId']; ?>"><?php echo $category['Category']; ?></option>
                      <?php } ?>
                      <?php }?>
                    </select>
                    </span>
                    <?php if ($error_category) { ?>
                    <div class="text-danger"><?php echo $error_category; ?></div>
                    <?php } ?>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label" for="input-name<?php echo $entry_itemname; ?>"><?php echo $entry_itemname; ?></label>
                  <div class="col-sm-3"><span id="modelitemid">
                    <select name="iitemid" id="iitemid" class="form-control">
                      <option value="">-- Select Item --</option>
                      <?php foreach ($items as $item) { ?>
                      <?php if ($item['iitemid'] == $iitemid) { ?>
                      <option value="<?php echo $item['iitemid']; ?>" selected="selected"><?php echo $item['vitemname']; ?></option>
                      <?php } else { ?>
                      <option value="<?php echo $item['iitemid']; ?>"><?php echo $item['vitemname']; ?></option>
                      <?php } ?>
                      <?php }?>
                    </select>
                    </span>
                    <?php if ($error_item) { ?>
                    <div class="text-danger"><?php echo $error_item; ?></div>
                    <?php } ?>
                  </div>
                  <label class="col-sm-2 control-label" for="input-name<?php echo $entry_price; ?>"><?php echo $entry_price; ?></label>
                  <div class="col-sm-3">
                    <input type="text" name="Price" id="Price" value="<?php echo isset($Price) ? $Price : ''; ?>" placeholder="<?php echo $entry_price; ?>"  class="form-control number" />
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-sm-4">
                    <div class="table-responsive" >
                    
                      <table class="table table-bordered table-hover" style="padding:0px; margin:0px;" >
                        <thead>
                          <tr>
                            <td>Pages</td>
                          </tr>
                        </thead>
                      </table>
                      <div><input type="text" name="searchboxpg" id="searchboxpg" class="form-control input-sm" placeholder="Search"/></div>
                      <div class="div-table-content">
                        <table class="table table-bordered table-hover" id="pagesort1">
                          <tbody>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-2" align="center" style="margin-top:125px;"> <a class="btn btn-primary" onclick="addrightpages()"><i class="fa fa-arrow-right fa-3x"></i> </a> <br />
                    <br />
                    <a class="btn btn-primary" onclick="addleftpage()"><i class="fa fa-arrow-left fa-3x"></i>&nbsp;</a> </div>
                  <div class="col-sm-6">
                    <div class="table-responsive">
                      <table class="table table-bordered table-hover" style="padding:0px; margin:0px;">
                        <thead>
                        <td style="width: 214px;">Pages</td>
                          <td style="width: 150px;">Action</td>
                          <td style="width: 110px;">Free Topping Ct</td>
                            </thead>
                      </table>
                      <div class="div-table-content">
                        <table class="table table-bordered table-hover" id="pagesort2">
                          <tbody>
                          </tbody>
                        </table>
                      </div>
                    </div>
                    <input type="hidden" name="right_pagesadded" id="right_pagesadded" value="" />
                  </div>
                </div>
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary" data-dismiss="modal" id="modelupdatepageflow">Save</button>
              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
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
        <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-page">
          <div class="well">
            <div class="row">
              <div class="col-sm-12">
                <div class="form-inline">
                  <label class="control-label" for="input-customer-group">Menu : </label>
                  <select name="filter_menuid" id="filter_menuid" class="form-control">
                    <option value="">-- Select Menu --</option>
                    <?php foreach ($menus as $menu) { ?>
                    <?php if ($menu['MenuId'] == $filter_menuid) { ?>
                    <option value="<?php echo $menu['MenuId']; ?>" selected="selected"><?php echo $menu['Title']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $menu['MenuId']; ?>"><?php echo $menu['Title']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <label class="control-label" for="input-customer-group">Category : </label>
                  <span id="changecat">
                  <select name="filter_categoryid"  id="filter_categoryid" class="form-control" onchange="filterpage()">
                    <option value="">-- Select Category --</option>
                    <?php foreach ($categorys as $category) { ?>
                    <?php if ($category['CategoryId'] == $filter_categoryid) { ?>
                    <option value="<?php echo $category['CategoryId']; ?>" selected="selected"><?php echo $category['Category']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $category['CategoryId']; ?>"><?php echo $category['Category']; ?></option>
                    <?php } ?>
                    <?php }?>
                  </select>
                  </span> </div>
              </div>
            </div><br />
            <div class="row">
            <div class="col-sm-6"><div class="form-inline"><label class="control-label">Search : </label> <input type="text" name="searchbox_flow" id="searchbox_flow" value="" class="form-control" placeholder="Search"/></div></div>
            </div>
          </div>
          <div class="table-responsive">
            <table class="table table-bordered table-hover" id="searchbox_flow_tbl">
              <thead>
                <tr>
                  <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
                  <td style="width:1px;" class="text-center">Image</td>
                  <td class="text-left">Item Name</td>
                   <td class="text-left">Price</td>
                  <td class="text-left">Pages</td>
                  <td class="text-right"><?php echo $column_action; ?></td>
                </tr>
              </thead>
              <tbody>
                <?php if ($page_flow) { $i=0;?>
                <?php foreach ($page_flow as $page) { ?>
                <tr>
                  <td class="text-center"><?php if (in_array($page['MenuDetailId'], $selected)) { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $page['MenuDetailId']; ?>" checked="checked" />
                    <?php } else { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $page['MenuDetailId']; ?>" />
                    <?php } ?></td>
                  <td class="text-center"><?php if ($page['image']) { ?>
                    <img src="data:image/jpeg; base64, <?php echo $page['image']; ?>" height="40" width="40"/>
                    <?php } else { ?>
                    <span class="img-thumbnail list"><i class="fa fa-camera fa-2x"></i></span>
                    <?php } ?></td>
                  <td class="text-left"><?php echo $page['vitemname']; ?><input type="hidden" name="itemseq[<?php echo $i; ?>]" value="<?php echo $page['MenuDetailId']; ?>" /> </td>
                  <td class="text-left"><input type="text" class="editable number" name="pgflo[<?php echo $i; ?>][Price]" id="pgflo[<?php echo $i; ?>][Price]" value="<?php echo $page['Price']; ?>" size="5" onblur="updateitemprice('<?php echo $page['MenuDetailId']; ?>',this.value)"/></td>
                  <td class="text-left"><ul class="sortable list-inline">
                      <?php $pageidseq=''; foreach($page['pagenames'] as $pg){  ?>
                      <?php if($pg['PageId']!=5){ $pageidseq .= $pg['PageId'].','; ?>
                      <li id="<?php echo $pg['PageId']; ?>" title="<?php echo $page['MenuDetailId']; ?>">
                        <div class="row pgbox">
                          <div class="pull-left" style="margin-right:10px;"><a href="<?php echo $pg['url'];?>" style="font-weight:bold; font-size:13px;"><?php echo $pg['InternalTitle']; ?></a> </div>
                          <div class="pull-right"><span class="label label-info" onclick="editflowpages('<?php echo $pg['PageFlowHeaderId']; ?>')" style="cursor:pointer;"><i class="fa fa-pencil"></i></span></div>
                          <?php if($pg['Action']=="S"){ ?>
                          <div class="pull-right" style="padding-right:4px;"><span class="label label-success"><?php echo $pg['Action']; ?></span></div>
                           <?php }else{ ?>
                           <div class="pull-right" style="padding-right:4px;"><span class="label label-danger"><?php echo $pg['Action']; ?></span></div>
                           <?php } ?>
                          <div class="pull-right" style="padding-right:4px;"><span class="label label-warning"><?php echo $pg['FreeTopingsCt']; ?></span></div>
                          
                        </div>
                      </li>
                      <?php } ?>
                      <?php } ?>
                    </ul>
                    <input type="hidden" id="pageid_seq<?php echo $page['MenuDetailId']; ?>" value="<?php echo rtrim($pageidseq,","); ?>" /></td>
                  <td class="text-right"><a class="btn btn-sm btn-success up" onclick='document.getElementById("category[<?php echo $category['CategoryId']; ?>][select]").setAttribute("checked","checked");'><i class="fa fa-arrow-up"></i> Up</a> <a class="btn btn-sm btn-warning down"><i class="fa fa-arrow-down"></i> Down</a> <a  data-toggle="tooltip" onclick="openpageflowedit('<?php echo $page['MenuDetailId']; ?>','<?php echo $page['iitemid']; ?>')" title="<?php echo $button_edit; ?>" class="btn btn-sm btn-primary"><i class="fa fa-pencil"></i> Edit</a></td>
                </tr>
                <?php $i++;} ?>
                <?php } else { ?>
                <tr>
                  <td class="text-center" colspan="7"><?php echo $text_no_results; ?></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
          <div class="row">
            <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
            <div class="col-sm-6 text-right"><?php echo $results; ?></div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
$('#button-filter').on('click', function() {
  url = 'index.php?route=kiosk/page_flow&token=<?php echo $token; ?>';
  
  var filter_menuid = $('select[name=\'filter_menuid\']').val();
  
  if (filter_menuid) {
    url += '&filter_menuid=' + encodeURIComponent(filter_menuid);
  }
  
  var filter_categoryid = $('select[name=\'filter_categoryid\']').val();
  
  if (filter_categoryid) {
    url += '&filter_categoryid=' + encodeURIComponent(filter_categoryid);
  }
  
  location = url;
});

function filterpage()
{
  url = 'index.php?route=kiosk/page_flow&token=<?php echo $token; ?>';
  
  var filter_menuid = $('select[name=\'filter_menuid\']').val();
  
  if (filter_menuid) {
    url += '&filter_menuid=' + encodeURIComponent(filter_menuid);
  }
  
  var filter_categoryid = $('select[name=\'filter_categoryid\']').val();
  
  if (filter_categoryid) {
    url += '&filter_categoryid=' + encodeURIComponent(filter_categoryid);
  }
  
  location = url;
} 
//--></script> 
<script type="text/javascript"><!--
$('#filter_menuid').on('change', function() {
  
  var menuidval= $("#filter_menuid option:selected").val();
  
  $.ajax({
    type: 'post',
    url: 'index.php?route=kiosk/page_flow/getCategory&token=<?php echo $token; ?>&menuid='+menuidval+'&model=No',
    dataType: 'html',
    success: function (data) {
      $("#changecat").html(data);
    }
  });
  });
  
$('#MenuId').on('change', function() {
  
  var menuidval= $("#MenuId option:selected").val();
  
  $.ajax({
    type: 'post',
    url: 'index.php?route=kiosk/page_flow/getCategory&token=<?php echo $token; ?>&menuid='+menuidval+'&model=Yes',
    dataType: 'html',
    success: function (data) {
      $("#modelcategory").html(data);
    }
  });
  });
//--></script> 
<script type="text/javascript"><!--
function removeValue(list, value) {
  /*return list.replace(new RegExp(",?" + value + ",?"), function(match) {
      var first_comma = match.charAt(0) === ',',
          second_comma;

      if (first_comma &&
          (second_comma = match.charAt(match.length - 1) === ',')) {
        return ',';
      }
      return '';
    });*/
  
  separator = ",";
  var values = list.split(separator);
  for(var i = 0 ; i < values.length ; i++) {
    if(values[i] == value) {
      values.splice(i, 1);
      return values.join(separator);
    }
  }
  return list;
};
//--></script> 
<script type="text/javascript"><!--

function loadleftitems(){
  $("#itemsort1 tbody").html("");
  $("#itemsort2 tbody").html("");
  $("#right_itemsadded").val("");

  var left='';
  var right='';
  var itemsid ='';
  
  $.ajax({
    type: 'post',
    url: 'index.php?route=kiosk/page_flow/getLeftItems&token=<?php echo $token; ?>',
    data : 'MenuId='+$("#MenuId option:selected").val()+'&CategoryId='+$("#CategoryId option:selected").val()+'&selecteditems='+$("#right_itemsadded").val(),
    dataType: 'html',
	beforeSend: function() {
		$("div#loading").addClass('show');
	},
    success: function (json) {
		$("div#loading").removeClass('show');
      //alert(json);
      var data  = $.parseJSON(json);
      left= data.left;
      right = data.right;
      itemsid = data.right_itemsid;

      $("#itemsort1 tbody").html("");
      $("#itemsort1 tbody").append(left);
      $("#itemsort2 tbody").append(right);
      $("#right_itemsadded").val(itemsid);
    }
  });}

function leftrightajax(){
  var left='';
  var right='';

  $.ajax({
    type: 'post',
    url: 'index.php?route=kiosk/page_flow/getLeftRightItems&token=<?php echo $token; ?>',
    //dataType: 'json',
    dataType: 'html',
    data: 'right_itemsadded='+$("#right_itemsadded").val()+'&MenuId='+$("#MenuId option:selected").val()+'&CategoryId='+$("#CategoryId option:selected").val(),
	beforeSend: function() {
		$("div#loading").addClass('show');
	},   
    success: function (json) {     
	
      $("div#loading").removeClass('show');
      var data  = $.parseJSON(json);
      left= data.left;
      right = data.right;
      itemsid = data.right_itemsid;
      
      $("#itemsort1 tbody").html("");
      $("#itemsort1 tbody").append(left);
      
      $("#itemsort2 tbody").html("");
      $("#itemsort2 tbody").append(right);
      //alert(json);
      //$("#right_itemsadded").val(itemsid);
    }
  });}

function addrightitem(){
  var testval = [];
  var itemcount = 0;
  if($("#right_itemsadded").val()!="")
  { 
    testval.push($("#right_itemsadded").val());
    
    itemcount = $("#right_itemsadded").val().split(",").length;
    
    $('input[name*=\'leftitemsselected\']:checked').each(function() {
      testval.push($(this).val());
      itemcount ++;
    });
  }
  else
  {
    
    $('input[name*=\'leftitemsselected\']:checked').each(function() {
      testval.push($(this).val());
      itemcount ++;
    });
  }   
  
  if(itemcount > 25)
  {
    alert("Maximum 25 item allowed to add selected category");
    return false;
  }else{
    $("#right_itemsadded").val(testval);
    leftrightajax();  
  } 
}

function addleftitem(){
  var right_hidden_val = [];
  
  if($("#right_itemsadded").val()!="")
  { 
    $('input[name*=\'rightitemsselected\']:checked').each(function() {
      right_hidden_val = removeValue($("#right_itemsadded").val(),$(this).val());
      $("#right_itemsadded").val(right_hidden_val);   
    });
  }
  else
  {
    $('input[name*=\'rightitemsselected\']:checked').each(function() {
      right_hidden_val = removeValue($("#right_itemsadded").val(),$(this).val()); 
    });
    $("#right_itemsadded").val(right_hidden_val);
  }   
  
  leftrightajax();  
}
  
$("#modelsave").click(function(){
  
  var model_menuid= $("#MenuId option:selected").val();
  var model_categoryid= $("#CategoryId option:selected").val();
  //var model_iitemid= $("#iitemid option:selected").val();
  
  if(model_menuid =="")
  {
    alert("Please Select Menu.");
    return false; 
  }
  if(model_categoryid =="")
  {
    alert("Please Select Category.");
    return false; 
  }
  if($("#right_itemsadded").val() =="")
  {
    alert("Please Select Item.");
    return false; 
  }
  
  if($("#right_itemsadded").val() !="")
  {
    itemcount = $("#right_itemsadded").val().split(",").length;
    if(itemcount > 25)
    {
      alert("Maximum 25 item allowed to add selected category");
      return false; 
    }
  }
  
  if(model_menuid !="" && model_categoryid !="")
  {
    //alert('Save');
    $('#form-model').attr('action','index.php?route=kiosk/page_flow/addItems&token=<?php echo $token; ?>');
    $('#form-model').submit();
  }
});
  
//--></script> 
<script type="text/javascript"><!--
function openpageflowedit(id,iitemid){
  $("#pagesort1 tbody").html("");
  $("#pagesort2 tbody").html("");
  $("#right_pagesadded").val("");
  
  $("#MenuDetailId").val(id);
  $("#iitemid").val(iitemid);
  
  var leftpages='';
  var rightpages='';
  var right_pagesadded = '';
  var itm='';
  var price='';
  
  $.ajax({
    type: 'post',
    url: 'index.php?route=kiosk/page_flow/getEditModelitemid&token=<?php echo $token; ?>&iitemid='+iitemid+"&MenuDetailId="+id,
    dataType: 'json',   
    success: function (json) {    
      
      $.each(json, function(k, v){
        itm= v.item;
        price = v.price;        
            }); 
      
      $("#modelitemid").html("");
      $("#modelitemid").html(itm);
      
      $("#Price").val(price);   
    }
  });
  
  $.ajax({
    type: 'post',
    url: 'index.php?route=kiosk/page_flow/getLeftRightPages&token=<?php echo $token; ?>',
    data : 'MenuId='+$("#MenuId option:selected").val()+'&CategoryId='+$("#CategoryId option:selected").val()+"&MenuDetailId="+id+"&right_pagesadded="+$("#right_pagesadded").val()+"&iitemid="+iitemid,
    //dataType: 'json',
    dataType: 'html',
    success: function (json) {
      var data  = $.parseJSON(json);
    
      $("#right_pagesadded").val("");
      $("#right_pagesadded").val(data.right_pagesadded);
      
      $("#pagesort1 tbody").html("");
      $("#pagesort1 tbody").append(data.left);
      
      $("#pagesort2 tbody").html("");
      $("#pagesort2 tbody").append(data.right);
    }
  });

  $('#editpageflowmodel').modal('toggle');
}

function addrightpages(){
  var testval = [];
  var pagescount = 0;
  if($("#right_pagesadded").val()!="")
  { 
    testval.push($("#right_pagesadded").val());
    
    pagescount = $("#right_pagesadded").val().split(",").length;
    
    $('input[name*=\'leftpagesselected\']:checked').each(function() {
      testval.push($(this).val());
      pagescount++;
    });
  }
  else
  {
    $('input[name*=\'leftpagesselected\']:checked').each(function() {
      testval.push($(this).val());
      pagescount++;
    });
  }   
  
  if(pagescount > 10)
  {
    alert("Maximum 10 pages allowed to add select item");
    return false;
  }else{
    $("#right_pagesadded").val(testval);
    
  }
  
  
  if($("#right_pagesadded").val()=="")
  {
    $("#modelupdatepageflow").attr('disabled', 'disabled');
  }
  else
  {
    $("#modelupdatepageflow").removeAttr('disabled');
  
    var leftpages='';
    var rightpages='';
      
    $.ajax({
      type: 'post',
      url: 'index.php?route=kiosk/page_flow/AddLeftToRightPages&token=<?php echo $token; ?>',
      dataType: 'json',
      //dataType: 'html',
      data : 'MenuId='+$("#MenuId option:selected").val()+'&CategoryId='+$("#CategoryId option:selected").val()+"&MenuDetailId="+$("#MenuDetailId").val()+"&right_pagesadded="+$("#right_pagesadded").val()+"&side=left",   
      
      success: function (json) {  
        //alert(json);
        $.each(json, function(k, v){        
          if(v.left=="0" || v.left === undefined){
            leftpages += "";
          }else{
            leftpages += v.left;  
          }
        });
        
        $.each(json, function(k, v){
          if(v.right=="0" || v.right === undefined){
            rightpages += "";
          }else{
            rightpages += v.right;  
          }
        });
  
        $("#pagesort1 tbody").html("");
        $("#pagesort1 tbody").append(leftpages);
        
        $("#pagesort2 tbody").html("");
        $("#pagesort2 tbody").append(rightpages);
      }
    });
  }
}

function addleftpage(){
  var right_pagehidden_val = [];
  
  if($("#right_pagesadded").val()!="")
  { 
    $('input[name*=\'rightpagesselected\']:checked').each(function() {
      right_pagehidden_val = removeValue($("#right_pagesadded").val(),$(this).val());
      $("#right_pagesadded").val(right_pagehidden_val);   
    });
  }
  else
  {
    $('input[name*=\'rightpagesselected\']:checked').each(function() {
      right_pagehidden_val = removeValue($("#right_pagesadded").val(),$(this).val()); 
    });
    $("#right_pagesadded").val(right_pagehidden_val);
  }   
  
  if($("#right_pagesadded").val()=="")
  {
    $("#modelupdatepageflow").attr('disabled', 'disabled');
  }
  else
  {
    $("#modelupdatepageflow").removeAttr('disabled');
  }
  var leftpages='';
  var rightpages='';
    
  $.ajax({
    type: 'post',
    url: 'index.php?route=kiosk/page_flow/AddRightToLeftPages&token=<?php echo $token; ?>',
    dataType: 'json',
    //dataType: 'html',
    data : 'MenuId='+$("#MenuId option:selected").val()+'&CategoryId='+$("#CategoryId option:selected").val()+"&MenuDetailId="+$("#MenuDetailId").val()+"&right_pagesadded="+$("#right_pagesadded").val()+"&side=right",    
    
    success: function (json) {  
      //alert(json);
      $.each(json, function(k, v){        
        if(v.left=="0" || v.left === undefined){
          leftpages += "";
        }else{
          leftpages += v.left;  
        }
            });
      
      $.each(json, function(k, v){
        if(v.right=="0" || v.right === undefined){
          rightpages += "";
        }else{
          rightpages += v.right;  
        }
            });

      $("#pagesort1 tbody").html("");
      $("#pagesort1 tbody").append(leftpages);
      
      $("#pagesort2 tbody").html("");
      $("#pagesort2 tbody").append(rightpages);
    }
  });
}

$("#modelupdatepageflow").click(function(){
    
  var model_menuid= $("#MenuId option:selected").val();
  var model_categoryid= $("#CategoryId option:selected").val();
  var model_iitemid= $("#iitemid option:selected").val();
  
  if(model_menuid =="")
  {
    alert("Please Select Menu.");
    return false; 
  }
  if(model_categoryid =="")
  {
    alert("Please Select Category.");
    return false; 
  }
  if(model_iitemid =="")
  {
    alert("Please Select Item.");
    return false; 
  }
  
  if(model_menuid !="" && model_categoryid !="" && model_iitemid !="")
  {
    //alert('Save');
    $('#modelform-pageedit').attr('action', 'index.php?route=kiosk/page_flow/updatePageflow&token=<?php echo $token; ?>');
    $('#modelform-pageedit').submit();
  }
});

//--></script> 
<script type="text/javascript"><!--

$("#copytoallpages").click(function(){
  
  var chkcount = $('input[name="selected[]"]:checked').length;
  if(chkcount == 0 )
  {
    alert("Please Select One Checkbox to Copy all");
    return false;
  }
  else if(chkcount > 1)
  {
    alert("Please Select Only One Checkbox to Copy all");
    return false;
  }
  else
  {   
    if(confirm('Are you sure want to copy this page flow for other pages.'))
    {
      $('#form-page').attr('action','index.php?route=kiosk/page_flow/CopyToAllPages&token=<?php echo $token; ?>');
      $('#form-page').submit();
    }
  }
});

$("#movepgflow").click(function(){
  
  var chkcount = $('input[name="selected[]"]:checked').length;
  if(chkcount == 0 )
  {
    alert("Please Select One Checkbox to Move");
    return false;
  }
  else if(chkcount > 1)
  {
    alert("Please Select Only One Checkbox to Move");
    return false;
  }
  else
  { 
	var menudetailid = '';
	var itemname = '';
	 
	$('input[name="selected[]').each(function() 
	{    
		if($(this).is(':checked')){
			menudetailid =$(this).val();
			
			$("#menudetailid").val($(this).val());
			var data = $(this).parents('tr:eq(0)');
			$("#pg_flow_itemname").html($(data).find('td:eq(2)').text());
		}
	});

  	$('#model_movepageflow').modal('show');
  
    /*if(confirm('Are you sure want to move this page flow for other.'))
    {
      $('#form-page').attr('action','index.php?route=kiosk/page_flow/movepageflow&token=<?php echo $token; ?>');
      $('#form-page').submit();movepgflowsave
    }*/
  }
});

$("#movepgflowsave").click(function(){
	if(confirm('Are you sure want to move this page flow for other.'))
    {
      $('#form-model_movepg').attr('action','index.php?route=kiosk/page_flow/movepageflow&token=<?php echo $token; ?>');
      $('#form-model_movepg').submit();
	}
});

$(".sortable" ).sortable({
  connectWith: '.sortable',
  update: function(event, ui) {
    var id = ui.item.attr("id");
    var title = ui.item.attr("title");    
    var changedList = this.id;
    var order = $(this).sortable('toArray');
    var positions = order.join(',');

    $("#pageid_seq"+title).val(positions);
    
    $.ajax({
      type: 'post',
      url: 'index.php?route=kiosk/page_flow/updaetPageflowposition&token=<?php echo $token; ?>&MenuDetailId='+title+'&pageid_seq='+$("#pageid_seq"+title).val(),
      dataType: 'html',   
      success: function (json) {
        //alert(json);
      }
    });
    } 
});
$(".sortable" ).disableSelection();

function editflowpages(id)
{
  var PageFlowHeaderId = id;
  var action = '';
  var freetopingsct ='';
  var internaltitle='';
  var html='';
  
  $.ajax({
    type: 'post',
    url: 'index.php?route=kiosk/page_flow/getPageFlowPagesEdit&token=<?php echo $token; ?>&PageFlowHeaderId='+PageFlowHeaderId,
    dataType: 'html',   
    success: function(json) {
      //alert(json);
      var data  = $.parseJSON(json);
      action= data.Action;
      freetopingsct = data.FreeTopingsCt;
      internaltitle = data.InternalTitle;     
           
        var html='';
      html +=  '<div class="modal fade" tabindex="-1" role="dialog" id="PageFlowEditModel">';
      html += '<div class="modal-dialog">';
      html += '<div class="modal-content">';
      html += '<div class="modal-header modal-header-info"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button><h4 class="modal-title">Edit '+internaltitle+'</h4></div>';  
      html += '<div class="modal-body">'; 
      html += '<form action="index.php?route=kiosk/page_flow/savePageFlow&token=<?php echo $token; ?>" method="post" enctype="multipart/form-data" id="form-pageflowitem" class="form-horizontal">';
        html += '<input type="hidden" name="PageFlowHeaderId" value="'+PageFlowHeaderId+'"/>';
      html += '<input type="hidden" name="filter_menuid" value="<?php echo $filter_menuid;?>"/>';
      html += '<input type="hidden" name="filter_categoryid" value="<?php echo $filter_categoryid;?>"/>';
      html += '<div class="form-group">';
      html += '<label class="col-sm-3 control-label">Action</label>';
      html += '<div class="col-sm-3">';
      if(action=="Single"){
        html += '<input type="radio" name="action" value="Single" checked/> Single   ';
      }else{
        html += '<input type="radio" name="action" value="Single"/> Single   ';
      }
      
      if(action=="Multi"){
        html += '  <input type="radio" name="action" value="Multi" checked/ > Multi ';
      }else{
        html += '  <input type="radio" name="action" value="Multi"/> Multi '; 
      }
      
      html += '</div></div>';
      html += '<div class="form-group">';
      html += '<label class="col-sm-3 control-label">Free Topings Ct</label>';
      html += '<div class="col-sm-3"><input type="text" class="form-control number" name="FreeTopingsCt" size="3" value="'+freetopingsct+'" /></div>';
      html += '</div>';
    
      html += '</form>';  
      html += '</div>';
      html += '<div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal"  onclick="btnflowsave()">Save</button> <button type="button" class="btn btn-default" data-dismiss="modal">Close</button></div>';
      html += '</div>';
      html += '</div>';
      html += '</div>';
      
      $("#model_pageflow").html(html);
      $("#PageFlowEditModel").modal("show");
    }
  });
}

function btnflowsave(){
  //$('#form-page').attr('action','index.php?route=kiosk/page_flow/CopyToAllPages&token=<?php echo $token; ?>');
  $('#form-pageflowitem').submit();
}

function updateitemprice(id,val){
  
  $.ajax({
    type: 'post',
    url: 'index.php?route=kiosk/page_flow/updaetItemPrice&token=<?php echo $token; ?>&MenuDetailId='+id+"&Price="+val,
    dataType: 'html',   
    success: function (json) {      
    }
  });
}

$("#updateitemsequence").click(function(){
  $('#form-page').attr('action','index.php?route=kiosk/page_flow/position&token=<?php echo $token; ?>');
  $('#form-page').submit();
});
//--></script> 
<script><!--
$('input[name=\'searchbox\']').autocomplete({
  minLength: 1,
  'source': function(request, response) {
    $.ajax({
      type: 'post',
      //url: 'index.php?route=kiosk/page_flow/getLeftItems&token=<?php echo $token; ?>&searchbox='+$('input[name=\'searchbox\']').val(),
      url: 'index.php?route=kiosk/page_flow/autocomplete&token=<?php echo $token; ?>&searchbox='+$('input[name=\'searchbox\']').val(),
      data: 'right_itemsadded='+$("#right_itemsadded").val()+'&MenuId='+$("#MenuId option:selected").val()+'&CategoryId='+$("#CategoryId option:selected").val(),   
      dataType: 'json',
      success: function(json) {       
        response($.map(json, function(item) {         
          return {
            label: item['vitemname'],
            value: item['iitemid']
          }
        }));
      }
    });
  },
  'select': function(event, ui) {
    $('input[id=\'searchbox\']').val(ui.item.label);
    $('input[id=\'searchboxid\']').val(ui.item.value);
    
    //$('#form-items').attr('action', 'index.php?route=kiosk/page_flow&token=<?php echo $token; ?>');
    //$('#form-items').submit();

    //return false;
  }
});
--></script>
<script type="text/javascript">
  $(document).on('keyup', '#searchbox', function(event) {
    event.preventDefault();
    $('#itemsort1 tbody tr').hide();
    var txt = $('#searchbox').val();

    if(txt != ''){
      $('#itemsort1 tbody tr').each(function(){
        if($(this).text().toUpperCase().indexOf(txt.toUpperCase()) != -1){
          $(this).show();
        }
      });
    }else{
      $('#itemsort1 tbody tr').show();
    }
  });
  
  $(document).on('keyup', '#searchboxpg', function(event) {
    event.preventDefault();
    
	$('#pagesort1 tbody tr').hide();
    
	var txtpg = $('#searchboxpg').val();

    if(txtpg != ''){
      $('#pagesort1 tbody tr').each(function(){
        if($(this).text().toUpperCase().indexOf(txtpg.toUpperCase()) != -1){
          $(this).show();
        }
      });
    }else{
      $('#pagesort1 tbody tr').show();
    }
  });
  $(document).on('keyup', '#searchbox_flow', function(event) {
    event.preventDefault();
    $('#searchbox_flow_tbl tbody tr').hide();
    var txts = $('#searchbox_flow').val();

    if(txts != ''){
      $('#searchbox_flow_tbl tbody tr').each(function(){
        if($(this).text().toUpperCase().indexOf(txts.toUpperCase()) != -1){
          $(this).show();
        }
      });
    }else{
      $('#searchbox_flow_tbl tbody tr').show();
    }
  });
</script>
<script>
function viewimage(itemid) {
	$.ajax({
      type: 'post',
      url: 'index.php?route=kiosk/page_flow/viewimage&token=<?php echo $token; ?>&itemid='+itemid,
      dataType: 'html',
	  cache :false,
	  beforeSend: function() {
		 $("div#loading").addClass('show');
		$('#loading').html('');
	  },
      success: function(json) {   
		$('#loading').html('');
		 $("div#loading").removeClass('show');
		$("#model_itemimageview").html(''); 
		$("#model_itemimageview").html(json);		
		$('#test2').modal('show'); 
      }
    });
}

$('.close').click(function() {
  $("#model_itemimageview").html(''); 
});


</script> 
<style type="text/css">

  #loading{
    display : none;
  }
  #loading.show{
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

</style>

<?php echo $footer; ?>