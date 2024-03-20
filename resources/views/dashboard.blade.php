@extends('layouts.backend')
@section('title','Dashboard')

@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="row">

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

        <!-- Announcement and News Timeline -->
        <div class="col-md-5 col-lg-5 mb-0">
            <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title m-0 me-2 text-warning">Pengumuman</h5>
            </div>
            <div class="card-body">
                <!-- Announcement Timeline -->
                <ul class="timeline">
                @if($getAnnouncement->count() > 0)
                @foreach($getAnnouncement as $announce)
                <li class="timeline-item timeline-item-transparent ps-4">
                    <span class="timeline-point timeline-point-warning"></span>
                    <div class="timeline-event pb-2">
                    <div class="timeline-header mb-1">
                        <h6 class="mb-0 text-warning">{{$announce->title}}</h6>
                        <small class="text-muted">{{ Carbon\Carbon::parse($announce->updated_at)->diffForHumans() }}</small>
                    </div>
                    <p class="mb-2">will be held on {{tanggal_indonesia($announce->publish_date)}}</p>
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
                <!-- /Announcement Timeline -->
            </div>
            </div>
            <div class="card mt-3">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title m-0 me-2 text-primary">Berita</h5>
            </div>
            <div class="card-body">
                <!-- News Timeline -->
                <ul class="timeline">
                @if($getNews->count() > 0)
                @foreach($getNews as $news)
                <li class="timeline-item timeline-item-transparent ps-4">
                    <span class="timeline-point timeline-point-primary"></span>
                    <div class="timeline-event pb-2">
                    <div class="timeline-header mb-1">
                        <h6 class="mb-0 text-primary">{{$news->title}}</h6>
                        <small class="text-muted">{{ Carbon\Carbon::parse($news->updated_at)->diffForHumans() }}</small>
                    </div>
                    <p class="mb-2">will be held on {{tanggal_indonesia($news->publish_date)}}</p>
                    <div class="d-flex">
                        <a href="{{$news->attachment}}" target="_blank" class="me-3" data-bs-toggle="tooltip" title="Click here to visit" data-bs-placement="bottom">
                        <img src="{{asset('assets/img/icons/brands/chrome.png')}}" alt="PDF image" width="23" class="me-2">
                        <span class="fw-bold text-body">{{$news->attachment}}</span>
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
                        <h6 class="mb-0">There's no news to publish yet</h6>
                        <small class="text-muted"></small>
                    </div>
                    <p class="mb-0">Tidak ada berita.</p>
                    </div>
                </li>
                <li class="timeline-end-indicator">
                    <i class="bx bx-check-circle"></i>
                </li>
                @endif
                </ul>
                <!-- /News Timeline -->
            </div>
            </div>
        </div>
        <!--/ News Timeline -->
        </div>
    
    </div>
    <!-- / Content -->

@endsection