<!DOCTYPE html>
<html lang="en">
	<head>
	  @include('includes_user.head')
	</head>
	<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">

		<div class="wrapper" id="app">
		   	@include('includes_user.header')
		    @include('includes_user.leftSidebarMenu')
		    <div class="content-wrapper">
		 
		     
		        
		            @yield('content')

		          
		        
		    </div>
		     
		</div>
		 @include('includes_user.footScript')
	</body>

</html>