var emailstr=/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,})+$/;
$(function () {    
    $('.subaction').click(function(){
        if(univfields()==0)
        $(this).closest('form').submit();
    });
});
$(document).on('change','.formnumeric',function(e){
    this.value = this.value.replace(/[^0-9.]/g,'');
});

$(document).on('keyup change','.error',function(e){
    checkerrors(this);
});
function univfields(){
var resp=0;
    $('form .required').each(function(){
        var fname = $(this).attr('id');
        var emsg = $(this).attr('title');
        var elename=$(this).attr('name');
       if(( $(this).val()=='') || ($(this).attr('type')=='checkbox' && $('input[name="'+elename+'"]:checked').length==0) || 
        ($(this).attr('type')=='radio' && !$('input[name="'+elename+'"]').is(':checked')) ||                
        ($(this).attr('type')=='email' &&($(this).val()=='' || !emailstr.test($(this).val()))) || 
        ($(this).hasClass('validemail') &&($(this).val()=='' || !emailstr.test($(this).val())))){
            $(this).addClass('error visible');
            if($(this).parent().find('label#'+fname+'-error').length==0)
            $(this).after('<label id="'+fname+'-error" class="error" for="'+fname+'"> '+(emsg)+' </label>');
            else
            $('label#'+fname+'-error').html(emsg).show();
            resp++;
        }else{
        $(this).parent().find('label#'+fname+'-error').hide();
        $(this).removeClass('error visible');
        }
    
    });
    $('form .visible:eq(0)').focus();
    return resp;
}
function checkerrors(ele){
    var fname = $(ele).attr('id');
    var elename=$(ele).attr('name');
   if( ($(ele).attr('type')=='email'&& ($(ele).val()=='' || !emailstr.test($(ele).val()))) || $(ele).val()==''||
     (($(ele).attr('type')=='radio' && !$('input[name="'+elename+'"]').is(':checked')||
      $(ele).attr('type')=='checkbox')&& $('input[name="'+elename+'"]:checked').length==0) || 
     ($(ele).hasClass('validemail') && ($(ele).val()=='' || !emailstr.test($(ele).val())))){       
        $(ele).addClass('visible');
        $(ele).parent().find('label#'+fname+'-error').show();
    }else{
        $(ele).removeClass('visible');
        $(ele).parent().find('label#'+fname+'-error').hide();
    }
}