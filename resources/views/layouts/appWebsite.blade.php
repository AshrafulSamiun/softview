<!DOCTYPE html>
<html lang="en">
<head>
  @include('web_include.head')
</head>
<body >
	 @include('web_include.header')
	<main id="main">
	   
	   
	        
	            @yield('content')

	        
	    
     
	</main>
	 @include('web_include.footer')

	 @include('web_include.footScript')

</body>



</html>