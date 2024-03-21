<!-- Navbar -->
<nav class="layout-navbar navbar navbar-expand-xl align-items-center bg-navbar-theme" id="layout-navbar">
    <div class="container-fluid"> 
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0   d-xl-none ">
        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
        <i class="bx bx-menu bx-sm"></i>
        </a>
    </div>

    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
        
        <!-- Search -->
        <div class="navbar-nav align-items-center">
        <div class="nav-item navbar-search-wrapper mb-0">
            <a class="nav-item nav-link search-toggler px-0" href="javascript:void(0);">
            <i class="bx bx-search-alt bx-sm"></i>
            <span class="d-none d-md-inline-block text-muted">Search (Ctrl+/)</span>
            </a>
        </div>
        </div>
        <!-- /Search -->
        

        <ul class="navbar-nav flex-row align-items-center ms-auto">         

        <!-- Style Switcher -->
        <li class="nav-item me-2 me-xl-0">
            <a class="nav-link style-switcher-toggle hide-arrow" href="javascript:void(0);">
            <i class='bx bx-sm'></i>
            </a>
        </li>
        <!--/ Style Switcher -->

        <!-- Quick links  -->
        <li class="nav-item dropdown-shortcuts navbar-dropdown dropdown me-2 me-xl-0">
            <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
            <i class='bx bx-cog bx-sm'></i> <b>Data Settings</b>
            </a>
            <div class="dropdown-menu dropdown-menu-end py-0">
            <div class="dropdown-menu-header border-bottom">
                <div class="dropdown-header d-flex align-items-center py-3">
                <h5 class="text-body mb-0 me-auto">Database Settings</h5>
                </div>
            </div>
            <div class="dropdown-shortcuts-list scrollable-container">
                <div class="row row-bordered overflow-visible g-0">
                    <div class="dropdown-shortcuts-item col">
                        <span class="dropdown-shortcuts-icon bg-label-secondary rounded-circle mb-2">
                        <i class="bx bx-alarm fs-4"></i>
                        </span>
                        <a href="{{route('data-standard-period.index')}}" class="stretched-link">Standard Period</a>
                        <small class="text-muted mb-0">Manage Standard</small>
                    </div>
                    <div class="dropdown-shortcuts-item col">
                        <span class="dropdown-shortcuts-icon bg-label-secondary rounded-circle mb-2">
                        <i class="bx bx-group fs-4"></i>
                        </span>
                        <a href="{{route('data-employee.index')}}" class="stretched-link">Employee</a>
                        <small class="text-muted mb-0">Manage Employee</small>
                    </div>
                    
                </div>
                <div class="row row-bordered overflow-visible g-0">
                    <div class="dropdown-shortcuts-item col">
                        <span class="dropdown-shortcuts-icon bg-label-secondary rounded-circle mb-2">
                        <i class="bx bx-book fs-4"></i>
                        </span>
                        <a href="{{route('data-department.index')}}" class="stretched-link">Department</a>
                        <small class="text-muted mb-0">Manage Department</small>
                    </div>
                    <div class="dropdown-shortcuts-item col">
                        <span class="dropdown-shortcuts-icon bg-label-secondary rounded-circle mb-2">
                        <i class="bx bx-user fs-4"></i>
                        </span>
                        <a href="{{route('data-user.index')}}" class="stretched-link">Users</a>
                        <small class="text-muted mb-0">Manage Users</small>
                    </div>
                </div>
                <div class="row row-bordered overflow-visible g-0">
                    <div class="dropdown-shortcuts-item col">
                        <span class="dropdown-shortcuts-icon bg-label-secondary rounded-circle mb-2">
                        <i class="bx bx-help-circle fs-4"></i>
                        </span>
                        <a href="{{route('data-period.index')}}" class="stretched-link">Period</a>
                        <small class="text-muted mb-0">Setting Period</small>
                    </div>                
                    <div class="dropdown-shortcuts-item col">
                        <span class="dropdown-shortcuts-icon bg-label-secondary rounded-circle mb-2">
                        <i class="bx bx-key fs-4"></i>
                        </span>
                        <a href="{{route('user-role.index')}}" class="stretched-link">Role</a>
                        <small class="text-muted mb-0">Role Settings</small>
                    </div>
                </div>
                <div class="row row-bordered overflow-visible g-0">
                    <div class="dropdown-shortcuts-item col">
                        <span class="dropdown-shortcuts-icon bg-label-secondary rounded-circle mb-2">
                        <i class="bx bx-alarm fs-4"></i>
                        </span>
                        <a href="#" class="stretched-link">Profile</a>
                        <small class="text-muted mb-0">Setting Profile</small>
                    </div>
                    <div class="dropdown-shortcuts-item col">
                        <span class="dropdown-shortcuts-icon bg-label-secondary rounded-circle mb-2">
                        <i class="bx bx-building fs-4"></i>
                        </span>
                        <a href="{{route('data-faculty.index')}}" class="stretched-link">Faculty</a>
                        <small class="text-muted mb-0">Manage Faculty</small>
                    </div>
                </div>
            </div>
            </div>
        </li>
        <!-- Quick links -->

        <!-- User -->
        <li class="nav-item navbar-dropdown dropdown-user dropdown">
            <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
            <div class="avatar avatar-online">
                <img src="{{asset('assets/img/avatars/1.png')}}" alt class="rounded-circle">
            </div>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
            <li>
                <a class="dropdown-item" href="pages-account-settings-account.html">
                <div class="d-flex">
                    <div class="flex-shrink-0 me-3">
                    <div class="avatar avatar-online">
                        <img src="{{asset('assets/img/avatars/1.png')}}" alt class="rounded-circle">
                    </div>
                    </div>
                    <div class="flex-grow-1">
                    <span class="fw-semibold d-block lh-1">{{Auth::user()->name}}</span>
                    <small>{{Auth::user()->email}}</small>
                    </div>
                </div>
                </a>
            </li>
            <li>
                <div class="dropdown-divider"></div>
            </li>
            <li>
                <a class="dropdown-item" href="#">
                <i class="bx bx-user me-2"></i>
                <span class="align-middle">My Profile</span>
                </a>
            </li>
            <li>
                <a class="dropdown-item" href="#">
                <i class="bx bx-cog me-2"></i>
                <span class="align-middle">Settings</span>
                </a>
            </li>
            <li>
                <div class="dropdown-divider"></div>
            </li>
            <li>
                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" target="_blank">
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                <i class="bx bx-power-off me-2"></i>
                <span class="align-middle">Log Out</span>
                </a>
            </li>
            </ul>
        </li>
        <!--/ User -->
        

        </ul>
    </div>

    
    <!-- Search Small Screens -->
    <div class="navbar-search-wrapper search-input-wrapper  d-none">
        <input type="text" class="form-control search-input container-fluid border-0" placeholder="Search..." aria-label="Search...">
        <i class="bx bx-x bx-sm search-toggler cursor-pointer"></i>
    </div>
    
    
    </div>
</nav>

<!-- / Navbar -->