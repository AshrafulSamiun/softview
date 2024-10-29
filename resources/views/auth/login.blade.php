
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <meta name="msapplication-tap-highlight" content="no">
    <title>NorthStar Property Management Technologies</title>
    <link href="images/logo_icon.png" rel="icon">
    <!------------CSS-------------->
    <link href="{{asset('css/main.css')}}" rel="stylesheet">
</head>

<body>

<div id="preloader" class="preloader">
    <div class='inner'>
        <div class='line1'></div>
        <div class='line2'></div>
        <div class='line3'></div>
    </div>
</div>

<section class="fxt-template-animation fxt-template-layout4">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 col-12">
                <div class="fxt-bg-img" data-bg-image="images/tower.jpg" style='background-image: url("images/logo.png");'>
                    <div class="fxt-header">
                        <!-- <div class="fxt-transformY-50 fxt-transition-delay-1">
                            <a href="login-4.html" class="fxt-logo"><img src="img/logo-4.png" alt="Logo"></a>
                        </div>  property_code -->
                        <div class="fxt-transformY-50 fxt-transition-delay-2">
                            <h1>NorthStar Property Management Technologies</h1>
                        </div>
                       
                    </div>
                    <ul class="fxt-socials" style="display:none">
                        <li class="fxt-facebook fxt-transformY-50 fxt-transition-delay-4"><a href="#" title="Facebook"><i class="fab fa-facebook-f"></i></a></li>
                        <li class="fxt-twitter fxt-transformY-50 fxt-transition-delay-5"><a href="#" title="twitter"><i class="fab fa-twitter"></i></a></li>
                        <li class="fxt-google fxt-transformY-50 fxt-transition-delay-6"><a href="#" title="google"><i class="fab fa-google-plus-g"></i></a></li>
                        <li class="fxt-linkedin fxt-transformY-50 fxt-transition-delay-7"><a href="#" title="linkedin"><i class="fab fa-linkedin-in"></i></a></li>
                        <li class="fxt-youtube fxt-transformY-50 fxt-transition-delay-8"><a href="#" title="youtube"><i class="fab fa-youtube"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-6 col-12 fxt-bg-color">
                <div class="fxt-content">
                    <div class="fxt-form">
                        <form  method="POST" action="{{ route('login') }}" >
                             {{ csrf_field() }}
                            <h1>Log In</h1>
                            
                            <div class="form-group">
                                <label for="email" class="input-label">Email Address</label>
                                <input type="text" id="email"  name="email" class="form-control" placeholder="Type Email Address" required="required" value="{{ old('email') }}" autocomplete="off">
                                 @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif

                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password" class="input-label">Password</label>
                                <input id="password" type="password" class="form-control" name="password" placeholder="****************" required="required" autocomplete="off">

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                                
                            </div>

                            <div class="form-group{{ $errors->has('pin_code') ? ' has-error' : '' }}">
                                <label for="pin_code" class="input-label">Pin Code</label>
                                <input id="pin_code" type="pin_code" class="form-control" name="pin_code"
                                 autocomplete="off" value="{{ old('pin_code') }}" required autofocus>

                                @if ($errors->has('pin_code'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('pin_code') }}</strong>
                                    </span>
                                @endif
                                
                            </div>

                            <div class="form-group{{ $errors->has('captcha') ? ' has-error' : '' }}">
                                <label for="captcha" class="col-md-4 control-label" style="color:#fff">Captcha</label>                                
                                <div class="captcha" style="min-height:50px; position:relative">
                                    <span>{!! captcha_img() !!}</span>
                                    <button type="button" style="position:absolute;left:180px; top:10px"
                                     class="btn btn-success btn-refresh" id="refresh_captcha">Refresh</button>
                                </div>
                                <br/>
                                <input type="text" id="captcha" class="form-control" placeholder="Enter Captcha" name="captcha">
                                @if ($errors->has('captcha'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('captcha') }}</strong>
                                    </span>
                                @endif
                                
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-block fxt-btn-fill" >
                                   Sign In
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="fxt-footer">
                        <p>Don't have an account?<a href="/register" class="switcher-text2 inline-text">Register Now</a></p>
                    </br>
                        <p><a href="{{ route('username.request') }}" class="switcher-text2 inline-text">Forget User Name </a></p>
                        <p><a href="{{ route('password.request') }}" class="switcher-text2 inline-text"> Forget Password</a></p>
                        <p><a href="{{ route('pincode.request') }}" class="switcher-text2 inline-text">Forget Pin Code</a></p>
                    </div>   
                </div>
            </div>
        </div>
    </div>
</section>


<!-- Custom Js -->
<script src="{{asset('js/main.js')}}"></script>
<script type="text/javascript" src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<script>
    //after window is loaded completely 
    window.onload = function(){
        //hide the preloader
        document.querySelector(".preloader").style.display = "none";
    }

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