 <!DOCTYPE html>
<html lang="en">
<head>
  @include('includes_dashboard.head')
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">

<div class="wrapper" id="app">
    @include('includes_dashboard.header')
    @include('includes_dashboard.leftSidebar')
    <div class="content-wrapper">
 
      <div class="content" style="min-height:700px;">
        
            @yield('content')

          
        
      </div>
    </div>
      @include('includes_dashboard.footer')
</div>
</body>

@include('includes_dashboard.footScript')


</html>