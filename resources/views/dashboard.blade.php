<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport"
          content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no"/>
    <meta name="msapplication-tap-highlight" content="no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>NORTHSTAR- Property Management Technologies</title>
    <link href="{!! asset('images/logo.png') !!}" rel="icon">

    <!------------CSS-------------->
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <link href="{!! asset('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css') !!}"
          media="all" rel="stylesheet" type="text/css"/>
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="{{ asset('css/glyphicon.css') }}" rel="stylesheet">
</head>

<style type="text/css">
    .clasic_view {
        font-size: 16px;
        color: #236EB2;
        font-weight: bolder;
    }

    .soft_view {
        font-size: 16px;
        color: #C3CDC3;
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


    .tr_disable {
        display: none;
    }

    .tr_anable {
        display: block;
    }

    .router-link {
        cursor: pointer;
    }

    .sidebar__heading li a .router-link-active {
        color: red !important;
    }


    .li_router_links .router-link-active {
        background-color: #2d8f12 !important;
        color: #fff !important;
    }

    .cursor-pointer {
        cursor: pointer;
    }

</style>
<script type="text/javascript">

    function enable_softview_clasic_view() {

        if ($("#switch_clasic_view").hasClass("clasic_view")) {
            //alert(4);
            $("#switch_clasic_view").removeClass("clasic_view");
            $("#switch_clasic_view").addClass("soft_view");
        } else {
            //alert(3);
            $("#switch_clasic_view").removeClass("soft_view");
            $("#switch_clasic_view").addClass("clasic_view");
        }
        //return;
        if ($("#switch_soft_view").hasClass("clasic_view")) {
            //alert(2);
            $("#switch_soft_view").removeClass("clasic_view");
            $("#switch_soft_view").addClass("soft_view");
        } else {
            //alert(1);
            $("#switch_soft_view").removeClass("soft_view");
            $("#switch_soft_view").addClass("clasic_view");
        }

        if ($("#menu_display_type").val() == 1) {

            $(".second_level_div").each(function () {

                $(this).css("display", "none");

            });
            $(".third_level").each(function () {

                $(this).css("display", "none");

            });
            $("#menu_display_type").val('0');

            $(".app-sidebar__heading").children("ul").addClass('tr_disable');
            $(".app-sidebar__heading a").children("i").css("display", "none");
        } else {
            $(".second_level_div").each(function () {

                $(this).css("display", "none");

            });

            $(".third_level").each(function () {

                $(this).css("display", "none");

            });
            $("#menu_display_type").val('1');
            $(".app-sidebar__heading").children("ul").removeClass('tr_disable');
            $(".app-sidebar__heading a").children("i").css("display", "block");
        }
    }

    function enable_disable_menu() {

        if ($("#show_menu").hasClass("clasic_view")) {
            //alert(4);
            $("#show_menu").removeClass("clasic_view");
            $("#show_menu").addClass("soft_view");
        } else {
            //alert(3);
            $("#show_menu").removeClass("soft_view");
            $("#show_menu").addClass("clasic_view");
        }
        //return;
        if ($("#hide_menu").hasClass("clasic_view")) {

            $("#hide_menu").removeClass("clasic_view");
            $("#hide_menu").addClass("soft_view");
        } else {
            $("#hide_menu").removeClass("soft_view");
            $("#hide_menu").addClass("clasic_view");
        }

        if ($("#menu_show_hide").val() == 1) {

            $(".app-sidebar").css("display", "none");


            $("#menu_show_hide").val('0');

            $(".app-main__outer").css("padding-left", "0");
        } else {
            $(".app-sidebar").css("display", "block");
            $("#menu_show_hide").val('1');
            $(".app-main__outer").css("padding-left", "280px");
        }
    }


    function show_second_level(row_id) {

        $(".second_level_div").each(function () {

            $(this).css("display", "none");
        });
        $(".third_level").each(function () {

            $(this).css("display", "none");
        });

        if ($("#menu_display_type").val() == 1) return;

        $("#selcond_level_" + row_id).css("display", "block");
        $("#selcond_level_" + row_id).children("div").css("display", "block");
    }

    function show_third_level(row_id) {


        $(".third_level").each(function () {

            $(this).css("display", "none");

        });


        $("#third_level_" + row_id).css("display", "block");
        $("#third_level_" + row_id).children("div").css("display", "block");
    }

    function tabdisplay(id) {
        var tab_array = ["licence", "warranty", "permit", "insuarnce-policies", "fire-extinguishers"];

        for (var i = 0; i <= 4; i++) {

            if (tab_array[i] == id)
                $("#" + tab_array[i]).css("display", "block");
            else
                $("#" + tab_array[i]).css("display", "none");
        }

    }
</script>
<body>

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
                <img src="images/logo.png" alt="" height="" width="40"/>
                <b>{{$project_name}}</b>
            </div>
            <br/>
            <div>
                <label for="switch_menu" id="show_menu" class="clasic_view">Show Menu</label>
                <label class="switch">

                    <input type="checkbox" id="switch_clasic_view_soft_view"
                           onclick="enable_disable_menu()"
                           name="switch_clasic_view_soft_view" value="1" checked>

                    <span class="btnonof round"></span>
                </label>
                <label for="switch_soft_view" id="hide_menu" class="soft_view">Hide Menu</label>
                <input type="hidden" id="menu_show_hide" name="menu_show_hide" value="1">

            </div>
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
            <input type="hidden" id="menu_display_type" name="menu_display_type" value="1">

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
                                    <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                       class="p-0 btn">
                                        <img width="42" class="rounded-circle" alt="">
                                        <!-- src="images/avatars/1.jpg" -->
                                        <i class="fa fa-angle-down ml-2 opacity-8"></i>
                                    </a>
                                    <div tabindex="-1" role="menu" aria-hidden="true"
                                         class="dropdown-menu dropdown-menu-right">
                                        <button type="button" tabindex="0" class="dropdown-item">User Account</button>
                                        <button type="button" tabindex="0" class="dropdown-item">Settings</button>
                                        <button type="button" tabindex="0" class="dropdown-item">Messages</button>
                                        <button type="button" tabindex="0" class="dropdown-item">Notifications</button>
                                        <div tabindex="-1" class="dropdown-divider"></div>
                                        <button type="button" tabindex="0" class="dropdown-item">
                                            <a class="dropdown-item" href="/logout"><i class="fa fa-logout"></i> Log Out</a></i>
                                        </button>
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
                                <img class="media-object img-circle" src="{{asset('image/user_photo/'.$user_image)}}"
                                     width="38" height="38">
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

            <div class="scrollbar-sidebar" style="overflow: scroll;">

                <div class="app-sidebar__inner">

                    <ul class="vertical-nav-menu">
                        @foreach ($menu as $mid => $m_value)
                            @if($m_value->rootMenu==0 && $m_value->position==1)
                                <li class="app-sidebar__heading" id="first_level_{{$mid}}"
                                    onClick="show_second_level({{$mid}})">
                                    @if(!empty($lavel_one_arr[$m_value->id]))
                                        <a class="text-capitalize" href="#">{{$m_value->menuName}}
                                            <i class="metismenu-state-icon fa fa-angle-down"></i>
                                        </a>
                                    @else
                                        <router-link :to="{ path: '/{{$m_value->menuRoute}}'}"
                                                     class="router-link text-capitalize">
                                            <p>{{ $m_value->menuName}}</p>
                                        </router-link>
                                    @endif

                                    @if(!empty($lavel_one_arr[$m_value->id]))
                                        <ul class="second_level">
                                            @foreach($lavel_one_arr[$m_value->id] as $l1_id=>$la_value)
                                                <li class="li_router_links">
                                                    @if(!empty($lavel_two_arr[$l1_id]))
                                                        <a class="text-capitalize" href="#">{{$la_value['menuName']}}
                                                            <i class="metismenu-state-icon fa fa-angle-down"></i>
                                                        </a>
                                                        <ul>
                                                            @foreach($lavel_two_arr[$l1_id] as $l2_id=>$lb_value)
                                                                <li>
                                                                    <router-link
                                                                            :to="{ path: '/{{$lb_value["menuRoute"]}}'}"
                                                                            class="router-link text-capitalize">
                                                                        <p>{{ $lb_value['menuName']}}</p>
                                                                    </router-link>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    @else
                                                        <router-link :to="{ path: '/{{$la_value["menuRoute"]}}'}"
                                                                     class="router-link text-capitalize">
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
        <div class="app-main__outer">

            <section class="app-main__inner">


                <div class="row">
                    <div class="col-md-12 ">
                        <div class="main-card mb-3 card "><!-- style="display: none" -->
                            @if(session()->has('legal_name'))
                                <div class="card-header" style="color:#2955C8;; font-size:20px">
                                    Company Name:{{session()->get('legal_name')}} -- Account
                                    No: {{session()->get('account_no')}}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <!----------Page Title Area-------->

                <div class="row">
                    <div class="col-md-12 ">
                        @foreach ($menu as $mid => $m_value)
                            @if($m_value->rootMenu==0 && $m_value->position==1)
                                @if(!empty($lavel_one_arr[$m_value->id]))
                                    <div class="main-card mb-3 card second_level_div" id="selcond_level_{{$mid}}"
                                         style="display: none"><!-- style="display: none" -->
                                        <div class="card-header">Second Lavel--{{$m_value->menuName}}</div>
                                        <div class="table-responsive">
                                            <table class="align-middle mb-0 table table-borderless table-striped table-hover">

                                                <tbody>
                                                <tr>
                                                        <?php $i = 1; ?>
                                                    @foreach($lavel_one_arr[$m_value->id] as $l1_id=>$la_value)
                                                        @if(!empty($lavel_two_arr[$l1_id]) )
                                                            <td class="text-center text-muted"
                                                                onClick="show_third_level({{$l1_id}})"
                                                                style="cursor:pointer">
                                                                {{$la_value['menuName']}}
                                                            </td>
                                                        @else
                                                            <td class="text-center text-muted" style="cursor:pointer">
                                                                <router-link
                                                                        :to="{ path: '/{{$la_value["menuRoute"]}}'}"
                                                                        class="router-link">
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
                                            <div class="main-card mb-3 card third_level" id="third_level_{{$l1_id}}"
                                                 style="display: none"><!-- style="display: none" -->
                                                <div class="card-header">Third Lavel--{{$la_value['menuName']}}
                                                    ---{{$l1_id}}</div>
                                                <div class="table-responsive">
                                                    <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                                                        <tbody>
                                                        <tr>
                                                                <?php $j = 1; ?>
                                                            @foreach($lavel_two_arr[$l1_id] as $l2_id=>$lb_value)
                                                                <td class="text-center text-muted">
                                                                    <router-link
                                                                            :to="{ path: '/{{$lb_value["menuRoute"]}}'}"
                                                                            class="router-link">
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
                <div class="row" style="min-height:800px">
                    <div class="col-md-12 col-xl-12">
                        <router-view></router-view>

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

<!------------Scripts-------------->
@vite('resources/js/app.js')
<!--<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/jquery.min.js') }}"></script>-->
<script type="text/javascript" src="{{ asset('js/main.js') }}"></script>

<script type="text/javascript" src="{{ asset('js/popper.min.js') }}"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script1.> -->
<!-- <script type="text/javascript" src="js/step.js"></script> -->

<!-- <script src="js/evo-calendar.js"></script> -->


<script>
    //after window is loaded completely 
    window.onload = function () {
        //hide the preloader
        document.querySelector(".preloader").style.display = "none";
    }


</script>


</body>
</html>