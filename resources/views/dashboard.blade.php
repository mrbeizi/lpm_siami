@extends('layouts.backend')
@section('title','Dashboard')

@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="row">
        <!-- Website Analytics-->
        <div class="col-lg-6 col-md-12 mb-4">
            <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Website Analytics</h5>
                <div class="dropdown">
                <button class="btn p-0" type="button" id="analyticsOptions" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="bx bx-dots-vertical-rounded"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="analyticsOptions">
                    <a class="dropdown-item" href="javascript:void(0);">Select All</a>
                    <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
                    <a class="dropdown-item" href="javascript:void(0);">Share</a>
                </div>
                </div>
            </div>
            <div class="card-body pb-2">
                <div class="d-flex justify-content-around align-items-center flex-wrap mb-4">
                <div class="user-analytics text-center me-2">
                    <i class="bx bx-user me-1"></i>
                    <span>Users</span>
                    <div class="d-flex align-items-center mt-2">
                    <div class="chart-report" data-color="success" data-series="35"></div>
                    <h3 class="mb-0">61K</h3>
                    </div>
                </div>
                <div class="sessions-analytics text-center me-2">
                    <i class="bx bx-pie-chart-alt me-1"></i>
                    <span>Sessions</span>
                    <div class="d-flex align-items-center mt-2">
                    <div class="chart-report" data-color="warning" data-series="76"></div>
                    <h3 class="mb-0">92K</h3>
                    </div>
                </div>
                <div class="bounce-rate-analytics text-center">
                    <i class="bx bx-trending-up me-1"></i>
                    <span>Bounce Rate</span>
                    <div class="d-flex align-items-center mt-2">
                    <div class="chart-report" data-color="danger" data-series="65"></div>
                    <h3 class="mb-0">72.6%</h3>
                    </div>
                </div>
                </div>
                <div id="analyticsBarChart"></div>
            </div>
            </div>

        </div>

        <!-- Referral, conversion, impression & income charts -->
        <div class="col-lg-6 col-md-12">
            <div class="row">
            <!-- Referral Chart-->
            <div class="col-sm-6 col-12 mb-4">
                <div class="card">
                <div class="card-body text-center">
                    <h2 class="mb-1">$32,690</h2>
                    <span class="text-muted">Referral 40%</span>
                    <div id="referralLineChart"></div>
                </div>
                </div>
            </div>
            <!-- Conversion Chart-->
            <div class="col-sm-6 col-12 mb-4">
                <div class="card">
                <div class="card-header d-flex justify-content-between pb-3">
                    <div class="conversion-title">
                    <h5 class="card-title mb-1">Conversion</h5>
                    <p class="mb-0 text-muted">60%
                        <i class="bx bx-chevron-up text-success"></i>
                    </p>
                    </div>
                    <h2 class="mb-0">89k</h2>
                </div>
                <div class="card-body">
                    <div id="conversionBarchart"></div>
                </div>
                </div>
            </div>
            <!-- Impression Radial Chart-->
            <div class="col-sm-6 col-12 mb-4">
                <div class="card">
                <div class="card-body text-center">
                    <div id="impressionDonutChart"></div>
                </div>
                </div>
            </div>
            <!-- Growth Chart-->
            <div class="col-sm-6 col-12">
                <div class="row">
                <div class="col-12 mb-4">
                    <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                        <div class="d-flex align-items-center gap-3">
                            <div class="avatar">
                            <span class="avatar-initial bg-label-primary rounded-circle"><i class="bx bx-user fs-4"></i></span>
                            </div>
                            <div class="card-info">
                            <h5 class="card-title mb-0 me-2">$38,566</h5>
                            <small class="text-muted">Conversion</small>
                            </div>
                        </div>
                        <div id="conversationChart"></div>
                        </div>
                    </div>
                    </div>
                </div>
                <div class="col-12 mb-4">
                    <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                        <div class="d-flex align-items-center gap-3">
                            <div class="avatar">
                            <span class="avatar-initial bg-label-warning rounded-circle"><i class="bx bx-dollar fs-4"></i></span>
                            </div>
                            <div class="card-info">
                            <h5 class="card-title mb-0 me-2">$53,659</h5>
                            <small class="text-muted">Income</small>
                            </div>
                        </div>
                        <div id="incomeChart"></div>
                        </div>
                    </div>
                    </div>
                </div>
                </div>
            </div>
            </div>
        </div>
        <!--/ Referral, conversion, impression & income charts -->

        <!-- Finance Summary -->
        <div class="col-md-7 col-lg-7 mb-4 mb-md-0">
            <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center me-3">
                <img src="{{asset('assets/img/avatars/4.png')}}" alt="Avatar" class="rounded-circle me-3" width="54">
                <div class="card-title mb-0">
                    <h5 class="mb-0">Financial Report for Kiara Cruiser</h5>
                    <small class="text-muted">Awesome App for Project Management</small>
                </div>
                </div>
                <div class="dropdown btn-pinned">
                <button class="btn p-0" type="button" id="financoalReport" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="bx bx-dots-vertical-rounded"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="financoalReport">
                    <a class="dropdown-item" href="javascript:void(0);">Select All</a>
                    <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
                    <a class="dropdown-item" href="javascript:void(0);">Share</a>
                </div>
                </div>
            </div>
            <div class="card-body">
                <div class="d-flex flex-wrap gap-4 mb-5 mt-4">
                <div class="d-flex flex-column me-2">
                    <h6>Start Date</h6>
                    <span class="badge bg-label-success">02 APR 22</span>
                </div>
                <div class="d-flex flex-column me-2">
                    <h6>End Date</h6>
                    <span class="badge bg-label-danger">06 MAY 22</span>
                </div>
                <div class="d-flex flex-column me-2">
                    <h6>Members</h6>
                    <ul class="list-unstyled me-2 d-flex align-items-center avatar-group mb-0">
                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Vinnie Mostowy" class="avatar avatar-xs pull-up">
                        <img class="rounded-circle" src="{{asset('assets/img/avatars/5.png')}}" alt="Avatar">
                    </li>
                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Allen Rieske" class="avatar avatar-xs pull-up">
                        <img class="rounded-circle" src="{{asset('assets/img/avatars/12.png')}}" alt="Avatar">
                    </li>
                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Julee Rossignol" class="avatar avatar-xs pull-up">
                        <img class="rounded-circle" src="{{asset('assets/img/avatars/6.png')}}" alt="Avatar">
                    </li>
                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Ellen Wagner" class="avatar avatar-xs pull-up">
                        <img class="rounded-circle" src="{{asset('assets/img/avatars/14.png')}}" alt="Avatar">
                    </li>
                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Darcey Nooner" class="avatar avatar-xs pull-up">
                        <img class="rounded-circle" src="{{asset('assets/img/avatars/10.png')}}" alt="Avatar">
                    </li>
                    </ul>
                </div>
                <div class="d-flex flex-column me-2">
                    <h6>Budget</h6>
                    <span>$249k</span>
                </div>
                <div class="d-flex flex-column me-2">
                    <h6>Expenses</h6>
                    <span>$82k</span>
                </div>
                </div>
                <div class="d-flex flex-column flex-grow-1">
                <span class="text-nowrap d-block mb-1">Kiara Cruiser Progress</span>
                <div class="progress w-100 mb-3" style="height: 8px;">
                    <div class="progress-bar bg-primary" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                </div>
                <span>I distinguish three main text objectives. First, your objective could be merely to inform people. A second be to persuade people.</span>
            </div>
            <div class="card-footer border-top">
                <ul class="list-inline mb-0">
                <li class="list-inline-item"><i class="bx bx-check"></i> 74 Tasks</li>
                <li class="list-inline-item"><i class="bx bx-chat"></i> 678 Comments</li>
                </ul>
            </div>
            </div>
        </div>
        <!-- Finance Summary -->

        <!-- Activity Timeline -->
        <div class="col-md-5 col-lg-5 mb-0">
            <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title m-0 me-2">Pengumuman</h5>
            </div>
            <div class="card-body">
                <!-- Activity Timeline -->
                <ul class="timeline">
                @if($datas->count() > 0)
                @foreach($datas as $announce)
                <li class="timeline-item timeline-item-transparent ps-4">
                    <span class="timeline-point timeline-point-primary"></span>
                    <div class="timeline-event pb-2">
                    <div class="timeline-header mb-1">
                        <h6 class="mb-0">{{$announce->title}}</h6>
                        <small class="text-muted">{{ Carbon\Carbon::parse($announce->created_at)->diffForHumans() }}</small>
                    </div>
                    <p class="mb-2">created at {{tanggal_indonesia($announce->publish_date)}}</p>
                    <div class="d-flex">
                        <a href="{{asset('dokumen-uploads/announcement/'.$announce->attachment.'')}}" target="_blank"  class="me-3">
                        <img src="{{asset('assets/img/icons/misc/pdf.png')}}" alt="PDF image" width="23" class="me-2">
                        <span class="fw-bold text-body">{{$announce->attachment}}</span>
                        </a>
                    </div>
                    </div>
                </li>
                
                <li class="timeline-end-indicator">
                    <i class="bx bx-check-circle"></i>
                </li>
                @endforeach
                @else
                <li class="timeline-item timeline-item-transparent ps-4">
                    <span class="timeline-point timeline-point-primary"></span>
                    <div class="timeline-event pb-2">
                    <div class="timeline-header mb-1">
                        <h6 class="mb-0">There's no announcement</h6>
                        <small class="text-muted"></small>
                    </div>
                    <p class="mb-0">Tidak ada pengumuman.</p>
                    </div>
                </li>
                <li class="timeline-end-indicator">
                    <i class="bx bx-check-circle"></i>
                </li>
                @endif
                </ul>
                <!-- /Activity Timeline -->
            </div>
            </div>
        </div>
        <!--/ Activity Timeline -->
        </div>
    
    </div>
    <!-- / Content -->

@endsection