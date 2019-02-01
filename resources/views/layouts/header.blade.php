<header class="header">
    <a href="#" class="logo">
        <img src="{{ asset('assets/img/Alberta POS_Logo.png') }}" heigh="60px" width="50px"/>
    </a>
    <nav class="navbar navbar-static-top" role="navigation">
        <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>
        @if(Auth::user()->roles()->first()->name == 'Admin' || Auth::user()->roles()->first()->name == 'Vendor')
                
                <?php
                    $haystack = Request::url();
                    $needle = 'npl';
                ?>
                @if (strpos($haystack, $needle) !== false)
                    <span class="store_head_title">National Product List</span>
                @else
                    <!-- Jignesh's code -->
                    <span class="store_head_title">{{ Session::get('selected_store_title') }}</span>
                @endif
                
        @endif
        <div class="navbar-right">
            <ul class="nav navbar-nav">
               <li class="dropdown messages-menu">
                @if(Auth::check()) 
                    @foreach (Auth::user()->roles()->get() as $role)
                        @if ($role->name == 'Sales Executive')
                        @elseif ($role->name == 'Sales Admin')
                        @elseif ($role->name == 'Sales Manager')
                        @elseif ($role->name == 'Sales Agent')
                        @elseif ($role->name == 'Store Clerk')
                        @elseif ($role->name == 'Kiosk Admin')
                        @else
                            <a href="#" class="dropdown-toggle bg-customer" data-toggle="dropdown">
                                  {{ Session::get('selected_store_title')}} [{{ Session::get('selected_store_id')}}] &nbsp;&nbsp;
                                  <i class="fa fa-building-o"></i>
                            </a>
                             
                            <ul class="dropdown-menu">
                                <li class="header"> <strong>&nbsp;&nbsp;Select Store From Here</strong></li>
                                <li>
                                    <ul class="menu">
                                        <?php 
                                            $stores = array();
                                            if ($role->name == 'Vendor' || $role->name == 'Store Manager') {

                                                $stores_data = Auth::user()->store()->get()->toArray();
                                                if(count($stores_data) > 0 ) {
                                                    unset($store_array);
                                                    foreach($stores_data as $k=>$v){
                                                        $store_array[$v['id']] = $v['name'];
                                                    }
                                                }
                                            }
                                        ?>
                                        @foreach($store_array as $key=>$store) 
                                            <li> 
                                                <a href="{{ url('admin/changeStore',$key) }}">
                                                    <h4 class="">
                                                       <input type="hidden" name="store" value='{{ $key }}'> {{ $store }} [{{$key}}]
                                                    </h4>
                                                </a>
                                            </li>
                                        @endforeach 
                                    </ul>
                                </li>
                            </ul> 
                            @endif
                        @endforeach
                    @endif
                </li>
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="glyphicon glyphicon-user"></i>
                        <span>{{ Auth::User()->fname}} {{ Auth::User()->lname}}<i class="caret"></i></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="user-header bg-light-blue">
                            <p>
                                {{ Auth::User()->fname}} {{ Auth::User()->lname}}
                            </p>
                        </li>
                        <li class="user-footer">
                            <div  align="center">
                                <a href="{{url('/auth/logout')}}" class="btn btn-default btn-flat">Sign out</a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>
