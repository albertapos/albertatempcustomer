@extends('main')
@section('content')
<section class="content-header">
	<h1>
	   PLCB Product Reports
	</h1>
	<ol class="breadcrumb">
	</ol>
</section><br>
<div class="col-md-12">
		  @include('layouts.partials.errors')
		  @include('layouts.partials.flash')
		  @include('layouts.partials.success')
</div>
<section class="content">
	<div class="container" style="width:100%;">
        <div class="row">
          <div class="col-md-12 text-right">
            <a href="{{ url('admin/plcb-reports-pdf') }}" class="btn btn-success">Generate Report</a>
          </div>
        </div><br>
        <div class="panel panel-default">
            <div class="panel-heading text-center"><b>PLCB Product Reports</b></div>
            <div class="panel-body">
                <div class="alert alert-info">
                    <div class="row">
                        <div class="col-md-4">
                           <span><b>Date: </b>{{\Carbon\Carbon::now()->setTimezone('EST')->toFormattedDateString()}}</span>
                       </div>
                       <div class="col-md-4">
                           <span><b>Report Month: </b> {{\Carbon\Carbon::now()->setTimezone('EST')->subMonth()->format('F, Y')}}</span>
                       </div>
                       <div class="col-md-4">
                           <span><b>Store Name: </b>{{Session::get('selected_store_title')}} </span>
                       </div>
                    </div>
               </div><br>
               <div class="row">
                   <div class="col-md-12">
                        @if(count($main_bucket_arr) > 0)

                          <?php
                            foreach($buckets as $bucket){
                              ${'bucket_id_total'.$bucket->id} = 0 ;
                            }
                            $v_row_total = 0;
                          ?>

                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                       <th class="text-center" >Description</th>
                                       @foreach($buckets as $bucket)
                                        <th class="text-center" >{{$bucket->bucket_name}}</th>
                                       @endforeach
                                        <th class="text-center">Row Total</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                        <tr>
                                        <td><b>Inventory Beginning of Month</b></td>
                                        <?php $row_total = 0;?>
                                          @foreach($buckets as $bucket)
                                          <?php $not_bucket = false; ?>
                                            @foreach($main_bucket_arr as $bucket_arr)
                                              @if($bucket->id == $bucket_arr['bucket_id'])
                                                <td>{{$bucket_arr['tot_qty']}}</td>
                                                <?php 
                                                  $row_total = $row_total + $bucket_arr['tot_qty'];
                                                  ${'bucket_id_total'.$bucket->id} = ${'bucket_id_total'.$bucket->id} + $bucket_arr['tot_qty'];

                                                  $not_bucket = false;
                                                  break;
                                                ?>
                                              @else
                                                <?php $not_bucket = true; ?>
                                              @endif
                                            @endforeach
                                            @if($not_bucket == true)
                                              <td>0</td>
                                            @endif
                                          @endforeach
                                        <td>
                                          {{$row_total}}
                                          <?php $v_row_total = $v_row_total + $row_total;  ?>
                                        </td>
                                        </tr>
                                        <tr>
                                          <td><b>Schedule A</b></td>
                                          <?php $schedule_a_h_total = 0; ?>
                                          @foreach($buckets as $bucket)
                                          <?php 
                                            $schedule_a_h_total = $schedule_a_h_total + $schedule_a[$bucket->id];
                                            ${'bucket_id_total'.$bucket->id} = ${'bucket_id_total'.$bucket->id} + $schedule_a[$bucket->id];

                                          ?>
                                          <td>{{$schedule_a[$bucket->id]}}</td>
                                          @endforeach
                                          <td>
                                            {{$schedule_a_h_total}}
                                            <?php $v_row_total = $v_row_total + $schedule_a_h_total;  ?>
                                          </td>
                                        </tr>
                                        <tr>
                                          <td><b>Total</b></td>
                                            @foreach($buckets as $bucket)
                                              <td>{{ ${'bucket_id_total'.$bucket->id} }}</td>
                                            @endforeach
                                          <td>{{$v_row_total}}</td>
                                        </tr>
                                        <tr>
                                          <td><b>Inventory at End of Month</b></td>
                                            <?php $int_end_mon_total = 0; ?>
                                            @foreach($buckets as $bucket)
                                              <?php 
                                              $int_end_mon_total = $int_end_mon_total + $main_bucket_arr_end[$bucket->id];
                                              ?>
                                              <td>{{ $main_bucket_arr_end[$bucket->id] }}</td>
                                            @endforeach
                                          <td>{{$int_end_mon_total}}</td>
                                        </tr>
                                        <tr>
                                          <td><b>Balance to be Accounted for</b></td>
                                            
                                            @foreach($buckets as $bucket)
                                              <?php
                                              if($main_bucket_arr_end[$bucket->id] < 0){
                                                $temp_accounted = -($main_bucket_arr_end[$bucket->id]);
                                              }else{
                                                  $temp_accounted = $main_bucket_arr_end[$bucket->id];
                                              }

                                                $bal_ac = ${'bucket_id_total'.$bucket->id} - $temp_accounted;
                                              ?>
                                              <td>{{ $bal_ac }}</td>
                                            @endforeach
                                          <td>{{$v_row_total - $int_end_mon_total}}</td>
                                        </tr>
                                        <tr>
                                          <td><b>Sales of Malt Beverage</b></td>
                                            <?php $malt_h_total = 0; ?>
                                            @foreach($buckets as $bucket)
                                              <?php 
                                                $malt_h_total = $malt_h_total + $main_bucket_arr_malt[$bucket->id];
                                              ?>
                                              <td>{{$main_bucket_arr_malt[$bucket->id]}}</td>
                                            @endforeach
                                          <td>{{$malt_h_total}}</td>
                                        </tr>
                                </tbody>
                            </table>
                        @else
                            <div class="col-md-12">
                               <div class="alert alert-danger">
                                  Sorry no product found!!!
                                </div>
                           </div>
                        @endif
                        
                        <br><br>

                        @if(count($main_supplier_arr) > 0)

                        <?php 
                          foreach($buckets as $bucket){
                              ${'bucket_id_total_sup'.$bucket->id} = 0 ;
                            }
                            $v_row_total_sup = 0;
                        ?>
                          <table class="table table-bordered">
                            <thead>
                                    <tr>
                                       <th class="text-center" >Name and Address of Importing Distributors</th>
                                       @foreach($buckets as $bucket)
                                        <th class="text-center" >{{$bucket->bucket_name}}</th>
                                       @endforeach
                                        <th class="text-center">Row Total</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                  @foreach($main_supplier_arr as $k => $main_supplier_array)
                                    @if(count($main_supplier_array) > 0)
                                    <tr>
                                        <td><b>{{$main_supplier_array[0]['supplier_name']}}</b></td>
                                        <?php $sup_row_total = 0;?>
                                        @foreach($buckets as $bucket)
                                           <?php $sup_not_bucket = false; ?>
                                          @foreach($main_supplier_array as $supplier_array)
                                            @if($bucket->id == $supplier_array['bucket_id'])
                                              <td>{{$supplier_array['tot_qty']}}</td>
                                              <?php 
                                              $sup_row_total = $sup_row_total + $supplier_array['tot_qty'];

                                              ${'bucket_id_total_sup'.$bucket->id} = ${'bucket_id_total_sup'.$bucket->id} + $supplier_array['tot_qty'];

                                              $sup_not_bucket = false;
                                              break;
                                            ?>
                                            @else
                                              <?php $sup_not_bucket = true; ?>
                                            @endif
                                          @endforeach
                                          @if($sup_not_bucket == true)
                                            <td>0</td>
                                          @endif
                                        @endforeach
                                        <td>
                                          {{$sup_row_total}}
                                          <?php $v_row_total_sup = $v_row_total_sup + $sup_row_total;  ?>
                                        </td>
                                    </tr>
                                    @endif
                                  @endforeach
                                  <tr>
                                    <td><b>Total Purchases from Importing Distributors (Schedule A)</b></td>
                                      @foreach($buckets as $bucket)
                                        <td>{{ ${'bucket_id_total_sup'.$bucket->id} }}</td>
                                      @endforeach
                                    <td>{{$v_row_total_sup}}</td>
                                  </tr>
                                </tbody>
                          </table>
                        @else
                          <div class="col-md-12">
                               <div class="alert alert-danger">
                                  Sorry no supplier product found !!!
                                </div>
                           </div>
                        @endif
                    </div>
               </div> 
            </div>
            <br>
      </div>
	</div>  
</section>  
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>


@stop