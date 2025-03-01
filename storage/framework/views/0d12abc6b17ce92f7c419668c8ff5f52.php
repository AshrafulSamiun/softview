<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <meta name="msapplication-tap-highlight" content="no">
    
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>SOFT VIEW</title>
    <link href="<?php echo asset('assets/img/icon/logo.png'); ?>" rel="icon">

    <!------------CSS-------------->
    <link href="css/main.css" rel="stylesheet">
    <link href="<?php echo asset('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css'); ?>" media="all" rel="stylesheet" type="text/css" />
  <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"  />
    <link href="css/glyphicon.css" rel="stylesheet">
   
</head>

<style type="text/css">
    .clasic_view{
      font-size:12px;
      color:#236EB2;
      font-weight: bolder;
    }
    .soft_view{
       font-size:12px;
        color:#C3CDC3;
         font-weight: bolder;
    }

    .switch {
      position: relative;
      display: inline-block;
      width: 37px;
      height: 16px;
    }

    .switch input { 
      opacity: 0;
      width: 0;
      height: 0;
    }

    .btnonof {
      position: absolute;
      cursor: pointer;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-color: #ccc;
      -webkit-transition: .4s;
      transition: .4s;
    }

    .btnonof:before {
      position: absolute;
      content: "";
      height: 14px;
      width: 14px;
      left: 6px;
      bottom: 2px;
      background-color: white;
      -webkit-transition: .4s;
      transition: .4s;
    }

    input:checked + .btnonof {
      background-color: #236EB2;
    }

    input:focus + .btnonof {
      box-shadow: 0 0 1px #236EB2;
    }

    input:checked + .btnonof:before {
      -webkit-transform: translateX(14px);
      -ms-transform: translateX(14px);
      transform: translateX(14px);
    }

    /* Rounded btnonofs */
    .btnonof.round {
      border-radius: 14px;
    }

    .btnonof.round:before {
      border-radius: 50%;
    }


    .tr_disable{
        display:none;
      }
    .tr_anable{
        display:block;
    }

    .router-link{
        cursor:pointer;
    }

    .sidebar__heading li a .router-link-active{
      color:red !important;
    }

/*    .li_router_links*/
  .router-link-active{
     background-color:#fff !important;
     color:rgba(0,0,0,.6) !important;
    font-family: Roboto;
    font-size: 18px;
    font-weight: 700;
    line-height: 21.09px;
    text-align: left;
  }

  .custom-btn {
       /* background-color: #007bff;
        color: white;
        border-radius: 10px;
        width: 120px;
        height: 50px;
*/       display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
       
        margin: 0 10px 10px 10px;
    }
    .custom-btn .details {
        color: #2D7BFC;
        font-size: 12px;
        margin-top: -5px;
        box-shadow: 0px 3px 2px 0px #00000026;
        width: 100%;
        height: 23px;
        padding-top: 5px;
        border-radius: 5px 0px 0px 0px;
        opacity: 0px;
        cursor: pointer;
         font-weight: 500;

    }
    .custom-btn button {
        padding: 5px 10px !important;
        font-size: 14px;
        font-weight: 700;
    }

    .custom-btn .details .active{
        color: red;
        font-weight: 700;
    }

</style>
<script type="text/javascript">
    
   

    function enable_disable_menu()
    {

        if($("#show_menu").hasClass("clasic_view"))
        {
          //alert(4);
          $("#show_menu").removeClass("clasic_view");
          $("#show_menu").addClass("soft_view");
        }
        else
        {
          //alert(3);
          $("#show_menu").removeClass("soft_view");
          $("#show_menu").addClass("clasic_view");
        }
        //return;
        if($("#hide_menu").hasClass("clasic_view"))
        {

          $("#hide_menu").removeClass("clasic_view");
          $("#hide_menu").addClass("soft_view");
        }
        else
        {
          $("#hide_menu").removeClass("soft_view");
          $("#hide_menu").addClass("clasic_view");
        }

        if($("#menu_show_hide").val()==1)
        {

          $(".app-sidebar").css("display", "none");

          
          $("#menu_show_hide").val('0');
    
          $(".app-main__outer").css("padding-left","0");
        }
        else
        {
          $(".app-sidebar").css("display", "block");
          $("#menu_show_hide").val('1');
          $(".app-main__outer").css("padding-left","280px");
        }
    }


</script>
<body >

<div id="preloader" class="preloader">
    <div class='inner'>
        <div class='line1'></div>
        <div class='line2'></div>
        <div class='line3'></div>
    </div>
</div> 

<!-----------------Full Body Area Start------------------>   
<div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header">
    

  <!----------Header Area-------->  
    <section class="app-header header-shadow" style="margin-bottom: 10px !important">
        <div class="app-header__logo">
            <div class="logo-src">
                <img src="assets/img/logo.png" alt="" height="" width="40" style="vertical-align:top !important" />
               
                    <?php if(session()->has('company_name')): ?>
                       <b> <?php echo e(session()->get('company_name')); ?> </b>
                    <?php else: ?>

                     <b> <?php echo e($project_name); ?></b>
                   <?php endif; ?>
             
            </div>

          <div class="text-right" >
              
              <input type="hidden" id="menu_show_hide" name="menu_show_hide" value="1" >
              <li style="text-align: right; color:blue; cursor:pointer; font-size: 25px;" onclick="enable_disable_menu()">
                  <i class="fa-solid fa-bars"></i>
              </li>
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
         <!--  <div class="div-redinet">
          </div> -->
            <div class="app-header-left mx-auto">
                <div class="d-flex gap-3 p-3 ">
                    
                    <div class="text-center custom-btn">
                        <button class="btn btn-primary " ><i class="fa-duotone fa-solid fa-bullhorn"></i>&nbsp;Announcements(252)</button>
                        <div class="details">Details</div>
                    </div>
                    <div class="text-center custom-btn">
                        <button class="btn btn-primary" ><i class="fa-solid fa-video"></i>&nbsp;VDC(2)</button>
                
                        <div class="details">Details</div>
                    </div>


                    <div class="text-center custom-btn">
                        <button class="btn btn-primary" ><i class="fa-sharp fa-solid fa-envelope-circle-check"></i>&nbsp;     Emails
                        </button>
                
                        <div class="details">Details</div>
                    </div>

                    <div class="text-center custom-btn">
                         <button class="btn btn-primary" ><i class="fa-solid fa-phone"></i>&nbsp;Phone(30)</button>  
                
                        <div class="details">Details</div>
                    </div>
                    

                    <div class="text-center custom-btn">
                        <button class="btn btn-primary" ><i class="fa fa-tasks"></i>&nbsp;Tasks(30)</button>
                
                        <div class="details">Details</div>
                    </div>
                </div>
              
             
            </div>
         
          <div class="app-header-right">
              <div class="header-btn-lg pr-0">
                  <div class="widget-content p-0">
                      <div class="widget-content-wrapper">
                          <div class="widget-content-left d-flex flex-row mb-3">

                              
                              <div class="search-wrapper">
                                  <div class="input-holder">
                                      <input type="text" class="search-input"  placeholder="Type to search">
                                      <button class="search-icon"><span></span></button>
                                  </div>
                                  <button class="close"></button>
                              </div>
                              

                          </div>
                          
                          <div class="widget-content-right header-user-info ml-3">
                              <img class="media-object rounded-circle" style="border: 2px solid rgba(8, 102, 255, 1)" src="img/user_image/ashraful.jpg"  width="38" height="38">
                              <p style="font-size: 10px;color: rgba(0, 0, 0, 0.8);">Ashraful Islam</p>
                              <!-- src="<?php echo e(asset('image/user_photo/'.$user_image)); ?>" -->
                          </div>
                      </div>
                  </div>
              </div>        
      </div>
    </section>        
         
  <!----------Sidebar and Panel Area--------> 
    <div class="app-main" id="app">

      <!----------Sidebar--------> 
        
        <section class="app-sidebar sidebar-shadow"> 


            <div class="scrollbar-sidebar" style="overflow: scroll;" >
              
                <div class="app-sidebar__inner">

                    <ul class="vertical-nav-menu" >
                      
                        <?php $__currentLoopData = $menu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mid => $m_value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($m_value->rootMenu==0 && $m_value->position==1): ?>
                                <li class="app-sidebar__heading" id="first_level_<?php echo e($mid); ?>" >
                                    <?php if(!empty($lavel_one_arr[$m_value->id])): ?>
                                        <a class="text-capitalize" href="#">
                                      
                                            <i class="<?php echo e($m_value->class); ?>" aria-hidden="true"></i> &nbsp;&nbsp; 
                                        
                                                <?php echo e($m_value->menuName); ?> 
                                         
                                            <i class="metismenu-state-icon fa fa-angle-down"></i>
                                         
                                        </a>


                                        <ul class="second_level" >
                                            <?php $__currentLoopData = $lavel_one_arr[$m_value->id]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $l1_id=>$la_value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <li class="">
                                                    <?php if(!empty($lavel_two_arr[$l1_id])): ?>
                                                        <a class="text-capitalize" href="#"><?php echo e($la_value['menuName']); ?> 
                                                            <i class="metismenu-state-icon fa fa-angle-down"></i>
                                                        </a>
                                                        <ul class="third_level_ul">
                                                            <?php $__currentLoopData = $lavel_two_arr[$l1_id]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $l2_id=>$lb_value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                                <li>
                                                                    <?php if(!empty($lavel_three_arr[$l2_id])): ?>
                                                                      <a class="text-capitalize" href="#"><?php echo e($lb_value['menuName']); ?>

                                                                          <i class="metismenu-state-icon fa fa-angle-down"></i>
                                                                      </a>
                                                                      <ul>
                                                                          <?php $__currentLoopData = $lavel_three_arr[$l2_id]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $l3_id=>$lc_value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                                              <li>
                                                                                  <router-link :to="{ path: '/<?php echo e($lc_value['menuRoute']); ?>'}" class="router-link text-capitalize" >
                                                                                      <p><?php echo e($lc_value['menuName']); ?></p>
                                                                                  </router-link>
                                                                              </li>
                                                                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                      </ul>
                                                                  <?php else: ?>
                                                                      <router-link :to="{ path: '/<?php echo e($lb_value['menuRoute']); ?>'}"
                                                                      class="router-link text-capitalize" >
                                                                      
                                                                          <p><?php echo e($lb_value['menuName']); ?></p>
                                                                      </router-link>
                                                                  <?php endif; ?>
                                                                </li>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </ul>
                                                    <?php else: ?>
                                                       
                                                        <router-link :to="{ path: '/<?php echo e($la_value['menuRoute']); ?>'}"
                                                                      class="router-link text-capitalize" >
                                                      
                                                          <p><?php echo e($la_value['menuName']); ?></p>
                                                      </router-link>
                                                    <?php endif; ?>

                                                </li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </ul>
                                    <?php else: ?>
                                        <router-link :to="{ path: '/<?php echo e($m_value->menuRoute); ?>'}"
                                                                      class="router-link text-capitalize" >
                                                      
                                            <p><i class="<?php echo e($m_value->class); ?>" aria-hidden="true"></i> &nbsp;&nbsp;<?php echo e($m_value->menuName); ?></p>
                                        </router-link>
                                    <?php endif; ?>


                                </li>
                              

                            <?php endif; ?>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                          
                    </ul>

                </div>
            </div>
        </section>  
      <!----------Main Panel Area--------> 
        <div class="app-main__outer" >

            <section class="app-main__inner" >
           

                <div class="row">
                      <div class="col-md-12 " >
                        <div class="main-card mb-3 card " style="display: none;" ><!-- style="display: none" -->
                          <?php if(session()->has('legal_name')): ?>
                            <div class="card-header" style="color:#2955C8;; font-size:20px">
                                 Company Name:<?php echo e(session()->get('legal_name')); ?> -- Account No: <?php echo e(session()->get('account_no')); ?>

                            </div>
                          <?php endif; ?>
                        </div>
                      </div>
                </div>
                <!----------Page Title Area--------> 
              
             
                <div class="row"  style="min-height:800px" >
                    <div class="col-md-12 col-xl-12">
                         <router-view>
                           
                          


                         </router-view>
                          

                    </div>
                </div>
              
             
            </section>

            <!----------Footer Area--------> 
            <section class="app-wrapper-footer">
                <div class="app-footer">
                    <div class="app-footer__inner">
                        <div class="app-footer-right">
                            <ul class="nav">
                                <li class="nav-item d-flex align-items-center">
                                  Design and Developed By:
                                    <a href="https://www.bms.com.ca" target="blank" class="nav-link">
                                      Soft-View
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </section> 

        </div>



    </div>

  
</div>
<!-----------------Full Body Area End------------------>   

<!------------Scripts-------------->
<?php echo app('Illuminate\Foundation\Vite')('resources/js/app.js'); ?>

<script type="text/javascript" src="js/main.js"></script>

<script type="text/javascript" src="<?php echo e(asset('js/popper.min.js')); ?>"></script>


<script>
    //after window is loaded completely 
    window.onload = function(){
        //hide the preloader
        document.querySelector(".preloader").style.display = "none";
    }

    
</script>


</body>
</html>
<?php /**PATH G:\WampServer\www\Development\SoftView\resources\views/dashboard.blade.php ENDPATH**/ ?>