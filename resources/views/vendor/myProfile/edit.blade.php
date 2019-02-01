@extends('main')
@section('content')
<section class="content-header">
  <h1>
     Profile Edit
  </h1>
</section><br>
  <div class="col-md-12">
        @include('layouts.partials.errors')
        @include('layouts.partials.flash')
        @include('layouts.partials.success')
  </div>
    <section class="content">
    <div class="row">
      <div class="col-xs-12">
          <div class="box">
              <div class="box-body col-xs-offset-1">
                    {!! Form::open(['files'=> true, 'method'=>'put','url'=>['vendor/myProfile', $myProfile->id]]) !!}
                    <div class="row">
                       <div class="form-group col-xs-5">
                            <label class="control-label">First Name</label>
                            <div class="">
                                <input type="text" class="form-control" name="fname" value="{{ $myProfile->fname }}" readonly>
                            </div>
                        </div>
                        <div class="form-group col-xs-5">
                            <label class="control-label">Last Name</label>
                            <div class="">
                                <input type="text" class="form-control" name="lname" value="{{ $myProfile->lname }}" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-xs-5">
                            <label class="control-label">Phone</label>
                            <div class="">
                                <input type="text" class="form-control" name="phone" value="{{ $myProfile->phone }}">
                            </div>
                        </div>

                        <div class="form-group col-xs-5">
                            <label class="control-label">E-Mail Address</label>
                            <div class="">
                                <input type="email" class="form-control" name="email" value="{{ $myProfile->email }}" >
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-xs-5">
                            <label class="control-label">Password</label>
                            <div class="">
                                <input type="password" class="form-control" name="password">
                            </div>
                        </div>

                        <div class="form-group col-xs-5">
                            <label class="control-label">Confirm Password</label>
                            <div class="">
                                <input type="password" class="form-control" name="password_confirmation">
                            </div>
                        </div>
                    </div><br>
                    <div class="box-footer">
                        <div class="col-md-offset-4">
                          <button type="submit" class="btn btn-primary btn-md">
                            Save
                          </button>
                          <a class="btn  btn-close btn btn-primary" style="margin-left: 20px;" href="{{ url('/vendor/myProfile') }}">Cancel</a><br><br>

                        </div>
                    </div><br><br><br><br>
            {!! Form::close() !!}
                </div>
          </div><!-- /.box -->
      </div>
    </div>  
    </section>          
     <script type="text/javascript">
     console.log(document.getElementById('role').value);

     if(document.getElementById('role').value == 2){
        document.getElementById('hidden_div').style.display = "block";
     }
        
      </script>
  @stop