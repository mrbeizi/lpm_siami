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

    <li class="menu-item">
        <div class="p-3">
        <select class="form-select" id="switch_periode" name="switch_periode" aria-label="Default select example" style="cursor:pointer;">
            @php $getPeriod = \App\Models\General\Period::select('id','title','is_active')->get(); @endphp
            @foreach($getPeriod as $data)
            @if($data->is_active == 1)
            <option value="{{$data->id}}" selected>{{$data->title}}</option>
            @else
            <option value="{{$data->id}}">{{$data->title}}</option>
            @endif
            @endforeach
        </select>
    </div>
    </li>

    <!-- Dashboards -->
    <li class="menu-item">
        <a href="{{route('dashboard')}}" class="menu-link {{set_active('dashboard')}}">
        <i class="menu-icon tf-icons bx bx-home-circle bx-tada-hover"></i>
        <div data-i18n="Dashboards">Dashboards</div>
        </a>
    </li>

    <!-- Apps & Pages -->
    <li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle {{set_active('data-period.index')}} OR {{set_active('data-schedule.index')}} OR {{set_active('data-assignment-letter.index')}}">
        <i class='menu-icon tf-icons bx bx-file-blank bx-tada-hover'></i>
        <div data-i18n="Perencanaan AMI">Perencanaan AMI</div>
        </a>
        <ul class="menu-sub">
        <li class="menu-item">
            <a href="{{route('data-period.index')}}" class="menu-link {{set_active('data-period.index')}}">
            <div data-i18n="Periode AMI">Periode AMI</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="{{route('data-schedule.index')}}" class="menu-link {{set_active('data-schedule.index')}}">
            <div data-i18n="Jadwal AMI">Jadwal AMI</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="{{route('data-assignment-letter.index')}}" class="menu-link {{set_active('data-assignment-letter.index')}}">
            <div data-i18n="Surat Tugas Auditor">Surat Tugas Auditor</div>
            </a>
        </li>
        </ul>
    </li>
    <li class="menu-item">
        <a href="{{route('ami-implementation.index')}}" class="menu-link {{set_active('ami-implementation.index')}}">
        <i class='menu-icon tf-icons bx bx-file-find bx-tada-hover'></i>
        <div data-i18n="Pelaksanaan AMI">Pelaksanaan AMI</div>
        </a>
        {{-- <ul class="menu-sub">
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
        </ul> --}}
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
        <a href="javascript:void(0);" class="menu-link menu-toggle {{set_active('data-announcement.index')}} OR {{set_active('data-news.index')}}">
        <i class='menu-icon tf-icons bx bx-news bx-tada-hover'></i>
        <div data-i18n="Informasi">Informasi</div>
        </a>
        <ul class="menu-sub">
            <li class="menu-item">
                <a href="{{route('data-announcement.index')}}" class="menu-link {{set_active('data-announcement.index')}}">
                <div data-i18n="Pengumuman">Pengumuman</div>
                </a>
            </li> 
            <li class="menu-item">
                <a href="{{route('data-news.index')}}" class="menu-link {{set_active('data-news.index')}}">
                <div data-i18n="Berita">Berita</div>
                </a>
            </li>      
        </ul>
    </li>
    <li class="menu-item">
        <a href="{{route('data-auditee.index')}}" class="menu-link {{set_active('data-auditee.index')}}">
        <i class="menu-icon tf-icons bx bx-group bx-tada-hover"></i>
        <div data-i18n="Daftar Auditee">Daftar Auditee</div>
        </a>
    </li>
    <li class="menu-item">
        <a href="{{route('data-auditor.index')}}" class="menu-link {{set_active('data-auditor.index')}}">
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
    </ul>

</aside>
<!-- / Menu -->

@section('script')
<script>
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });

    $('#switch_periode').on('change', function(e){
        var optionSelected = $("option:selected", this);
        var dataId = this.value;
        // alert(dataId);

            $.ajax({
                type: "POST",
                dataType: "json",
                url: "{{ route('switch-period-main') }}",
                data:{'id':dataId},
            }).done(function(data, response) {
                Swal.fire({
                    title: 'Success!',
                    text: 'State changed successfully!',
                    type: 'success',
                    customClass: { confirmButton: 'btn btn-primary' },
                    buttonsStyling: false,
                    timer: 2000
                })
            })
    });
</script>
@endsection