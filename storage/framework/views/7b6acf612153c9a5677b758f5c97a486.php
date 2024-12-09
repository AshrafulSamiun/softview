<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <meta name="msapplication-tap-highlight" content="no">
    <title>SOFT VIEW</title>
    <link href="assets/img/armitis_security.png" rel="icon">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <!------------CSS-------------->
    <link href="css/main.css" rel="stylesheet">
    <link href="<?php echo asset('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css'); ?>" media="all" rel="stylesheet" type="text/css" />
  <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"  />
    <link href="css/glyphicon.css" rel="stylesheet">
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
    <section class="app-header header-shadow" style="background:rgb(45, 123, 252)">
        <div class="app-header__logo" style="background:rgb(45, 123, 252)">
            <div class="logo-src">
                <img src="assets/img/artemis.png" style="max-height: 60px; " alt=""/>
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
        <div class="app-header__content" style="background:rgb(45, 123, 252)">
            <div class="app-header-left">
                <div class="search-wrapper">
                    <div class="input-holder">
                        <input type="text" class="search-input" placeholder="Type to search">
                        <button class="search-icon"><span></span></button>
                    </div>
                    <button class="close"></button>
                </div>
                       
            </div>
            <div class="app-header-right">
                <div class="header-btn-lg pr-0">
                    <div class="widget-content p-0">
                        <div class="widget-content-wrapper">
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
               
                <div class="container-fluid" id="app">
                    <div class="row justify-content-center">
                        <div class="card" id="msform">
                            
                                <!-- progressbar -->
                                <ul id="progressbar">
                                    <?php $sl=1; ?>
                                     <?php $__currentLoopData = $main_menu_arr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mid => $m_value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li class="<?php if($m_value['slno']>=$project_type) echo "active"; ?>"> 
                                            <strong><?php echo e($sl); ?>/10
                                                <span class="<?php if($sl==1) echo "first_span"; else if($sl>1 && $sl<14) echo "middle_span"; else if($sl==14) echo "last_span"; ?>">
                                                    <?php if($m_value['menuRoute']): ?>
                                                        <?php if($m_value['slno']>=$project_type): ?>
                                                            <router-link :to="{ path: '/<?php echo e($m_value['menuRoute']); ?>'}"
                                                                class="router-link" >
                                                                
                                                                <p><?php echo e($m_value['menuName']); ?></p>
                                                            </router-link>
                                                          <?php else: ?>
                                                            <p><?php echo e($m_value['menuName']); ?></p>
                                                        <?php endif; ?>
                                                    <?php endif; ?> 
                                                   </span> 
                                                   <span class="<?php if($sl==1) echo "first_span_shadow"; else if($sl>1 && $sl<14) echo "middle_span_shadow";  ?>"></span>
                                                </strong>
                                           </li>
                                           <?php $sl++; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                   
                                </ul>
                            
                                <router-view></router-view>
                        </div>
                    </div>
                </div>
            </section>

        </div>

    </div>
</div>
<!-----------------Full Body Area End------------------->   

<!------------Scripts-------------->
<?php echo app('Illuminate\Foundation\Vite')('resources/js/app.js'); ?>
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
        if(project_type==105)
        {
           window.open('#/Temp-AccountNo','_self');
           setProgressBar(1,14); 
        } 
        if(project_type==104)
        {
           window.open('#/Temp-CompanyProfile','_self');
           setProgressBar(2,14); 
        } 
        else if(project_type==103)
        {
           window.open('#/Temp-BusinessType','_self');
           setProgressBar(3,14); 
        } 
        else if(project_type==102)
        {
           window.open('#/Temp-ServicePlan','_self'); 
            setProgressBar(4,14); 
        }
        else if(project_type==101)
        {
            window.open('#/Temp-ServiceContract','_self'); 
           setProgressBar(5,14); 
        } 
        else if(project_type==100)
        {
           window.open('#/Temp-ContactsPersons','_self');
           setProgressBar(6,14); 
        } 
         
        else if(project_type==99)
        {
           window.open('#/Temp-TermsOfAgreement','_self');  
            setProgressBar(7,14); 
        } 
       
        else if(project_type==98)
        {
           
            window.open('#/Temp-Declaration','_self');
             setProgressBar(8,14);
        } 
        else if(project_type==97)
        {
            window.open('#/Temp-ShoppingCard','_self');
             setProgressBar(9,14);
        } 
        else if(project_type==96)
        {
            window.open('#/Temp-ActivationStatus','_self');
             setProgressBar(10,14);
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
<?php /**PATH G:\WampServer\www\Development\SoftView\resources\views/temp_dashboard/account_no2.blade.php ENDPATH**/ ?>