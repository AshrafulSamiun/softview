<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <meta name="msapplication-tap-highlight" content="no">
    <title>.: BMS - Vancouver Property Management :.</title>

    <!------------CSS-------------->
    <link href="css/main.css" rel="stylesheet">
</head>
<style type="text/css">

    .router-link{
        cursor:pointer;
    }

</style>
<body>

<div id="preloader" class="preloader">
    <div class='inner'>
        <div class='line1'></div>
        <div class='line2'></div>
        <div class='line3'></div>
    </div>
</div>

<!-----------------Full Body Area Start---------------->   
<div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header">
    

<!----------Header Area------>  
<section class="app-header header-shadow">
    <div class="app-header__logo">
        <div class="logo-src">
            <img src="images/logo-inverse.png" alt=""/>
        </div>
    </div>
    <div class="app-header__mobile-menu">
        <div>
            <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                <span class="hamburger-box">
                    <span class="hamburger-inner"></span>
                </span>
            </button>
        </div>
    </div>
    <div class="app-header__menu">
        <span>
            <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                <span class="btn-icon-wrapper">
                    <i class="fa fa-ellipsis-v fa-w-6"></i>
                </span>
            </button>
        </span>
    </div>   
    <div class="app-header__content">
        <div class="app-header-left">
            <div class="search-wrapper">
                <div class="input-holder">
                    <input type="text" class="search-input" placeholder="Type to search">
                    <button class="search-icon"><span></span></button>
                </div>
                <button class="close"></button>
            </div>
            <!-- <ul class="header-menu nav">
                <li class="nav-item">
                    <a href="javascript:void(0);" class="nav-link">
                        <i class="nav-link-icon fa fa-database"> </i>
                        Schedules
                    </a>
                </li>
                <li class="btn-group nav-item">
                    <a href="javascript:void(0);" class="nav-link">
                        <i class="nav-link-icon fa fa-edit"></i>
                        Projects
                    </a>
                </li>
                <li class="dropdown nav-item">
                    <a href="javascript:void(0);" class="nav-link">
                        <i class="nav-link-icon fa fa-cog"></i>
                        Repair and Maintenance
                    </a>
                </li>
                <li class="dropdown nav-item">
                    <a href="javascript:void(0);" class="nav-link">
                        <i class="nav-link-icon fa fa-forward"></i>
                        Moving
                    </a>
                </li>
                <li class="dropdown nav-item">
                    <a href="javascript:void(0);" class="nav-link">
                        <i class="nav-link-icon fa fa-calendar"></i>
                        Expiration Date
                    </a>
                </li>
            </ul>  ---->       
        </div>
        <div class="app-header-right">
            <div class="header-btn-lg pr-0">
                <div class="widget-content p-0">
                    <div class="widget-content-wrapper">
                        <!-- <div class="widget-content-left">
                            <div class="btn-group">
                                <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="p-0 btn">
                                    <img width="42" class="rounded-circle" src="images/avatars/1.jpg" alt="">
                                    <i class="fa fa-angle-down ml-2 opacity-8"></i>
                                </a>
                                <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-right">
                                    <button type="button" tabindex="0" class="dropdown-item">User Account</button>
                                    <button type="button" tabindex="0" class="dropdown-item">Settings</button>
                                    <button type="button" tabindex="0" class="dropdown-item">Messages</button>
                                    <button type="button" tabindex="0" class="dropdown-item">Notifications</button>
                                    <div tabindex="-1" class="dropdown-divider"></div>
                                    <button type="button" tabindex="0" class="dropdown-item"><i class="fa fa-logout"></i>Log Out</button>
                                </div>
                            </div>
                        </div> -->
                        <div class="widget-content-left  ml-3 header-user-info">
                            <div class="widget-heading">
                                Creating Account
                            </div>
                            <!-- <div class="widget-subheading">
                                VP People Manager
                            </div>-->                    
                        </div>
                        <div class="widget-content-right header-user-info ml-3">
                            <button type="button" class="btn-shadow p-1 btn btn-primary btn-sm show-toastr-example">
                                <i class="fa text-white fa-calendar pr-1 pl-1"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>        
        </div>
    </div>
</section>        
       
<!----------Sidebar and Panel Area------> 
<div class="app-main">
    <input type="hidden" id="hidden_project_type" name="hidden_project_type" value="<?php echo $project_type; ?>" />

<!----------Main Panel Area--------> 
<div class="app-main__outer without-left-bar">

<section class="app-main__inner">

    <!----------Page Title Area--------> 
    <div class="app-page-title create-account-head">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
              
                <div>
                    <div class="page-title-subheading">Please filled all required sessions by follow step by step to create account fully.
                    </div>
                </div>
            </div>   
        </div>
    </div> 
    <div class="container-fluid" id="app">
        <div class="row justify-content-center">
            <div class="card" id="msform">
                
                    <!-- progressbar -->
                   <ul id="progressbar">
                        <?php $sl=1; ?>
                         @foreach ($main_menu_arr as $mid => $m_value)
                            <li class="<?php if($m_value['slno']>=$project_type) echo "active"; ?>"> <strong>{{$sl}}/7<br><span>
                               @if($m_value['menuRoute'])
                                    @if($m_value['slno']>=$project_type)
                                        <router-link :to="{ path: '/{{$m_value['menuRoute']}}', params: { id: 20 }}"
                                            class="router-link" >
                                            
                                            <p>{{ $m_value['menuName']}}</p>
                                        </router-link>
                                      @else
                                        <p>{{ $m_value['menuName']}}</p>
                                    @endif
                                @endif 
                               </span> </strong>
                               </li>
                               <?php $sl++; ?>
                        @endforeach
                       
                    </ul>
                    <div class="progress">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>


                    <router-view></router-view>



            </div>
        </div>
    </div>
</section>


</div>

<script src="http://maps.google.com/maps/api/js?sensor=true"></script>

</div>
</div>
<!-----------------Full Body Area End------------------->   

<!------------Scripts-------------->
<script src="{{ asset('js/app.js') }}"></script>
<script type="text/javascript" src="js/main.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript" src="js/step.js"></script>


<script>
    //after window is loaded completely 
    window.onload = function(){
        //hide the preloader
        document.querySelector(".preloader").style.display = "none";
    }

    $( document ).ready(function() {
        var project_type=$("#hidden_project_type").val();

        if(project_type==100)
        {
           window.open('#/Temp-CompanyProfile','_self');
           setProgressBar(1,7); 
        } 
        else if(project_type==99)
        {
           window.open('#/Temp-ContactsPersons','_self');
           setProgressBar(2,7); 
        } 
        else if(project_type==98)
        {
           window.open('#/Temp-ServicePlan','_self'); 
            setProgressBar(3,7); 
        } 

        else if(project_type==97)
        {
           window.open('#/Temp-ServiceContract','_self'); 
            setProgressBar(4,7); 
        } 

        else if(project_type==96)
        {
           window.open('#/Temp-TermsOfAgreement','_self'); 
            setProgressBar(5,7);
        } 

        else if(project_type==95)
        {
           window.open('#/Temp-DocumentsSubmission','_self');
            setProgressBar(6,7); 
        } 

        else if(project_type==94)
        {
            window.open('#/Temp-ActivationStatus','_self');
             setProgressBar(7,7);
        } 
        return;
    });


    function setProgressBar(curStep,steps){
        var percent = parseFloat(100 / steps) * curStep;
        percent = percent.toFixed();
        $(".progress-bar")
        .css("width",percent+"%")
        }

    
</script>


</body>
</html>
