<!DOCTYPE html>
<html lang="en">
<head>
  @include('includes_user.head')
</head>
<body class="hold-transition layout-top-nav">

<div class="wrapper" id="app">
    @include('includes_user.header')
    <div class="content-wrapper">
 
      <div class="content" style="min-height:700px;">
        
            @yield('content')

          
        
      </div>
    </div>
      @include('includes_user.footer')
</div>
</body>

@include('includes_user.footScript')


</html>