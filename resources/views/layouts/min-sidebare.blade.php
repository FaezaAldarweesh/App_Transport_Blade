<div class="sidebar" data-background-color="dark">
    <div class="sidebar-logo">
      <!-- Logo Header -->
      <div class="logo-header" data-background-color="dark">
        <a href="index.html" class="logo">
        </a>
        <div class="nav-toggle">
          <button class="btn btn-toggle toggle-sidebar">
            <i class="gg-menu-right"></i>
          </button>
          <button class="btn btn-toggle sidenav-toggler">
            <i class="gg-menu-left"></i>
          </button>
        </div>
        <button class="topbar-toggler more">
          <i class="gg-more-vertical-alt"></i>
        </button>
      </div>
      <!-- End Logo Header -->
    </div>
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
      <div class="sidebar-content">
        <ul class="nav nav-secondary">
          <li class="nav-item active">
            <a
              data-bs-toggle="collapse"
              href="#dashboard"
              class="collapsed"
              aria-expanded="false"
            >
              <i class="fas fa-home"></i>
              <p>Home</p>
              <span class="caret"></span>
            </a>
            <div class="collapse" id="dashboard">
              <ul class="nav nav-collapse">
                <li>
                  <a href="{{ route('home') }}">
                    <span class="sub-item">main page</span>
                  </a>
                </li>
              </ul>
            </div>
          </li>
          <li class="nav-section">
            <span class="sidebar-mini-icon">
              <i class="fa fa-ellipsis-h"></i>
            </span>
            <h4 class="text-section">Components</h4>
          </li>

          <li class="nav-item">
            <a data-bs-toggle="collapse" href="#sidebarLayouts">
              <i class="fas fa-th-list"></i>
              <p>Employees</p>
              <span class="caret"></span>
            </a>
            <div class="collapse" id="sidebarLayouts">
              <ul class="nav nav-collapse">
                <li>
                  <a href="{{ route('employee.index') }}">
                    <span class="sub-item">All Employees</span>
                  </a>
                </li>
                <li>
                  <a href="{{ route('all_trashed_employee') }}">
                    <span class="sub-item">Trashed Employees</span>
                  </a>
                </li>
              </ul>
            </div>
          </li>

          @can('students')
          <li class="nav-item">
            <a data-bs-toggle="collapse" href="#forms">
              <i class="fas fa-pen-square"></i>
              <p>Students</p>
              <span class="caret"></span>
            </a>
            <div class="collapse" id="forms">
              <ul class="nav nav-collapse">
                @can('student management')
                <li>
                  <a href="{{ route('student.index') }}">
                    <span class="sub-item">All Students</span>
                  </a>
                </li>
                @endcan
                @can('trashed student management')
                <li>
                  <a href="{{ route('all_trashed_student') }}">
                    <span class="sub-item">Trashed Students</span>
                  </a>
                </li>
                @endcan
              </ul>
            </div>
          </li>
          @endcan

          @can('drivers')
          <li class="nav-item">
            <a data-bs-toggle="collapse" href="#tables">
              <i class="fas fa-table"></i>
              <p>Driver</p>
              <span class="caret"></span>
            </a>
            <div class="collapse" id="tables">
              <ul class="nav nav-collapse">
                @can('driver management')
                <li>
                  <a href="{{ route('driver.index') }}">
                    <span class="sub-item">Show All Driver</span>
                  </a>
                </li>
                @endcan
                @can('trashed driver management')
                <li>
                  <a href="{{ route('all_trashed_driver') }}">
                    <span class="sub-item">Trashed Driver</span>
                  </a>
                </li>
                @endcan
              </ul>
            </div>
          </li>
          @endcan

          @can('supervisors')
          <li class="nav-item">
            <a data-bs-toggle="collapse" href="#maps">
              <i class="fas fa-map-marker-alt"></i>
              <p>Supervisor</p>
              <span class="caret"></span>
            </a>
            <div class="collapse" id="maps">
              <ul class="nav nav-collapse">
                @can('supervisor management')
                <li>
                  <a href="{{ route('supervisor.index') }}">
                    <span class="sub-item">All Supervisor</span>
                  </a>
                </li>
                @endcan
                @can('trashed supervisor management')
                <li>
                  <a href="{{ route('all_trashed_supervisor') }}">
                    <span class="sub-item">Trashed Supervisor</span>
                  </a>
                </li>
                @endcan
              </ul>
            </div>
          </li>
          @endcan

          @can('buses')
          <li class="nav-item">
            <a data-bs-toggle="collapse" href="#charts">
              <i class="far fa-chart-bar"></i>
              <p>Buses</p>
              <span class="caret"></span>
            </a>
            <div class="collapse" id="charts">
              <ul class="nav nav-collapse">
                @can('buse management')
                <li>
                  <a href="{{ route('bus.index') }}">
                    <span class="sub-item"> all Buses</span>
                  </a>
                </li>
                @endcan
                @can('trashed bus management')
                <li>
                  <a href="{{ route('all_trashed_bus') }}">
                    <span class="sub-item"> Trashed Busses</span>
                  </a>
                </li>
                @endcan
              </ul>
            </div>
          </li>
          @endcan

          @can('paths')
          <li class="nav-item">
            <a data-bs-toggle="collapse" href="#charts1">
              <i class="far fa-chart-bar"></i>
              <p>Paths</p>
              <span class="caret"></span>
            </a>
            <div class="collapse" id="charts1">
              <ul class="nav nav-collapse">
                @can('path management')
                <li>
                  <a href="{{ route('path.index') }}">
                    <span class="sub-item">All Paths</span>
                  </a>
                </li>
                @endcan
                @can('trashed path management')
                <li>
                  <a href="{{ route('all_trashed_path') }}">
                    <span class="sub-item">Trushed Paths</span>
                  </a>
                </li>
                @endcan
              </ul>
            </div>
          </li>
          @endcan

          @can('stations')
          <li class="nav-item">
            <a data-bs-toggle="collapse" href="#charts2">
              <i class="far fa-chart-bar"></i>
              <p>Stations</p>
              <span class="caret"></span>
            </a>
            <div class="collapse" id="charts2">
              <ul class="nav nav-collapse">
                @can('station management')
                <li>
                  <a href="{{ route('station.index') }}">
                    <span class="sub-item"> All Stations</span>
                  </a>
                </li>
                @endcan
                @can('trashed station management')
                <li>
                  <a href="{{ route('all_trashed_station') }}">
                    <span class="sub-item"> Trashed Stations</span>
                  </a>
                </li>
                @endcan
              </ul>
            </div>
           </li> 
          </li>
          @endcan

          @can('trips')
          <li class="nav-item">
            <a data-bs-toggle="collapse" href="#charts3">
              <i class="far fa-chart-bar"></i>
              <p>Trips</p>
              <span class="caret"></span>
            </a>
            <div class="collapse" id="charts3">
              <ul class="nav nav-collapse">
                @can('trip management')
                <li>
                  <a href="{{ route('trip.index') }}">
                    <span class="sub-item"> All Trips</span>
                  </a>
                </li>
                @endcan
                @can('trashed trip management')
                <li>
                  <a href="{{ route('all_trashed_trip') }}">
                    <span class="sub-item"> Trashed Trips</span>
                  </a>
                </li>
                @endcan
              </ul>
            </div>
           </li> 
          @endcan

          @can('checkouts')
           <li class="nav-item">
            <a data-bs-toggle="collapse" href="#charts4">
              <i class="far fa-chart-bar"></i>
              <p>Checkouts</p>
              <span class="caret"></span>
            </a>
            <div class="collapse" id="charts4">
              <ul class="nav nav-collapse">
                @can('checkout management')
                <li>
                  <a href="{{ route('checkout.index') }}">
                    <span class="sub-item"> All Checkout</span>
                  </a>
                </li>
                @endcan
              </ul>
            </div>
           </li> 
          @endcan

          @can('users')
           <li class="nav-item">
            <a data-bs-toggle="collapse" href="#charts5">
              <i class="far fa-chart-bar"></i>
              <p>users</p>
              <span class="caret"></span>
            </a>
            <div class="collapse" id="charts5">
              <ul class="nav nav-collapse">
                @can('user management')
                <li>
                  <a href="{{ route('users.index') }}">
                    <span class="sub-item"> All users</span>
                  </a>
                </li>
                @endcan
                <li>
                  <a href="{{ route('all_trashed_user') }}">
                    <span class="sub-item"> All trashed users</span>
                  </a>
                </li>
                @can('role management')
                <li>
                  <a href="{{ route('roles.index') }}">
                    <span class="sub-item"> All Role</span>
                  </a>
                </li>
                @endcan
              </ul>
            </div>
           </li> 
          </li>
          @endcan
        </ul>
      </div>
    </div>
  </div>