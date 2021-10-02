<footer id="footer"><?php echo $text_footer; ?><br /><?php echo $text_version; ?></footer></div>
</body></html>
<div style="display:none;">
    <form method="post" action="<?php echo $dashboard_url; ?>" id="form_store_change">
        <input name="change_store_id" id="change_store_id" value="">
        <input type="submit" value="change">
    </form>
</div>
<script type="text/javascript">
    $(document).on('change', '#store_list', function(event) {
        
        var store_id = $(this).val();
        $('form#form_store_change #change_store_id').val(store_id);
        $('form#form_store_change').submit();

    });
</script>