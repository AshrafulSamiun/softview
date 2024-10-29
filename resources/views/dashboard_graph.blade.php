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
    .clasic_view{
      font-size:16px;
      color:#236EB2;
      font-weight: bolder;
    }
    .soft_view{
       font-size:16px;
        color:#C3CDC3;
         font-weight: bolder;
    }

    .switch {
      position: relative;
      display: inline-block;
      width: 60px;
      height: 28px;
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
      height: 24px;
      width: 24px;
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
      -webkit-transform: translateX(24px);
      -ms-transform: translateX(24px);
      transform: translateX(24px);
    }

    /* Rounded btnonofs */
    .btnonof.round {
      border-radius: 24px;
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

</style>
<script type="text/javascript">
    
    function enable_softview_clasic_view()
    {

        if($("#switch_clasic_view").hasClass("clasic_view"))
        {
          //alert(4);
          $("#switch_clasic_view").removeClass("clasic_view");
          $("#switch_clasic_view").addClass("soft_view");
        }
        else
        {
          //alert(3);
          $("#switch_clasic_view").removeClass("soft_view");
          $("#switch_clasic_view").addClass("clasic_view");
        }
        //return;
        if($("#switch_soft_view").hasClass("clasic_view"))
        {
          //alert(2);
          $("#switch_soft_view").removeClass("clasic_view");
          $("#switch_soft_view").addClass("soft_view");
        }
        else
        {
          //alert(1);
          $("#switch_soft_view").removeClass("soft_view");
          $("#switch_soft_view").addClass("clasic_view");
        }

        if($("#menu_display_type").val()==1)
        {

            $(".second_level_div").each(function(){
               
                $(this).css("display", "none");

            });
             $(".third_level").each(function(){
           
               $(this).css("display", "none");

            });
          $("#menu_display_type").val('0');
    
          $(".app-sidebar__heading").children("ul").addClass('tr_disable');
          $(".app-sidebar__heading a").children("i").css("display","none");
        }
        else
        {
             $(".second_level_div").each(function(){
               
                   $(this).css("display", "none");

            });

              $(".third_level").each(function(){
           
                   $(this).css("display", "none");

            });
          $("#menu_display_type").val('1');
          $(".app-sidebar__heading").children("ul").removeClass('tr_disable');
          $(".app-sidebar__heading a").children("i").css("display","block");
        }
    }


    function show_second_level(row_id)
    {

        $(".second_level_div").each(function(){
           
              $(this).css("display", "none");
        });
        $(".third_level").each(function(){
           
            $(this).css("display", "none");
        });
        
        if($("#menu_display_type").val()==1) return;

        $("#selcond_level_"+row_id).css("display", "block");
        $("#selcond_level_"+row_id).children("div").css("display", "block");
    }

    function show_third_level(row_id)
    {
        

         $(".third_level").each(function(){
           
               $(this).css("display", "none");

        });
        
    
        $("#third_level_"+row_id).css("display", "block");
        $("#third_level_"+row_id).children("div").css("display", "block");
    }

    function tabdisplay(id){
        var tab_array=["licence", "warranty", "permit","insuarnce-policies","fire-extinguishers"];

        for(var i=0;i<=4; i++)
        {

            if(tab_array[i]==id)
                $("#"+tab_array[i]).css("display","block");
            else 
                $("#"+tab_array[i]).css("display","none");
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
  <section class="app-header header-shadow">
      <div class="app-header__logo">
          <div class="logo-src">
              <img src="images/logo-inverse.png" alt=""/>
              <b>{{$project_name}}</b>
          </div>
          <strong></strong>
      </div>
      <div>
          <label for="switch_clasic_view" id="switch_clasic_view" class="clasic_view">Clasic View</label>
          <label class="switch">

              <input type="checkbox" id="switch_clasic_view_soft_view"
              onclick="enable_softview_clasic_view()"
              name="switch_clasic_view_soft_view" value="1" checked>

              <span class="btnonof round"></span>
          </label>
          <label for="switch_soft_view" id="switch_soft_view" class="soft_view">Soft View</label>
          <input type="hidden" id="menu_display_type" name="menu_display_type" value="1" >

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
              
              <ul class="header-menu nav">
                  <li class="nav-item">
                      <a href="javascript:void(0);" class="nav-link">
                          <i class="nav-link-icon fa fa-database"> </i>
                          Weather-{{$weather['weather'][0]['main']}}
                      </a>
                  </li>
                  <li class="dropdown nav-item">
                      <a href="javascript:void(0);" class="nav-link">
                          <i class="nav-link-icon fa fa-calendar"></i>
                          <strong>Date / Day- {{date("l, F, Y")}}</strong>
                      </a>
                  </li>
                  <li class="btn-group nav-item">
                      <a href="javascript:void(0);" class="nav-link">
                          <i class="nav-link-icon fa fa-edit"></i>
                          <strong>Location-{{$weather['name']}}</strong>
                      </a>
                  </li>
                  <li class="dropdown nav-item">
                      <a href="javascript:void(0);" class="nav-link">
                          <i class="nav-link-icon fa fa-cog"></i>
                          <strong>Local Time-{{date("H:i:s")}}</strong>
                      </a>
                  </li>
                  <li class="dropdown nav-item">
                      <a href="javascript:void(0);" class="nav-link">
                          <i class="nav-link-icon fa fa-forward"></i>Risks & Threats Level &nbsp;&nbsp;
                          <div id="denger_alert" style="height: 20px; width:150px;
                                background-color: red; 
                                background-image: linear-gradient(to right, #07f107 70%, red);"></div>
                      </a>
                  </li>

                 
                  
              </ul>
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
                          <div class="widget-content-left">
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
                                      <button type="button" tabindex="0" class="dropdown-item">
                                        <a class="dropdown-item" href="/logout"><i class="fa fa-logout"></i> Log Out</a></i></button>
                                  </div>
                              </div>
                          </div>
                          <div class="widget-content-left  ml-3 header-user-info">
                              <div class="widget-heading">
                                  {{$user->name}}
                              </div>
                              <div class="widget-subheading">
                                  {{$user_type_arr[$user->user_type]}}
                              </div>
                          </div>
                          <div class="widget-content-right header-user-info ml-3">
                              <img class="media-object img-circle" src="{{asset('image/user_photo/'.$user_image)}}" width="38" height="38">
                          </div>
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
                      @foreach ($menu as $mid => $m_value)
                          @if($m_value->rootMenu==0 && $m_value->position==1)
                              <li class="app-sidebar__heading" id="first_level_{{$mid}}" onClick="show_second_level({{$mid}})">
                                  <a href="#">{{$m_value->menuName}} 
                                      @if(!empty($lavel_one_arr[$m_value->id]))
                                         <i class="metismenu-state-icon fa fa-angle-down"></i>
                                      @endif
                                  </a>

                                  @if(!empty($lavel_one_arr[$m_value->id]))
                                      <ul class="second_level" >
                                      @foreach($lavel_one_arr[$m_value->id] as $l1_id=>$la_value)
                                          <li>
                                              @if(!empty($lavel_two_arr[$l1_id]))
                                                  <a class="text-capitalize" href="#">{{$la_value['menuName']}}
                                                      <i class="metismenu-state-icon fa fa-angle-down"></i>
                                                  </a>
                                                  <ul>
                                                      @foreach($lavel_two_arr[$l1_id] as $l2_id=>$lb_value)

                                                          <li>
                                                              <router-link :to="{ path: '/{{$m_value['menuRoute']}}', params: { id: 20 }}"
                                                  class="router-link" >
                                                  
                                                                  <p>{{ $lb_value['menuName']}}</p>
                                                              </router-link>
                                                          </li>
                                                      @endforeach
                                                  </ul>
                                              @else
                                                  <router-link :to="{ path: '/{{$la_value['menuRoute']}}', params: { id: 20 }}"
                                                  class="router-link" >
                                                  
                                                      <p>{{ $la_value['menuName']}}</p>
                                                  </router-link>
                                              @endif

                                          </li>
                                      @endforeach
                                  </ul>
                                      
                                  @endif


                              </li>
                              

                          @endif

                      @endforeach
                      
                  </ul>


              </div>
          </div>
      </section>    

      <!----------Main Panel Area--------> 
      <div class="app-main__outer" >

          <section class="app-main__inner" >

              <!----------Page Title Area--------> 
              
              <div class="row">
                  <div class="col-md-12 " >
                      @foreach ($menu as $mid => $m_value)
                          @if($m_value->rootMenu==0 && $m_value->position==1)
                              @if(!empty($lavel_one_arr[$m_value->id]))
                                  <div class="main-card mb-3 card second_level_div" id="selcond_level_{{$mid}}" style="display: none"><!-- style="display: none" -->
                                      <div class="card-header">Second Lavel--{{$m_value->menuName}}</div>
                                      <div class="table-responsive">
                                          <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                                             
                                              <tbody>
                                                  <tr>
                                                  <?php $i=1; ?>
                                                  @foreach($lavel_one_arr[$m_value->id] as $l1_id=>$la_value)
                                                       @if(!empty($lavel_two_arr[$l1_id]) )
                                                          <td class="text-center text-muted" onClick="show_third_level({{$l1_id}})" style="cursor:pointer" >
                                                               {{$la_value['menuName']}}</td>
                                                      @else

                                                          <td class="text-center text-muted"  style="cursor:pointer" >
                                                               
                                                              <router-link :to="{ path: '/{{$la_value['menuRoute']}}', params: { id: 20 }}" class="router-link" >
                                                      
                                                              <p>{{ $la_value['menuName']}}</p>
                                                              </router-link>
                                                           </td>
                                                      @endif
                                                      @if($i%6==0)
                                                          </tr>
                                                          <tr>
                                                      @endif
                                                      <?php $i++; ?>
                                                  @endforeach
                                                  
                                                  </tr>
                                           
                                              </tbody>
                                          </table>
                                      </div>
                                  </div>

                                  @foreach($lavel_one_arr[$m_value->id] as $l1_id=>$la_value)
                                      @if(!empty($lavel_two_arr[$l1_id]) )


                                          <div class="main-card mb-3 card third_level" id="third_level_{{$l1_id}}" style="display: none"><!-- style="display: none" -->
                                              <div class="card-header">Third Lavel--{{$la_value['menuName']}} ---{{$l1_id}}</div>
                                              <div class="table-responsive">
                                                  <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                                                     
                                                      <tbody>
                                                          <tr>
                                                          <?php $j=1; ?>
                                                          @foreach($lavel_two_arr[$l1_id] as $l2_id=>$lb_value)
                                                              <td class="text-center text-muted" >
                                                                  <router-link :to="{ path: '/{{$lb_value['menuRoute']}}', params: { id: 20 }}" class="router-link" >
                                                      
                                                                  <p>{{ $lb_value['menuName']}}</p>
                                                              </router-link>
                                                              </td>
                                                              @if($j%6==0)
                                                                  </tr>
                                                                  <tr>
                                                              @endif
                                                              <?php $j++; ?>
                                                          @endforeach
                                                          
                                                          </tr>
                                                   
                                                      </tbody>
                                                  </table>
                                              </div>
                                          </div>
                                      @endif

                                  @endforeach

                              @endif
                          @endif
                      @endforeach
                  </div>
              </div> 
              <div class="row" >
                  <div class="col-md-12 col-xl-12">
                     <router-view></router-view>
                  </div>
              </div>
              <div class="row" >
                  <div class="col-md-6 col-xl-6">

                      <div class="card mb-3 widget-content">
                          <div class="main-card mb-3 card">
                              
                             {!! $line->html() !!}
                              
                          </div>
                      </div>
                      <div class="card mb-3 widget-content">
                          <div class="main-card mb-3 card">
                              
                             {!! $chart->html() !!}
                              
                          </div>
                      </div>
                      <div class="card mb-3 widget-content">
                          <div class="main-card mb-3 card">
                              
                             {!! $donut->html() !!}
                              
                          </div>
                      </div>
                  </div>
                 
                  <div class="col-md-6 col-xl-6">
                      <div class="card mb-3 widget-content">
                          <div class="main-card mb-3 card">
                              
                             <div id="calendar"></div>
                              
                          </div>
                      </div>


                      <div class="card mb-3 widget-content">
                          <div class="app-main__inner">          
                              <ul class="body-tabs body-tabs-layout tabs-animated body-tabs-animated nav">
                                  <li class="nav-item">
                                      <a role="tab" class="nav-link active" id="tab-0" data-toggle="tab" href="#tab-content-0">
                                          <span>Basic Calendar</span>
                                      </a>
                                  </li>
                                  <li class="nav-item">
                                      <a role="tab" class="nav-link" id="tab-1" data-toggle="tab" href="#tab-content-1">
                                          <span>List View</span>
                                      </a>
                                  </li>
                                  <li class="nav-item">
                                      <a role="tab" class="nav-link" id="tab-2" data-toggle="tab" href="#tab-content-2">
                                          <span>Background Events</span>
                                      </a>
                                  </li>
                              </ul>
                              <div class="tab-content">
                                  <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
                                      <div class="main-card mb-3 card">
                                          <div class="card-body">
                                              <div id='calendar'></div>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="tab-pane tabs-animation fade" id="tab-content-1" role="tabpanel">
                                      <div class="main-card mb-3 card">
                                          <div class="card-body">
                                              <div id='calendar-list'></div>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="tab-pane tabs-animation fade" id="tab-content-2" role="tabpanel">
                                      <div class="main-card mb-3 card">
                                          <div class="card-body">
                                              <div id="calendar-bg-events"></div>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>

                      
                      <div class="card mb-3 widget-content">
                          <div class="main-card mb-3 card">
                              <div class="card-header">Schedules
                                  
                              </div>
                              <div class="table-responsive">
                                  <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                                      <thead>
                                      <tr>
                                          <th class="text-center">Sl</th>
                                          <th>Particular</th>
                                          <th class="text-center">Date</th>
                                          <th class="text-center">Actions</th>
                                      </tr>
                                      </thead>
                                      <tbody>
                                      <tr>
                                          <td class="text-center text-muted">1</td>
                                          <td>
                                              <div class="widget-content p-0">
                                                  <div class="widget-content-wrapper">
                                                     
                                                      <div class="widget-content-left flex2">
                                                          <div class="widget-heading">Entry Permision</div>
                                                          
                                                      </div>
                                                  </div>
                                              </div>
                                          </td>
                                          <td class="text-center">08-08-2022</td>
                                          <td class="text-center">
                                              <div class="badge badge-warning">Pending</div>
                                          </td>
                                          
                                      </tr>
                                      <tr>
                                          <td class="text-center text-muted">2</td>
                                          <td>
                                              <div class="widget-content p-0">
                                                  <div class="widget-content-wrapper">
                                                     
                                                      <div class="widget-content-left flex2">
                                                          <div class="widget-heading">Moving Out</div>
                                                          
                                                      </div>
                                                  </div>
                                              </div>
                                          </td>
                                          <td class="text-center">05-07-2022</td>
                                          <td class="text-center">
                                              <div class="badge badge-info">On Hold</div>
                                          </td>
                                          
                                      </tr>
                                      
                                      </tbody>
                                  </table>
                              </div>
                              
                          </div>
                      </div>

                      <div class="card mb-3 widget-content">
                          <div class="main-card mb-3 card">
                              <div class="card-header">Projects
                                  
                              </div>
                              <div class="table-responsive">
                                  <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                                      <thead>
                                      <tr>
                                          <th class="text-center">Date</th>
                                          <th class="text-center">Location</th>
                                          <th class="text-center">Project No</th>
                                          <th class="text-center">Contractor</th>
                                          <th class="text-center">Start-End</th>
                                          <th class="text-center">Status</th>
                                      </tr>
                                      </thead>
                                      <tbody>
                                      <tr>
                                          <td class="text-center">08-06-2022</td>
                                          <td class="text-center">Vancouver</td>
                                          <td class="text-center">001</td>
                                          <td class="text-center">Tom Martin</td>
                                          <td class="text-center">Jul-2022 to Aug-2022</td>
                                          <td class="text-center">
                                              <div class="badge badge-warning">Pending</div>
                                          </td>
                                          
                                      </tr>
                                      <tr>
                                          <td class="text-center">08-05-2022</td>
                                          <td class="text-center">Torento</td>
                                          <td class="text-center">001</td>
                                          <td class="text-center"> Martin Hall</td>
                                          <td class="text-center">May-2022 to Jun-2022</td>
                                          <td class="text-center">
                                              <div class="badge badge-success">Completed</div>
                                          </td>
                                          
                                      </tr>
                                      
                                      
                                      </tbody>
                                  </table>
                              </div>
                              
                          </div>
                      </div>


                      <div class="card mb-3 widget-content">
                          <div class="main-card mb-3 card">
                              <div class="card-header">Repair And Maintenance
                                  
                              </div>
                              <div class="table-responsive">
                                  <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                                      <thead>
                                      <tr>
                                          <th class="text-center">Date</th>
                                          <th class="text-center">Location</th>
                                          <th class="text-center" style="width:60px;">WO No</th>
                                          <th class="text-center">Contractor</th>
                                          <th class="text-center">Start-End</th>
                                          <th class="text-center">Status</th>
                                      </tr>
                                      </thead>
                                      <tbody>
                                      <tr>
                                          <td class="text-center">08-06-2022</td>
                                          <td class="text-center">Vancouver</td>
                                          <td class="text-center" >001</td>
                                          <td class="text-center">Tom Martin</td>
                                          <td class="text-center">Jul-2022 to Aug-2022</td>
                                          <td class="text-center">
                                              <div class="badge badge-warning">Pending</div>
                                          </td>
                                          
                                      </tr>
                                      <tr>
                                          <td class="text-center">08-05-2022</td>
                                          <td class="text-center">Torento</td>
                                          <td class="text-center">002</td>
                                          <td class="text-center"> Martin Hall</td>
                                          <td class="text-center">May-2022 to Jun-2022</td>
                                          <td class="text-center">
                                              <div class="badge badge-success">Done</div>
                                          </td>
                                          
                                      </tr>
                                      
                                      
                                      </tbody>
                                  </table>
                              </div>
                              
                          </div>
                      </div>
                      <div class="card mb-3 widget-content">
                          <div class="main-card mb-3 card">
                              <div class="card-header">Moving
                                  
                              </div>
                              <div class="table-responsive">
                                  <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                                      <thead>
                                      <tr>
                                          <th class="text-center">Date</th>
                                          <th class="text-center">Time</th>
                                          <th class="text-center">Suit/Unit No</th>
                                          <th class="text-center">Name</th>
                                          <th class="text-center">Contact</th>
                                      </tr>
                                      </thead>
                                      <tbody>
                                      <tr>
                                          <td class="text-center">08-06-2022</td>
                                          <td class="text-center">14:00</td>
                                          <td class="text-center" >001</td>
                                          <td class="text-center">Tom Martin</td>
                                          <td class="text-center">+1-54544444</td>
                                          
                                          
                                      </tr>
                                      <tr>
                                          <td class="text-center">08-06-2022</td>
                                          <td class="text-center">14:00</td>
                                          <td class="text-center" >001</td>
                                          <td class="text-center">Tom Martin</td>
                                          <td class="text-center">+1-54544444</td>
                                          
                                          
                                      </tr>
                                      
                                      
                                      </tbody>
                                  </table>
                              </div>
                              
                          </div>
                      </div>

                      <div class="card mb-3 widget-content">
                          <div class="main-card mb-3 card">
                              <div class="card-header">Expire Date
                                  
                              </div>
                              <div class="container">
                                  <ul class="nav nav-tabs" id="">
                                      <li class="active"><a data-toggle="tab" href="#licence" onclick="tabdisplay('licence')">Licence  </a>&nbsp; &nbsp; &nbsp;</li>
                                      <li><a data-toggle="tab" href="#warranty" onclick="tabdisplay('warranty')" >Warranty  </a>&nbsp; &nbsp; &nbsp;</li>
                                      <li><a data-toggle="tab" href="#permit" onclick="tabdisplay('permit')">Permit   </a>&nbsp; &nbsp; &nbsp;</li>
                                      <li><a data-toggle="tab" href="#insuarnce-policies" onclick="tabdisplay('insuarnce-policies')" >Insuarnce Policies  </a>&nbsp; &nbsp; &nbsp;</li>
                                      <li><a data-toggle="tab" href="#fire-extinguishers" onclick="tabdisplay('fire-extinguishers')">Fire Extinguishers   </a>&nbsp; &nbsp; &nbsp;</li>                           
                                    </ul>
                                </div>
                              <div class="table-responsive" id="licence" style="display:none;">
                                  <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                                      <thead>
                                      <tr>
                                          <th class="text-center">Date</th>
                                          <th class="text-center">Class</th>
                                          <th class="text-center">Expiration Date</th>
                                          <th class="text-center">Renewd Date</th>
                                          <th class="text-center">Status</th>
                                      </tr>
                                      </thead>
                                      <tbody>
                                      <tr>
                                          <td class="text-center">08-06-2022</td>
                                          <td class="text-center">14:00</td>
                                          <td class="text-center" >001</td>
                                          <td class="text-center">Tom Martin</td>
                                          <td class="text-center"><div class="badge badge-info">On Hold</div></td>
                                          
                                          
                                      </tr>
                                      <tr>
                                          <td class="text-center">08-06-2022</td>
                                          <td class="text-center">14:00</td>
                                          <td class="text-center" >001</td>
                                          <td class="text-center">Tom Martin</td>
                                          <td class="text-center"><div class="badge badge-success">Done</div></td>
                                          
                                          
                                      </tr>
                                      
                                      
                                      </tbody>
                                  </table>
                              </div>
                              <div class="table-responsive" id="warranty" style="display:none;">
                                  <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                                      <thead>
                                      <tr>
                                          <th class="text-center">Date</th>
                                          <th class="text-center">Class</th>
                                          <th class="text-center">Expiration Date</th>
                                          <th class="text-center">Renewd Date</th>
                                          <th class="text-center">Status</th>
                                      </tr>
                                      </thead>
                                      <tbody>
                                      <tr>
                                          <td class="text-center">05-06-2022</td>
                                          <td class="text-center">14:00</td>
                                          <td class="text-center" >001</td>
                                          <td class="text-center">Martin</td>
                                          <td class="text-center"><div class="badge badge-success">Done</div></td>
                                          
                                          
                                      </tr>
                                      <tr>
                                          <td class="text-center">25-06-2022</td>
                                          <td class="text-center">14:00</td>
                                          <td class="text-center" >001</td>
                                          <td class="text-center">Tom Suji</td>
                                          <td class="text-center"><div class="badge badge-warning">Pending</div></td>
                                          
                                          
                                      </tr>
                                      
                                      
                                      </tbody>
                                  </table>
                              </div>
                              
                          </div>
                      </div>
                  </div>
                  <div class="d-xl-none d-lg-block col-md-6 col-xl-4">
                      <div class="card mb-3 widget-content">
                          <div class="widget-content-outer">
                              <div class="widget-content-wrapper">
                                  <div class="widget-content-left">
                                      <div class="widget-heading">Income</div>
                                      <div class="widget-subheading">Expected totals</div>
                                  </div>
                                  <div class="widget-content-right">
                                      <div class="widget-numbers text-focus">$147</div>
                                  </div>
                              </div>
                              <div class="widget-progress-wrapper">
                                  <div class="progress-bar-sm progress-bar-animated-alt progress">
                                      <div class="progress-bar bg-info" role="progressbar" aria-valuenow="54" aria-valuemin="0" aria-valuemax="100" style="width: 54%;"></div>
                                  </div>
                                  <div class="progress-sub-label">
                                      <div class="sub-label-left">Expenses</div>
                                      <div class="sub-label-right">100%</div>
                                  </div>
                              </div>
                          </div>
                      </div>
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
                                      BMS-Building Management System
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
{!! Charts::scripts() !!}
{!! $line->script() !!}
{!! $chart->script() !!}
{!! $donut->script() !!}
<!------------Scripts-------------->
<script src="{{ asset('js/app.js') }}"></script>
<!-- <script src="{{ asset('js/jquery.min.js') }}"></script> -->
<script type="text/javascript" src="js/main.js"></script>

<script type="text/javascript" src="{{ asset('js/popper.min.js') }}"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> -->
<script type="text/javascript" src="js/step.js"></script>

<!-- <script src="js/evo-calendar.js"></script> -->


<script>
    //after window is loaded completely 
    window.onload = function(){
        //hide the preloader
        document.querySelector(".preloader").style.display = "none";
    }

    $(document).ready(function() {
        $(document).ready(function() {
            $('#calendar').evoCalendar()
        })
    })
</script>


</body>
</html>
