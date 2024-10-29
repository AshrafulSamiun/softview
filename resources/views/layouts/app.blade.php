
@guest
 
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'BMS Property Management') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body style="background:#0070C0">
    <div id="app" >
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'BMS Property Management') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    
                </div>
            </div>
        </nav>

        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script>

        $("#refresh_captcha").click(function()
        {
            $.ajax({

              type:'GET',
              url:'/refresh_captcha',
              success:function(data){
                $(".captcha span").html(data.captcha);
              }
            });
        });
    </script> 
</body>
</html>

  @else

  <!DOCTYPE html>
<html lang="en">
<head>
  @include('includes.head')
  
  <style>
      .fakeimg {
          height: 200px;
          background: #aaa;
      }

     #doughnutChart {
        width       : 100%;
        height      : 600px;
        font-size   : 11px;
     }

     #world-tansaction{
      width: 100%;
      height: 500px;
    }   
  </style>

  
</head>
<body>

<div class="wrapper">
    @include('includes.header')
    <div class="content">
      @include('includes.header_title')
      <div class="page-body">
        <div class="container-fluid">
          @include('includes.leftSidebar')
          <div class="page-content">  
            @yield('content')
          </div>        
        </div>
      </div>
    </div>
  </div>
</body>

@include('includes.footScript')

</html>

@endguest