@extends('layouts.main')

@section('content')

    <ul class="body-tabs body-tabs-layout tabs-animated body-tabs-animated nav">
        <li class="nav-item">
            <a role="tab" class="nav-link active" id="tab-0" data-toggle="tab" href="#tab-content-0">
                <span>Today</span>
            </a>
        </li>
        <li class="nav-item">
            <a role="tab" class="nav-link" id="tab-1" data-toggle="tab" href="#tab-content-1">
                <span>Weekly</span>
            </a>
        </li>
        <li class="nav-item">
            <a role="tab" class="nav-link" id="tab-2" data-toggle="tab" href="#tab-content-2">
                <span>Monthly</span>
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
            <div class="row">
                <div class="col-md-12 col-lg-6 col-xl-7">
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                            <h6 class="text-muted text-uppercase font-size-md opacity-7 mb-3 font-weight-normal">
                                Agents Today
                            </h6>
                            <div class="border-light card-border card">
                                <div>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">
                                            <div class="widget-content p-0">
                                                <div class="widget-content-wrapper">
                                                    <div class="widget-content-left mr-3">
                                                        <img width="38" class="rounded-circle" src="/images/avatars/1.jpg" alt="">
                                                    </div>
                                                    <div class="widget-content-left">
                                                        <div class="widget-heading">Beck Collier</div>
                                                        <div class="widget-subheading mt-1 opacity-10">
                                                            <div class="badge badge-pill badge-primary">Quezon City</div>
                                                        </div>
                                                    </div>
                                                    <div class="widget-content-right">
                                                        <div class="icon-wrapper m-0">
                                                            <div class="progress-circle-wrapper">
                                                                <div class="circle-progress d-inline-block circle-progress-alternate">
                                                                    <small></small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="widget-content p-0">
                                                <div class="widget-content-wrapper">
                                                    <div class="widget-content-left mr-3">
                                                        <img width="38" class="rounded-circle" src="/images/avatars/2.jpg" alt="">
                                                    </div>
                                                    <div class="widget-content-left">
                                                        <div class="widget-heading">Angelo Hume</div>
                                                        <div class="widget-subheading mt-1 opacity-10">
                                                            <div class="badge badge-pill badge-primary">Quezon City</div>
                                                        </div>
                                                    </div>
                                                    <div class="widget-content-right">
                                                        <div class="icon-wrapper m-0">
                                                            <div class="progress-circle-wrapper">
                                                                <div class="circle-progress d-inline-block circle-progress-info">
                                                                    <small></small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="widget-content p-0">
                                                <div class="widget-content-wrapper">
                                                    <div class="widget-content-left mr-3">
                                                        <img width="38" class="rounded-circle" src="/images/avatars/2.jpg" alt="">
                                                    </div>
                                                    <div class="widget-content-left">
                                                        <div class="widget-heading">Saim Melendez</div>
                                                        <div class="widget-subheading mt-1 opacity-10">
                                                            <div class="badge badge-pill badge-primary">Quezon City</div>
                                                        </div>
                                                    </div>
                                                    <div class="widget-content-right">
                                                        <div class="icon-wrapper m-0">
                                                            <div class="progress-circle-wrapper">
                                                                <div class="circle-progress d-inline-block circle-progress-danger">
                                                                    <small></small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="widget-content p-0">
                                                <div class="widget-content-wrapper">
                                                    <div class="widget-content-left mr-3">
                                                        <img width="38" class="rounded-circle" src="/images/avatars/3.jpg" alt="">
                                                    </div>
                                                    <div class="widget-content-left">
                                                        <div class="widget-heading">Primrose Navarro</div>
                                                        <div class="widget-subheading mt-1 opacity-10">
                                                            <div class="badge badge-pill badge-primary">North Caloocan</div>
                                                        </div>
                                                    </div>
                                                    <div class="widget-content-right">
                                                        <div class="icon-wrapper m-0">
                                                            <div class="progress-circle-wrapper">
                                                                <div class="circle-progress d-inline-block circle-progress-success">
                                                                    <small></small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="widget-content p-0">
                                                <div class="widget-content-wrapper">
                                                    <div class="widget-content-left mr-3">
                                                        <img width="38" class="rounded-circle" src="/images/avatars/4.jpg" alt="">
                                                    </div>
                                                    <div class="widget-content-left">
                                                        <div class="widget-heading">Finnlay Barton</div>
                                                        <div class="widget-subheading mt-1 opacity-10">
                                                            <div class="badge badge-pill badge-primary">North Caloocan</div>
                                                        </div>
                                                    </div>
                                                    <div class="widget-content-right">
                                                        <div class="icon-wrapper m-0">
                                                            <div class="progress-circle-wrapper">
                                                                <div class="circle-progress d-inline-block circle-progress-primary">
                                                                    <small></small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="widget-content p-0">
                                                <div class="widget-content-wrapper">
                                                    <div class="widget-content-left mr-3">
                                                        <img width="38" class="rounded-circle" src="/images/avatars/10.jpg" alt="">
                                                    </div>
                                                    <div class="widget-content-left">
                                                        <div class="widget-heading">Johan Corbett</div>
                                                        <div class="widget-subheading mt-1 opacity-10">
                                                            <div class="badge badge-pill badge-primary">South Caloocan</div>
                                                        </div>
                                                    </div>
                                                    <div class="widget-content-right">
                                                        <div class="icon-wrapper m-0">
                                                            <div class="progress-circle-wrapper">
                                                                <div class="circle-progress d-inline-block circle-progress-dark">
                                                                    <small></small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="border-bottom-0 list-group-item">
                                            <div class="widget-content p-0">
                                                <div class="widget-content-wrapper">
                                                    <div class="widget-content-left mr-3">
                                                        <img width="38" class="rounded-circle" src="/images/avatars/9.jpg" alt="">
                                                    </div>
                                                    <div class="widget-content-left">
                                                        <div class="widget-heading">Kaja Wolfe</div>
                                                        <div class="widget-subheading mt-1 opacity-10">
                                                            <div class="badge badge-pill badge-primary">South Caloocan</div>
                                                        </div>
                                                    </div>
                                                    <div class="widget-content-right">
                                                        <div class="icon-wrapper m-0">
                                                            <div class="progress-circle-wrapper">
                                                                <div class="circle-progress d-inline-block circle-progress-success">
                                                                    <small></small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 col-lg-6 col-xl-5">
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                            <h6 class="text-muted text-uppercase font-size-md opacity-7 mb-3 font-weight-normal">
                                Agents Task Monitor
                            </h6>
                            <div class="border-light card-border card">
                                <div>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">
                                            <div class="widget-content p-0">
                                                <div class="widget-content-wrapper">
                                                    <div class="widget-content-left mr-3">
                                                        <img width="38" class="rounded-circle" src="/images/avatars/1.jpg" alt="">
                                                    </div>
                                                    <div class="widget-content-left">
                                                        <div class="widget-heading">Beck Collier</div>
                                                        <div class="widget-subheading mt-1 opacity-10">
                                                            <div class="badge badge-pill badge-primary">Quezon City</div>
                                                        </div>
                                                    </div>
                                                    <div class="widget-content-right">
                                                        <div class="icon-wrapper m-0">
                                                            <div class="progress-circle-wrapper">
                                                                <div class="circle-progress d-inline-block circle-progress-alternate">
                                                                    <small></small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="widget-content p-0">
                                                <div class="widget-content-wrapper">
                                                    <div class="widget-content-left mr-3">
                                                        <img width="38" class="rounded-circle" src="/images/avatars/2.jpg" alt="">
                                                    </div>
                                                    <div class="widget-content-left">
                                                        <div class="widget-heading">Angelo Hume</div>
                                                        <div class="widget-subheading mt-1 opacity-10">
                                                            <div class="badge badge-pill badge-primary">Quezon City</div>
                                                        </div>
                                                    </div>
                                                    <div class="widget-content-right">
                                                        <div class="icon-wrapper m-0">
                                                            <div class="progress-circle-wrapper">
                                                                <div class="circle-progress d-inline-block circle-progress-info">
                                                                    <small></small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="widget-content p-0">
                                                <div class="widget-content-wrapper">
                                                    <div class="widget-content-left mr-3">
                                                        <img width="38" class="rounded-circle" src="/images/avatars/2.jpg" alt="">
                                                    </div>
                                                    <div class="widget-content-left">
                                                        <div class="widget-heading">Saim Melendez</div>
                                                        <div class="widget-subheading mt-1 opacity-10">
                                                            <div class="badge badge-pill badge-primary">Quezon City</div>
                                                        </div>
                                                    </div>
                                                    <div class="widget-content-right">
                                                        <div class="icon-wrapper m-0">
                                                            <div class="progress-circle-wrapper">
                                                                <div class="circle-progress d-inline-block circle-progress-danger">
                                                                    <small></small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="widget-content p-0">
                                                <div class="widget-content-wrapper">
                                                    <div class="widget-content-left mr-3">
                                                        <img width="38" class="rounded-circle" src="/images/avatars/3.jpg" alt="">
                                                    </div>
                                                    <div class="widget-content-left">
                                                        <div class="widget-heading">Primrose Navarro</div>
                                                        <div class="widget-subheading mt-1 opacity-10">
                                                            <div class="badge badge-pill badge-primary">North Caloocan</div>
                                                        </div>
                                                    </div>
                                                    <div class="widget-content-right">
                                                        <div class="icon-wrapper m-0">
                                                            <div class="progress-circle-wrapper">
                                                                <div class="circle-progress d-inline-block circle-progress-success">
                                                                    <small></small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="widget-content p-0">
                                                <div class="widget-content-wrapper">
                                                    <div class="widget-content-left mr-3">
                                                        <img width="38" class="rounded-circle" src="/images/avatars/4.jpg" alt="">
                                                    </div>
                                                    <div class="widget-content-left">
                                                        <div class="widget-heading">Finnlay Barton</div>
                                                        <div class="widget-subheading mt-1 opacity-10">
                                                            <div class="badge badge-pill badge-primary">North Caloocan</div>
                                                        </div>
                                                    </div>
                                                    <div class="widget-content-right">
                                                        <div class="icon-wrapper m-0">
                                                            <div class="progress-circle-wrapper">
                                                                <div class="circle-progress d-inline-block circle-progress-primary">
                                                                    <small></small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="widget-content p-0">
                                                <div class="widget-content-wrapper">
                                                    <div class="widget-content-left mr-3">
                                                        <img width="38" class="rounded-circle" src="/images/avatars/10.jpg" alt="">
                                                    </div>
                                                    <div class="widget-content-left">
                                                        <div class="widget-heading">Johan Corbett</div>
                                                        <div class="widget-subheading mt-1 opacity-10">
                                                            <div class="badge badge-pill badge-primary">South Caloocan</div>
                                                        </div>
                                                    </div>
                                                    <div class="widget-content-right">
                                                        <div class="icon-wrapper m-0">
                                                            <div class="progress-circle-wrapper">
                                                                <div class="circle-progress d-inline-block circle-progress-dark">
                                                                    <small></small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="border-bottom-0 list-group-item">
                                            <div class="widget-content p-0">
                                                <div class="widget-content-wrapper">
                                                    <div class="widget-content-left mr-3">
                                                        <img width="38" class="rounded-circle" src="/images/avatars/9.jpg" alt="">
                                                    </div>
                                                    <div class="widget-content-left">
                                                        <div class="widget-heading">Kaja Wolfe</div>
                                                        <div class="widget-subheading mt-1 opacity-10">
                                                            <div class="badge badge-pill badge-primary">South Caloocan</div>
                                                        </div>
                                                    </div>
                                                    <div class="widget-content-right">
                                                        <div class="icon-wrapper m-0">
                                                            <div class="progress-circle-wrapper">
                                                                <div class="circle-progress d-inline-block circle-progress-success">
                                                                    <small></small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="tab-pane tabs-animation fade" id="tab-content-1" role="tabpanel">
        </div>
        <div class="tab-pane tabs-animation fade" id="tab-content-2" role="tabpanel">
        </div>
    </div>

@endsection

@section('menu')

    @include('profiles.vendor.menu')

@endsection

@section('title')
    {{ $title }}
@endsection

@section('title-subheading')
    {{ $title_subheading }}
@endsection

@section('title-icon')

    <i class=" {{ "pe-7s-" . $title_icon . " icon-gradient bg-mean-fruit" }}"></i>

    {{-- icon from controller issue need to find a new way --}}
    {{-- to get variable info from UserController --}}
    {{-- {{ $title_icon }} --}}

@endsection
