<aside class="left-side sidebar-offcanvas">
    <section class="sidebar">
        <div class="user-panel">
          
            <div class=" info" align="center">
                <p>{{ Auth::User()->fname}} {{ Auth::User()->lname}}</p>
            </div>
        </div>
       <ul class="sidebar-menu">
       @if(Auth::check()) 
        
        
        
        @foreach (Auth::user()->roles()->get() as $role)
            @if ($role->name == 'Admin')
                <li class="active">{{ (Request::is('/admin') ? 'class="active"' : '') }}
                    <a href="{{ url('/admin') }}">
                        <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                    </a>
                </li>
                <li class="active">
                     {{ (Request::is('/admin/users') ? 'class="active"' : '') }}
                        <a href="{{ url('/admin/users') }}">
                            <i class="fa fa-th"></i> Users
                        </a>
                </li>
                <li class="active">
                     {{ (Request::is('/admin/vendors') ? 'class="active"' : '') }}
                        <a href="{{ url('/admin/vendors') }}">
                            <i class="fa fa-th"></i> Stores
                        </a>
                </li>
                <li class="active hide">
                     {{ (Request::is('/admin/products') ? 'class="active"' : '') }}
                        <a href="{{ url('/admin/products') }}">
                            <i class="fa fa-th"></i> Products
                        </a>
                </li>
                
                <li class="active">
                     {{ (Request::is('/admin/charts') ? 'class="active"' : '') }}
                        <a href="{{ url('/admin/charts') }}">
                            <i class="fa fa-th"></i> Charts
                        </a>
                </li>
                
                
                @if(!empty(Session::get('selected_store_id')))
                    @if(\pos2020\Store::getSelectedStore()->plcb_product == 'Y')
                        <li class="active">
                             {{ (Request::is('/admin/plcb-products') ? 'class="active"' : '') }}
                                <a href="{{ url('/admin/plcb-products') }}">
                                    <i class="fa fa-th"></i> PLCB Products
                                </a>
                        </li>
                    @endif
                    @if(\pos2020\Store::getSelectedStore()->plcb_report == 'Y')
                        {{-- <li class="active">
                             {{ (Request::is('/admin/plcb-reports') ? 'class="active"' : '') }}
                                <a href="{{ url('/admin/plcb-reports') }}">
                                    <i class="fa fa-th"></i> PLCB Reports
                                </a>
                        </li> --}}
                    @endif
                @endif
            @endif
            @if($role->name == 'Vendor')
                @if(($role->name == 'Vendor') || ($role->name == 'Admin'))
                <li class="active">{{ (Request::is('/admin') ? 'class="active"' : '') }}
                    <a href="{{ url('/admin') }}">
                        <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                    </a>
                </li>
                @endif
                <li class="active">{{ (Request::is('/vendor/myProfile') ? 'class="active"' : '') }}
                    <a href="{{ url('/vendor/myProfile') }}">
                        <i class="fa fa-user"></i> <span>My Profile</span>
                    </a>
                </li>
                @if(($role->name == 'Vendor') || ($role->name == 'Admin'))
                <li class="active hide">
                     {{ (Request::is('/admin/products') ? 'class="active"' : '') }}
                        <a href="{{ url('/admin/products') }}">
                            <i class="fa fa-th"></i> Products
                        </a>
                </li>
                @endif
                 <li class="active">{{ (Request::is('/vendor/stores') ? 'class="active"' : '') }}
                    <a href="{{ url('/vendor/stores') }}">
                        <i class="fa fa-th"></i> <span>My Store</span>
                    </a>
                </li>
                @if(($role->name == 'Vendor') || ($role->name == 'Admin'))
                <li class="active">
                     {{ (Request::is('/admin/charts') ? 'class="active"' : '') }}
                        <a href="{{ url('/admin/charts') }}">
                            <i class="fa fa-th"></i> Charts
                        </a>
                </li>
                @endif
                @if(!empty(Session::get('selected_store_id')))
                    @if(\pos2020\Store::getSelectedStore()->plcb_product == 'Y')
                        <li class="active">
                             {{ (Request::is('/admin/plcb-products') ? 'class="active"' : '') }}
                                <a href="{{ url('/admin/plcb-products') }}">
                                    <i class="fa fa-th"></i> PLCB Products
                                </a>
                        </li>
                    @endif
                    @if(\pos2020\Store::getSelectedStore()->plcb_report == 'Y')
                        {{-- <li class="active">
                             {{ (Request::is('/admin/plcb-reports') ? 'class="active"' : '') }}
                                <a href="{{ url('/admin/plcb-reports') }}">
                                    <i class="fa fa-th"></i> PLCB Reports
                                </a>
                        </li> --}}
                    @endif
                @endif
                   
            @endif
            @if($role->name == 'Sales Executive')
                <li class="active">{{ (Request::is('/sales/vendors') ? 'class="active"' : '') }}
                    <a href="{{ url('/sales/vendors') }}">
                        <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                    </a>
                </li>
                <li class="active">
                     {{ (Request::is('/sales/users') ? 'class="active"' : '') }}
                        <a href="{{ url('/sales/users') }}">
                            <i class="fa fa-th"></i> Users
                        </a>
                </li>
                 <li class="active">
                     {{ (Request::is('/sales/vendors') ? 'class="active"' : '') }}
                        <a href="{{ url('/sales/vendors') }}">
                            <i class="fa fa-th"></i> Stores
                        </a>
                </li>
            @endif
            @if($role->name == 'Sales Admin')
                <li class="active">
                     {{ (Request::is('/sales/users') ? 'class="active"' : '') }}
                        <a href="{{ url('/sales/users') }}">
                            <i class="fa fa-th"></i> Users
                        </a>
                </li>n
                <li class="active">
                     {{ (Request::is('/sales/users') ? 'class="active"' : '') }}
                        <a href="{{ url('/sales/vendors') }}">
                            <i class="fa fa-th"></i> Stores
                        </a>
                </li>
                <li class="active">
                     {{ (Request::is('/sales/users') ? 'class="active"' : '') }}
                        <a href="{{ url('/sales/agentoffice') }}">
                            <i class="fa fa-th"></i> Agent Office
                        </a>
                </li>
            @endif
            @if($role->name == 'Sales Manager')
                <li class="active">
                     {{ (Request::is('/sales/users') ? 'class="active"' : '') }}
                        <a href="{{ url('/sales/users') }}">
                            <i class="fa fa-th"></i> Users
                        </a>
                </li>
                <li class="active">
                     {{ (Request::is('/sales/users') ? 'class="active"' : '') }}
                        <a href="{{ url('/sales/vendors') }}">
                            <i class="fa fa-th"></i> Stores
                        </a>
                </li>
            @endif
            @if($role->name == 'Sales Agent')
                <li class="active">
                     {{ (Request::is('/sales/users') ? 'class="active"' : '') }}
                        <a href="{{ url('/sales/users') }}">
                            <i class="fa fa-th"></i> Users
                        </a>
                </li>
                 <li class="active">
                     {{ (Request::is('/sales/vendors') ? 'class="active"' : '') }}
                        <a href="{{ url('/sales/vendors') }}">
                            <i class="fa fa-th"></i> Stores
                        </a>
                </li>
            @endif
            @if($role->name == 'Store Manager')
               @if(($role->name == 'Admin') || ($role->name == 'Store Manager'))
                <li class="active">{{ (Request::is('/admin') ? 'class="active"' : '') }}
                    <a href="{{ url('/admin') }}">
                        <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                    </a>
                </li>
                @endif
                <li class="active">
                     {{ (Request::is('/sales/vendors') ? 'class="active"' : '') }}
                        <a href="{{ url('/sales/vendors') }}">
                            <i class="fa fa-th"></i> Stores
                        </a>
                </li>
                @if(($role->name == 'Store Manager') || ($role->name == 'Vendor'))
                <li class="active">{{ (Request::is('/vendor/myProfile') ? 'class="active"' : '') }}
                    <a href="{{ url('/vendor/myProfile') }}">
                        <i class="fa fa-user"></i> <span>My Profile</span>
                    </a>
                </li>
                @endif
                @if(($role->name == 'Store Manager') || ($role->name == 'Admin'))
                 <li class="active">
                     {{ (Request::is('/admin/charts') ? 'class="active"' : '') }}
                        <a href="{{ url('/admin/charts') }}">
                            <i class="fa fa-th"></i> Charts
                        </a>
                </li>
                @endif
            @endif
        @endforeach
        
        @if (Auth::user()->id == 1 || Auth::user()->id == 4)
            <li class="active">
                    <a href="{{ url('/admin/npl-list') }}">
                        <i class="fa fa-dashboard"></i> <span>NPL</span>
                    </a>
            </li>
            
        @endif        
        
        
    @endif
    </ul> 
</section>
</aside>
