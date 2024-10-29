<div class="page-sidebar toggled sidebar">
      <nav class="sidebar-collapse d-none d-lg-block">
        <i class="ion ion-ios-arrow-forward show-on-collapsed"></i>
        <i class="ion ion-ios-arrow-back hide-on-collapsed"></i>
      </nav>
      <div id="dynamic_left_sidear">
      <ul class="nav nav-pills nav-stacked" id="sidebar-stacked">
        <li class="d-lg-none">
          <a href="#" class="sidebar-close"><i class="ion ion-ios-arrow-left"></i></a>
        </li>

         @if($smodule_id==0)
        <li class="nav-item active">
          <a class="nav-link" href="index.html"><i class="ion ion-ios-home"></i> <span class="nav-text">Dashboard</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-container" data-toggle="collapse" data-parent="#sidebar-stacked" href="#p1">
            <i class="ion ion-ios-flask"></i> <span class="nav-text">User Interface <span class="badge badge-pill badge-nav badge-warning">6</span></span>
          </a>
          <ul class="nav nav-pills nav-stacked collapse" id="p1">
            <li class="nav-item"><a class="nav-link" href="ui-buttons.html">Buttons</a></li>
            <li class="nav-item"><a class="nav-link" href="ui-grid.html">Grid</a></li>
            <li class="nav-item"><a class="nav-link" href="ui-typography.html">Typography</a></li>
            <li class="nav-item"><a class="nav-link" href="ui-icons.html">Icons</a></li>
            <li class="nav-item"><a class="nav-link" href="ui-images.html">Images</a></li>
            <li class="nav-item"><a class="nav-link" href="ui-components.html">Components</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-container dropdown-toggle" data-toggle="collapse" data-parent="#sidebar-stacked" href="#p2">
            <i class="ion ion-ios-pie"></i> <span class="nav-text">Charts</span>
          </a>
          <ul class="nav nav-pills nav-stacked collapse" id="p2">
            <li class="nav-item"><a class="nav-link" href="chart-flot.html">Flot Chart</a></li>
            <li class="nav-item"><a class="nav-link" href="chart-morris.html">Morris Chart</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-container" data-toggle="collapse" data-parent="#sidebar-stacked" href="#p3">
            <i class="ion ion-ios-copy"></i> <span class="nav-text">Custom Pages <span class="badge badge-pill badge-nav badge-warning">4</span></span>
          </a>
          <ul class="nav nav-pills nav-stacked collapse" id="p3">
            <li class="nav-item"><a class="nav-link" href="page-login.html">Login</a></li>
            <li class="nav-item"><a class="nav-link" href="page-register.html">Register</a></li>
            <li class="nav-item"><a class="nav-link" href="page-reset-password.html">Reset Password</a></li>
            <li class="nav-item"><a class="nav-link" href="page-lock-screen.html">Lock Screen</a></li>
            <li class="nav-item"><a class="nav-link" href="page-blank.html">Blank Page</a></li>
            <li class="nav-item"><a class="nav-link" href="page-error-404.html">404 Page</a></li>
            <li class="nav-item"><a class="nav-link" href="page-error-500.html">500 Page</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-container dropdown-toggle" data-toggle="collapse" data-parent="#sidebar-stacked" href="#p4">
            <i class="ion ion-ios-paper"></i> <span class="nav-text">Forms</span>
          </a>
          <ul class="nav nav-pills nav-stacked collapse" id="p4">
            <li class="nav-item"><a class="nav-link" href="form-elements.html">Form Elements</a></li>
            <li class="nav-item"><a class="nav-link" href="form-validation.html">Form Validation</a></li>

            <li class="nav-item"><a class="nav-link" href="form-summernote.html">Summernote</a></li>
          </ul>
        </li>

         <li class="nav-item">
          <a class="nav-container dropdown-toggle" data-toggle="collapse" data-parent="#sidebar-stacked" href="#p5}">
            <i class="ion ion-ios-list"></i> <span class="nav-text">Tables</span>
          </a>
          <ul class="nav nav-pills nav-stacked collapse" id="p5">
            <li class="nav-item"><a class="nav-link" href="table-basic.html">Basic Table</a></li>
            <li class="nav-item"><a class="nav-link" href="table-data.html">Data Table</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-container" href="calendar.html">
            <i class="ion ion-ios-calendar"></i> <span class="nav-text">Calendar</span>
          </a>
        </li>

      
        <li class="nav-item">
          <a class="nav-container dropdown-toggle" data-toggle="collapse" data-parent="#sidebar-stacked" href="#p6">
            <i class="ion ion-ios-location"></i> <span class="nav-text">Maps</span>
          </a>
          <ul class="nav nav-pills nav-stacked collapse" id="p6">
            <li class="nav-item"><a class="nav-link" href="map-google.html">Google Maps</a></li>
            <li class="nav-item"><a class="nav-link" href="map-vector.html">Vector Maps</a></li>
          </ul>
        </li>  

 @else
        @php

              $moduleSl=1;
             // echo "<pre>";
              // print_r($module);die;
         @endphp


      @if($smodule_id!="")

         

            @foreach ($rootMenu as $rmenu=> $rootmenu_value)
              

              @if(!empty($root_menu_arr[$rootmenu_value->id]))
                  <li class="nav-item"> 

                  @if($sroot_menu_id==$rootmenu_value->id)                       
                    <a class="nav-container " data-toggle="collapse" data-parent="#sidebar-stacked" href="#p{{ $moduleSl}}" aria-expanded="true">
                      <i class="ion ion-ios-list"></i> <span class="nav-text">{{ $rootmenu_value->menuName }}44</span>
                    </a>
                       <ul class="nav nav-pills nav-stacked collapse show" id="p{{ $moduleSl}}"> 

                  @else

                     <a class="nav-container collapse" data-toggle="collapse" data-parent="#sidebar-stacked" href="#p{{ $moduleSl}}" aria-expanded="false">
                      <i class="ion ion-ios-list"></i> <span class="nav-text">{{ $rootmenu_value->menuName }}</span>
                    </a>
                       <ul class="nav nav-pills nav-stacked collapse" id="p{{ $moduleSl}}"> 

                  @endif 
                          @foreach ($menu as $index=> $menu_value)
                              @if($rootmenu_value->id==$menu_value->rootMenu)
                                  @if($menu_value->id==$smenu_id)
                                             
                                      <li class="nav-item active">

                                        <a class="nav-link" href="{!! url('/').'/'.$menu_value->menuRoute !!}" >22</a></li>
                                
                                  @else  
                                               
                                      <li class="nav-item">
                                        <!-- <a class="nav-link" href="{!! url('/').'/'.$menu_value->menuRoute !!}">{{$menu_value->menuName}}33</a>-->

                                         <router-link to="{!! url('/').'/'.$menu_value->menuRoute !!}"  class="nav-link router-link">{{$menu_value->menuName}}</router-link>

                                      </li>
                                    
                                  @endif
                              @endif
                          @endforeach  
                          </ul>                 
                    </li>
                
            

                  @php
                    $moduleSl++;
                  @endphp


                @else

                     @if($rootmenu_value->id==$smenu_id)
                                             
                          <li class="nav-item"><a class="nav-link" href="{!! url('/').'/'.$rootmenu_value->menuRoute !!}" > <i class="ion ion-ios-list"></i>{{$rootmenu_value->menuName}}55</a></li>
                    
                       @else  
                                   
                          <li class="nav-item"><a class="nav-link" href="{!! url('/').'/'.$rootmenu_value->menuRoute !!}"> <i class="ion ion-ios-list"></i>{{$rootmenu_value->menuName}}66</a></li>
                        
                    @endif


                @endif 

            @endforeach

         @endif    

       @endif    
            
      </ul>
    </div>
</div>