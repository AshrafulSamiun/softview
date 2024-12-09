 <!-- ======= Top Bar ======= -->
  <div id="topbar" class="d-none d-lg-flex align-items-center fixed-top" style="background:#171511">
    <div class="container d-flex">
      <div class="contact-info mr-auto">
        <i class="icofont-envelope"></i> <a href="mailto:contact@example.com">info@artemis.com</a>
        <i class="icofont-phone"></i> +1001215331663
      </div>
      <div class="social-links">
        <a href="#" class="facebook"><i class="icofont-facebook"></i></a>
        <a href="#" class="instagram"><i class="icofont-instagram"></i></a>
        <a href="#" class="linkedin"><i class="icofont-linkedin"></i></i></a>
        <a href="#" class="skype"><i class="icofont-youtube"></i></a>
          
      </div>
      <div class="float-right">
          
      </div>

    </div>
  </div>

  <!-- ======= Header ======= -->



<header id="header" class="fixed-top">
    <div class=" d-flex " >

      <div class="header-logo" style=" ">
        <h6 class="logo mr-auto">
          <a href="/"><img src="assets/img/logo.png" alt=""></a></h6>
      </div>
      <div class="header-title" style=" ">
        <h6 class="logo mr-auto">
          <a style="padding-left:30px" href="/">SOFT VIEW</a></h6>
        <!-- Uncomment below if you prefer to use an image logo -->
        <!-- <a href="index.html" class="logo mr-auto"><img src="assets/img/logo.png" alt=""></a>-->
      </div>
      <div class="div-redinet">

      </div>
      <div class="header-menu" style="background:rgba(8, 102, 255, 1); text-align: left;">
          <nav class="nav-menu d-none d-lg-block" >
            <ul>
              @if($active_menu==1) 
                <li  class="active"><a href="/">Home</a></li>
              @else 
              <li  ><a href="/">Home</a></li>
              @endif
              @if($active_menu==2) 
                <li  class="active"><a href="/about-us">About</a></li>
              @else 
              <li  ><a href="/about-us">About</a></li>
              @endif
              @if($active_menu==3) 
                <li  class="active"><a href="/plan">Plans</a></li>
              @else 
              <li  ><a href="/plan">Plans</a></li>
              @endif
              @if($active_menu==4) 
                <li  class="active"><a href="/contact-us">Contact</a></li>
              @else 
              <li  ><a href="/contact-us">Contact</a></li>
              @endif
                <li class="login_li" ><a href="/login">Log In</a></li>
                <li><a href="/register">Create Account</a></li>
            </ul>
          </nav><!-- .nav-menu -->

          
    </div>
    </div>
  </header><!-- End Header -->

  