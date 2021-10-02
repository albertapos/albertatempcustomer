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
            @if ($role->name == 'SuperAdmin')
                <li class="active">{{ (Request::is('/admin') ? 'class="active"' : '') }}
                    <a href="{{ url('/admin') }}">
                        <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                    </a>
                </li>
                
                <li class="active">
                     {{ (Request::is('/admin/users') ? 'class="active"' : '') }}
                        <a href="{{ url('/admin/users') }}">
                            <i class="fa fa-users"></i> Users
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
                     {{ (Request::is('/admin/systemOption') ? 'class="active"' : '') }}
                        <a href="{{ url('/admin/systemOption') }}">
                            <i class="fa fa-sliders"></i> System Option
                        </a>
                </li>
                <li class="active">
                     {{ (Request::is('/admin/charts') ? 'class="active"' : '') }}
                        <a href="{{ url('/admin/charts') }}">
                            <i class="fa fa-th"></i> Charts
                        </a>
                </li>
                
                
                @if(!empty(Session::get('selected_store_id')))
                    @if(isset(\pos2020\Store::getSelectedStore()->plcb_product) && \pos2020\Store::getSelectedStore()->plcb_product == 'Y')
                        <li class="active">
                             {{ (Request::is('/admin/plcb-products') ? 'class="active"' : '') }}
                                <a href="{{ url('/admin/plcb-products') }}">
                                    <i class="fa fa-th"></i> PLCB Products
                                </a>
                        </li>
                    @endif
                    @if(isset(\pos2020\Store::getSelectedStore()->plcb_product) && \pos2020\Store::getSelectedStore()->plcb_report == 'Y')
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
                @if(($role->name == 'Vendor') || (SuperAdmin))
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
                @if(($role->name == 'Vendor') || ($role->name == 'SuperAdmin'))
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
                @if(($role->name == 'Vendor') || ($role->name == 'SuperAdmin'))
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
                            <i class="fa fa-users"></i> Users
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
                            <i class="fa fa-users"></i> Users
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
                            <i class="fa fa-users"></i> Users
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
                            <i class="fa fa-users"></i> Users
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
               @if(($role->name == 'SuperAdmin') || ($role->name == 'Store Manager'))
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
                @if(($role->name == 'Store Manager') || ($role->name == 'SuperAdmin'))
                 <li class="active">
                     {{ (Request::is('/admin/charts') ? 'class="active"' : '') }}
                        <a href="{{ url('/admin/charts') }}">
                            <i class="fa fa-th"></i> Charts
                        </a>
                </li>
                @endif
            @endif
        @endforeach
        
        @if ($role->name == 'SuperAdmin')
        
            <?php
                
                $is_npl_menu = false;
            
                if (strpos($_SERVER['REQUEST_URI'], '/admin/npl') !== false) {
                    $is_npl_menu = true;
                }
            ?>
            
            @if($is_npl_menu)
                <li class="active" data-target="#nplMenu" data-toggle="collapse" style="cursor: pointer;">
            @else
                <li class="active collapsed" data-target="#nplMenu" data-toggle="collapse" style="cursor: pointer;">
            @endif
        
                
                
                    <!-- <a href="{{ url('/admin/npl-list') }}"><i class="fa fa-th"></i> <span>NPL</span></a> -->
                    
                    <a class="parent active">  
                        <i class="fa fa-list-alt"></i> 
                        <span>NPL</span>
                    </a>
            
                    @if($is_npl_menu)
                        <ul id='nplMenu'  class="sidebar-menu collapse in">
                    @else
                        <ul id='nplMenu'  class="sidebar-menu collapse">
                    @endif
                    
                      <li class="active"><a href="{{ url('/admin/npl-list') }}"><?php echo "Items"; ?></a></li>      
                      <li><a href="{{ url('/admin/npl/departments') }}"><?php echo "Departments"; ?></a></li>
                      <li><a href="{{ url('/admin/npl/categories') }}"><?php echo "Categories"; ?></a></li>
                      <li><a href="{{ url('/admin/npl/subcategories') }}"><?php echo "Sub-categories"; ?></a></li>
                      <li><a href="{{ url('/admin/npl/manufacturers') }}"><?php echo "Manufacturers"; ?></a></li>
                      <li><a href="{{ url('/admin/npl/units') }}"><?php echo "Units"; ?></a></li>
                      <li><a href="{{ url('/admin/npl/sizes') }}"><?php echo "Sizes"; ?></a></li>
                      <li><a href="{{ url('/admin/npl/transfer') }}"><?php echo "Data Transfer"; ?></a></li>

                    </ul>
                    
            </li>
            <li class="active">
                    <a href="{{ url('/admin/newskus') }}">
                        <i class="fa fa-th"></i> <span>Newly Added SKUs</span>
                    </a>
            </li>
            <li class="active">
                    <a href="{{ url('/newsupdate') }}">
                        <i class="fa fa-th"></i> <span>News Update</span>
                    </a>
            </li>
            
        @endif       
        
        
    @endif
    </ul> 
</section>
</aside>
