<!DOCTYPE html>
<html lang="en">
	<head>
	  @include('include_dashboard.head')
	</head>
	<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">

		<div class="wrapper" id="app">
		    @include('include_dashboard.header')
		    @include('include_dashboard.leftSidebar')
		    <div class="content-wrapper">
		 
		     
		        
		            @yield('content')

		          
		        
		    </div>
		     
		</div>
		 @include('include_dashboard.footScript')
	</body>

</html>