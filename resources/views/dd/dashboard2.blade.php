<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title')</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
 
 <!-- <link href="{!! asset('css/bootstrap.min.css') !!}" media="all" rel="stylesheet" type="text/css" />-->
  <!-- Font Awesome -->
  
  <link href="{!! asset('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css') !!}" media="all" rel="stylesheet" type="text/css" />
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <!-- Theme style -->
  <link href="{!! asset('css/bootstrap.css') !!}" media="all" rel="stylesheet" type="text/css" />


  <link href="{!! asset('css/style.css') !!}" media="all" rel="stylesheet" type="text/css" />

  
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link href="{!! asset('css/ionicon.css') !!}" media="all" rel="stylesheet" type="text/css" />

  <script type="text/javascript" src="{{ asset('js/jquery.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/popper.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/bootstrap.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/cloudeState.js') }}"></script>

   <link href="{!! asset('tailSelect/css/bootstrap4/tail.select-primary.min.css') !!}" media="all" rel="stylesheet" type="text/css" />
   
  <script type="text/javascript" src="{{ asset('tailSelect/js/tail.select.min.js') }}"></script>

</head>
<body>

<div class="wrapper">
    <nav class="navbar navbar-spark navbar-toggleable navbar-expand-md">
        <div class="container-fluid">
        <button type="button" class="sidebar-open d-lg-none">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand d-none d-lg-inline-block" href="index.html">
          <i class="ion ion-ios-pulse-strong" aria-hidden="true"></i>
        </a>
    
    
        <ul class="nav navbar-nav navbar-right">
      
          <li class="nav-item dropdown active">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Profile</a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="#"><i class="ion ion-person"></i> View Profile</a></li>
              <li><a class="dropdown-item" href="#"><i class="ion ion-chatbubbles"></i> Contacts</a></li>
              <li><a class="dropdown-item" href="#"><i class="ion ion-email"></i> Mailbox</a></li>
              <li><a class="dropdown-item" href="#"><i class="ion ion-gear-b"></i> Settings</a></li>
              <li role="separator" class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="#"><i class="ion ion-log-out"></i> Sign out</a></li>
            </ul>
          </li>

          <li class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Messages</a>
            <div class="dropdown-menu dropdown-md">

              <div class="media-items">
                <div class="media">
                  <div class="media-left mr-1">
                    <a href="#">
                      <img class="media-object img-circle" src="{{asset('img/avatar-500x500.png')}}" width="38" height="38">
                    </a>
                  </div>
                  <div class="media-body text-muted">
                    <p class="media-heading">Linda Miller</p>
                    <span class="text-sm">Aenean posuere, tortor sed..</span>
                  </div>
                </div>

                <div class="media">
                  <div class="media-left mr-1">
                    <a href="#">
                      <img class="media-object img-circle" src="{{asset('img/avatar-500x500-2.png')}}" width="38" height="38">
                    </a>
                  </div>
                  <div class="media-body text-muted">
                    <p class="media-heading">Kathie Burton</p>
                    <span class="text-sm">Nam pretium turpis et arcu..</span>
                  </div>
                </div>

                <div class="media">
                  <div class="media-left mr-1">
                    <a href="#">
                      <img class="media-object img-circle" src="{{asset('img/avatar-500x500.png')}}" width="38" height="38">
                    </a>
                  </div>
                  <div class="media-body text-muted">
                    <p class="media-heading">Linda Miller</p>
                    <span class="text-sm">Aenean posuere, tortor sed..</span>
                  </div>
                </div>

                <div class="media">
                  <div class="media-left mr-1">
                    <a href="#">
                      <img class="media-object img-circle" src="{{asset('img/avatar-500x500-2.png')}}" width="38" height="38">
                    </a>
                  </div>
                  <div class="media-body text-muted">
                    <p class="media-heading">Kathie Burton</p>
                    <span class="text-sm">Nam pretium turpis et arcu..</span>
                  </div>
                </div>
              </div>

              <a class="dropdown-menu-footer" href="#">
                View all
              </a>

            </div>
          </li>

          <li class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Tasks</a>
            <div class="dropdown-menu dropdown-menu-right dropdown-md last-dropdown">

              <div class="dropdown-task text-muted">
                <div class="pull-right text-sm">50%</div>
                Google Chrome Extension
                <div class="progress">
                  <div class="progress-bar bg-warning" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
              </div>

              <div class="dropdown-task text-muted">
                <div class="pull-right text-sm">90%</div>
                Bootstrap Admin Theme
                <div class="progress">
                  <div class="progress-bar bg-success" role="progressbar" style="width: 90%" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
              </div>

              <div class="dropdown-task text-muted">
                <div class="pull-right text-sm">33%</div>
                YouTube Client
                <div class="progress">
                  <div class="progress-bar bg-danger" role="progressbar" style="width: 33%" aria-valuenow="33" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
              </div>

              <div class="dropdown-task text-muted">
                <div class="pull-right text-sm">40%</div>
                Form Validation
                <div class="progress">
                  <div class="progress-bar" role="progressbar" style="width: 40%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
              </div>

              <a class="dropdown-menu-footer" href="#">
                View all
              </a>

            </div>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link">
              <img src="{{asset('img/avatar-500x500.png')}}" alt="Avatar" class="avatar img-circle" width="48" height="48">
            </a>
          </li>
        </ul>
        </div>
    </nav>
    <div class="content">
      <header class="page-header">
        <div class="container-fluid">
          <div class="row">
            <div class="col-sm-8 page-title-wrapper">
              <h6 class="page-title">Dashboard</h6>
            </div>
            <div class="col-sm-4 d-none d-md-inline-block page-search-wrapper">
              <input class="form-control form-control-lg keyword-search" placeholder="Search for files &amp; reports.." type="text">
            </div>
          </div>
        </div>
      </header>
      <div class="page-body" id="app">
        <div class="container-fluid">
         <div class="page-sidebar toggled sidebar">
            <nav class="sidebar-collapse d-none d-lg-block">
              <i class="ion ion-ios-arrow-forward show-on-collapsed"></i>
              <i class="ion ion-ios-arrow-back hide-on-collapsed"></i>
            </nav>
            <div id="dynamic_left_sidear" >
              <ul class="nav nav-pills nav-stacked" id="sidebar-stacked">
              <li class="d-lg-none">
                <a href="#" class="sidebar-close"><i class="ion ion-ios-arrow-left"></i></a>
              </li>



              @foreach ($module as $mid => $m_value)

                 <li class="nav-item">
                    <a class="nav-container" data-toggle="collapse" data-parent="#sidebar-stacked" href="#pp{{ $m_value->id }}">
                      <i class="ion ion-ios-flask"></i> <span class="nav-text">{{ $m_value->moduleName }}<span class="badge badge-pill badge-nav badge-warning">{{count($main_menu_arr[$m_value->id])}}</span></span>
                    </a>
                    <ul class="nav nav-pills nav-stacked collapse" id="pp{{ $m_value->id }}">
                       @foreach ($main_menu_arr[$m_value->id] as $menuid => $menu_value)
                          <li class="nav-item">

                               <router-link to="/{{$menu_value['menuRoute']}}" class="nav-link router-link">
                                {{ $menu_value['menuName']}}
                               </router-link>
                          </li>
                          
                        @endforeach
                    </ul>
                  </li>
              @endforeach

                   <li class="nav-item">
                    <a class="nav-container" data-toggle="collapse" data-parent="#sidebar-stacked" href="#p1111">
                      <i class="ion ion-ios-flask"></i> <span class="nav-text">User Interface <span class="badge badge-pill badge-nav badge-warning">6</span></span>
                    </a>
                    <ul class="nav nav-pills nav-stacked collapse" id="p1111">
                        <li>
                             <router-link to="/Modules" class="nav-link router-link">Module
                             </router-link>
                        </li>
                        <li class="nav-item">

                             <router-link to="/Menus" class="nav-link router-link">Menus
                             </router-link>
                        </li>
                        <li class="nav-item">

                             <router-link to="/Users" class="nav-link router-link">User Creation
                             </router-link>
                        </li>
                       <!-- <li class="nav-item">

                             <router-link to="/Selectable-Rows" class="nav-link router-link">Selectable Rows
                             </router-link>
                        </li>
                        <li class="nav-item">

                             <router-link to="/Custom-Tamplates" class="nav-link router-link">Custom Tamplates
                             </router-link>
                        </li>-->
                        <li class="nav-item">

                             <router-link to="/Multiple-Tables" class="nav-link router-link">Multiple Tables
                             </router-link>
                        </li>
                        <li class="nav-item">

                             <router-link to="/Pager-Style" class="nav-link router-link">Pager Style
                             </router-link>
                        </li>
                        <li class="nav-item">

                             <router-link to="/Azax-Request" class="nav-link router-link">Azax Request
                             </router-link>
                        </li>
                        <li class="nav-item">

                             <router-link to="/Customer" class="nav-link router-link">Customer
                             </router-link>
                        </li>
                    </ul>
                  </li>
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
                    <a class="nav-container dropdown-toggle" data-toggle="collapse" data-parent="#sidebar-stacked" href="#p5">
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

               
                      
                </ul>
              </div>
            </div>
            <div class="page-content" > 
            
               <router-view></router-view>
                
          </div>        
        </div>
      </div>
    </div>
  </div>
</body>


 <script src="{{ asset('js/app.js') }}"></script>



<script type="text/javascript" src="{{ asset('js/wow.min.js') }}"></script>


<script type="text/javascript">
    new WOW().init();
    tail.select(".select");

</script>
<link href="{!! asset('css/glyphicon.css') !!}" media="all" rel="stylesheet" type="text/css" />
</html>