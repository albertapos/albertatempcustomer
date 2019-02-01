@extends('main')
@section('content')
<section class="content-header">
    <h1>
    </h1>
</section><br>
<div class="col-md-12">
          @include('layouts.partials.errors')
          @include('layouts.partials.flash')
          @include('layouts.partials.success')
</div>
<section class="content">
    <div class="container box box-body "><br>
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#basic_detail">Store Details</a></li>
            <li><a href="#computers" disabled="disabled">Computer</a></li>
            <li><a href="#service" disabled="disabled" >Services</a></li>
            <!-- <li><a href="#user" disabled="disabled" >User</a></li> -->
            <li><a href="#store" disabled="disabled" >Multi Store</a></li>
        </ul>
        {!! Form::open(['url'=>'sales/vendors', 'method'=>'Post', 'files'=> true,'id'=>'form1']) !!}
        <div class="tab-content">
            <div id="basic_detail" class="tab-pane fade in active"><br>
                <div class="panel panel-default col-xs-offset-1" style="width:800px">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-sm-7">   
                                   <strong>Add Store Details</strong>
                                </div>
                    
                            </div>
                        </div><br>
                    <div class="row  col-xs-offset-1">
                            <div class="row"><br>
                                <div class="form-group col-xs-5">
                                    <label class="control-label">Store Name <font color="red">*</font> </label>
                                    <div class="">
                                        <input type="text" class="form-control" name="name" value="{{ old('name') }}" required id="name" >
                                    </div>
                                </div>
                                 <div class="form-group col-xs-5">
                                    <label class="control-label">Business Name <font color="red">*</font></label>
                                    <div class="">
                                        <input type="text" class="form-control required" name="business_name" value="{{ old('business_name') }}" id="business_name">
                                    </div>
                                </div> 
                            </div>
                            <div class="row">
                                <div class="form-group col-xs-5">
                                    <label class="control-label">Address <font color="red">*</font></label>
                                    <div class="">
                                        <input type="text" class="form-control" name="address" value="{{ old('address') }}" id="address">
                                    </div>
                                </div>
                                <div class="form-group col-xs-5">
                                    <label class="control-label">City <font color="red">*</font></label>
                                    <div class="">
                                        <input type="text" class="form-control" name="city" value="{{ old('city') }}" id="city">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-xs-5">
                                    <label class="control-label">State <font color="red">*</font> </label>
                                    <div class="">
                                        <select class="form-control" name="state" id="state">
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-xs-5">
                                    <label class="control-label">Zip <font color="red">*</font> </label>
                                    <div class="">
                                        <input type="text" maxlength="5" class="form-control" name="zip" value="{{ old('zip') }}" id="zip">
                                    </div>
                                </div>
                                <input type="hidden" name="country" value="USA">
                            </div>
                            <div class="row">
                                <div class="form-group col-xs-5">
                                    <label class="control-label">Phone <font color="red">*</font> </label>
                                    <div class="">
                                        <input type="text" maxlength="10" class="form-control" name="phone" value="{{ old('phone') }}" id="phone">
                                    </div>
                                </div>
                                <div class="form-group col-xs-5">
                                    <label class="control-label">Contact Name <font color="red">*</font></label>
                                    <div class="">
                                        <input type="text" class="form-control" name="contact_name" value="{{ old('contact_name') }}" id="contact_name">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-xs-10">
                                    <label class="control-label">Description</label>
                                    <div class="">
                                        <textarea class="textarea" placeholder="Place some text here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" name="description" id="description" value="{{ old('description') }}"></textarea>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
                <a class="btn  btn-close btn btn-primary col-sm-offset-4" href="{{ url('/sales/vendors') }}">Cancel</a>
                <button class="btn btn-primary" id="nexttab" type="button" style="width: 70px;margin-left: 20px;">Next</button>                   
                <br><br>                       
            </div>
            <div id="computers" class="tab-pane"><br>
                <div class="panel panel-default col-xs-offset-1" style="width:800px">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-sm-7">   
                               <strong>Number of Computer </strong>
                            </div>
                
                        </div>
                    </div><br>
                    <div class="row col-xs-offset-1">
                        <div class="col-lg-6">
                            <div class="input-group">
                              <input type="text" name="no_of_computers" id="no_of_computers" class="form-control" placeholder="Number of Computer">
                              <span class="input-group-btn">
                                <button class="btn btn-info" id="go"  onClick = "generateForm(); " type="button">Go!</button>
                              </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <div class="form-group" id="create">
                          <div class="clearfix"></div>
                          <div class = "col-xs-offset-1" id="my_div"><br><br></div>
                        </div> 
                    </div>
                </div>
                <a class="btn btn-primary btnPrevious1 col-md-offset-3" >Previous</a> &nbsp;&nbsp;&nbsp;&nbsp;
                <a class="btn  btn-close btn btn-primary" href="{{ url('/sales/vendors') }}">Cancel</a>
                <button class="btn btn-primary" id="next2tab" type="button" style="width: 70px;margin-left: 20px;" disabled="disabled">Next</button>
                <br><br>           
         </div>
            <div id="service" class="tab-pane fade"><br>
                 <div class="panel panel-default col-xs-offset-1" style="width:800px">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-sm-7">   
                               <strong>Service Type </strong>
                            </div>
                            <div class="col-sm-3">   
                               <strong> &nbsp;&nbsp;Yes </strong>
                            </div>
                
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col-sm-7">   
                            <div class="form-group col-xs-5">
                                <label class="control-label">POS</label>  
                            </div>
                        </div>
                        <div class="col-sm-3">   
                            <div class="form-group col-sm-2">
                                <input type="checkbox" class="form-control" name="pos1" id="pos1" value="Y">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-7">   
                            <div class="form-group col-xs-5">
                                <label class="control-label">Kiosk</label>  
                            </div>
                        </div>
                        <div class="col-sm-3">   
                            <div class="form-group col-sm-2">
                                <input type="checkbox" class="form-control" name="kiosk1" id="kiosk1" value="Y">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-7">   
                            <div class="form-group col-xs-5">
                                <label class="control-label">Mobile App</label>  
                            </div>
                        </div>
                        <div class="col-sm-3">   
                            <div class="form-group col-sm-2">
                                <input type="checkbox" class="form-control" name="mobile1" id="mobile1" value="Y">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-7">   
                            <div class="form-group col-xs-5">
                                <label class="control-label">Credit Card</label>  
                            </div>
                        </div>
                        <div class="col-sm-3">   
                            <div class="form-group col-sm-2">
                                <input type="checkbox" class="form-control" name="card1" id="card1" value="Y">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-7">   
                            <div class="form-group col-xs-5">
                                <label class="control-label">Web Store</label>  
                            </div>
                        </div>
                        <div class="col-sm-3">   
                            <div class="form-group col-sm-2">
                                <input type="checkbox" class="form-control" name="webstore1" id="store1" value="Y">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-7">   
                            <div class="form-group col-xs-5">
                                <label class="control-label">Portal</label>  
                            </div>
                        </div>
                        <div class="col-sm-3">   
                            <div class="form-group col-sm-2">
                                <input type="checkbox" class="form-control" name="portal1" id="portal1" value="Y">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-7">   
                            <div class="form-group col-xs-5">
                                <label class="control-label">PLCB Product</label>  
                            </div>
                        </div>
                        <div class="col-sm-3">   
                            <div class="form-group col-sm-2">
                                <input type="checkbox" class="form-control" name="plcb_product" id="plcb_product" value="Y">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-7">   
                            <div class="form-group col-xs-5">
                                <label class="control-label">PLCB Report</label>  
                            </div>
                        </div>
                        <div class="col-sm-3">   
                            <div class="form-group col-sm-2">
                                <input type="checkbox" class="form-control" name="plcb_report" id="plcb_report" value="Y">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-7">   
                            <div class="form-group col-xs-5">
                                <label class="control-label">License Expiry Date</label>  
                            </div>
                        </div>
                        <div class="col-sm-3">   
                            {!! Form::date('lexpdate', app('request')->input('lexpdate',\Carbon\Carbon::now()->addYear()),array('class'=>"form-control",'id'=>"lexpdate")) !!}
                        </div>
                    </div>
                </div>
                    <a class="btn btn-primary btnPrevious2 col-md-offset-3" >Previous</a> &nbsp;&nbsp;&nbsp;&nbsp;
                    <a class="btn  btn-close btn btn-primary" href="{{ url('/sales/vendors') }}">Cancel</a>
                    <button class="btn btn-primary" id="next3tab" type="button" style="width: 70px;margin-left: 20px;">Next</button>
                    <br><br>
            </div>
            <div id="user" class="tab-pane"><br>
                <div class="panel panel-default col-xs-offset-1" style="width:800px">
                    <div class="panel-heading">
                         <strong>Add User</strong>
                    </div><br>
                   <div class="row col-xs-offset-1">
                        <div class="form-group col-xs-5">
                            <div class="">
<!--                                {!! Form::select('userName[]',['0' => 'Select User'] + $user_array,null,['class'=>'form-control','multiple']) !!}<br>   
 -->                                  <button type="button" class="btn btn-info btn-md" data-toggle="modal" data-target="#myModal">Add User</button>
   
                             </div>
                        </div>
                    </div>
                </div>
                <a class="btn btn-primary btnPrevious3 col-md-offset-3" >Previous</a> &nbsp;&nbsp;&nbsp;&nbsp;
                <a class="btn  btn-close btn btn-primary" href="{{ url('/sales/vendors') }}">Cancel</a>
                <button class="btn btn-primary" id="next4tab" type="button" style="width: 70px;margin-left: 20px;">Next</button>
                <br><br> 
            </div>
            <div id="store" class="tab-pane"><br>
                <div class="panel panel-default col-xs-offset-1" style="width:800px">
                    <div class="panel-heading">
                         <strong>Store</strong>
                    </div><br>
                    <div class="row col-xs-offset-1" >
                        <div class="form-group col-xs-2">
                            <input type="checkbox" class="form-control multistore" id="multistores" name="multistore" value="Y"> <label>MultiStore</label> 
                        </div>
                        <div class="form-group col-xs-5" style="display:none" id="storeId">
                            <div class="">
                               {!! Form::select('storeName',['0' => 'Select Store'] + $store_array,null,['class'=>'form-control']) !!}<br>   
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="box-footer">
                       <div class="orm-group col-xs-5">
                         <a class="btn btn-primary btnPrevious4 col-md-offset-3" >Previous</a> &nbsp;&nbsp;&nbsp;
                         <a class="btn  btn-close btn btn-primary" href="{{ url('/sales/vendors') }}">Cancel</a>
                            <button type="submit" class="btn btn-primary" style="margin-left: 20px;" id="button">
                            <i class="fa fa-disk-o"></i>
                                Save 
                            </button>
                             <br><br>
                        </div>   
                    </div> 
                </div>
            </div>
        </div>
         {!! Form::close() !!}
    </div>
</section>  
<style type="text/css">
    .about_border {
    border-top: 1px solid black;
    height: 1px;
    margin: 15px auto 0;
    position: relative;
    width: 35%;
    padding-bottom: 60px;
}
.about_border:before {
    background-color: black;
    border: 1px ridge black;
    content: "";
    height: 10px;
    left: 50%;
    margin-left: -20px;
    position: absolute;
    top: -5px;
    width: 40px;
}
</style>
<script type="text/javascript">

    function generateForm() 
    { 
        var a = parseInt(document.getElementById("no_of_computers").value); 
        my_div.innerHTML = ""; 
        my_div.innerHTML = my_div.innerHTML + "<br><div class='row'><div class='form-group col-xs-5 col-md-offset-3 '><div class='row'><div class='col-md-2 '>Register</div><div class='col-md-3  col-md-offset-1 temp'>Kiosk</div><div class='col-md-3'>Server</div><div class='col-md-2'>&nbsp;Active</div></div></div></div></div>" 

        for(i=1;i<a+1;i++) 
        { 
          var randomnum = Math.random().toString(36).substr(2,8); 
          var color = getRandomColor();
          my_div.innerHTML = my_div.innerHTML + "<div class='row check_checkbox'><div class='col-md-3 temp'><div class='form-group'><label  class=\"control-label labeltext\">UID"+"</label><input type='text' id='uid_"+ i +"' class=\"form-control\" required name='uid_"+ i +"' value='10"+ i +"' readonly></div></div><div class='col-md-6 temp'><br><div class='row'><div class='col-md-2'><input type='checkbox' class='form-control' name='register_"+ i +"' id='register_"+ i +"' value='Y' onclick='selectOnlyThis(this.id)'></div><div class='col-md-3 temp'><input type='checkbox' class='form-control' name='kiosk_"+ i +"' id='register_"+ i +"' value='Y' onclick='selectOnlyThis(this.id)'></div><div class='col-md-2 temp'><input type='checkbox' class='form-control' name='server_"+ i +"' id='server_"+ i +"' value='Y'></div><div class='col-md-4 temp'><input type='hidden' class='form-control' name='hexa_"+ i +"' id='hexa_"+ i +"' value=\""+color+"\"  readonly></div><div class='col-md-3 '><input type='checkbox' disabled='disabled' class='form-control' name='status_"+ i +"' id='active' value='Y'></div></div></div>"  
       
        } 
        my_div.innerHTML = my_div.innerHTML
         show();
    }
    function getRandomColor() {
        var letters = '0123456789ABCDEF';
        var color = '';
        for (var i = 0; i < 6; i++ ) {
            color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
    }
    function selectOnlyThis(id) {
        $('input[type="checkbox"]').on('change', function() {
            $('input[id="' + this.id + '"]').not(this).prop('checked', false);
        });
    }

</script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $('input[name="multistore"]').on('ifChanged', function (e) {
        $(this).trigger("onclick", e);
         if($(this).prop("checked") == true){
             $('#storeId').css({'display':'block'});
         }
         else
         {
            $('#storeId').css({'display':'none'});
         } 
    });
    var $tabs = $('.container li');
    $('#nexttab').on('click', function () {

       if ($("#name").val().length == 0 ) {

            bootbox.alert({ 
                size: 'small',
                message: "Please Enter Store Name", 
                callback: function(){}
            });
            $("#name").focus();
            return false;
        }
        if ($("#business_name").val().length == 0 ) {
            bootbox.alert({ 
                size: 'small',
                message: "Please Enter Business Name", 
                callback: function(){}
            });
            $("#business_name").focus();
            return false;
        }
        if ($("#address").val().length == 0 ) {
            bootbox.alert({ 
                size: 'small',
                message: "Please Enter Address", 
                callback: function(){}
            });
            $("#address").focus();
            return false;
        }
        if ($("#city").val().length == 0 ) {
            bootbox.alert({ 
                size: 'small',
                message: "Please Enter City", 
                callback: function(){}
            });
            $("#city").focus();
            return false;
        }
        if ($("#state").find('option:selected').val() == 0 || $("#state").find('option:selected').val() == '') {
            bootbox.alert({ 
                size: 'small',
                message: "Please Select State", 
                callback: function(){}
            });
            $("#state").focus();
            return false;
        }
        if ($("#zip").val().length == 0 || !$("#zip").val().match(/^\d{5}$/)) {
            bootbox.alert({ 
                size: 'small',
                message: "Please Enter Valid Zip Code", 
                callback: function(){}
            });
            $("#zip").focus();
            return false;
        }
        if ($("#phone").val().length == 0 ) {
            bootbox.alert({ 
                size: 'small',
                message: "You must provide a phone number", 
                callback: function(){}
            });
            $("#phone").focus();
            return false;
        }
        if (!($("#phone").val().length  > 0 && ($("#phone").val()).match(/^\d{10}$/))) {
            bootbox.alert({ 
                size: 'small',
                message: "Invalid Phone Number", 
                callback: function(){}
            });
            $("#phone").focus();
            return false;
        }
        if ($("#contact_name").val().length == 0 ) {
            bootbox.alert({ 
                size: 'small',
                message: "Please Enter Contact Name", 
                callback: function(){}
            });
            $("#contact_name").focus();
            return false;
        }
        if ($("#description").val() != '' ) {
            if ($("#description").val().length >= 40 ) {
                bootbox.alert({ 
                    size: 'small',
                    message: "Description must less then 40 characters", 
                    callback: function(){}
                });
                $("#description").focus();
                return false;
            }
        }
        $tabs.filter('.active').next('li').find('a[href="#computers"]').tab('show');
    });
    $('#next2tab').on('click', function () {
        var val_tab = true;
        var server_check = false;

        var server_count = 0;
        $("#my_div div.check_checkbox").each(function(){
            if($(this).find('input[type="checkbox"]:eq(2)').prop("checked") == true){
                server_count++;
            }
        });

        if(server_count > 1 || server_count == 0){
            bootbox.alert({ 
                size: 'medium',
                message: "Must select only one server!!!", 
                callback: function(){ }
             });
            return false;
        }else{
            server_check = true;
        }

        if(server_check == true){
            $("#my_div div.check_checkbox").each(function(){
                var first_checkbox = false;
                var second_checkbox = false;

                if($(this).find('input[type="checkbox"]:eq(0)').prop("checked") == true){
                    first_checkbox = true;
                }
                if($(this).find('input[type="checkbox"]:eq(1)').prop("checked") == true){
                    second_checkbox = true;
                }

                if(first_checkbox == true && second_checkbox == true){
                    bootbox.alert({ 
                        size: 'medium',
                        message: "You Can't Select both Register and Kiosk !<br> Select only One", 
                        callback: function(){ }
                     });
                    val_tab = false;
                    return false;
                }
            });
        }
        if(val_tab == true){
            $tabs.filter('.active').next('li').find('a[href="#service"]').tab('show');
        }
    });
   /* $('#next3tab').on('click', function () {
        $tabs.filter('.active').next('li').find('a[href="#user"]').tab('show');
    });*/
    $('#next3tab').on('click', function () {
        //var created_date = '{!! date("Y-m-d") !!}';
        //var arr_created_date = created_date.split('-');
        //var arr_lexpdate = $('#lexpdate').val().split('-');

        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth()+1; 
        var yyyy = today.getFullYear()+1;
        if(dd<10) {
            dd='0'+dd;
        } 
        if(mm<10) {
            mm='0'+mm;
        }
        today = yyyy+'-'+mm+'-'+dd;
        var arr_lexpdate = $('#lexpdate').val();
        arr_lexpdate = new Date(arr_lexpdate);

        var dd1 = arr_lexpdate.getDate();
        var mm1 = arr_lexpdate.getMonth()+1; 
        var yyyy1 = arr_lexpdate.getFullYear();
        if(dd1<10) {
            dd1='0'+dd1;
        } 
        if(mm1<10) {
            mm1='0'+mm1;
        }
        arr_lexpdate = yyyy1+'-'+mm1+'-'+dd1;

        var d1 = Date.parse(today);
        var d2 = Date.parse(arr_lexpdate);
        
        if(d2 > d1){
            bootbox.alert({ 
                size: 'medium',
                message: "License Expiry Date Max 1 Year From Created Store", 
                callback: function(){ }
            });
            return false;
        }
        
        $tabs.filter('.active').next('li').find('a[href="#store"]').tab('show');
    });
    $('.btnPrevious1').click(function(){
          $('.nav-tabs > .active').prev('li').find('a[href="#basic_detail"]').tab('show');
    });
    $('.btnPrevious2').click(function(){
          $('.nav-tabs > .active').prev('li').find('a[href="#computers"]').tab('show');
    });
    $('.btnPrevious3').click(function(){
          $('.nav-tabs > .active').prev('li').find('a[href="#service"]').tab('show');
    });
    $('.btnPrevious4').click(function(){
          $('.nav-tabs > .active').prev('li').find('a[href="#user"]').tab('show');
    });

    $(document).on('click', '#button', function(event) {

        $('#modalwait').modal('show');
        
        // setTimeout(function(){
        //     $(this).attr('disabled', true);
        // }, 1000);
    });

});
</script>
<script type="text/javascript">
function show()
{
    document.getElementById("next2tab").disabled = false;
}
</script>

<!-- States  -->

<script src="{{ asset('/assets/js/states.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        var options = '';
        var options = '<option value="">Please Select State</option>';
        $.each(window.states, function(i, v) {
            options += '<option value="' + i + '">' + v + '</option>';
        });
        $('#state').append(options);
    });
</script>

<!-- States  -->

<!-- Zip code Validation  -->
<script type="text/javascript">
    $(document).on('change', '#zip', function(event) {
        event.preventDefault();
        if ($(this).val().length == 5 && $(this).val() != NaN) {
            var url = 'http://maps.googleapis.com/maps/api/geocode/json?address='+$(this).val()+'&sensor=true';
            $.getJSON(url, function(d) {
                if(d.status == 'OK'){
                    var add_str = d.results[0].formatted_address;
                    if(add_str.indexOf("USA") >= 0){
                        // console.log('country match');
                    }else{
                        bootbox.alert({ 
                            size: 'small',
                            message: "Please Enter USA Zip Code", 
                            callback: function(){}
                        });
                        $("#zip").focus();
                        return false;
                    }
                }else{
                    bootbox.alert({ 
                        size: 'small',
                        message: "Please Enter Valid Zip Code", 
                        callback: function(){}
                    });
                    $("#zip").focus();
                    return false;
                }
            });
        }else{
            bootbox.alert({ 
                size: 'small',
                message: "Please Enter Zip Code", 
                callback: function(){}
            });
            $("#zip").focus();
            return false;
        }
    });  
</script>
<!-- Zip code Validation  -->

<!-- Modal -->
  <div class="modal fade" id="modalwait" role="dialog" style="pointer-events: none;">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12 text-center text-warning">
                    <h3>Please Wait...</h3>
                </div>
            </div>
        </div>
      </div>
    </div>
  </div>

@stop