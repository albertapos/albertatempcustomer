<!DOCTYPE html>
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>">
<head>
<meta charset="UTF-8" />
<title><?php echo $title; ?></title>
<base href="<?php echo $base; ?>" />
<?php if ($description) { ?>
<meta name="description" content="<?php echo $description; ?>" />
<?php } ?>
<?php if ($keywords) { ?>
<meta name="keywords" content="<?php echo $keywords; ?>" />
<?php } ?>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
<script type="text/javascript" src="view/javascript/jquery/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="view/javascript/bootstrap/js/bootstrap.min.js"></script>
<link href="view/stylesheet/bootstrap.css" type="text/css" rel="stylesheet" />
<link href="view/javascript/font-awesome/css/font-awesome.min.css" type="text/css" rel="stylesheet" />
<link href="view/javascript/summernote/summernote.css" rel="stylesheet" />
<script type="text/javascript" src="view/javascript/summernote/summernote.js"></script>
<script src="view/javascript/jquery/datetimepicker/moment.js" type="text/javascript"></script>
<script src="view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
<link href="view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.css" type="text/css" rel="stylesheet" media="screen" />
<link type="text/css" href="view/stylesheet/stylesheet.css" rel="stylesheet" media="screen" />
<?php foreach ($styles as $style) { ?>
<link type="text/css" href="<?php echo $style['href']; ?>" rel="<?php echo $style['rel']; ?>" media="<?php echo $style['media']; ?>" />
<?php } ?>
<?php foreach ($links as $link) { ?>
<link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>" />
<?php } ?>
<script src="view/javascript/common.js" type="text/javascript"></script>
<?php foreach ($scripts as $script) { ?>
<script type="text/javascript" src="<?php echo $script; ?>"></script>
<?php } ?>
<link rel="stylesheet" href="view/stylesheet/jquery-ui.css">
<script src="view/javascript/jquery/jquery-ui.js"></script>
<!-- DataTables -->
<script src="view/javascript/jquery/datatables/jquery.dataTables.min.js"></script>
<script src="view/javascript/jquery/datatables/dataTables.bootstrap.min.js"></script>

</head>
<body>
<div id="container">
<header id="header" class="navbar navbar-static-top">
  <div class="navbar-header">
    <?php if ($logged) { ?>
    <a type="button" id="button-menu" class="pull-left"><i class="fa fa-indent fa-lg"></i></a>
    <?php } ?>
    <a href="<?php echo $home; ?>" class="navbar-brand"><img src="view/image/Alberta POS_Logo.png" height="25" width="60" alt="<?php echo $heading_title; ?>" title="<?php echo $heading_title; ?>" /></a></div>    
  <?php if ($logged) { ?>
  
  <ul class="nav pull-right">
    <li>
        <?php if($stores) { ?>
            <select id="store_list" class="form-control" style="padding-top:5px !important;">
                <?php foreach($stores as $store) {?>
                    <option value="<?php echo $store['id'];?>" <?php echo ($store['id'] == $SID) ? 'selected' : '' ;?>><?php echo $store['name'];?></option>
                <?php } ?>
            </select>
        <?php } ?>
    </li>  	
    <li><a href="<?php echo $logout; ?>"><span class="hidden-xs hidden-sm hidden-md"><?php echo $text_logout; ?></span> <i class="fa fa-sign-out fa-lg"></i></a></li>
    
  </ul>
  <div style="border:0px solid #000; width:100%; text-align:center; margin-top:10px; font-size:18px; color:#F30; font-weight:bold;">Store - <?php echo $storename;?></div>
  
  <?php } ?>
</header>
<style type="text/css">
    .title_div{
        border: 1px solid #ddd;
        padding: 5px;
    }
    .align-self {position: relative; margin-top: 17px;}
    .select2-selection__rendered {
        line-height: 31px !important;
    }
    .select2-container .select2-selection--single {
        height: 35px !important;
    }
    .select2-selection__arrow {
        height: 34px !important;
    }
    .select2-container{
        width:150px;padding-top:5px;
    }
</style>

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script type="text/javascript">
    $('#store_list').select2();
</script>