<div class="sidebar" data-background-color="dark">
    <div class="sidebar-logo">
      <!-- Logo Header -->
      <div class="logo-header" data-background-color="dark">
        <a href="index.html" class="logo">
          {{-- <img
            src="{{ asset('assets/img/kaiadmin/logo_light.svg') }}" 
            alt="navbar brand"
            class="navbar-brand"
            height="20"
          /> --}}
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
            <a data-bs-toggle="collapse" href="#base">
              <i class="fas fa-layer-group"></i>
              <p>Users</p>
              <span class="caret"></span>
            </a>
            <div class="collapse" id="base">
              <ul class="nav nav-collapse">
                <li>
                  <a href="components/avatars.html">
                    <span class="sub-item">All Users</span>
                  </a>
                </li>
                <li>
                  <a href="components/buttons.html">
                    <span class="sub-item">Trushed Users</span>
                  </a>
                </li>
              </ul>
            </div>
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
                  <a href="sidebar-style-2.html">
                    <span class="sub-item">All Employees</span>
                  </a>
                </li>
                <li>
                  <a href="icon-menu.html">
                    <span class="sub-item">Trushed Employees</span>
                  </a>
                </li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a data-bs-toggle="collapse" href="#forms">
              <i class="fas fa-pen-square"></i>
              <p>Students</p>
              <span class="caret"></span>
            </a>
            <div class="collapse" id="forms">
              <ul class="nav nav-collapse">
                <li>
                  <a href="forms/forms.html">
                    <span class="sub-item">All Students</span>
                  </a>
                </li>
                <li>
                  <a href="forms/forms.html">
                    <span class="sub-item">Trushed Students</span>
                  </a>
                </li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a data-bs-toggle="collapse" href="#tables">
              <i class="fas fa-table"></i>
              <p>Driver</p>
              <span class="caret"></span>
            </a>
            <div class="collapse" id="tables">
              <ul class="nav nav-collapse">
                <li>
                  <a href="{{ route('driver.index') }}">
                    <span class="sub-item">Show All Driver</span>
                  </a>
                </li>
                <li>
                  <a href="{{ route('all_trashed_driver') }}">
                    <span class="sub-item">Trushed Driver</span>
                  </a>
                </li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a data-bs-toggle="collapse" href="#maps">
              <i class="fas fa-map-marker-alt"></i>
              <p>Supervisor</p>
              <span class="caret"></span>
            </a>
            <div class="collapse" id="maps">
              <ul class="nav nav-collapse">
                <li>
                  <a href="maps/googlemaps.html">
                    <span class="sub-item">All Supervisor</span>
                  </a>
                </li>
                <li>
                  <a href="maps/jsvectormap.html">
                    <span class="sub-item">Trushed Supervisor</span>
                  </a>
                </li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a data-bs-toggle="collapse" href="#charts">
              <i class="far fa-chart-bar"></i>
              <p>Buses</p>
              <span class="caret"></span>
            </a>
            <div class="collapse" id="charts">
              <ul class="nav nav-collapse">
                <li>
                  <a href="{{ route('bus.index') }}">
                    <span class="sub-item"> Busses</span>
                  </a>
                </li>
                <li>
                  <a href="{{ route('all_trashed_bus') }}">
                    <span class="sub-item"> Trushed Busses</span>
                  </a>
                </li>
              </ul>
            </div>
          </li>
          {{-- <li class="nav-item">
            <a href="widgets.html">
              <i class="fas fa-desktop"></i>
              <p>Widgets</p>
              <span class="badge badge-success">4</span>
            </a>
          </li> --}}
          {{-- <li class="nav-item">
            <a href="../../documentation/index.html">
              <i class="fas fa-file"></i>
              <p>Documentation</p>
              <span class="badge badge-secondary">1</span>
            </a>
          </li> --}}
          <li class="nav-item">
            <a data-bs-toggle="collapse" href="#submenu">
              <i class="fas fa-bars"></i>
              <p>Paths</p>
              <span class="caret"></span>
            </a>
            <div class="collapse" id="submenu">
              <ul class="nav nav-collapse">
                <li>
                  <a data-bs-toggle="collapse" href="#subnav1">
                    <span class="sub-item">All Paths</span>
                    {{-- <span class="caret"></span> --}}
                  </a>
                  {{-- <div class="collapse" id="subnav1">
                    <ul class="nav nav-collapse subnav">
                      <li>
                        <a href="#">
                          <span class="sub-item">Level 2</span>
                        </a>
                      </li>
                      <li>
                        <a href="#">
                          <span class="sub-item">Level 2</span>
                        </a>
                      </li>
                    </ul>
                  </div> --}}
                </li>
                <li>
                  <a data-bs-toggle="collapse" href="#subnav2">
                    <span class="sub-item">Trushed Paths</span>
                    {{-- <span class="caret"></span> --}}
                  </a>
                  {{-- <div class="collapse" id="subnav2">
                    <ul class="nav nav-collapse subnav">
                      <li>
                        <a href="#">
                          <span class="sub-item">Level 2</span>
                        </a>
                      </li>
                    </ul>
                  </div> --}}
                </li>
              </ul>
            </div>
          </li>
          </li>
        </ul>
      </div>
    </div>
  </div>