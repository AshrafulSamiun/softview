  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-light-primary elevation-4 ">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="{{asset('/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">Company Name</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar layout-navbar-fixed">
  

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

        @foreach ($main_menu_arr as $mid => $m_value)
          <li class="nav-item has-treeview ">

            @if($m_value['menuRoute'])

              <router-link to="/{{$m_value['menuRoute']}}" class="nav-link router-link" style="background-color:#007bff; color:#fff">
                  <i class="nav-icon fas fa-tachometer-alt"></i>
                  <p>{{ $m_value['name']}}</p>
              </router-link>
            @else

              <a href="#" class="nav-link active">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  {{ $m_value['name'] }}

                  @if(!$m_value['menuRoute'])
                      <i class="right fas fa-angle-left"></i>
                  @endif

                  @if(!empty($root_menu_arr[$m_value['id']]))
                  <span class="badge badge-info right">{{count($root_menu_arr[$m_value['id']])}}</span>
                  @endif
                </p>
              </a>
              @if(!empty($root_menu_arr[$m_value['id']]))
              <ul class="nav nav-treeview">
                <?php $sl=1; ?>
                @foreach ($root_menu_arr[$m_value['id']] as $menuid => $menu_value)
                <li class="nav-item">
                  

                    <router-link to="/{{$menu_value['menuRoute']}}" class="nav-link router-link">
                                
                      @if($sl==1)
                      <i class="nav-icon far fa-circle text-info"></i>
                      @elseif($sl==2)
                      <i class="nav-icon far fa-circle text-danger"></i>
                      @elseif($sl==3)
                      <i class="nav-icon far fa-circle text-warning"></i>
                      @elseif($sl==4)
                      <i class="far fa-circle nav-icon"></i>
                        
                      @endif
                      <p>{{ $menu_value['name']}}</p>
                    </router-link>
                  </a>
                </li>
                   <?php $sl++;
                          if($sl==5) $sl=1;
                    ?>
                @endforeach
              </ul>
               @endif
            @endif  
          </li>
           @endforeach

         



       
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>