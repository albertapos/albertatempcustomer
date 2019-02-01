$(document).ready(function() {
    //toggle `popup` / `inline` mode
   // $.fn.editable.defaults.mode = 'popup';     
    $.fn.editable.defaults.mode = 'inline';
    
    //make username editable
    $('#price').editable();
    
    //make status editable
    
        /*
        //uncomment these lines to send data on server
        ,pk: 1
        ,url: '/post'
        */
   
});