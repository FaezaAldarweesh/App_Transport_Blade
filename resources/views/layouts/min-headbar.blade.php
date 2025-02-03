<div class="main-header">
    <div class="main-header-logo">
      <!-- Logo Header -->
      <div class="logo-header" data-background-color="dark">
        <a href="index.html" class="logo">
          <img
            src="{{ asset('assets/img/kaiadmin/logo_light.svg') }}"
            alt="navbar brand"
            class="navbar-brand"
            height="20"
          />
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
    <!-- Navbar Header -->
    <nav
      class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom"
    >
      <div class="container-fluid">
        <nav
          class="navbar navbar-header-left navbar-expand-lg navbar-form nav-search p-0 d-none d-lg-flex">
        </nav>

        <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
{{--            Notification button--}}
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="notificationDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-bell"></i>
{{--                    <span class="badge bg-danger" id="notificationCount">3</span> <!-- عدد الإشعارات -->--}}
                </a>
                <ul class="dropdown-menu dropdown-menu-end p-3 notifications-dropdown" aria-labelledby="notificationDropdown">
                    <li><h6 class="dropdown-header">الإشعارات</h6></li>
                    <div class="notifications-list">
                    </div>
{{--                    <li><a class="dropdown-item text-center" href="#">عرض الكل</a></li>--}}
                </ul>
            </li>



            <li
            class="nav-item topbar-icon dropdown hidden-caret d-flex d-lg-none"
          >
            <a
              class="nav-link dropdown-toggle"
              data-bs-toggle="dropdown"
              href="#"
              role="button"
              aria-expanded="false"
              aria-haspopup="true"
            >
              <i class="fa fa-search"></i>
            </a>
            <ul class="dropdown-menu dropdown-search animated fadeIn">
              <form class="navbar-left navbar-form nav-search">
                <div class="input-group">
                  <input
                    type="text"
                    placeholder="Search ..."
                    class="form-control"
                  />
                </div>
              </form>
            </ul>
          </li>
          <li class="nav-item topbar-user dropdown hidden-caret">
            <a
              class="dropdown-toggle profile-pic"
              data-bs-toggle="dropdown"
              href="#"
              aria-expanded="false"
            >
              <div class="avatar-sm">
                <img
                  src="{{ asset('assets/img/profile.jpg') }}"
                  alt="..."
                  class="avatar-img rounded-circle"
                />
              </div>
              <span class="profile-username">
                <span class="op-7">Hi,</span>
                <span class="fw-bold">{{Auth::user()->name}}</span>
              </span>
            </a>
            <ul class="dropdown-menu dropdown-user animated fadeIn">
              <div class="dropdown-user-scroll scrollbar-outer">
                <li>
                  <div class="user-box">
                    <div class="avatar-lg">
                      <img
                        src="{{ asset('assets/img/profile.jpg') }}"
                        alt="image profile"
                        class="avatar-img rounded"
                      />
                    </div>
                    <div class="u-text">
                      <h4>Hizrian</h4>
                      <p class="text-muted">hello@example.com</p>
                      <a
                        href="profile.html"
                        class="btn btn-xs btn-secondary btn-sm"
                        >View Profile</a
                      >
                    </div>
                  </div>
                </li>
                <li>
                  {{-- <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="#">My Profile</a>
                  <a class="dropdown-item" href="#">My Balance</a>
                  <a class="dropdown-item" href="#">Inbox</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="#">Account Setting</a> --}}
                  <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
              </div>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
    <!-- End Navbar -->
  </div>
<style>

    .notifications-dropdown {
        width: 400px;
        max-height: 500px;
        overflow: hidden;
        border-radius: revert;
    }

    .notifications-list {
        max-height: 400px;
        overflow-y: auto;
    }

    .notifications-list .dropdown-item {
        white-space: normal;
        margin: 10px;
        border-bottom: 1px solid #eee;
    }

    #notificationCount {
        position: absolute;
        top: 5px;
        right: 5px;
        font-size: 12px;
        padding: 4px 7px;
        border-radius: 50%;
    }
    .notifications-list .dropdown-item {
        text-align: right; /* محاذاة النص إلى اليمين */
        padding: 10px;
        display: flex;
        flex-direction: column;
    }

    .notification-time {
        font-size: 12px;
        color: #807e7e;
        text-align: left;
        margin-top: 5px;
    }


</style>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.getElementById("notificationDropdown").addEventListener("click", function () {
            fetch("{{ route('notifications.fetch') }}") // استبدل بمسار جلب الإشعارات
                .then(response => response.json())
                .then(data => {
                    let notificationList = document.querySelector(".notifications-list");
                    notificationList.innerHTML = "";
                    if (data.length > 0) {
                        data.forEach(notification => {
                            let timestamp = new Date(notification.created_at);
                            let formattedTime = timestamp.toLocaleDateString('ar-EG', {
                                weekday: 'long',
                                year: 'numeric',
                                month: 'long',
                                day: 'numeric',
                                hour: '2-digit',
                                minute: '2-digit'
                            });

                            let item = `
                            <li class="dropdown-item">
                                <span>${notification.data.message}</span>
                                <span class="notification-time">${formattedTime}</span>
                            </li>`;
                            notificationList.innerHTML += item;
                        });
                    } else {
                        notificationList.innerHTML = `<li class="dropdown-item text-center">لا توجد إشعارات جديدة</li>`;
                    }
                    document.getElementById("notificationCount").innerText = data.length;
                })
                .catch(error => console.error("Error fetching notifications:", error));
        });
    });
</script>

