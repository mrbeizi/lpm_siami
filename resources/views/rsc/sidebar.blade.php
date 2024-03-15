<!-- Menu -->
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">

                
    <div class="app-brand demo mt-3">
    <a href="{{route('dashboard')}}" class="app-brand-link">
        <span class="app-brand-logo demo"><img src="{{asset('images/svg/1111.png')}}" width="32px" height="32px" alt=""></span>
        <span class="app-brand-text demo menu-text fw-bold ms-2">{{config('app.name')}}</span>
    </a>

    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
        <i class="bx menu-toggle-icon d-none d-xl-block fs-4 align-middle"></i>
        <i class="bx bx-x d-block d-xl-none bx-sm align-middle"></i>
    </a>
    </div>

    
    <div class="menu-divider mt-0  ">
    </div>

    <div class="menu-inner-shadow"></div>

    
    
    <ul class="menu-inner py-1">
    <!-- Dashboards -->
    <li class="menu-item">
        <a href="{{route('dashboard')}}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-home-circle bx-tada-hover"></i>
        <div data-i18n="Dashboards">Dashboards</div>
        </a>
    </li>

    <!-- Apps & Pages -->
    <li class="menu-header small text-uppercase"><span class="menu-header-text">Main Menus</span></li>
    <li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class='menu-icon tf-icons bx bx-file-blank bx-tada-hover'></i>
        <div data-i18n="Perencanaan AMI">Perencanaan AMI</div>
        </a>
        <ul class="menu-sub">
        <li class="menu-item">
            <a href="#" class="menu-link">
            <div data-i18n="Periode AMI">Periode AMI</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="#" class="menu-link">
            <div data-i18n="Jadwal AMI">Jadwal AMI</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="#" class="menu-link">
            <div data-i18n="Surat Tugas Auditor">Surat Tugas Auditor</div>
            </a>
        </li>
        </ul>
    </li>
    <li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class='menu-icon tf-icons bx bx-file-find bx-tada-hover'></i>
        <div data-i18n="Pelaksanaan AMI">Pelaksanaan AMI</div>
        </a>
        <ul class="menu-sub">
        <li class="menu-item">
            <a href="#" class="menu-link">
            <div data-i18n="Fakultas Bisnis">Fakultas Bisnis</div>
            </a>
        </li>             
        <li class="menu-item">
            <a href="#" class="menu-link">
            <div data-i18n="Fakultas Komputer">Fakultas Komputer</div>
            </a>
        </li>             
        <li class="menu-item">
            <a href="#" class="menu-link">
            <div data-i18n="Fakultas Teknik">Fakultas Teknik</div>
            </a>
        </li>             
        <li class="menu-item">
            <a href="#" class="menu-link">
            <div data-i18n="Fakultas Seni">Fakultas Seni</div>
            </a>
        </li>             
        <li class="menu-item">
            <a href="#" class="menu-link">
            <div data-i18n="Fakultas PBB">Fakultas PBB</div>
            </a>
        </li>             
        </ul>
    </li>
    <li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle ">
        <i class="menu-icon tf-icons bx bx-move bx-tada-hover"></i>
        <div data-i18n="Pengendalian AMI">Pengendalian AMI</div>
        </a>
        <ul class="menu-sub">
            <li class="menu-item">
                <a href="#" class="menu-link ">
                <div data-i18n="Rapat Tinjauan Manajemen">Rapat Tinjauan Manajemen</div>
                </a>
            </li>        
            <li class="menu-item">
                <a href="#" class="menu-link">
                <div data-i18n="Pengawasan Internal">Pengawasan Internal</div>
                </a>
            </li>
        </ul>
    </li>
    <li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle ">
        <i class="menu-icon tf-icons bx bx-trending-up bx-tada-hover"></i>
        <div data-i18n="Peningkatan AMI">Peningkatan AMI</div>
        </a>
        <ul class="menu-sub">
            <li class="menu-item">
                <a href="#" class="menu-link ">
                <div data-i18n="Rapat Tindak Lanjut">Rapat Tindak Lanjut</div>
                </a>
            </li>
        </ul>
    </li>
    
    <li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class='menu-icon tf-icons bx bx-news bx-tada-hover'></i>
        <div data-i18n="Informasi">Informasi</div>
        </a>
        <ul class="menu-sub">
            <li class="menu-item">
                <a href="#" class="menu-link ">
                <div data-i18n="Pengumuman">Pengumuman</div>
                </a>
            </li> 
            <li class="menu-item">
                <a href="#" class="menu-link ">
                <div data-i18n="Berita">Berita</div>
                </a>
            </li>      
        </ul>
    </li>
    <li class="menu-item">
        <a href="#" class="menu-link">
        <i class="menu-icon tf-icons bx bx-group bx-tada-hover"></i>
        <div data-i18n="Daftar Auditee">Daftar Auditee</div>
        </a>
    </li>
    <li class="menu-item">
        <a href="#" class="menu-link">
        <i class="menu-icon tf-icons bx bx-body bx-tada-hover"></i>
        <div data-i18n="Daftar Auditor">Daftar Auditor</div>
        </a>
    </li>
    <li class="menu-item">
        <a href="#" class="menu-link">
        <i class="menu-icon tf-icons bx bx-folder-open bx-tada-hover"></i>
        <div data-i18n="Dokumen SPMI">Dokumen SPMI</div>
        </a>
    </li>

    <li class="menu-header small text-uppercase"><span class="menu-header-text">Master Data</span></li>
    <li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class='menu-icon tf-icons bx bx-group bx-tada-hover'></i>
        <div data-i18n="Users">Users</div>
        </a>
        <ul class="menu-sub">
        <li class="menu-item">
            <a href="{{route('data-user.index')}}" class="menu-link">
            <div data-i18n="User List">User List</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="{{route('user-role.index')}}" class="menu-link">
            <div data-i18n="Setting Role">Setting Role</div>
            </a>
        </li>
        </ul>
    </li>
    
    </ul>

</aside>
<!-- / Menu -->