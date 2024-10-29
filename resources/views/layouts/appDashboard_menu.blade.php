<!DOCTYPE html>
<html lang="en">
<head>
  @include('includes_dashboard.head')
</head>
<body id="layout_body" class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
 
<div class="wrapper" id="app">
    @include('includes_dashboard.header')
    @include('includes_dashboard.leftSidebar_menu')
    <div class="content-wrapper">
  
      <div class="content"  style="min-height:700px; ">
        	<router-view></router-view>
          
            @yield('content')
                  
      </div>
    </div>
     @include('includes_dashboard.footer')
</div>
</body>

@include('includes_dashboard.footScript')
 <script src="{{ asset('js/app.js') }}"></script>

</html>