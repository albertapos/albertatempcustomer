<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>AlbertaInc | Log in</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="{{ asset('assets/css/AdminLTE.css') }}" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <div class="form-box" id="login-box">
            <div class="box box-primary" style="margin-top: -47px!important;">
                <div class="box-header">
                    <h3 class="box-title">Account Login</h3>
                </div>
                <form role="form" method="POST" action="{{ url('/login') }}">
                    <div class="box-body">

                        <div class="form-group">
                            @include('layouts.partials.errors')
                            @include('layouts.partials.flash')
                            @include('layouts.partials.success')
                        </div>

                        <div class="input-group">
                            <span class="input-group-addon">&nbsp;<i class="fa fa-user"></i></span>
                            <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="User ID">
                        </div>
                        <div>
                            &nbsp;
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-key"></i></span>
                            <input type="password" name="password" class="form-control" placeholder="Password"/>
                        </div>                                                      
                        <div>
                            &nbsp;<h6 class="text-danger box-title-small" ></h6>
                           <span id="feedback"><h6 class="text-info"></h6></span>                              
                        </div>                                                                                  
                         <button type="submit" class="btn btn-primary " id="login" >Sign me in</button>  
                    </div>
                </form>
            </div>
        </div>

        @include('layouts.footer')
