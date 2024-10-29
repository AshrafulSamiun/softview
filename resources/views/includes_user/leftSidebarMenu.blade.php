  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-light-primary elevation-4 ">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="{{asset('/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">Company Name  dssd</span>
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
                  <p>{{ $m_value['menuName']}}</p>
              </router-link>
            @endif  
          </li>
           @endforeach

         



       
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>