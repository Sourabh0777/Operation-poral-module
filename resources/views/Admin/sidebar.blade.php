
  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      {{-- <img src="http://smcca.co.in/wp-content/uploads/2021/03/logo.jpg" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8"> --}}
      <span class="brand-text font-weight-light">{{env('APP_NAME')}}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{asset('assets/dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{$users->name}}</a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item menu-open">
            <a href="{{route('dashboard')}}" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
          
          </li>
          @if ($users->emp_type=='HR')
          <li class="nav-item">
            <a href="{{route('emp-leave-request')}}" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
               Apply For Leave
              
              </p>
            </a>
          </li> 
          @endif
         
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Reports
                <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right"></span>
              </p>
            </a>
            <ul class="nav nav-treeview">
              @if ($users->emp_type=='Admin')
              @endif
              @if ($users->emp_type=='Writer')
              <li class="nav-item">
                <a href="{{route('production-details')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Production Details</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('floor-assigned-job')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Floor Assigned Job</p>
                </a>
              </li>
              @endif
              @if ($users->emp_type=='TL')
              <li class="nav-item">
                <a href="{{route('write-new-feedback')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>New writer feedback</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('production-details')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Production Details</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('floor-assigned-job')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Floor Assigned Job</p>
                </a>
              </li>
              @endif
              @if ($users->emp_type=='QC' || $users->emp_type=='Operation' || $users->emp_type=='Admin')
              <li class="nav-item">
                <a href="{{route('job-id-deadline')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>JOB ID Deadline</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('demo-job-list')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Demo Jobs list</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('word-details')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Word details</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('employee-details')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Employee details</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Leave updates</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('production-capacity')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Production capacity</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('query-section')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Query section</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Notifications</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('get-writer-feedback')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>New writer feedback</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('list-idle-writters')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>List of Idle Writers</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Chat messaging services</p>
                </a>
              </li>
              
              @endif
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Master Options
                <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right"></span>
              </p>
            </a>
            <ul class="nav nav-treeview">
              @if ($users->emp_type=='Admin' || $users->emp_type=='HR')
              <li class="nav-item">
                <a href="{{route('employee-list')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Employees</p>
                </a>
              </li>
              @endif
              @if ($users->emp_type=='Admin' || $users->emp_type=='Operation')
              <li class="nav-item">
                <a href="{{route('team-structure')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Team Structure</p>
                </a>
              </li>
              @endif
              @if ($users->emp_type=='Admin' || $users->emp_type=='Marketing' )
              <li class="nav-item">
                <a href="{{route('client-list')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Clients</p>
                </a>
              </li> 
              @endif
              
            </ul>
          </li>
          @if ($users->emp_type=='Marketing')
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Marketing Panel
                <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right"></span>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('post-new-job')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Job List</p>
                </a>
              </li>
             
            </ul>
          </li>
          @endif
         @if ( $users->emp_type=='Operation')
             <li class="nav-item">
            <a href="{{route('post-new-job')}}" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Job List
               
              </p>
            </a>
          </li> 
          <li class="nav-item">
            <a href="{{route('leave-view')}}" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Leave List
               
              </p>
            </a>
          </li> 
         @endif
         @if ( $users->emp_type=='Writer' || $users->emp_type=='TL' || $users->emp_type=='QC' ||  $users->emp_type=='Operation')
         <li class="nav-item">
        <a href="{{route('writer-job-list')}}" class="nav-link">
          <i class="nav-icon fas fa-th"></i>
          <p>
           My Job List
           
          </p>
          <span class="right badge badge-danger reworkcounter">0</span>
        </a>
        
      </li> 
      <li class="nav-item">
        <a href="{{route('job-calender-view')}}" class="nav-link">
          <i class="nav-icon fas fa-th"></i>
          <p>
           My Job Calender
           
          </p>
          <span class="right badge badge-danger reworkcounter">0</span>
        </a>
        
      </li> 
      
     @endif
     
     @if ($users->emp_type=='TL' || $users->emp_type=='QC')
     <li class="nav-item">
    <a href="{{route('my-teams')}}" class="nav-link">
      <i class="nav-icon fas fa-th"></i>
      <p>
       My Teams
       
      </p>
    </a>
  </li> 
  <li class="nav-item">
    <a href="{{route('projects-on-network')}}" class="nav-link">
      <i class="nav-icon fas fa-th"></i>
      <p>
        Projects
       
      </p>
    </a>
  </li> 
  
 @endif

 
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
<script>
  function getcounter(){
    $.ajax({
        url:"{{route('count-rework-job')}}",
        success:function(res){
            $(".reworkcounter").html(res)
        }
      })
  }
  getcounter()
  setInterval(() => {
    getcounter();
  }, 10000);
</script>