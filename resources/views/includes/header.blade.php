<nav class="navbar navbar-spark navbar-toggleable navbar-expand-md">
      <div class="container-fluid">
        <button type="button" class="sidebar-open d-lg-none">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand d-none d-lg-inline-block" href="index.html">
          <i class="ion ion-ios-pulse-strong" aria-hidden="true"></i>
        </a>
		
		
        <ul class="nav navbar-nav navbar-right">
			@foreach ($module as $mid => $m_value)
				<li class="nav-link dropdown-toggle">
				<a href="{{ route('user_module',$m_value->id) }}" class="nav-link module-link" >{{ $m_value->moduleName }}</a>
       
				</li>
			@endforeach
          <li class="nav-item dropdown active">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Profile</a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="#"><i class="ion ion-person"></i> View Profile</a></li>
              <li><a class="dropdown-item" href="#"><i class="ion ion-chatbubbles"></i> Contacts</a></li>
              <li><a class="dropdown-item" href="#"><i class="ion ion-email"></i> Mailbox</a></li>
              <li><a class="dropdown-item" href="#"><i class="ion ion-gear-b"></i> Settings</a></li>
              <li role="separator" class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="#"><i class="ion ion-log-out"></i> Sign out</a></li>
            </ul>
          </li>

          <li class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Messages</a>
            <div class="dropdown-menu dropdown-md">

              <div class="media-items">
                <div class="media">
                  <div class="media-left mr-1">
                    <a href="#">
                      <img class="media-object img-circle" src="{{asset('img/avatar-500x500.png')}}" width="38" height="38">
                    </a>
                  </div>
                  <div class="media-body text-muted">
                    <p class="media-heading">Linda Miller</p>
                    <span class="text-sm">Aenean posuere, tortor sed..</span>
                  </div>
                </div>

                <div class="media">
                  <div class="media-left mr-1">
                    <a href="#">
                      <img class="media-object img-circle" src="{{asset('img/avatar-500x500-2.png')}}" width="38" height="38">
                    </a>
                  </div>
                  <div class="media-body text-muted">
                    <p class="media-heading">Kathie Burton</p>
                    <span class="text-sm">Nam pretium turpis et arcu..</span>
                  </div>
                </div>

                <div class="media">
                  <div class="media-left mr-1">
                    <a href="#">
                      <img class="media-object img-circle" src="{{asset('img/avatar-500x500.png')}}" width="38" height="38">
                    </a>
                  </div>
                  <div class="media-body text-muted">
                    <p class="media-heading">Linda Miller</p>
                    <span class="text-sm">Aenean posuere, tortor sed..</span>
                  </div>
                </div>

                <div class="media">
                  <div class="media-left mr-1">
                    <a href="#">
                      <img class="media-object img-circle" src="{{asset('img/avatar-500x500-2.png')}}" width="38" height="38">
                    </a>
                  </div>
                  <div class="media-body text-muted">
                    <p class="media-heading">Kathie Burton</p>
                    <span class="text-sm">Nam pretium turpis et arcu..</span>
                  </div>
                </div>
              </div>

              <a class="dropdown-menu-footer" href="#">
                View all
              </a>

            </div>
          </li>

          <li class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Tasks</a>
            <div class="dropdown-menu dropdown-menu-right dropdown-md last-dropdown">

              <div class="dropdown-task text-muted">
                <div class="pull-right text-sm">50%</div>
                Google Chrome Extension
                <div class="progress">
                  <div class="progress-bar bg-warning" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
              </div>

              <div class="dropdown-task text-muted">
                <div class="pull-right text-sm">90%</div>
                Bootstrap Admin Theme
                <div class="progress">
                  <div class="progress-bar bg-success" role="progressbar" style="width: 90%" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
              </div>

              <div class="dropdown-task text-muted">
                <div class="pull-right text-sm">33%</div>
                YouTube Client
                <div class="progress">
                  <div class="progress-bar bg-danger" role="progressbar" style="width: 33%" aria-valuenow="33" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
              </div>

              <div class="dropdown-task text-muted">
                <div class="pull-right text-sm">40%</div>
                Form Validation
                <div class="progress">
                  <div class="progress-bar" role="progressbar" style="width: 40%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
              </div>

              <a class="dropdown-menu-footer" href="#">
                View all
              </a>

            </div>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link">
              <img src="{{asset('img/avatar-500x500.png')}}" alt="Avatar" class="avatar img-circle" width="48" height="48">
            </a>
          </li>
        </ul>
      </div>
    </nav>
    <script>

		function load_left_dropdown(module_id,e)
		{
			 e.preventDefault();
			// var module_id = e.target.value;
       $.get('/api/left_menu_list?module_id=' + module_id, function(data){
           $('#dynamic_left_sidear').empty();
           $('#dynamic_left_sidear').append(data);

       });
			
		}




     $(document).ready(function() {
     
     $('.module-link').on('change', function(e){

        
            var module_id = e.target.value;
            alert(module_id)
               $.get('/api/rootMenu-dropdown?module_id=' + module_id, function(data){
                   $('#rootMenu').empty();
           
                   $('#rootMenu').append('<option value="0">Select Root Menu</option>');
    
                   $.each(data, function(index, rootMenuObj){
        
                       $('#rootMenu').append('<option value="'
                       + rootMenuObj.id+ '">'
                       + rootMenuObj.menuName+ '</option>');
                   });
               });
           });
  
     });
	</script>