<ul id="menu">
    
    
  <li id="dashboard"><a href="<?php echo $home; ?>"><i class="fa fa-dashboard fa-fw"></i> <span><?php echo $text_dashboard; ?></span></a></li>
  <li id="catalog"><a class="parent active"><i class="fa fa-tags fa-fw"></i> <span><?php echo $text_kiosk; ?></span></a>
    <ul>
      <li><a href="<?php echo $menus; ?>"><?php echo $text_menus; ?></a></li>
      <li><a href="<?php echo $category; ?>"><?php echo $text_category; ?></a></li>
      <li><a href="<?php echo $pages; ?>"><?php echo $text_pages; ?></a></li>
      <li><a href="<?php echo $page_flow; ?>"><?php echo $text_page_flow; ?></a></li>
      <li><a href="<?php echo $items; ?>"><?php echo $text_items; ?></a></li>
      <li><a href="<?php echo $gloabal_param; ?>"><?php echo $text_gloabal_param; ?></a></li>
    </ul>
  </li>  
</ul>

<script type="text/javascript">

$("#column-left").addClass('active');
</script>