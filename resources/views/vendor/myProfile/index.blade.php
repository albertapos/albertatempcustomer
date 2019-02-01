@extends('main')
@section('content')
<div class="col-md-12">
 
</div>
<section class="content-header">
   <h1>
      Profile Detail
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/admin') }}"><i class="fa fa-dashboard"></i> Home</a></li>
    </ol>
</section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                   <!--  <div class="box-header">
                        <h3 class="box-title">Users</h3>
                    </div><!-- /.box-header --> 
                    <div class="box-body table-responsive no-padding">
                        <div class="panel panel-default" style="margin-left: 57px;margin-right: 72px;">
                            <div class="">
                                <div class="row">
                                    <div class="text-center custom_title " >
                                        <h4>My Profile<span class="custom_color"></span></h4>
                                        <div class="about_border"></div>
                                    </div>
                                </div>
                            </div><br>
                            @foreach ($myProfile as $profile)
                            <div class="row" style="margin-left:70px">
                                <div class="form-group col-sm-5" style="font-weight: bold" > 
                                  Id
                                </div>
                                <div class=" form-group col-sm-5" style="text-weight-normal"> 
                                   {{ $profile->id }}
                                </div>
                                <div class="form-group col-sm-5" style="font-weight: bold"> 
                                    Name
                                </div>
                                <div class="form-group col-sm-5"> 
                                  {{ $profile->fname }} {{ $profile->lname }}
                                </div>
                                 <div class="form-group col-sm-5" style="font-weight: bold"> 
                                    Phone
                                </div>
                                <div class="form-group col-sm-5"> 
                                  {{ $profile->phone }} 
                                </div>
                                 <div class="form-group col-sm-5" style="font-weight: bold"> 
                                    Email
                                </div>
                                <div class="form-group col-sm-5"> 
                                  {{ $profile->email }}
                                </div>
                            </div> 
                            <div class="panel-footer">
                            <div class="row">
                                     <div class="col-sm-9" align="center">   
                                            <a href="/vendor/myProfile/{{ $profile->id }}/edit"
                                               align="center">

                                            <input class="btn btn btn-primary" style="margin-left: 20px;" type="button" value="Edit">
                                            
                                        </a>
                                     </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                        <!-- <table class="table table-hover">
                            <tr>
                                <tr>
                                    <th>ID</th>
                                    <th>Created</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Updated</th>
                                    <th colspan="2">&nbsp;&nbsp;&nbsp;Actions</th>
                                </tr>
                            </tr>
                             @foreach ($myProfile as $profile)
                            <tr>
                                <td>{{ $profile->id }}</td>
                                <td>{{ $profile->created_at->format('j-M-y g:ia') }}</td>
                                <td>{{ $profile->fname }} {{ $profile->lname }}</td>
                                <td>{{ $profile->phone }}</td>
                                <td>{{ $profile->email }}</td>
                                <td>{{ $profile->updated_at->format('j-M-y g:ia') }}</td>
                                 <td>
                                    <a href="/vendor/myProfile/{{ $profile->id }}/edit"
                                    class="btn btn-xs btn-info">
                                        <i class="fa fa-pencil"></i> 
                                    </a>
                                </td>
                            </tr>
                           @endforeach
                        </table> -->
                    </div><!-- /.box-body -->
            </div>
        </div>  
    </section>   
    <style type="text/css">
    .about_border {
        border-top: 1px solid black;
        height: 1px;
        margin: 15px auto 0;
        position: relative;
        width: 97%;
        padding-bottom: 16px;
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
    .custom_title h4 {
        text-transform: uppercase;
        font-weight: 700;
        font-size: 20px;
        color: #111;
    }
    .labeltext {
        float: left;
    }
    .label {
        display: inline-block;
        max-width: 100%;
        margin-bottom: 5px;
        font-weight: 700;
    }
    </style>       

  @stop