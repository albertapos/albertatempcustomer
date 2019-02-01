<footer id="footer"><?php echo $text_footer; ?><a id="alberta_listing_btn" style="cursor: text;" href="<?php echo $alberta_listing; ?>">.</a><br /></footer></div>
<a href="javascript:void(0)" class="scrollToTop" title="Go To Top"><i class="fa fa-arrow-up"></i></a>
</body></html>
<div style="display:none;">
    <form method="post" action="<?php echo $dashboard_url; ?>" id="form_store_change">
        <input name="change_store_id" id="change_store_id" value="">
        <input type="submit" value="change">
    </form>
</div>

<script type="text/javascript">
$(document).ready(function(){   
    /*to top*/
        $(window).scroll(function(){
        if ($(this).scrollTop() > 200) {
            $('.scrollToTop').fadeIn();
        } else {
            $('.scrollToTop').fadeOut();
        }
    }); 
    //Click event to scroll to top
    $('.scrollToTop').click(function(){
        $('html, body').animate({scrollTop : 0},800);
        return false;
    }); 
});
</script>

<script type="text/javascript">
    $(document).on('click', '.change_store', function(event) {
        
        var store_id = $(this).attr('data-store-id');
        $('form#form_store_change #change_store_id').val(store_id);
        $('form#form_store_change').submit();

    });
</script>

<script>
function openNavStore() {
    document.getElementById("mySidenavStore").style.width = "250px";
    document.getElementById("mySidenavReports").style.width = "0";
}

function closeNavStore() {
    document.getElementById("mySidenavStore").style.width = "0";
}

$(document).on('click', '.di_store_name,.di_reports', function(event) {
    event.preventDefault();
    /* Act on the event */
});

function openNavReports() {
    document.getElementById("mySidenavReports").style.width = "250px";
    document.getElementById("mySidenavStore").style.width = "0";
}

function closeNavReports() {
    document.getElementById("mySidenavReports").style.width = "0";
}

$(document).on('click', '.di_store_name', function(event) {
    event.preventDefault();
    /* Act on the event */
});


$(window).scroll(function(){
    if ($(this).scrollTop() > 52) {
        $('.sidenav').css('top','0px');
    } else {
        $('.sidenav').css('top','45px');
    }
});
</script>

<script type="text/javascript">
    $(document).on('keyup', '#store_search', function(event) {
        event.preventDefault();
        $('p.change_store').hide();
        var txt = $(this).val();

        if(txt != ''){
          $('p.change_store').each(function(){
            if($(this).text().toUpperCase().indexOf(txt.toUpperCase()) != -1){
              $(this).show();
            }
          });
        }else{
          $('p.change_store').show();
        }
      });

    $(document).on('keyup', '#report_search', function(event) {
        event.preventDefault();
        $('a.report_name').hide();
        var txt = $(this).val();

        if(txt != ''){
          $('a.report_name').each(function(){
            if($(this).text().toUpperCase().indexOf(txt.toUpperCase()) != -1){
              $(this).show();
            }
          });
        }else{
          $('a.report_name').show();
        }
      });
</script>

<style type="text/css">
    #header .navbar-header a.navbar-brand{
        color: #fff;
        font-size: 20px;
        font-weight: bold;
    }
</style>

<div id="forgottenModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <!-- <div class="modal-header" style="border-bottom:none;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div> -->
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12 text-center">
            <p style="font-size: 15px"><b>To Reset Your Password Call On :</b><a href="tel:+18885026650" style="font-size: 15px">&nbsp;&nbsp;1-888-502-6650</a></p>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>

<script type="text/javascript">
    $(document).on('click', '#forgotten_link', function(event) {
        event.preventDefault();
        $('#forgottenModal').modal('show');
    });

    $(document).on('click', '.editable_all_selected', function(event) {
      event.preventDefault();
      $(this).select();
    });
</script>

<!-- rotating logo -->

<script type="text/javascript">

  $(document).on('click', '.breadcrumb li a, ul.pagination > li, #header > ul > li:eq(2),#header > ul > li:eq(3), #header > ul > li:eq(4), #mySidenavStore > div.side_content_div > div.side_inner_content_div > p:not(:eq(0)), #mySidenavReports > div.side_content_div > div.side_inner_content_div > p:not(:eq(0)), .edit_btn_rotate, .cancel_btn_rotate, .add_new_btn_rotate, .save_btn_rotate, .show_all_btn_rotate', function(event) {
    $("div#divLoading").addClass('show');
  });

  $(document).on('click', '#menu li a', function(event) {
    if (!$(this).hasClass("parent")) {
      $("div#divLoading").addClass('show');
    }
  });
</script>

<!-- rotating logo -->

<script type="text/javascript">
  $(document).on('paste', '.nordqty_class, .npackqty_class, input[name="iqtyonhand"], .ndebitqty_class, .ntransferqty_class', function(event) {
    event.preventDefault();
    
  });
</script>

<script type="text/javascript">
  function isValid(str) {
      return !/[~`!@#$%\^&*()+=\-\[\]\\';._,/{}|\\":<>\?]/g.test(str);
  }
</script>